<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
BOM - Lista de Materiales
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">BOM - Lista de Materiales</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <div class="form-group">
            <label for="producto_terminado">Seleccione un Producto Terminado</label>
            <select class="form-control" id="producto_terminado" name="producto_terminado">
                <option value="">Seleccione un producto</option>
                <?php foreach ($productos as $producto): ?>
                    <option value="<?= $producto['id'] ?>"><?= $producto['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div id="detallesBom"></div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#producto_terminado').on('change', function() {
        var productoId = $(this).val();
        if (productoId) {
            $.ajax({
                url: '/bom/obtenerDetalles/' + productoId,
                method: 'GET',
                success: function(response) {
                    var detalles = response.detalles;
                    var html = '';

                    detalles.forEach(function(tarea) {
                        html += '<h5>' + tarea.nombre_tarea + '</h5>';
                        html += '<table class="table table-bordered"><thead><tr><th>Nombre</th><th>Código de Barra</th><th>Cantidad</th><th>% Desperdicio</th><th>Cantidad Material</th><th>Costo Unitario</th><th>Subtotal</th></tr></thead><tbody>';

                        tarea.materiales.forEach(function(material) {
                            html += '<tr>';
                            html += '<td>' + material.nombre + '</td>';
                            html += '<td>' + material.codigo_de_barra + '</td>';
                            html += '<td>' + material.cantidad + '</td>';
                            html += '<td>' + material.desperdicio + '</td>';
                            html += '<td>' + material.cantidad_material + '</td>';
                            html += '<td>' + material.costo_unitario + '</td>';
                            html += '<td>' + material.subtotal + '</td>';
                            html += '</tr>';
                        });

                        html += '</tbody></table>';
                        html += '<hr/>';
                        html += '<h6>Subtotal Tarea: ' + tarea.subtotal_tarea + '</h6>';
                        html += '<hr/ style="border: 0; height: 2px; background: #333; background-image: linear-gradient(to right, #ffcc00, #ff0000, #ffcc00);">';
                        html += '<hr/ style="border: 0; height: 2px; background: #333; background-image: linear-gradient(to right, #ffcc00, #ff0000, #ffcc00);">';
                    });

                    html += '<h3>Total: ' + detalles.reduce((acc, tarea) => acc + tarea.subtotal_tarea, 0) + '</h3>';
                    $('#detallesBom').html(html);
                },
                error: function(xhr, status, error) {
                    console.error('Ocurrió un error al obtener los detalles.');
                }
            });
        } else {
            $('#detallesBom').html('');
        }
    });
});
</script>

<?= $this->endSection() ?>
