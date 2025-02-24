<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Incentivos
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Incentivos</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <form action="<?= base_url('empleados/guardarIncentivo') ?>" method="post">
            <div class="form-group">
                <label for="empleado_id">Empleado</label>
                <select class="form-control" id="empleado_id" name="empleado_id" required>
                    <?php foreach ($empleados as $empleado): ?>
                        <option value="<?= $empleado['id'] ?>"><?= $empleado['primer_nombre'] . ' ' . $empleado['apellido'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="incentivo">Incentivo</label>
                <select class="form-control" id="incentivo" name="incentivo" required>
                    <option value="">Seleccione</option>
                    <?php foreach ($incentivos_disponibles as $incentivo): ?>
                        <option value="<?= $incentivo['id'] ?>" data-monto="<?= $incentivo['monto'] ?>" data-tipo-incentivo="<?= $incentivo['tipo_incentivo'] ?>">
                            <?= $incentivo['nombre'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group" id="cantidad_group" style="display:none;">
                <label for="cantidad">Cantidad (horas extras)</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" step="0.01" min="0">
            </div>
            <div class="form-group" id="monto_group">
                <label for="monto">Monto</label>
                <input type="number" class="form-control" id="monto" name="monto" step="0.01" min="0" required>
            </div>
            <div class="form-group">
                <label for="fecha">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="form-group">
                <label for="frecuencia">Frecuencia</label>
                <select class="form-control" id="frecuencia" name="frecuencia" required>
                    <option value="norecurrente">No Recurrente</option>
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
            <button type="submit" class="btn btn-primary">Guardar Incentivo</button>
        </form>

        <h3 class="mt-5">Incentivos Asignados</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Empleado</th>
                    <th>Incentivo</th>
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
                <?php foreach ($incentivos as $incentivo): ?>
                    <tr>
                        <td><?= $incentivo['primer_nombre'] . ' ' . $incentivo['apellido'] ?></td>
                        <td><?= $incentivo['nombre'] ?></td>
                        <td><?= $incentivo['monto'] ?></td>
                        <td><?= $incentivo['fecha'] ?></td>
                        <td><?= ucfirst($incentivo['frecuencia']) ?></td>
                        <td><?= $incentivo['periodo_inicio_nombre'] ?></td>
                        <td><?= $incentivo['periodo_fin_nombre'] ?: $incentivo['periodo_inicio_nombre'] ?></td>
                        <td><?= $incentivo['comentario'] ?></td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="eliminarIncentivo(<?= $incentivo['id'] ?>)">Eliminar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $('#incentivo').change(function() {
        var selectedOption = $(this).find('option:selected');
        var monto = selectedOption.data('monto');
        var tipoIncentivo = selectedOption.data('tipo-incentivo');
        
        if (monto > 0) {
            $('#monto').val(monto);
        }

        if (['extra_35', 'extra_100', 'extra_15', 'extra_no_labor_100'].includes(tipoIncentivo)) {
            $('#cantidad_group').show();
            $('#monto').prop('disabled', true);
        } else {
            $('#cantidad_group').hide();
            $('#cantidad').val('');
            $('#monto').prop('disabled', false);
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

    function eliminarIncentivo(id) {
        if (confirm('¿Estás seguro de que deseas eliminar este incentivo?')) {
            $.ajax({
                url: '<?= base_url('empleados/eliminarIncentivo') ?>/' + id,
                method: 'POST',
                success: function(response) {
                    if (response.status === 'success') {
                        location.reload();
                    } else {
                        alert('Error al eliminar el incentivo');
                    }
                }
            });
        }
    }
</script>
<?= $this->endSection() ?>
