<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Lista de Cotizaciones
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">
    <h2>Lista de Cotizaciones</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Número de Cotización</th>
                <th>Cliente</th>
                <th>Fecha de Cotización</th>
                <th>Fecha de Vencimiento</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cotizaciones as $cotizacion): ?>
            <tr>
                <td><?= $cotizacion['numero_cotizacion'] ?></td>
                <td><?= $cotizacion['cliente_id'] ?></td> <!-- Aquí deberíamos mostrar el nombre del cliente -->
                <td><?= $cotizacion['fecha_cotizacion'] ?></td>
                <td><?= $cotizacion['fecha_vencimiento'] ?></td>
                <td><?= $cotizacion['total'] ?></td> <!-- Necesitaríamos calcular el total -->
                <td>
                    <a href="<?= base_url('/cotizaciones/detalle/'.$cotizacion['id']) ?>" class="btn btn-info">Ver Detalles</a>
                    <a href="#" class="btn btn-warning">Editar</a>
                    <a href="#" class="btn btn-danger">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
