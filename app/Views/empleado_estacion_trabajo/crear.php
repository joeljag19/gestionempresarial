<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Agregar Asignación
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Agregar Asignación</h1>
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
                        <h3 class="card-title">Nueva Asignación</h3>
                    </div>
                    <div class="card-body">
                        <form action="<?= site_url('empleado_estacion_trabajo/guardar') ?>" method="post">
                            <div class="form-group">
                                <label for="empleado_id">Empleado</label>
                                <select class="form-control" id="empleado_id" name="empleado_id" required>
                                    <?php foreach ($empleados as $empleado): ?>
                                        <option value="<?= $empleado['id'] ?>"><?= $empleado['nombre'] ?> <?= $empleado['apellido'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="estacion_trabajo_id">Estación de Trabajo</label>
                                <select class="form-control" id="estacion_trabajo_id" name="estacion_trabajo_id" required>
                                    <?php foreach ($estaciones as $estacion): ?>
                                        <option value="<?= $estacion['id'] ?>"><?= $estacion['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
