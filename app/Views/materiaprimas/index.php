<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Lista de Materias Primas
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Lista de  Materias Primas</h1>
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
                        <h3 class="card-title"> Materias Primas</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Unidad de Medida</th>
                                    <th>Costo Unitario</th>
                                    <th>Código de Barras</th>
                                    <th>Grupo de materiaprimas</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($materiaprimas as $materiaprima): ?>
                                <tr>
                                    <td><?= $materiaprima['id'] ?></td>
                                    <td><?= $materiaprima['nombre'] ?></td>
                                    <td><?= $materiaprima['descripcion'] ?></td>
                                    <td><?= $materiaprima['unidad'] ?></td>
                                    <td><?= $materiaprima['costo_unitario'] ?></td>

                                    <td><?= $materiaprima['codigo_de_barra'] ?></td>
                                    <td><?= $materiaprima['categoria'] ?></td>
                                    <td>
                                        <a href="/materiaprimas/editar/<?= $materiaprima['id'] ?>" class="btn btn-warning">Editar</a>
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
