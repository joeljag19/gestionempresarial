<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Gestión de Órdenes de Compra
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Gestión de Órdenes de Compra</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <form id="ordenCompraForm" method="post" action="<?= base_url('ordenes-compra/guardar') ?>">
            <div class="form-group">
                <label for="suplidor">Proveedor</label>
                <select id="suplidor" name="suplidor_id" class="form-control">
                    <?php foreach ($suplidores as $suplidor): ?>
                        <option value="<?= $suplidor['id'] ?>"><?= $suplidor['nombre'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="fecha_orden">Fecha de Orden</label>
                <input type="date" id="fecha_orden" name="fecha_orden" class="form-control" value="<?= date('Y-m-d'); ?>">
            </div>
            <div class="form-group">
                <label for="estado">Estado</label>
                <select id="estado" name="estado" class="form-control">
                    <option value="Pendiente">Pendiente</option>
                    <option value="Aprobado">Aprobado</option>
                </select>
            </div>
            <div class="form-group">
                <label for="detalle">Detalle</label>
                <textarea id="detalle" name="detalle" class="form-control"></textarea>
            </div>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Materia Prima</h3>
                </div>
                <div class="card-body">
                    <table class="table" id="materiasPrimasTable">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Unidad de Medida</th>
                                <th>Precio Unitario</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                                <th>ITBIS</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select class="form-control materia-prima">
                                        <option value="">Seleccione...</option>
                                        <?php foreach ($materiasPrimas as $materiaPrima): ?>
                                            <option value="<?= $materiaPrima['id'] ?>"><?= $materiaPrima['nombre'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td class="unidad-de-medida"></td>
                                <td><input type="number" step="0.01" class="form-control precio-unitario"></td>
                                <td><input type="number" class="form-control cantidad"></td>
                                <td class="subtotal"></td>
                                <td class="itbis"></td>
                                <td><button type="button" class="btn btn-danger btn-remove">Eliminar</button></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" id="btn-add-row" class="btn btn-primary mt-3">Agregar Materia Prima</button>
                </div>
            </div>
            <div class="form-group">
                <label for="total">Total</label>
                <label id="total" class="form-control">0.00</label>
            </div>
            <input type="submit" value="Guardar Orden" class="btn btn-primary mt-3">
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#btn-add-row').click(function() {
        var newRow = $('#materiasPrimasTable tbody tr:first').clone();
        newRow.find('input').val('');
        newRow.find('.subtotal, .itbis').text('');
        $('#materiasPrimasTable tbody').append(newRow);
    });

    $(document).on('change', '.materia-prima', function() {
        var materiaPrimaId = $(this).val();
        var row = $(this).closest('tr');
        $.ajax({
            url: '<?= base_url('ordenes-compra/getMateriaPrimaDetails') ?>',
            method: 'POST',
            data: { materia_prima_id: materiaPrimaId },
            success: function(response) {
                row.find('.unidad-de-medida').text(response.unidad_de_medida);
                row.find('.precio-unitario').val(response.costo_unitario);
                row.find('.itbis').text((response.costo_unitario * response.itbis).toFixed(2));
            }
        });
    });

    $(document).on('input', '.precio-unitario, .cantidad', function() {
        var row = $(this).closest('tr');
        var precioUnitario = parseFloat(row.find('.precio-unitario').val());
        var cantidad = parseInt(row.find('.cantidad').val());
        var subtotal = (precioUnitario * cantidad).toFixed(2);
        var itbis = (subtotal * 0.18).toFixed(2); // Si el ITBIS es el 18%
        row.find('.subtotal').text(subtotal);
        row.find('.itbis').text(itbis);

        // Actualizar el total general
        var total = 0;
        $('#materiasPrimasTable tbody tr').each(function() {
            var subtotal = parseFloat($(this).find('.subtotal').text());
            total += isNaN(subtotal) ? 0 : subtotal;
        });
        $('#total').text(total.toFixed(2));
    });

    $(document).on('click', '.btn-remove', function() {
        $(this).closest('tr').remove();

        // Actualizar el total general
        var total = 0;
        $('#materiasPrimasTable tbody tr').each(function() {
            var subtotal = parseFloat($(this).find('.subtotal').text());
            total += isNaN(subtotal) ? 0 : subtotal;
        });
        $('#total').text(total.toFixed(2));
    });
});
</script>
<?= $this->endSection() ?>
