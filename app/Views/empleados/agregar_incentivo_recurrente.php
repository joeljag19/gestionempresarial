<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Agregar Incentivo Recurrente
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Agregar Incentivo Recurrente</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <form id="form-incentivo-recurrente">
            <div class="form-group">
                <label for="empleado_id">Empleado</label>
                <select class="form-control select2" id="empleado_id" name="empleado_id" required>
                    <option value="">Seleccionar empleado</option>
                    <?php foreach ($empleados as $empleado): ?>
                        <option value="<?= $empleado['id'] ?>"><?= $empleado['primer_nombre'] . ' ' . $empleado['apellido'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="incentivo">Incentivo</label>
                <select class="form-control" id="incentivo" name="incentivo" required>
                    <option value="">Seleccionar incentivo</option>
                    <?php foreach ($incentivos as $incentivo): ?>
                        <option value="<?= $incentivo['id'] ?>" data-tipo="<?= $incentivo['tipo_monto'] ?>" data-monto="<?= $incentivo['monto'] ?>">
                            <?= $incentivo['nombre'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="monto">Monto</label>
                <input type="number" class="form-control" id="monto" name="monto" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="fecha_inicio">Fecha de Inicio</label>
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
            </div>
            <div class="form-group">
                <label for="fecha_fin">Fecha de Fin</label>
                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin">
            </div>
            <div class="form-group">
                <label for="comentario">Comentario</label>
                <textarea class="form-control" id="comentario" name="comentario" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Incentivo Recurrente</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<script>
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

$(document).ready(function() {
    $('.select2').select2({
        placeholder: "Seleccionar empleado",
        allowClear: true
    });

    $('#incentivo').change(function() {
        const selectedOption = $(this).find('option:selected');
        const tipoMonto = selectedOption.data('tipo');
        const monto = selectedOption.data('monto');

        if (tipoMonto === 'fijo') {
            $('#monto').val(monto).prop('readonly', true);
        } else {
            $('#monto').val('').prop('readonly', false);
        }
    });
});

$('#form-incentivo-recurrente').submit(function(e) {
    e.preventDefault();
    const formData = $(this).serialize();
    $.ajax({
        url: '<?= base_url('empleados/guardarIncentivoRecurrente') ?>',
        method: 'POST',
        data: formData,
        success: function(response) {
            if (response.status === 'success') {
                Toast.fire({
                    icon: 'success',
                    title: 'Incentivo recurrente guardado exitosamente.'
                });
                location.reload();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Error al guardar el incentivo recurrente.'
                });
            }
        },
        error: function() {
            Toast.fire({
                icon: 'error',
                title: 'Error de servidor.'
            });
        }
    });
});
</script>
<?= $this->endSection() ?>
