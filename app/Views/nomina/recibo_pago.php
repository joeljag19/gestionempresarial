<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Recibo de Pago
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Recibo de Pago</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('nomina') ?>">Nómina</a></li>
                    <li class="breadcrumb-item active">Recibo de Pago</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recibo de pago: <?= esc($empleado['primer_nombre'] . ' ' . $empleado['apellido']) ?> ID <?= esc($nominaEmpleado['id']) ?></h3>
                <div class="card-tools">
                    <a href="<?= base_url('nomina/calcular/' . $nomina['id']) ?>" class="btn btn-secondary">Volver</a>
                    <button class="btn btn-primary" onclick="window.print()">Editar</button>
                </div>
            </div>
            <div class="card-body">
                <p>Conoce el detalle de los devengados y deducciones incluidos en el período de nómina.</p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fas fa-user"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Joel Guzman</span>
                                <span class="info-box-number">CC: <?= esc($empleado['cedula']) ?>, <?= esc(direccion_empresa()) ?> / <?= esc($empleado['correo_personal']) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="fas fa-user"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"><?= esc(nombre_empresa()) ?></span>
                                <span class="info-box-number">RNC: <?= esc(empresa_rnc()) ?>, <?= esc(direccion_empresa()) ?> / <?= esc(telefono_empresa()) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Fecha de inicio de cálculo</label>
                            <input type="text" class="form-control" value="<?= formatear_fecha($periodo['inicio']) ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Fecha de fin de cálculo</label>
                            <input type="text" class="form-control" value="<?= formatear_fecha($periodo['fin']) ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Medio de pago</label>
                            <input type="text" class="form-control" value="Transferencia bancaria" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Días calculados</label>
                            <input type="text" class="form-control" value="11.915" readonly>
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Resumen de pago</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <p><strong>Salario</strong></p>
                                <p><?= formatear_moneda($nominaEmpleado['salario']) ?></p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Ingresos adicionales</strong></p>
                                <p><?= formatear_moneda($nominaEmpleado['total_ingresos_adicionales']) ?></p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Deducciones</strong></p>
                                <p><?= formatear_moneda($nominaEmpleado['total_deducciones']) ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <h4><strong>TOTAL DE PAGO</strong> <?= formatear_moneda($nominaEmpleado['total_pago']) ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Ingresos</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Concepto</th>
                                            <th>Cantidad</th>
                                            <th>Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($ingresos as $ingreso): ?>
                                            <tr>
                                                <td><?= esc($ingreso['concepto']) ?></td>
                                                <td></td>
                                                <td><?= formatear_moneda($ingreso['valor']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2"><strong>TOTAL</strong></td>
                                            <td><?= formatear_moneda(array_sum(array_column($ingresos, 'valor'))) ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Deducciones</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Concepto</th>
                                            <th>Porcentaje</th>
                                            <th>Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($deducciones as $deduccion): ?>
                                            <tr>
                                                <td><?= esc($deduccion['concepto']) ?></td>
                                                <td><?= esc($deduccion['porcentaje'])?></td>
                                                <td><?= formatear_moneda($deduccion['valor']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2"><strong>TOTAL</strong></td>
                                            <td><?= formatear_moneda(array_sum(array_column($deducciones, 'valor'))) ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>