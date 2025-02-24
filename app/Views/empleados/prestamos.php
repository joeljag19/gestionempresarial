<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Gestión de Préstamos
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Gestión de Préstamos</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <form id="form-prestamos">
            <div class="form-group">
                <label for="monto">Monto del Préstamo</label>
                <input type="number" class="form-control" id="monto" name="monto" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="fecha_inicio">Fecha de Inicio</label>
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
            </div>
            <div class="form-group">
                <label for="fecha_fin">Fecha de Fin</label>
                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
            </div>
            <div class="form-group">
                <label for="frecuencia">Frecuencia de Pago</label>
                <select class="form-control" id="frecuencia" name="frecuencia">
                    <option value="quincenal">Quincenal</option>
                    <option value="mensual">Mensual</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Préstamo</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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

$('#form-prestamos').submit(function(e) {
    e.preventDefault();
    var formData = $(this).serialize();
    $.ajax({
        url: '<?= base_url('empleados/guardarPrestamo/' . $empleado_id) ?>',
        method: 'POST',
        data: formData,
        success: function(response) {
            if (response.status === 'success') {
                Toast.fire({
                    icon: 'success',
                    title: 'Préstamo guardado exitosamente.'
                });
                location.reload();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Error al guardar el préstamo.'
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
