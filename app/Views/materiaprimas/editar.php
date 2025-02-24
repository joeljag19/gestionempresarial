<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Editar materiaprima
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Editar materiaprima</h1>
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
                        <h3 class="card-title">Editar materiaprima</h3>
                    </div>
                    <div class="card-body">
                        <form action="/materiaprimas/actualizar/<?= $materiaprima['id'] ?>" method="post">
                        <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $materiaprima['nombre'] ?>" required>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                <label for="categoria">Categoría:</label> 
                                <select class="form-control" name="categoria" id="categoria"> 
                                    <?php foreach($categorias as $categoria): ?> 
                                        <option value="<?= $categoria['id'] ?>" <?= $categoria['id'] == $materiaprima['grupo_de_materia'] ? 'selected' : '' ?> ><?= $categoria['nombre'] ?></option>
                                    <?php endforeach; ?> 
                                </select>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?= $materiaprima['descripcion'] ?>" required>
                 </div>
                <!-- /.form-group -->
                <div class="form-group">
                <label for="grupo_de_materiaprimas">Unidad Medida</label>
                                <select class="form-control" name="unidad_de_medida" id="unidad_de_medida"> 
                                    <?php foreach($medidas as $medida): ?> 
                                        <option value="<?= $medida['id'] ?>" <?= $medida['id'] == $materiaprima['unidad_de_medida'] ? 'selected' : '' ?>><?= $medida['nombre'] ?> (<?= $medida['abreviacion'] ?>)</option>
                                    <?php endforeach; ?> 
                                </select>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
              <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="codigo_de_barras">Código de Barras</label>
                    <input type="text" class="form-control" id="codigo_de_barras" name="codigo_de_barras" value="<?= $materiaprima['codigo_de_barras'] ?>" required>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-12 col-sm-6">
                <div class="form-group">
                <label for="codigo_de_barras">Costo Material</label>
                <input type="number" class="form-control" id="costo_material" name="costo_material" value="<?= $materiaprima['costo_unitario'] ?>" required>
                  </div>
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
