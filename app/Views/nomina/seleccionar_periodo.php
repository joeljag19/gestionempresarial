<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Seleccionar Período de Nómina
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Seleccionar Período de Nómina</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <form action="<?= base_url('nomina/generarNominaPorPeriodo') ?>" method="post">
            <div class="form-group">
                <label for="anno">Año</label>
                <select class="form-control" id="anno" name="anno" required>
                    <option value="">Seleccionar Año</option>
                    <?php foreach ($annos as $anno): ?>
                        <option value="<?= $anno['anno'] ?>"><?= $anno['anno'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="periodo_id">Período de Nómina</label>
                <select class="form-control" id="periodo_id" name="periodo_id" required>
                    <option value="">Seleccionar Período</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Generar Nómina</button>
        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $('#anno').change(function() {
        var anno = $(this).val();
        if (anno) {
            $.ajax({
                url: '<?= base_url('nomina/obtenerPeriodosPorAnno') ?>',
                method: 'POST',
                data: { anno: anno },
                success: function(response) {
                    $('#periodo_id').empty().append('<option value="">Seleccionar Período</option>');
                    $.each(response, function(index, periodo) {
                        $('#periodo_id').append('<option value="' + periodo.id + '">' + periodo.nombre + '</option>');
                    });
                }
            });
        } else {
            $('#periodo_id').empty().append('<option value="">Seleccionar Período</option>');
        }
    });
</script>
<?= $this->endSection() ?>
