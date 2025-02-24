<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Tiempos de Producción
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tiempos de Producción</h1>
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
                        <h3 class="card-title">Detalles de los Productos Terminados</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Código de Barras</th>
                                    <th>Nombre</th>
                                    <th>Categoría</th>
                                    <th>Tiempo Total</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($productos as $producto): ?>
                                    <tr>
                                        <td><?= $producto['codigo_barras'] ?></td>
                                        <td><?= $producto['nombre'] ?></td>
                                        <td><?= $producto['categoria'] ?></td>
                                        <td><?= $producto['tiempo_total'] ?></td>
                                        <td><a href="<?= base_url('tiempos_produccion/detalle') ?>/<?=$producto['id'] ?>" class="btn btn-info btn-sm">Detalles</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
