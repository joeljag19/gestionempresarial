<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Pagos - Período: <?= esc($periodo['nombre']) ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .totales { font-weight: bold; }
    </style>
</head>
<body>
    <h1>Reporte de Pagos - Período: <?= esc($periodo['nombre']) ?></h1>
    <p>Resumen de los pagos, incentivos, descuentos y deducciones para los empleados en el período <?= formatear_fecha($periodo['inicio']) ?> al <?= formatear_fecha($periodo['fin']) ?>.</p>

    <table>
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
            <tr class="totales">
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
</body>
</html>