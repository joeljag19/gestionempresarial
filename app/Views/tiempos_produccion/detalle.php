<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Detalle de Tiempos de Producción
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Detalle de Tiempos de Producción</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <h3><?= $producto['nombre'] ?></h3>
        <p><strong>Código de Barras: </strong><?= $producto['codigo_de_barra'] ?></p>

        <?php foreach ($estaciones as $estacion): ?>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><?= $estacion['nombre'] ?></h3>
                </div>
                <div class="card-body">
                    <?php if (count($estacion['tareas']) > 0): ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nombre de la Tarea</th>
                                    <th>Tiempo Estimado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($estacion['tareas'] as $tarea): ?>
                                    <tr>
                                        <td><?= $tarea['nombre'] ?></td>
                                        <td><?= $tarea['tiempo_estimado'] ?> minutos</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm editarTarea" data-id="<?= $tarea['id'] ?>" data-nombre="<?= $tarea['nombre'] ?>" data-tiempo="<?= $tarea['tiempo_estimado'] ?>">Editar</button>
                                            <a href="/tareas_produccion/eliminar/<?= $tarea['id'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No hay tareas disponibles para esta estación de trabajo.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Modal para editar tareas -->
<div class="modal fade" id="editarTareaModal" tabindex="-1" role="dialog" aria-labelledby="editarTareaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarTareaModalLabel">Editar Tarea</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editarTareaForm">
                    <input type="hidden" id="tarea_id" name="tarea_id">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="tiempo_estimado">Tiempo Estimado</label>
                        <input type="text" class="form-control" id="tiempo_estimado" name="tiempo_estimado" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Manejar el evento de clic en el botón de edición
    $('.editarTarea').on('click', function() {
        var tareaId = $(this).data('id');
        var nombre = $(this).data('nombre');
        var tiempo = $(this).data('tiempo');

        // Llenar el formulario del modal con los datos de la tarea
        $('#tarea_id').val(tareaId);
        $('#nombre').val(nombre);
        $('#tiempo_estimado').val(tiempo);

        // Mostrar el modal
        $('#editarTareaModal').modal('show');
    });

    // Manejar el evento de envío del formulario de edición
    $('#editarTareaForm').on('submit', function(e) {
        e.preventDefault();

        var tareaId = $('#tarea_id').val();
        var nombre = $('#nombre').val();
        var tiempoEstimado = $('#tiempo_estimado').val();

        // Enviar la solicitud AJAX para actualizar la tarea
        $.ajax({
            url: '/tiempos_produccion/actualizar/' + tareaId,
            method: 'POST',
            data: {
                nombre: nombre,
                tiempo_estimado: tiempoEstimado
            },
            success: function(response) {
                // Recargar la página o actualizar los datos en la tabla
                location.reload();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText); // Mensaje de depuración
                alert('Ocurrió un error al actualizar la tarea.');
            }
        });
    });
});
</script>


<?= $this->endSection() ?>
