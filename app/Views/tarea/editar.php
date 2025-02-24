<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Editar Tarea
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Editar Tarea</h1>
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
                        <h3 class="card-title">Editar Tarea</h3>
                    </div>
                    <div class="card-body">
                        <form action="<?= site_url('tarea/actualizar/'.$tarea['id']) ?>" method="post">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $tarea['nombre'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion"><?= $tarea['descripcion'] ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="tiempo_estimado">Tiempo Estimado (min)</label>
                                <input type="number" class="form-control" id="tiempo_estimado" name="tiempo_estimado" value="<?= $tarea['tiempo_estimado'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="estacion_trabajo_id">Estación de Trabajo</label>
                                <select class="form-control" id="estacion_trabajo_id" name="estacion_trabajo_id" required>
                                    <?php foreach ($estaciones as $estacion): ?>
                                        <option value="<?= $estacion['id'] ?>" <?= $estacion['id'] == $tarea['estacion_trabajo_id'] ? 'selected' : '' ?>><?= $estacion['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="producto_terminado_id">Producto Terminado</label>
                                <select class="form-control" id="producto_terminado_id" name="producto_terminado_id" required>
                                    <?php foreach ($productos as $producto): ?>
                                        <option value="<?= $producto['id'] ?>" <?= $producto['id'] == $tarea['producto_terminado_id'] ? 'selected' : '' ?>><?= $producto['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
