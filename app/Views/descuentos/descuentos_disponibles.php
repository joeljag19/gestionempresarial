<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Descuentos Disponibles
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Descuentos Disponibles</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <form id="form-descuento-disponible">
            <div class="form-group">
                <label for="nombre">Nombre del Descuento</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="monto">Monto</label>
                <input type="number" class="form-control" id="monto" name="monto" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="tipo_monto">Tipo de Monto</label>
                <select class="form-control" id="tipo_monto" name="tipo_monto">
                    <option value="fijo">Fijo</option>
                    <option value="porcentaje">Porcentaje</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Agregar Descuento</button>
        </form>
        <h3>Descuentos Disponibles</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Monto</th>
                    <th>Tipo de Monto</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($descuentos_disponibles as $descuento): ?>
                    <tr>
                        <td><?= $descuento['nombre'] ?></td>
                        <td><?= $descuento['tipo_monto'] == 'fijo' ? $descuento['monto'] : $descuento['monto'] . '%' ?></td>
                        <td><?= $descuento['tipo_monto'] == 'fijo' ? 'Fijo' : 'Porcentaje' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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

$('#form-descuento-disponible').submit(function(e) {
    e.preventDefault();
    var formData = $(this).serialize();
    $.ajax({
        url: '<?= base_url('descuentos/guardarDisponible') ?>',
        method: 'POST',
        data: formData,
        success: function(response) {
            if (response.status === 'success') {
                Toast.fire({
                    icon: 'success',
                    title: 'Descuento agregado exitosamente.'
                });
                location.reload();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Error al agregar el descuento.'
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
