<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Cálculo de Nómina
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Cálculo de Nómina</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <h3>Periodo de Nómina: <?= $nomina['periodo_nombre'] ?></h3>
      <!-- Barra de progreso -->
       <!-- En la cabecera o al final del card-body en calcular.php -->
<div class="text-right mt-3">
    <a href="<?= base_url('nomina/reportePagos/' . $nomina['id']) ?>" class="btn btn-primary">Generar Reporte de Pagos</a>
</div>
<div class="progress mb-3">
    <div class="progress-bar progress-bar-striped" role="progressbar" 
         style="width: <?= ($totalEmpleados > 0) ? ($empleadosCompletados / $totalEmpleados * 100) : 0 ?>%;" 
         aria-valuenow="<?= $empleadosCompletados ?>" 
         aria-valuemin="0" 
         aria-valuemax="<?= $totalEmpleados ?>">
        <?= $empleadosCompletados ?> de <?= $totalEmpleados ?> empleados calculados
    </div>
</div>

        <table class="table table-bordered" id="totalesTable">
            <thead>
                <tr>
                    <th>Salario</th>
                    <th>Ingresos Adicionales</th>
                    <th>Deducciones</th>
                    <th>Empleados</th>
                    <th>Total Costo</th>
                    <th>Total Pago</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td id="totalSalario"><?= number_format($nomina['total_salario'], 2) ?></td>
                    <td id="totalIngresos"><?= number_format($nomina['total_ingresos_adicionales'], 2) ?></td>
                    <td id="totalDeducciones"><?= number_format($nomina['total_deducciones'], 2) ?></td>
                    <td id="totalEmpleados"><?= $totalEmpleados ?></td>
                    <td id="totalCosto"><?= number_format($nomina['total_costo'], 2) ?></td>
                    <td id="totalPago"><?= number_format($nomina['total_pago'], 2) ?></td>
                </tr>
            </tbody>
        </table>

        <h3 class="mt-5">Detalle por Empleado</h3>
        <table class="table table-striped" id="detalleEmpleados">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Identificación</th>
                    <th>Salario</th>
                    <th>Ingresos Adicionales</th>
                    <th>Deducciones</th>
                    <th>Total a Pagar</th>
                    <th>Estatus</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($empleados as $empleado): ?>
                    <?php $empleadoInfo = $empleadoModel->find($empleado['empleado_id']); ?>
                    <tr data-id="<?= $empleado['id'] ?>">
                        <td><?= $empleadoInfo['primer_nombre'] ?> <?= $empleadoInfo['apellido'] ?></td>
                        <td><?= $empleadoInfo['cedula'] ?></td>
                        <td><?= number_format($empleado['salario'], 2) ?></td>
                        <td><?= number_format($empleado['total_ingresos_adicionales'], 2) ?></td>
                        <td><?= number_format($empleado['total_deducciones'], 2) ?></td>
                        <td><?= number_format($empleado['total_pago'], 2) ?></td>
                        <td>
                            <?= $empleado['estatus_completado'] == 0 ? 'En progreso' : ' <span class="btn btn-block btn-success btn-xs">Completado</span>' ?>
                        </td>
                        <td>
                            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#incentivoModal" data-empleado="<?= $empleado['id'] ?>">+</button>
                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deduccionModal" data-empleado="<?= $empleado['id'] ?>">+</button>
                            <div class="dropdown">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="accionesMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Acciones
                                </button>
                                <div class="dropdown-menu" aria-labelledby="accionesMenu">
                                    <a class="dropdown-item" href="#">Opción 1</a>
                                    <a class="dropdown-item" href="<?= base_url('nomina/reciboPago/' . $nomina['id'] . '/' . $empleado['id']) ?>"  target=”_blank”>Ver Detalle Pago</a>
                                    <button class="btn btn-success btn-sm" onclick="marcarEmpleadoCompletado(<?= $empleado['id'] ?>)">Marcar Completado</button>
                                    <a class="dropdown-item eliminar-empleado" href="#" data-empleado="<?= $empleado['id'] ?>">Eliminar</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <button class="btn btn-success" data-toggle="modal" data-target="#empleadoModal">Añadir Empleado</button>
        <button class="btn btn-primary">Generar Reporte</button>
        <!-- Botón global para marcar la nómina completa -->
        <div class="text-right mt-3">
            <button class="btn btn-primary" onclick="marcarNominaCompletada(<?= $nomina['id'] ?>)">Marcar Nómina como Completada</button>
        </div>
    </div>
</div>

<!-- Modal para añadir empleado -->
<div class="modal fade" id="empleadoModal" tabindex="-1" role="dialog" aria-labelledby="empleadoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="empleadoModalLabel">Añadir Empleado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAgregarEmpleados">
                    <table class="table table-striped" id="listaEmpleados">
                        <thead>
                            <tr>
                                <th>Seleccionar</th>
                                <th>Nombre</th>
                                <th>Identificación</th>
                                <th>Salario</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($empleadosDisponibles as $empleado): ?>
                                <tr>
                                    <td><input type="checkbox" name="empleado_id[]" value="<?= $empleado['id'] ?>"></td>
                                    <td><?= $empleado['primer_nombre'] ?> <?= $empleado['apellido'] ?></td>
                                    <td><?= $empleado['cedula'] ?></td>
                                    <td><?= number_format($empleado['sueldo'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-primary" id="btnAgregarEmpleados">Añadir</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para añadir incentivos -->
<div class="modal fade" id="incentivoModal" tabindex="-1" role="dialog" aria-labelledby="incentivoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="incentivoModalLabel">Añadir Incentivo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('nomina/agregarDetalleManual') ?>" method="post" id="formIncentivo">
                    <input type="hidden" id="nomina_empleado_id_incentivo" name="nomina_empleado_id">
                    <input type="hidden" name="tipo" value="incentivo">
                    <div class="form-group">
                        <label for="referencia_id_incentivo">Tipo de Incentivo</label>
                        <select class="form-control" id="referencia_id_incentivo" name="referencia_id" required>
                            <option value="">Seleccione un incentivo</option>
                            <?php foreach ((new \App\Models\IncentivoModel())->findAll() as $incentivo): ?>
                                <option value="<?= $incentivo['id'] ?>"><?= $incentivo['nombre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="monto_incentivo">Monto</label>
                        <input type="number" class="form-control" id="monto_incentivo" name="monto" step="0.01" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Añadir</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para añadir deducciones -->
<div class="modal fade" id="deduccionModal" tabindex="-1" role="dialog" aria-labelledby="deduccionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deduccionModalLabel">Añadir Deducción</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('nomina/agregarDetalleManual') ?>" method="post" id="formDeduccion">
                    <input type="hidden" id="nomina_empleado_id_deduccion" name="nomina_empleado_id">
                    <input type="hidden" name="tipo" value="descuento">
                    <div class="form-group">
                        <label for="referencia_id_deduccion">Tipo de Deducción</label>
                        <select class="form-control" id="referencia_id_deduccion" name="referencia_id" required>
                            <option value="">Seleccione una deducción</option>
                            <?php foreach ((new \App\Models\DescuentoModel())->findAll() as $descuento): ?>
                                <option value="<?= $descuento['id'] ?>"><?= $descuento['nombre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="monto_deduccion">Monto</label>
                        <input type="number" class="form-control" id="monto_deduccion" name="monto" step="0.01" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Añadir</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$('#incentivoModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var nominaEmpleadoId = button.data('empleado');
    var modal = $(this);
    modal.find('#nomina_empleado_id_incentivo').val(nominaEmpleadoId);
});

$('#deduccionModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var nominaEmpleadoId = button.data('empleado');
    var modal = $(this);
    modal.find('#nomina_empleado_id_deduccion').val(nominaEmpleadoId);
});

function actualizarTablaEmpleados() {
    $.ajax({
        url: '<?= base_url('nomina/calcular/' . $nomina['id']) ?>',
        method: 'GET',
        dataType: 'html',
        success: function(response) {
            var newContent = $(response).find('#detalleEmpleados tbody').html();
            $('#detalleEmpleados tbody').html(newContent);

            var totalSalario = $(response).find('#totalSalario').text();
            var totalIngresos = $(response).find('#totalIngresos').text();
            var totalDeducciones = $(response).find('#totalDeducciones').text();
            var totalEmpleados = $(response).find('#totalEmpleados').text();
            var totalCosto = $(response).find('#totalCosto').text();
            var totalPago = $(response).find('#totalPago').text();

            $('#totalSalario').text(totalSalario);
            $('#totalIngresos').text(totalIngresos);
            $('#totalDeducciones').text(totalDeducciones);
            $('#totalEmpleados').text(totalEmpleados);
            $('#totalCosto').text(totalCosto);
            $('#totalPago').text(totalPago);
        },
        error: function(error) {
            console.error('Error al actualizar la tabla:', error);
        }
    });
}

$('#empleadoModal').on('show.bs.modal', function (event) {
    $.ajax({
        url: '<?= base_url('nomina/obtenerEmpleadosNominaActual/' . $nomina['id']) ?>',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log('Empleados en nomina actual:', response);
            var empleadosIdsAñadidos = response.map(id => parseInt(id));

            $('#listaEmpleados input[type="checkbox"]').each(function() {
                var empleadoId = parseInt($(this).val());
                if (empleadosIdsAñadidos.includes(empleadoId)) {
                    $(this).prop('disabled', true).prop('checked', true);
                } else {
                    $(this).prop('disabled', false).prop('checked', false);
                }
            });
        },
        error: function(xhr, status, error) {
            console.error('Error al obtener empleados en nomina actual:', xhr.responseText);
        }
    });
});

$('#btnAgregarEmpleados').on('click', function () {
    var empleadosSeleccionados = [];
    
    $('#listaEmpleados input[type="checkbox"]:checked:not(:disabled)').each(function () {
        empleadosSeleccionados.push($(this).val());
    });

    if (empleadosSeleccionados.length > 0) {
        $.ajax({
            url: '<?= base_url('nomina/agregarEmpleados') ?>',
            method: 'POST',
            data: {
                'empleado_id': empleadosSeleccionados,
                'nomina_id': <?= $nomina['id'] ?>
            },
            success: function(response) {
                console.log('Respuesta del servidor:', response);
                $('#empleadoModal').modal('hide');
                actualizarTablaEmpleados();
            },
            error: function(xhr, status, error) {
                console.error('Error al agregar empleados:', xhr.responseText);
            }
        });
    }
});

$(document).on('click', '.eliminar-empleado', function(e) {
    e.preventDefault();
    var nominaEmpleadoId = $(this).data('empleado');

    if (confirm('¿Estás seguro de eliminar este empleado de la nómina?')) {
        $.ajax({
            url: '<?= base_url('nomina/eliminarEmpleado') ?>', // URL sin ID en la ruta
            method: 'POST',
            data: {
                nomina_empleado_id: nominaEmpleadoId, // Enviar ID como parámetro en data
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>' // Incluye CSRF si está activo
            },
            beforeSend: function() {
                console.log('Enviando solicitud para eliminar empleado ID:', nominaEmpleadoId);
            },
            success: function(response) {
                console.log('Respuesta del servidor:', response);
                if (response.message) {
                    alert(response.message);
                    location.reload(); // Recargar la página para reflejar los cambios
                } else if (response.error) {
                    alert('Error: ' + response.error);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al eliminar empleado:', error);
                let errorMessage = 'Error al eliminar el empleado';
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMessage = xhr.responseJSON.error;
                }
                alert(errorMessage);
                console.log('Respuesta del servidor:', xhr.responseText);
                console.log('Estado:', status);
                console.log('Cabeceras:', xhr.getAllResponseHeaders());
            }
        });
    }
});

$('#formIncentivo, #formDeduccion').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            console.log('Respuesta del servidor:', response);
            $('#incentivoModal').modal('hide');
            $('#deduccionModal').modal('hide');
            actualizarTablaEmpleados();
        },
        error: function(error) {
            console.error('Error al agregar detalle:', error);
        }
    });
});

function marcarEmpleadoCompletado(nominaEmpleadoId) {
    if (confirm('¿Estás seguro de que deseas marcar este empleado como completado?')) {
        $.ajax({
            url: '<?= base_url('nomina/marcarEmpleadoCompletado/') ?>' + nominaEmpleadoId,
            method: 'POST',
            success: function(response) {
                if (response.message) {
                    alert(response.message);
                    location.reload(); // Recargar para reflejar el cambio
                } else if (response.error) {
                    alert('Error: ' + response.error);
                }
            },
            error: function(xhr, status, error) {
                alert('Error al marcar como completado: ' + error);
            }
        });
    }
}

// Similar para la nómina completa (botón global)
function marcarNominaCompletada(nominaId) {
    if (confirm('¿Estás seguro de que deseas marcar esta nómina como completada?')) {
        $.ajax({
            url: '<?= base_url('nomina/marcarNominaCompletada/') ?>' + nominaId,
            method: 'POST',
            success: function(response) {
                if (response.message) {
                    alert(response.message);
                    location.reload();
                } else if (response.error) {
                    alert('Error: ' + response.error);
                }
            },
            error: function(xhr, status, error) {
                alert('Error al marcar la nómina como completada: ' + error);
            }
        });
    }
}
</script>
<?= $this->endSection() ?>