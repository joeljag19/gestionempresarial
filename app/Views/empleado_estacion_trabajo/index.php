<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Asignaciones de Empleados a Estaciones de Trabajo
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Asignaciones de Empleados a Estaciones de Trabajo</h1>
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
                        <h3 class="card-title">Asignaciones</h3>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-start">
                            <a class="btn btn-primary btn-block col-3" href="<?= site_url('empleado_estacion_trabajo/crear'); ?>"><i class="fa fa-plus-circle"></i> Agregar Asignación</a>
                        </div>
                        <br/>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Empleado</th>
                                    <th>Estación de Trabajo</th>
                                    <th>Fecha de Asignación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($asignaciones as $asignacion): ?>
                                <tr>
                                    <td><?= $asignacion['id'] ?></td>
                                    <td><?= $asignacion['nombre_empleado'] ?></td>
                                    <td><?= $asignacion['nombre_estacion'] ?></td>
                                    <td><?= $asignacion['fecha_asignacion'] ?></td>
                                    <td>
                                        <a href="/empleado_estacion_trabajo/editar/<?= $asignacion['id'] ?>" class="btn btn-warning">Editar</a>
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
