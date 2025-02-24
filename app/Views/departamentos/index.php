<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Gestión de Departamentos
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Gestión de Departamentos</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
<div class="row">
    <div class="col-sm-6">
        <form id="form-departamento">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
        <!-- <hr> -->

        <div class="col-sm-6">
        <table class="table table-bordered" id="tabla-departamentos">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Contenido dinámico -->
            </tbody>
        </table>
        </div>
    </div>
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
    function cargarDepartamentos() {
        $.ajax({
            url: '<?= base_url('departamentos/listar') ?>',
            method: 'GET',
            success: function(response) {
                var tbody = $('#tabla-departamentos tbody');
                tbody.empty();
                response.departamentos.forEach(function(departamento) {
                    var row = '<tr>' +
                        '<td>' + departamento.id + '</td>' +
                        '<td>' + departamento.nombre + '</td>' +
                        '<td>' + departamento.descripcion + '</td>' +
                        '<td>' +
                        '<button class="btn btn-warning btn-editar" data-id="' + departamento.id + '">Editar</button> ' +
                        '<button class="btn btn-danger btn-eliminar" data-id="' + departamento.id + '">Eliminar</button>' +
                        '</td>' +
                        '</tr>';
                    tbody.append(row);
                });
            }
        });
    }

    $('#form-departamento').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: '<?= base_url('departamentos/guardar') ?>',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.status === 'success') {
                    cargarDepartamentos();
                    $('#form-departamento')[0].reset();
                    Toast.fire({
                        icon: 'success',
                        title: 'Departamento guardado exitosamente.'
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
                    url: '<?= base_url('departamentos/eliminar') ?>/' + id,
                    method: 'GET',
                    success: function(response) {
                        if (response.status === 'success') {
                            cargarDepartamentos();
                            Toast.fire({
                                icon: 'success',
                                title: 'Departamento eliminado exitosamente.'
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
        var nombre = row.find('td:eq(1)').text();
        var descripcion = row.find('td:eq(2)').text();
        $('#nombre').val(nombre);
        $('#descripcion').val(descripcion);
        $('#form-departamento').off('submit').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '<?= base_url('departamentos/actualizar') ?>/' + id,
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.status === 'success') {
                        cargarDepartamentos();
                        $('#form-departamento')[0].reset();
                        Toast.fire({
                            icon: 'success',
                            title: 'Departamento actualizado exitosamente.'
                        });
                        $('#form-departamento').off('submit').on('submit', function(e) {
                            e.preventDefault();
                            var formData = $(this).serialize();
                            $.ajax({
                                url: '<?= base_url('departamentos/guardar') ?>',
                                method: 'POST',
                                data: formData,
                                success: function(response) {
                                    if (response.status === 'success') {
                                        cargarDepartamentos();
                                        $('#form-departamento')[0].reset();
                                        Toast.fire({
                                            icon: 'success',
                                            title: 'Departamento guardado exitosamente.'
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

    cargarDepartamentos();
});
</script>
<?= $this->endSection() ?>
