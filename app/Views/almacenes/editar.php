
<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Editar Almacén
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Editar Almacén</h1>
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
                        <h3 class="card-title">Editar Almacén</h3>
                    </div>
                    <div class="card-body">
                        <form action="/almacenes/actualizar/<?= $almacen['id'] ?>" method="post">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $almacen['nombre'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="descripcion_ubicacion">Descripción de Ubicación</label>
                                <textarea class="form-control" id="descripcion_ubicacion" name="descripcion_ubicacion" required><?= $almacen['descripcion_ubicacion'] ?></textarea>
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