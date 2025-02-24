<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Lista de Estaciones de Trabajo
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Lista de Estaciones de Trabajo</h1>
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
                        <h3 class="card-title">Estaciones de Trabajo</h3>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-start">
                            <a class="btn btn-primary btn-block col-3" href="<?= site_url('estacion_trabajo/crear'); ?>"><i class="fa fa-plus-circle"></i> Agregar Estación de Trabajo</a>
                        </div>
                        <br/>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($estaciones as $estacion): ?>
                                <tr>
                                    <td><?= $estacion['id'] ?></td>
                                    <td><?= $estacion['nombre'] ?></td>
                                    <td><?= $estacion['descripcion'] ?></td>
                                    <td>
                                        <a href="/estacion_trabajo/editar/<?= $estacion['id'] ?>" class="btn btn-warning">Editar</a>
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
