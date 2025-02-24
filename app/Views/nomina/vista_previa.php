<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Vista Previa de Nómina
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Vista Previa de Nómina</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <?php foreach ($vista_previa as $nomina): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h3><?= $nomina['empleado']['primer_nombre'] . ' ' . $nomina['empleado']['apellido'] ?></h3>
                </div>
                <div class="card-body">
                    <p><strong>Salario Base:</strong> <?= $nomina['salario_base'] ?></p>
                    <p><strong>Incentivos:</strong></p>
                    <ul>
                        <?php foreach ($nomina['incentivos']['detalles'] as $incentivo): ?>
                            <li><?= $incentivo['descripcion'] ?>: <?= $incentivo['monto'] ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <p><strong>Bonificaciones:</strong></p>
                    <ul>
                        <?php foreach ($nomina['bonificaciones']['detalles'] as $bonificacion): ?>
                            <li><?= $bonificacion['descripcion'] ?>: <?= $bonificacion['monto'] ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <p><strong>Deducciones:</strong></p>
                    <ul>
                        <?php foreach ($nomina['deducciones']['detalles'] as $deduccion): ?>
                            <li><?= $deduccion['descripcion'] ?>: <?= $deduccion['monto'] ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <p><strong>Salario Neto:</strong> <?= $nomina['salario_neto'] ?></p>
                </div>
            </div>
        <?php endforeach; ?>
        <form action="<?= base_url('nomina/generarNominaDefinitiva') ?>" method="post">
            <button type="submit" class="btn btn-primary">Generar Nómina Definitiva</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
