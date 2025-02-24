<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Gestión de Salarios
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Gestión de Salarios</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <form id="form-salario">
            <div class="form-group">
                <label for="empleado_buscar">Buscar Empleado</label>
                <input type="text" class="form-control" id="empleado_buscar" autocomplete="off"  placeholder="Buscar empleado por nombre">
                <div id="empleado_sugerencias" class="list-group"></div>
                <div id="empleado_seleccionado" style="display: none;">
                    <span id="empleado_nombre"></span>
                    <button type="button" class="btn btn-danger btn-sm" id="cancelar_empleado">Cancelar</button>
                </div>
                <input type="hidden" id="empleado_id" name="empleado_id">
            </div>
            <div class="form-group">
                <label for="tipo_salario">Tipo de Salario</label>
                <select class="form-control" id="tipo_salario" name="tipo_salario" required>
                    <option value="Fijo">Fijo</option>
                    <option value="Producción">Producción</option>
                </select>
            </div>
            <div class="form-group">
                <label for="monto">Monto</label>
                <input type="number" class="form-control" id="monto" name="monto" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
        <hr>
        <table class="table table-bordered" id="tabla-salarios">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Empleado</th>
                    <th>Tipo de Salario</th>
                    <th>Monto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Contenido dinámico -->
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

$(document).ready(function() {
    function cargarSalarios() {
        $.ajax({
            url: '<?= base_url('salarios/listar') ?>',
            method: 'GET',
            success: function(response) {
                var tbody = $('#tabla-salarios tbody');
                tbody.empty();
                response.salarios.forEach(function(salario) {
                    var row = '<tr>' +
                        '<td>' + salario.id + '</td>' +
                        '<td>' + salario.empleado_nombre + '</td>' + // Mostrar el nombre del empleado
                        '<td>' + salario.tipo_salario + '</td>' +
                        '<td>' + salario.monto + '</td>' +
                        '<td>' +
                        '<button class="btn btn-warning btn-editar" data-id="' + salario.id + '" data-empleado-nombre="' + salario.empleado_nombre + '">Editar</button> ' +
                        '<button class="btn btn-danger btn-eliminar" data-id="' + salario.id + '">Eliminar</button>' +
                        '</td>' +
                        '</tr>';
                    tbody.append(row);
                });
            }
        });
    }

    $('#empleado_buscar').on('input', function() {
        var query = $(this).val();
        if (query.length > 2) {
            $.ajax({
                url: '<?= base_url('salarios/listarEmpleados') ?>',
                method: 'GET',
                data: { query: query },
                success: function(response) {
                    var sugerencias = $('#empleado_sugerencias');
                    sugerencias.empty();
                    response.empleados.forEach(function(empleado) {
                        var item = '<a href="#" class="list-group-item list-group-item-action" data-id="' + empleado.id + '">' + empleado.primer_nombre + ' ' + empleado.apellido + '</a>';
                        sugerencias.append(item);
                    });
                }
            });
        }
    });

    $(document).on('click', '#empleado_sugerencias .list-group-item', function(e) {
        e.preventDefault();
        var empleado_id = $(this).data('id');
        var empleado_nombre = $(this).text();
        $('#empleado_id').val(empleado_id);
        $('#empleado_nombre').text(empleado_nombre);
        $('#empleado_seleccionado').show();
        $('#empleado_buscar').hide();
        $('#empleado_sugerencias').hide();
    });

    $('#cancelar_empleado').on('click', function() {
        $('#empleado_seleccionado').hide();
        $('#empleado_buscar').show().val('');
        $('#empleado_sugerencias').show().empty();
        $('#empleado_id').val('');
    });

    $('#form-salario').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: '<?= base_url('salarios/guardar') ?>',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.status === 'success') {
                    cargarSalarios();
                    $('#form-salario')[0].reset();
                    $('#empleado_seleccionado').hide();
                    $('#empleado_buscar').show().val('');
                    $('#empleado_sugerencias').show().empty();
                    Toast.fire({
                        icon: 'success',
                        title: 'Salario guardado exitosamente.'
                    });
                }
            }
        });
    });

    $(document).on('click', '.btn-eliminar', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('salarios/eliminar') ?>/' + id,
                    method: 'GET',
                    success: function(response) {
                        if (response.status === 'success') {
                            cargarSalarios();
                            Toast.fire({
                                icon: 'success',
                                title: 'Salario eliminado exitosamente.'
                            });
                        }
                    }
                });
            }
        });
    });

    $(document).on('click', '.btn-editar', function() {
        var id = $(this).data('id');
        var row = $(this).closest('tr');
        var empleado_id = row.find('td:eq(1)').data('id');
        var empleado_nombre = $(this).data('empleado-nombre');
        var tipo_salario = row.find('td:eq(2)').text();
        var monto = row.find('td:eq(3)').text();
        $('#empleado_id').val(empleado_id).prop('disabled', true);
        $('#empleado_buscar').val(empleado_nombre).prop('disabled', true);
        $('#tipo_salario').val(tipo_salario);
        $('#monto').val(monto);
        $('#form-salario').off('submit').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '<?= base_url('salarios/actualizar') ?>/' + id,
                method: 'GET',
                data: formData,
                success: function(response) {
                    if (response.status === 'success') {
                        cargarSalarios();
                        $('#form-salario')[0].reset();
                        $('#empleado_id').prop('disabled', false);
                        $('#empleado_buscar').prop('disabled', false);
                        $('#empleado_seleccionado').hide();
                        $('#empleado_buscar').show().val('');
                        $('#empleado_sugerencias').show().empty();
                        Toast.fire({
                            icon: 'success',
                            title: 'Salario actualizado exitosamente.'
                        });
                        $('#form-salario').off('submit').on('submit', function(e) {
                            e.preventDefault();
                            var formData = $(this).serialize();
                            $.ajax({
                                url: '<?= base_url('salarios/guardar') ?>',
                                method: 'POST',
                                data: formData,
                                success: function(response) {
                                    if (response.status === 'success') {
                                        cargarSalarios();
                                        $('#form-salario')[0].reset();
                                        $('#empleado_seleccionado').hide();
                                        $('#empleado_buscar').show().val('');
                                        $('#empleado_sugerencias').show().empty();
                                        Toast.fire({
                                            icon: 'success',
                                            title: 'Salario guardado exitosamente.'
                                        });
                                    }
                                }
                            });
                        });
                    }
                }
            });
        });
    });

    cargarSalarios();
});
</script>
<?= $this->endSection() ?>
