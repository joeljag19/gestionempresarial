<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Listado de Clientes
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Clientes</h1>
            </div>
            <div class="col-sm-6">
                <a href="<?= base_url('/clientes/agregar') ?>" class="btn btn-primary float-sm-right">Agregar Cliente</a>
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
                <?php foreach ($clientes as $cliente): ?>
                    <tr>
                        <td><?= esc($cliente['codigo_cliente']) ?></td>
                        <td><?= esc($cliente['nombre']) ?></td>
                        <td><?= esc($cliente['tipo']) ?></td>
                        <td><?= esc($cliente['email']) ?></td>
                        <td><?= esc($cliente['telefono']) ?></td>
                        <td>
                            <a href="<?= base_url('/clientes/editar/'.$cliente['id']) ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="<?= base_url('/clientes/eliminar/'.$cliente['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este cliente?')">Eliminar</a>
                            <a href="<?= base_url('/clientes/detalles/'.$cliente['id']) ?>" class="btn btn-info btn-sm">Ver Detalles</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
