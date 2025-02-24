<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Lista de Productos Terminados
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Lista de Productos Terminados</h1>
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
                        <h3 class="card-title">Productos Terminados</h3>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-start">
                            <a class="btn btn-primary btn-block col-3" href="<?= site_url('producto_terminado/crear'); ?>"><i class="fa fa-plus-circle"></i> Agregar Producto</a>
                        </div>
                        <br/>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Código de Barra</th>
                                    <th>Nombre</th>
                                    <th>Categoría</th>
                                    <th>Impuesto</th>
                                    <th>Costo Unidad</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($productos as $producto): ?>
                                <tr>
                                    <td><?= $producto['id'] ?></td>
                                    <td><?= $producto['codigo_de_barra'] ?></td>
                                    <td><?= $producto['nombre'] ?></td>
                                    <td><?= $producto['nombre_categoria'] ?></td>
                                    <td><?= $producto['impuesto'] ?></td>
                                    <td><?= $producto['costo_unidad'] ?></td>
                                    <td>
                                        <a href="/producto_terminado/editar/<?= $producto['id'] ?>" class="btn btn-warning">Editar</a>
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
