<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Seleccionar Tipo de Período de Nómina
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Seleccionar Tipo de Período de Nómina</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <form action="<?= base_url('nomina/configurarPeriodos') ?>" method="post">
            <div class="form-group">
                <label for="tipo">Tipo de Período de Nómina</label>
                <select class="form-control" id="tipo" name="tipo" required>
                    <option value="quincenal">Quincenal</option>
                    <option value="mensual">Mensual</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Configurar Períodos</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
