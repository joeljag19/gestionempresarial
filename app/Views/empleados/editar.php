<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Editar Empleado
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Editar Empleado</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <ul class="nav nav-tabs" id="empleadoTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="datos-personales-tab" data-toggle="tab" href="#datos-personales" role="tab" aria-controls="datos-personales" aria-selected="true">Datos Personales</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="direccion-tab" data-toggle="tab" href="#direccion" role="tab" aria-controls="direccion" aria-selected="false">Dirección</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contacto-tab" data-toggle="tab" href="#contacto" role="tab" aria-controls="contacto" aria-selected="false">Contacto</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="movimientos-tab" data-toggle="tab" href="#movimientos" role="tab" aria-controls="movimientos" aria-selected="false">Movimientos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="descuentos-tab" data-toggle="tab" href="#descuentos" role="tab" aria-controls="descuentos" aria-selected="false">Descuentos</a>
            </li>
        </ul>
        <div class="tab-content" id="empleadoTabsContent">
            <div class="tab-pane fade show active" id="datos-personales" role="tabpanel" aria-labelledby="datos-personales-tab">
                <form id="form-datos-personales">
                    <div class="form-group">
                        <label for="primer_nombre">Primer Nombre</label>
                        <input type="text" class="form-control" id="primer_nombre" name="primer_nombre" value="<?= $empleado['primer_nombre'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" value="<?= $empleado['apellido'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="cedula">Cédula</label>
                        <input type="text" class="form-control" id="cedula" name="cedula" value="<?= $empleado['cedula'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="genero">Género</label>
                        <input type="text" class="form-control" id="genero" name="genero" value="<?= $empleado['genero'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?= $empleado['fecha_nacimiento'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <input type="text" class="form-control" id="estado" name="estado" value="<?= $empleado['estado'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="sueldo">Sueldo</label>
                        <input type="number" class="form-control" id="sueldo" name="sueldo" value="<?= $empleado['sueldo'] ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Datos Personales</button>
                </form>
            </div>
            <div class="tab-pane fade" id="direccion" role="tabpanel" aria-labelledby="direccion-tab">
                <form id="form-direccion">
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" value="<?= $direccion['direccion'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="ciudad">Ciudad</label>
                        <input type="text" class="form-control" id="ciudad" name="ciudad" value="<?= $direccion['ciudad'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="pais">País</label>
                        <input type="text" class="form-control" id="pais" name="pais" value="<?= $direccion['pais'] ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Dirección</button>
                </form>
            </div>
            <div class="tab-pane fade" id="contacto" role="tabpanel" aria-labelledby="contacto-tab">
                <form id="form-contacto">
                    <div class="form-group">
                        <label for="numero_celular">Número Celular</label>
                        <input type="text" class="form-control" id="numero_celular" name="numero_celular" value="<?= $contacto['numero_celular'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="correo_personal">Correo Personal</label>
                        <input type="email" class="form-control" id="correo_personal" name="correo_personal" value="<?= $contacto['correo_personal'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="correo_compania">Correo de la Compañía</label>
                        <input type="email" class="form-control" id="correo_compania" name="correo_compania" value="<?= $contacto['correo_compania'] ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Contacto</button>
                </form>
            </div>
            <div class="tab-pane fade" id="movimientos" role="tabpanel" aria-labelledby="movimientos-tab">
                <form id="form-movimientos">
                    <div class="form-group">
                        <label for="tipo_movimiento">Tipo de Movimiento</label>
                        <select class="form-control" id="tipo_movimiento" name="tipo_movimiento" required>
                            <option value="hire" <?= $empleado['estado'] == 'active' ? 'disabled' : '' ?>>Ingreso</option>
                            <option value="fire" <?= $empleado['estado'] == 'inactive' ? 'disabled' : '' ?>>Salida</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fecha_movimiento">Fecha de Movimiento</label>
                        <input type="date" class="form-control" id="fecha_movimiento" name="fecha_movimiento" required>
                    </div>
                    <button type="submit" class="btn btn-primary" <?= $empleado['estado'] == 'active' ? 'disabled' : '' ?>>Guardar Movimiento</button>
                </form>
                <h3>Historial de Movimientos</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tipo de Movimiento</th>
                            <th>Fecha de Movimiento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($movimientos as $movimiento): ?>
                            <tr>
                                <td><?= $movimiento['movement_type'] == 'hire' ? 'Ingreso' : 'Salida' ?></td>
                                <td><?= $movimiento['movement_date'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="descuentos" role="tabpanel" aria-labelledby="descuentos-tab">
                <form id="form-descuentos">
                    <div class="form-group">
                        <label for="descuentos">Descuentos Disponibles</label>
                        <?php foreach ($descuentos_disponibles as $descuento): ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="descuentos[]" value="<?= $descuento['id'] ?>" id="descuento-<?= $descuento['id'] ?>" <?= in_array($descuento['id'], array_column($descuentos, 'descuento_disponible_id')) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="descuento-<?= $descuento['id'] ?>">
    <?= $descuento['nombre'] ?> (<?= $descuento['tipo_monto'] == 'fijo' ? 'Fijo' : 'Porcentaje' ?>: <?= $descuento['monto'] ?>)
</label>
</div>
<?php endforeach; ?>
</div>
<button type="submit" class="btn btn-primary">Guardar Descuentos</button>
</form>
</div>
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

$('#form-datos-personales').submit(function(e) {
    e.preventDefault();
    var formData = $(this).serialize();
    $.ajax({
        url: '<?= base_url('empleados/actualizarDatos/' . $empleado['id']) ?>',
        method: 'POST',
        data: formData,
        success: function(response) {
            if (response.status === 'success') {
                Toast.fire({
                    icon: 'success',
                    title: 'Datos personales actualizados exitosamente.'
                });
            }
        }
    });
});

$('#form-direccion').submit(function(e) {
    e.preventDefault();
    var formData = $(this).serialize();
    $.ajax({
        url: '<?= base_url('empleados/actualizarDireccion/' . $empleado['id']) ?>',
        method: 'POST',
        data: formData,
        success: function(response) {
            if (response.status === 'success') {
                Toast.fire({
                    icon: 'success',
                    title: 'Dirección actualizada exitosamente.'
                });
            }
        }
    });
});

$('#form-contacto').submit(function(e) {
    e.preventDefault();
    var formData = $(this).serialize();
    $.ajax({
        url: '<?= base_url('empleados/actualizarContacto/' . $empleado['id']) ?>',
        method: 'POST',
        data: formData,
        success: function(response) {
            if (response.status === 'success') {
                Toast.fire({
                    icon: 'success',
                    title: 'Contacto actualizado exitosamente.'
                });
            }
        }
    });
});

$('#form-movimientos').submit(function(e) {
    e.preventDefault();
    var formData = $(this).serialize();
    $.ajax({
        url: '<?= base_url('empleados/guardarMovimiento/' . $empleado['id']) ?>',
        method: 'POST',
        data: formData,
        success: function(response) {
            if (response.status === 'success') {
                Toast.fire({
                    icon: 'success',
                    title: 'Movimiento guardado exitosamente.'
                });
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Error al guardar el movimiento.'
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

$('#form-descuentos').submit(function(e) {
    e.preventDefault();
    var formData = $(this).serialize();
    $.ajax({
        url: '<?= base_url('empleados/guardarDescuento/' . $empleado['id']) ?>',
        method: 'POST',
        data: formData,
        success: function(response) {
            if (response.status === 'success') {
                Toast.fire({
                    icon: 'success',
                    title: 'Descuentos actualizados exitosamente.'
                });
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Error al actualizar los descuentos.'
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

                             