<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Tareas de Producción
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tareas de Producción</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Asignar Estaciones de Trabajo</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="producto_terminado">Seleccione un Producto Terminado</label>
                            <select class="form-control" id="producto_terminado" name="producto_terminado">
                                <option value="">Seleccione un producto</option>
                                <?php foreach ($productos as $producto): ?>
                                    <option value="<?= $producto['id'] ?>"><?= $producto['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div id="estacionesTrabajo">
                                        <!-- Las estaciones de trabajo se cargarán aquí -->
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div id="tareasTrabajoForm">
                                        <!-- Las tareas de trabajo y el formulario se cargarán aquí -->
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- Modal para agregar materias primas -->
                        <div class="modal fade" id="materiasPrimasModal" tabindex="-1" role="dialog" aria-labelledby="materiasPrimasModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="materiasPrimasModalLabel">Agregar Materia Prima</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form id="materiaPrimaForm">
                                    <input type="hidden" id="tarea_id" name="tarea_id">
                                    <label for="materia_prima_id">Nombre del Producto</label>

                                   <select class="form-control" id="materia_prima_id" name="materia_prima_id" required>
                                    <?php foreach ($materias_primas as $materiaprima): ?>
                                        <option value="<?= $materiaprima['id'] ?>"><?= $materiaprima['nombre'] ?></option>
                                    <?php endforeach; ?>
                                    </select>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="cantidad">Cantidad</label>
                                                <input type="text" class="form-control" id="cantidad" name="cantidad" required>
                                            </div>
                                    </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="desperdicio">Desperdicio</label>
                                                <input type="text" class="form-control" id="desperdicio" name="desperdicio" required>
                                            </div>    
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </form>
                                <div id="materiasPrimasList"></div>
                              </div>
                            </div>
                          </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#producto_terminado').on('change', function() {
        var productoId = $(this).val();
        if (productoId) {
            $.ajax({
                url: '/tareas_produccion/cargarEstaciones/' + productoId,
                method: 'GET',
                success: function(response) {
                    $('#estacionesTrabajo').html(response);

                    // Añadir funcionalidad a los botones
                    $('.showtasks').on('click', function() {
                        var estacionId = $(this).closest('tr').find('td:first').text();
                        verTareas(estacionId, productoId);
                    });

                    $('.addnewtask').on('click', function() {
                        var estacionId = $(this).closest('tr').find('td:first').text();
                        abrirFormulario(estacionId, productoId);
                    });
                }
            });
        } else {
            $('#estacionesTrabajo').html('');
            $('#tareasTrabajoForm').html('');
        }
    });

    $(document).on('submit', '#nuevaTareaForm', function(e) {
        e.preventDefault();
        $.ajax({
            url: '/tareas_produccion/nuevaTarea',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#tareasTrabajoForm').html(response);
                cerrarFormulario();
            }
        });
    });

    // Evento para agregar materias primas
    $(document).on('click', '.addMaterials', function() {
        var tareaId = $(this).data('tarea-id');
        $('#tarea_id').val(tareaId);
        $('#materiasPrimasModal').modal('show');
        cargarMateriasPrimas(tareaId);
    });

    $(document).on('submit', '#materiaPrimaForm', function(e) {
        e.preventDefault();
        $.ajax({
            url: '/tareas_produccion/agregarMateriaPrima',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#materiasPrimasList').html(response);
                $('#materiaPrimaForm')[0].reset();
            }
        });
    });

    $(document).on('click', '.deleteMaterial', function() {
        var materiaId = $(this).data('id');
        $.ajax({
            url: '/tareas_produccion/eliminarMateriaPrima/' + materiaId,
            method: 'DELETE',
            success: function(response) {
                $('#materiasPrimasList').html(response);
            }
        });
    });
});

function verTareas(estacionId, productoId) {
    $.ajax({
        url: '/tareas_produccion/verTareas/' + estacionId + '/' + productoId,
        method: 'GET',
        success: function(response) {
            $('#tareasTrabajoForm').html(response);
        }
    });
}

function abrirFormulario(estacionId, productoId) {
    $.ajax({
        url: '/tareas_produccion/getEstacionProducto/' + estacionId + '/' + productoId,
        method: 'GET',
        success: function(response) {
            var data = JSON.parse(response);
            var formHtml = `
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Nueva Tarea</h3>
                    </div>
                    <div class="card-body">
                        <div>
                            <h3>${data.producto.nombre}</h3>
                            <p><strong>Código de Barras: </strong>${data.producto.codigo_barras}</p>
                            <p><strong>Estación de Trabajo: </strong>${data.estacion.nombre}</p>
                        </div>
                        <form id="nuevaTareaForm">
                            <input type="hidden" id="producto_terminado_id" name="producto_terminado_id" value="${productoId}">
                            <input type="hidden" id="estacion_trabajo_id" name="estacion_trabajo_id" value="${estacionId}">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="tiempo_estimado">Tiempo Estimado</label>
                                <input type="text" class="form-control" id="tiempo_estimado" name="tiempo_estimado" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <button type="button" class="btn btn-secondary" onclick="cerrarFormulario()">Cancelar</button>
                        </form>
                    </div>
                </div>
            `;
            $('#tareasTrabajoForm').html(formHtml);
        }
    });
}

function cargarMateriasPrimas(tareaId) {
    $.ajax({
        url: '/tareas_produccion/cargarMateriasPrimas/' + tareaId,
        method: 'GET',
        success: function(response) {
            $('#materiaPrimaSelect').html(response);
            $('#materiasPrimasList').html(response);
        }
    });
}

function cerrarFormulario() {
    $('#tareasTrabajoForm').html('');
}
</script>




<?= $this->endSection() ?>
