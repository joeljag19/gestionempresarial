<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Listado de Nóminas
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Listado de Nóminas</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <button class="btn btn-primary" data-toggle="modal" data-target="#nuevoPeriodoModal">Nuevo Periodo de Nómina</button>

        <h3 class="mt-5">Nóminas Generadas</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Periodo</th>
                    <th>Estado</th>
                    <th>Total Pago</th>
                    <th>Total Ingresos Adicionales</th>
                    <th>Total Deducciones</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($nominas as $nomina): ?>
                    <tr>
                        <td><?= $nomina['periodo_nombre'] ?></td>
                        <td><?= ucfirst($nomina['estado']) ?></td>
                        <td><?= number_format($nomina['total_pago'], 2) ?></td>
                        <td><?= number_format($nomina['total_ingresos_adicionales'], 2) ?></td>
                        <td><?= number_format($nomina['total_deducciones'], 2) ?></td>
                        <td>
                            <?php if ($nomina['estado'] == 'completada'): ?>
                                <a href="<?= base_url('nomina/ver/' . $nomina['id']) ?>" class="btn btn-info btn-sm">Ver</a>
                            <?php else: ?>
                                <a href="<?= base_url('nomina/calcular/' . $nomina['id']) ?>" class="btn btn-warning btn-sm">Calcular</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal para nuevo periodo de nómina -->
<div class="modal fade" id="nuevoPeriodoModal" tabindex="-1" role="dialog" aria-labelledby="nuevoPeriodoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nuevoPeriodoModalLabel">Nuevo Periodo de Nómina</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('nomina/generar') ?>" method="post">
                    <div class="form-group">
                        <label for="anio">Año</label>
                        <select class="form-control" id="anio" name="anio" required>
                            <?php foreach ($anios as $anio): ?>
                                <option value="<?= $anio ?>"><?= $anio ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="periodo_id">Periodo</label>
                        <select class="form-control" id="periodo_id" name="periodo_id" required>
                            <!-- Aquí se llenará dinámicamente con los periodos disponibles del año seleccionado -->
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Generar Nómina</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#anio').change(function() {
        var anio = $(this).val();
        $.ajax({
            url: '<?= base_url('nomina/obtenerPeriodosDisponibles') ?>',
            method: 'GET',
            data: { anio: anio },
            success: function(response) {
                var periodos = response.periodos;
                $('#periodo_id').empty();
                periodos.forEach(function(periodo) {
                    $('#periodo_id').append('<option value="' + periodo.id + '">' + periodo.nombre + '</option>');
                });
            }
        });
    });

    // Al cargar la página, disparar el evento change para cargar los periodos del primer año
    $('#anio').trigger('change');
</script>
<?= $this->endSection() ?>
