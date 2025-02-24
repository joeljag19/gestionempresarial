<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Incentivos Aplicados
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Incentivos Aplicados</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <h3>Incentivos Aplicados a <?= $empleado['primer_nombre'] . ' ' . $empleado['apellido'] ?></h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Incentivo</th>
                    <th>Monto</th>
                    <th>Fecha</th>
                    <th>Comentario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($incentivos_aplicados as $incentivo): ?>
                    <tr>
                        <td><?= $incentivo['incentivo_nombre'] ?></td>
                        <td><?= $incentivo['monto'] ?></td>
                        <td><?= $incentivo['fecha'] ?></td>
                        <td><?= $incentivo['comentario'] ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editarIncentivo(<?= $incentivo['id'] ?>)">Editar</button>
                            <button class="btn btn-danger btn-sm" onclick="eliminarIncentivo(<?= $incentivo['id'] ?>)">Eliminar</button>
                        </td>
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

function editarIncentivo(id) {
    // Lógica para editar incentivo
}

function eliminarIncentivo(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url('empleados/eliminarIncentivo') ?>/' + id,
                method: 'POST',
                success: function(response) {
                    if (response.status === 'success') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Incentivo eliminado exitosamente.'
                        });
                        location.reload();
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Error al eliminar el incentivo.'
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
        }
    });
}
</script>
<?= $this->endSection() ?>
