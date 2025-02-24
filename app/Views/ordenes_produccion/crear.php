<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Crear Orden de Producción
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">
    <h2>Crear Orden de Producción</h2>
    <form id="form-orden-produccion" action="<?= base_url('/ordenes_produccion/guardar') ?>" method="post">
        <div class="form-group">
            <label for="cotizacion">Cotización</label>
            <select class="form-control" id="cotizacion" name="cotizacion" required>
                <?php foreach ($cotizaciones as $cotizacion): ?>
                    <option value="<?= $cotizacion['id'] ?>"><?= $cotizacion['numero_cotizacion'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="fecha_inicio">Fecha de Inicio</label>
            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
        </div>
        <div class="form-group">
            <label for="fecha_fin">Fecha de Finalización</label>
            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
        </div>
        <div id="lista-productos"></div>
        <button type="submit" class="btn btn-primary">Guardar Orden de Producción</button>
    </form>
</div>

<script>
$(document).ready(function() {
    $('#cotizacion').select2();

    $('#cotizacion').change(function() {
        var cotizacion_id = $(this).val();
        $.ajax({
            url: '<?= base_url('/cotizaciones/detalle') ?>/' + cotizacion_id,
            type: 'GET',
            success: function(data) {
                $('#lista-productos').html(data);
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
