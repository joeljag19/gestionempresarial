<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Descuentos
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Descuentos</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <form action="<?= base_url('empleados/guardarDescuento') ?>" method="post">
            <div class="form-group">
                <label for="empleado_id">Empleado</label>
                <select class="form-control" id="empleado_id" name="empleado_id" required>
                    <?php foreach ($empleados as $empleado): ?>
                        <option value="<?= $empleado['id'] ?>"><?= $empleado['primer_nombre'] . ' ' . $empleado['apellido'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="descuento">Descuento</label>
                <select class="form-control" id="descuento" name="descuento" required>
                    <?php foreach ($descuentos_disponibles as $descuento): ?>
                        <option value="<?= $descuento['id'] ?>" data-monto="<?= $descuento['monto'] ?>" data-tipo-monto="<?= $descuento['tipo_monto'] ?>">
                            <?= $descuento['nombre'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="monto">Monto</label>
                <input type="number" class="form-control" id="monto" name="monto" step="0.01" min="0" required>
            </div>
            <div class="form-group">
                <label for="fecha">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="form-group">
                <label for="frecuencia">Frecuencia</label>
                <select class="form-control" id="frecuencia" name="frecuencia">
                    <option value="">No Recurrente</option>
                    <option value="mensual">Mensual</option>
                    <option value="quincenal">Quincenal</option>
                </select>
            </div>
            <div class="form-group">
                <label for="periodo_inicio">Período de Inicio</label>
                <select class="form-control" id="periodo_inicio" name="periodo_inicio" required>
                    <?php foreach ($periodos as $periodo): ?>
                        <option value="<?= $periodo['id'] ?>"><?= $periodo['nombre'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="toggle_fin">Agregar Período de Terminación</label>
                <input type="checkbox" id="toggle_fin" disabled>
            </div>
            <div class="form-group" id="periodo_fin_group" style="display:none;">
                <label for="periodo_fin">Período de Fin</label>
                <select class="form-control" id="periodo_fin" name="periodo_fin">
                    <option value="">Sin Terminación</option>
                    <?php foreach ($periodos as $periodo): ?>
                        <option value="<?= $periodo['id'] ?>"><?= $periodo['nombre'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="comentario">Comentario</label>
                <textarea class="form-control" id="comentario" name="comentario"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Descuento</button>
        </form>

        <h3 class="mt-5">Descuentos Asignados</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Empleado</th>
                    <th>Descuento</th>
                    <th>Monto</th>
                    <th>Fecha</th>
                    <th>Frecuencia</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Comentario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($descuentos as $descuento): ?>
                    <tr>
                        <td><?= $descuento['primer_nombre'] . ' ' . $descuento['apellido'] ?></td>
                        <td><?= $descuento['nombre'] ?></td>
                        <td><?= number_format($descuento['monto'], 2) ?></td>
                        <td><?= $descuento['fecha'] ?></td>
                        <td><?= ucfirst($descuento['frecuencia'] ?? 'No recurrente') ?></td>
                        <td><?= $descuento['periodo_inicio_nombre'] ?? 'N/A' ?></td>
                        <td><?= $descuento['periodo_fin_nombre'] ?? ($descuento['frecuencia'] ? 'Indefinido' : $descuento['periodo_inicio_nombre']) ?></td>
                        <td><?= $descuento['comentario'] ?? '' ?></td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="eliminarDescuento(<?= $descuento['id'] ?>)">Eliminar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $('#descuento').change(function() {
        var selectedOption = $(this).find('option:selected');
        var monto = selectedOption.data('monto');
        var tipoMonto = selectedOption.data('tipo-monto');
        
        if (monto > 0) {
            $('#monto').val(monto);
        }
    });

    $('#frecuencia').change(function() {
        var frecuencia = $(this).val();
        if (frecuencia === 'mensual' || frecuencia === 'quincenal') {
            $('#toggle_fin').prop('disabled', false);
            $('#periodo_inicio').prop('required', true);
        } else {
            $('#toggle_fin').prop('disabled', true);
            $('#toggle_fin').prop('checked', false);
            $('#periodo_fin').prop('required', false);
            $('#periodo_fin_group').hide();
        }
    });

    $('#toggle_fin').change(function() {
        if ($(this).is(':checked')) {
            $('#periodo_fin_group').show();
            $('#periodo_fin').prop('required', true);
        } else {
            $('#periodo_fin_group').hide();
            $('#periodo_fin').prop('required', false);
        }
    });

    function eliminarDescuento(id) {
        if (confirm('¿Estás seguro de que deseas eliminar este descuento?')) {
            $.ajax({
                url: '<?= base_url('empleados/eliminarDescuento') ?>/' + id,
                method: 'POST',
                success: function(response) {
                    if (response.status === 'success') {
                        location.reload();
                    } else {
                        alert('Error al eliminar el descuento');
                    }
                }
            });
        }
    }
</script>
<?= $this->endSection() ?>