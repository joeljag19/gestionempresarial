<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Asignar Estaciones de Trabajo
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Asignar Estaciones de Trabajo a <?= $producto['nombre'] ?></h1>
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
                        <h3 class="card-title">Asignar Estaciones de Trabajo</h3>
                    </div>
                    <div class="card-body">
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= site_url('producto_estacion/guardarAsignacion') ?>" method="post">
                            <input type="hidden" name="producto_terminado_id" value="<?= $producto['id'] ?>">
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
                        <hr>
                        <h3 class="card-title">Estaciones Asignadas</h3>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Estación de Trabajo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($asignaciones as $asignacion): ?>
                                <tr>
                                    <td><?= $asignacion['id'] ?></td>
                                    <td>
                                        <?php
                                            $estacion = array_filter($estaciones, function($e) use ($asignacion) {
                                                return $e['id'] == $asignacion['estacion_trabajo_id'];
                                            });

                                            if (!empty($estacion)) {
                                                $estacion = array_values($estacion)[0];
                                                echo $estacion['nombre'];
                                            } else {
                                                echo 'Estación no encontrada';
                                            }
                                        ?>
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
