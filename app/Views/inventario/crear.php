<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Crear Ítem de Inventario
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Crear Ítem de Inventario</h1>
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
                        <h3 class="card-title">Nuevo Ítem de Inventario</h3>
                    </div>
                    <div class="card-body">
                        <form action="/inventario/guardar" method="post">
                            <div class="form-group">
                                <label for="materiaprima_id">Materia Prima</label>
                                <select class="form-control" id="materiaprima_id" name="materiaprima_id" required>
                                    <?php foreach ($materiaprimas as $materiaprima): ?>
                                    <option value="<?= $materiaprima['id'] ?>"><?= $materiaprima['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="cantidad">Cantidad</label>
                                <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                            </div>
                            <div class="form-group">
                                <label for="accion">Accion Materia Prima</label>
                                <select class="form-control" id="accion" name="accion" required>
                                   
                                    <option value="sumar">Sumar Materia Prima</option>
                                    <option value="restar">Restar Materia Prima</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="motivo">Motivo Movimiento</label>
                                <input type="text" class="form-control" id="motivo" name="motivo" required>

                            </div>
                            <div class="form-group">
                                <label for="id_almacen">Almacén</label>
                                <select class="form-control" id="id_almacen" name="id_almacen" required>
                                    <?php foreach ($almacenes as $almacen): ?>
                                    <option value="<?= $almacen['id'] ?>"><?= $almacen['nombre'] ?></option>
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
