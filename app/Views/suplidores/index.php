<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Listado de Suplidores
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Suplidores</h1>
            </div>
            <div class="col-sm-6">
                <a href="<?= base_url('/suplidores/agregar') ?>" class="btn btn-primary float-sm-right">Agregar Suplidor</a>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($suplidores as $suplidor): ?>
                    <tr>
                        <td><?= esc($suplidor['codigo_suplidor']) ?></td>
                        <td><?= esc($suplidor['nombre']) ?></td>
                        <td><?= esc($suplidor['tipo']) ?></td>
                        <td><?= esc($suplidor['email']) ?></td>
                        <td><?= esc($suplidor['telefono']) ?></td>
                        <td>
                            <a href="<?= base_url('/suplidores/editar/'.$suplidor['id']) ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="<?= base_url('/suplidores/eliminar/'.$suplidor['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este suplidor?')">Eliminar</a>
                            <a href="<?= base_url('/suplidores/detalles/'.$suplidor['id']) ?>" class="btn btn-info btn-sm">Ver Detalles</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
