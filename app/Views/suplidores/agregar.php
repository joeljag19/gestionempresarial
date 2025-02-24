<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Agregar Suplidor
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Agregar Suplidor</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <form id="form-agregar-suplidor" action="<?= base_url('/suplidores/guardar') ?>" method="post">
            <div class="form-group">
                <label for="tipo">Tipo de Suplidor</label>
                <select class="form-control" id="tipo" name="tipo" required>
                    <option value="Empresa">Empresa</option>
                    <option value="Persona Física">Persona Física</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" required>
            </div>
            <div class="form-group">
                <label for="ciudad">Ciudad</label>
                <input type="text" class="form-control" id="ciudad" name="ciudad" required>
            </div>
            <div class="form-group">
                <label for="codigo_postal">Código Postal</label>
                <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" required>
            </div>
            <div class="form-group">
                <label for="pais">País</label>
                <input type="text" class="form-control" id="pais" name="pais" required>
            </div>
            <div class="form-group">
                <label for="rnc_cedula">RNC/Cédula</label>
                <input type="text" class="form-control" id="rnc_cedula" name="rnc_cedula" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Suplidor</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
