<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Lista de Bill of Materials
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Lista de Bill of Materials</h1>
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
                        <h3 class="card-title">Bill of Materials</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Producto Fabricado</th>
                                    <th>Costo Total</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($boms as $bom): ?>
                                <tr>
                                    <td><?= $bom['id'] ?></td>
                                    <td><?= $bom['nombre'] ?></td>
                                    <td><?= $bom['descripcion'] ?></td>
                                    <td><?= $bom['materiaprima_id'] ?></td>
                                    <td><?= $bom['costo_total'] ?></td>
                                    <td>
                                        <a href="/bom/editar/<?= $bom['id'] ?>" class="btn btn-warning">Editar</a>
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
