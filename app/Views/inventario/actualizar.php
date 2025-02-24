<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Actualizar Inventario de Productos Terminados
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">
    <h2>Actualizar Inventario de Productos Terminados</h2>
    <form id="form-actualizar-inventario" action="<?= base_url('/inventario/guardarActualizacion') ?>" method="post">
        <div class="form-group">
            <label for="producto">Producto</label>
            <select class="form-control" id="producto" name="producto" required>
                <?php foreach ($productos as $producto): ?>
                    <option value="<?= $producto['id'] ?>"><?= $producto['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="cantidad">Cantidad</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Inventario</button>
    </form>
</div>

<script>
$(document).ready(function() {
    $('#producto').select2();

    $('#form-actualizar-inventario').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.post('<?= base_url('/inventario/guardarActualizacion') ?>', formData, function(data) {
            alert('Inventario actualizado correctamente.');
            $('#form-actualizar-inventario')[0].reset();
        });
    });
});
</script>
<?= $this->endSection() ?>
