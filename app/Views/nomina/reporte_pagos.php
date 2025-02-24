<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Reporte de Pagos
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Reporte de Pagos</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('nomina') ?>">Nómina</a></li>
                    <li class="breadcrumb-item active">Reporte de Pagos</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Reporte de Pagos - Período: <?= esc($periodo['nombre']) ?></h3>
            </div>
            <div class="card-body">
                <p>Resumen de los pagos, incentivos, descuentos y deducciones para los empleados en el período <?= formatear_fecha($periodo['inicio']) ?> al <?= formatear_fecha($periodo['fin']) ?>.</p>
<!-- En la cabecera o al final del card-body en calcular.php -->
<div class="text-right mt-3">
    <a href="<?= base_url('nomina/reportePagos/' . $nomina['id']) ?>" class="btn btn-primary">Generar Reporte de Pagos (HTML)</a>
    <a href="<?= base_url('nomina/reportePagos/' . $nomina['id'] . '/pdf') ?>" class="btn btn-success">Exportar Reporte a PDF</a>
</div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Empleado</th>
                            <th>Cédula</th>
                            <th>Salario</th>
                            <th>Incentivos (Monto)</th>
                            <th>Descuentos (Monto)</th>
                            <th>AFP</th>
                            <th>SFS</th>
                            <th>ISR</th>
                            <th>Infotep</th>
                            <th>Total Deducciones</th>
                            <th>Total Pago</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reporte as $registro): ?>
                            <tr>
                                <td><?= esc($registro['empleado']) ?></td>
                                <td><?= esc($registro['cedula']) ?></td>
                                <td><?= formatear_moneda($registro['salario']) ?></td>
                                <td>
                                    <?php foreach ($registro['incentivos'] as $monto): ?>
                                        <?= formatear_moneda($monto) ?><br>
                                    <?php endforeach; ?>
                                    <strong>Total: <?= formatear_moneda($registro['totalIncentivos']) ?></strong>
                                </td>
                                <td>
                                    <?php foreach ($registro['descuentos'] as $monto): ?>
                                        <?= formatear_moneda($monto) ?><br>
                                    <?php endforeach; ?>
                                    <strong>Total: <?= formatear_moneda($registro['totalDescuentos']) ?></strong>
                                </td>
                                <td><?= formatear_moneda($registro['afp']) ?></td>
                                <td><?= formatear_moneda($registro['sfs']) ?></td>
                                <td><?= formatear_moneda($registro['isr']) ?></td>
                                <td><?= formatear_moneda($registro['infotep']) ?></td>
                                <td><?= formatear_moneda($registro['totalDeducciones']) ?></td>
                                <td><?= formatear_moneda($registro['totalPago']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3">Totales</th>
                            <th><?= formatear_moneda($totales['incentivos']) ?></th>
                            <th><?= formatear_moneda($totales['descuentos']) ?></th>
                            <th><?= formatear_moneda($totales['afp']) ?></th>
                            <th><?= formatear_moneda($totales['sfs']) ?></th>
                            <th><?= formatear_moneda($totales['isr']) ?></th>
                            <th><?= formatear_moneda($totales['infotep']) ?></th>
                            <th><?= formatear_moneda($totales['totalDeducciones']) ?></th>
                            <th><?= formatear_moneda($totales['totalPago']) ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>