<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Formatos de Fecha
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Formatos de Fecha</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <form action="<?= base_url('/formatos_fecha/guardar') ?>" method="post">
            <div class="form-group">
                <label for="formato">Formato</label>
                <input type="text" class="form-control" id="formato" name="formato" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion">
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
        <hr>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Formato</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($formatos as $formato): ?>
                    <tr>
                        <td><?= $formato['id'] ?></td>
                        <td><?= $formato['formato'] ?></td>
                        <td><?= $formato['descripcion'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
