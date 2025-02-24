<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Incentivos Recurrentes
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Incentivos Recurrentes</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <form action="<?= base_url('empleados/guardarIncentivoRecurrente') ?>" method="post">
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
                    <?php foreach ($incentivos as $incentivo): ?>
                        <option value="<?= $incentivo['id'] ?>"><?= $incentivo['nombre'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="monto">Monto</label>
                <input type="number" class="form-control" id="monto" name="monto" required>
            </div>
            <div class="form-group">
                <label for="frecuencia">Frecuencia</label>
                <select class="form-control" id="frecuencia" name="frecuencia" required>
                    <option value="quincenal">Quincenal</option>
                    <option value="mensual">Mensual</option>
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
                <input type="checkbox" id="toggle_fin">
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
            <button type="submit" class="btn btn-primary">Guardar Incentivo</button>
        </form>

        <h3 class="mt-5">Incentivos Recurrentes Asignados</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Empleado</th>
                    <th>Incentivo</th>
                    <th>Monto</th>
                    <th>Frecuencia</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($incentivos_recurrentes as $incentivo): ?>
                    <tr>
                        <td><?= $incentivo['primer_nombre'] . ' ' . $incentivo['apellido'] ?></td>
                        <td><?= $incentivo['incentivo_nombre'] ?></td>
                        <td><?= $incentivo['monto'] ?></td>
                        <td><?= ucfirst($incentivo['frecuencia']) ?></td>
                        <td><?= $incentivo['periodo_inicio'] ?></td>
                        <td><?= $incentivo['periodo_fin'] ? $incentivo['periodo_fin'] : 'Indefinido' ?></td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="eliminarIncentivoRecurrente(<?= $incentivo['id'] ?>)">Eliminar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $('#toggle_fin').change(function() {
        if ($(this).is(':checked')) {
            $('#periodo_fin_group').show();
        } else {
            $('#periodo_fin_group').hide();
        }
    });

    function eliminarIncentivoRecurrente(id) {
        if (confirm('¿Estás seguro de que deseas eliminar este incentivo recurrente?')) {
            $.ajax({
                url: '<?= base_url('empleados/eliminarIncentivoRecurrente') ?>/' + id,
                method: 'POST',
                success: function(response) {
                    if (response.status === 'success') {
                        location.reload();
                    } else {
                        alert('Error al eliminar el incentivo recurrente');
                    }
                }
            });
        }
    }
</script>
<?= $this->endSection() ?>
