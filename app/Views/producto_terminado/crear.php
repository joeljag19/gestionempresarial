<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Agregar Producto Terminado
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Agregar Producto Terminado</h1>
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
                        <h3 class="card-title">Nuevo Producto</h3>
                    </div>
                    <div class="card-body">
                        <form action="<?= site_url('producto_terminado/guardar') ?>" method="post">
                            <div class="form-group">
                                <label for="codigo_de_barra">Código de Barra</label>
                                <input type="text" class="form-control" id="codigo_de_barra" name="codigo_de_barra" required>
                            </div>
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="categoria_id">Categoría</label>
                                <select class="form-control" id="categoria_id" name="categoria_id" required>
                                    <?php foreach ($categorias as $categoria): ?>
                                        <option value="<?= $categoria['id'] ?>"><?= $categoria['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="unidad_medida_id">Unidad de Medida</label>
                                <select class="form-control" id="unidad_medida_id" name="unidad_medida_id" required>
                                    <?php foreach ($unidades as $unidad): ?>
                                        <option value="<?= $unidad['id'] ?>"><?= $unidad['nombre'] ?> (<?= $unidad['abreviacion'] ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="impuesto">Impuesto</label>
                                <input type="text" class="form-control" id="impuesto" name="impuesto" required>
                            </div>
                            <div class="form-group">
                                <label for="costo_unidad">Costo Unidad</label>
                                <input type="text" class="form-control" id="costo_unidad" name="costo_unidad" required>
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
