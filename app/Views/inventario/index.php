<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Lista de Inventario
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Lista de Inventario</h1>
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
                        <h3 class="card-title">Inventario</h3>
                    </div>
                    <div class="card-body">
                    <div class="row justify-content-start">
                                        <a class="btn btn-primary btn-block col-3" href="<?= site_url('inventario/crear'); ?>"><i class="fa fa-plus-circle"></i> Agregar Inventario</a>
                                    </div>
                                    <br/>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Almacén</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($inventario as $item): ?>
                                <tr>
                                    <td><?= $item['id'] ?></td>
                                    <td><?= $item['nombre_producto'] ?></td>
                                    <td><?= $item['cantidad'] ?></td>
                                    <td><?= $item['nombre_almacen'] ?></td>
                                    <td>
                                        <a href="/inventario/editar/<?= $item['id'] ?>" class="btn btn-warning">Editar</a>
                                    </td>
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
