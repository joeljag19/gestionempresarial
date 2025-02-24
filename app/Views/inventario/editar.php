<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Editar Ítem de Inventario
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Editar Ítem de Inventario</h1>
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
                        <h3 class="card-title">Editar Ítem de Inventario</h3>
                    </div>
                    <div class="card-body">
                        <form action="/inventario/actualizar/<?= $item['id'] ?>" method="post">
                            <div class="form-group">
                                <label for="materiaprima_id">materiaprima</label>
                                <select class="form-control" id="materiaprima_id" name="materiaprima_id" required>
                                    <?php foreach ($materiaprimas as $materiaprima): ?>
                                    <option value="<?= $materiaprima['id'] ?>" <?= $materiaprima['id'] == $item['materiaprima_id'] ? 'selected' : '' ?>><?= $materiaprima['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="cantidad">Cantidad</label>
                                <input type="number" class="form-control" id="cantidad" name="cantidad" value="<?= $item['cantidad'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="id_almacen">Almacén</label>
                                <select class="form-control" id="id_almacen" name="id_almacen" required>
                                    <?php foreach ($almacenes as $almacen): ?>
                                    <option value="<?= $almacen['id'] ?>" <?= $almacen['id'] == $item['id_almacen'] ? 'selected' : '' ?>><?= $almacen['nombre'] ?></option>
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
