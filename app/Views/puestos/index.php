<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Gestión de Puestos
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Gestión de Puestos</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
<div class="row">



<div class="col-md-6">

        <form id="form-puesto">
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
        <div class="col-md-6">
        <table class="table table-bordered" id="tabla-puestos">
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
    function cargarPuestos() {
        $.ajax({
            url: '<?= base_url('puestos/listar') ?>',
            method: 'GET',
            success: function(response) {
                var tbody = $('#tabla-puestos tbody');
                tbody.empty();
                response.puestos.forEach(function(puesto) {
                    var row = '<tr>' +
                        '<td>' + puesto.id + '</td>' +
                        '<td>' + puesto.nombre + '</td>' +
                        '<td>' + puesto.descripcion + '</td>' +
                        '<td>' +
                        '<button class="btn btn-warning btn-editar" data-id="' + puesto.id + '">Editar</button> ' +
                        '<button class="btn btn-danger btn-eliminar" data-id="' + puesto.id + '">Eliminar</button>' +
                        '</td>' +
                        '</tr>';
                    tbody.append(row);
                });
            }
        });
    }

    $('#form-puesto').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: '<?= base_url('puestos/guardar') ?>',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.status === 'success') {
                    cargarPuestos();
                    $('#form-puesto')[0].reset();
                    Toast.fire({
                        icon: 'success',
                        title: 'Puesto guardado exitosamente.'
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
                    url: '<?= base_url('puestos/eliminar') ?>/' + id,
                    method: 'GET',
                    success: function(response) {
                        if (response.status === 'success') {
                            cargarPuestos();
                            Toast.fire({
                                icon: 'success',
                                title: 'Puesto eliminado exitosamente.'
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
        $('#form-puesto').off('submit').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '<?= base_url('puestos/actualizar') ?>/' + id,
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.status === 'success') {
                        cargarPuestos();
                        $('#form-puesto')[0].reset();
                        Toast.fire({
                            icon: 'success',
                            title: 'Puesto actualizado exitosamente.'
                        });
                        $('#form-puesto').off('submit').on('submit', function(e) {
                            e.preventDefault();
                            var formData = $(this).serialize();
                            $.ajax({
                                url: '<?= base_url('puestos/guardar') ?>',
                                method: 'POST',
                                data: formData,
                                success: function(response) {
                                    if (response.status === 'success') {
                                        cargarPuestos();
                                        $('#form-puesto')[0].reset();
                                        Toast.fire({
                                            icon: 'success',
                                            title: 'Puesto guardado exitosamente.'
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

    cargarPuestos();
});
</script>
<?= $this->endSection() ?>
