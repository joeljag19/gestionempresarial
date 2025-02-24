<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Detalles de la Cotización
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">
    <h2>Detalles de la Cotización</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Descuento</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detalles as $detalle): ?>
            <tr>
                <td><?= $detalle['producto_id'] ?></td> <!-- Aquí deberíamos mostrar el nombre del producto -->
                <td><?= $detalle['cantidad'] ?></td>
                <td><?= $detalle['precio_unitario'] ?></td>
                <td><?= $detalle['descuento'] ?></td>
                <td><?= ($detalle['cantidad'] * $detalle['precio_unitario']) - $detalle['descuento'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="<?= base_url('/cotizaciones') ?>" class="btn btn-primary">Volver a Cotizaciones</a>
</div>
<?= $this->endSection() ?>
