empleados<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Lista de Empleados
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Lista de Empleados</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <a href="<?= base_url('empleados/crear') ?>" class="btn btn-primary mb-3">Crear Empleado</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Primer Nombre</th>
                    <th>Apellido</th>
                    <th>Cédula</th>
                    <th>Género</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($empleados as $empleado): ?>
                <tr>
                    <td><?= $empleado['id'] ?></td>
                    <td><?= $empleado['primer_nombre'] ?></td>
                    <td><?= $empleado['apellido'] ?></td>
                    <td><?= $empleado['cedula'] ?></td>
                    <td><?= $empleado['genero'] ?></td>
                    <td><?= $empleado['fecha_nacimiento'] ?></td>
                    <td><?= $empleado['estado'] ?></td>
                    <td>
                        <a href="<?= base_url('empleados/editar/' . $empleado['id']) ?>" class="btn btn-warning">Editar</a>
                        <a href="<?= base_url('empleados/eliminar/' . $empleado['id']) ?>" class="btn btn-danger">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
