<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Lista de Tareas
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Lista de Tareas</h1>
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
                        <h3 class="card-title">Tareas</h3>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-start">
                            <a class="btn btn-primary btn-block col-3" href="<?= site_url('tarea/crear'); ?>"><i class="fa fa-plus-circle"></i> Agregar Tarea</a>
                        </div>
                        <br/>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Tiempo Estimado (min)</th>
                                    <th>Estación de Trabajo</th>
                                    <th>Producto Terminado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tareas as $tarea): ?>
                                <tr>
                                    <td><?= $tarea['id'] ?></td>
                                    <td><?= $tarea['nombre'] ?></td>
                                    <td><?= $tarea['descripcion'] ?></td>
                                    <td><?= $tarea['tiempo_estimado'] ?></td>
                                    <td><?= $tarea['nombre_estacion'] ?></td>
                                    <td><?= $tarea['nombre_producto'] ?></td>
                                    <td>
                                        <a href="/tarea/editar/<?= $tarea['id'] ?>" class="btn btn-warning">Editar</a>
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
