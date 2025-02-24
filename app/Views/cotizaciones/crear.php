<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Crear Cotización
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">
    <h2>Crear Cotización</h2>
    <form id="form-cotizacion" action="<?= base_url('/cotizaciones/guardar') ?>" method="post">
        <div class="form-group">
            <label for="cliente">Cliente</label>
            <select class="form-control" id="cliente" name="cliente" required>
                <?php if (isset($clientes)): ?>
                    <?php foreach ($clientes as $cliente): ?>
                        <option value="<?= $cliente['id'] ?>"><?= $cliente['nombre'] ?></option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="">No hay clientes disponibles</option>
                <?php endif; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="numero_cotizacion">Número de Cotización</label>
            <input type="text" class="form-control" id="numero_cotizacion" name="numero_cotizacion" required>
        </div>
        <div class="form-group">
            <label for="fecha_cotizacion">Fecha de Cotización</label>
            <input type="date" class="form-control" id="fecha_cotizacion" name="fecha_cotizacion" required>
        </div>
        <div class="form-group">
            <label for="fecha_vencimiento">Fecha de Vencimiento</label>
            <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" required>
        </div>
        <div class="form-group">
            <label for="gastos_envio">Gastos de Envío</label>
            <input type="number" class="form-control" id="gastos_envio" name="gastos_envio">
        </div>
        <div class="form-group">
            <label for="forma_entrega">Forma de Entrega</label>
            <input type="text" class="form-control" id="forma_entrega" name="forma_entrega">
        </div>
        <div class="form-group">
            <label for="modo_pago">Modos de Pago Permitidos</label>
            <select multiple class="form-control" id="modo_pago" name="modo_pago[]">
                <option value="tarjeta">Tarjeta</option>
                <option value="contado">Contado</option>
                <option value="cheque">Cheque</option>
                <!-- Más opciones de pago aquí -->
            </select>
        </div>
        <div class="form-group">
            <label for="moneda">Moneda</label>
            <select class="form-control" id="moneda" name="moneda" required>
                <option value="USD">USD</option>
                <option value="EUR">EUR</option>
                <!-- Más opciones de moneda aquí -->
            </select>
        </div>
        <div class="form-group">
            <label for="agente_ventas">Agente de Ventas</label>
           
        </div>
        <div class="form-group">
            <label for="factura_recurrente">Factura Recurrente</label>
            <select class="form-control" id="factura_recurrente" name="factura_recurrente">
                <option value="no">No</option>
                <option value="si">Sí</option>
            </select>
        </div>
        <div class="form-group">
            <label for="tipo_descuento">Tipo de Descuento</label>
            <select class="form-control" id="tipo_descuento" name="tipo_descuento">
                <option value="no_descuento">No Descuento</option>
                <option value="porcentaje">Porcentaje</option>
                <option value="monto_fijo">Monto Fijo</option>
                <!-- Más opciones de descuento aquí -->
            </select>
        </div>
        <div class="form-group">
            <label for="nota_admin">Nota del Administrador</label>
            <textarea class="form-control" id="nota_admin" name="nota_admin" rows="3"></textarea>
        </div>
        <h4>Productos</h4>
        <table class="table" id="tabla-productos">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Medida</th>
                    <th>Costo U</th>
                    <th>Cantidad</th>
                    <th>Descuento</th>
                    <th>Subtotal</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí se añadirán las filas de productos -->
            </tbody>
        </table>
        <button type="button" class="btn btn-success" id="agregar-producto">Agregar Producto</button>
        <br><br>
        <button type="submit" class="btn btn-primary">Guardar Cotización</button>
    </form>
</div>

<script>
$(document).ready(function() {
    $('#cliente, #modo_pago, #moneda, #agente_ventas, #tipo_descuento').select2();

    var productosAgregados = [];

    function inicializarSelect2() {
        $('.select-producto').select2({
            ajax: {
                url: '<?= base_url('/producto_terminado/buscar') ?>',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.nombre,
                                id: item.id
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 1
        });
    }

    $('#agregar-producto').click(function() {
        var productoHtml = `
            <tr>
                <td>
                    <select class="form-control select-producto" name="productos[]" required></select>
                    <span class="producto-label" style="display:none;"></span>
                </td>
                <td class="unidad_medida"></td>
                <td class="costo_unitario"></td>
                <td><input type="number" class="form-control cantidad" name="cantidades[]" min="1" value="1" required></td>
                <td><input type="number" class="form-control descuento" name="descuentos[]" min="0" value="0"></td>
                <td class="subtotal"></td>
                <td><button type="button" class="btn btn-danger eliminar-producto">Eliminar</button></td>
            </tr>
        `;
        $('#tabla-productos tbody').append(productoHtml);
        inicializarSelect2();
    });

    $('#tabla-productos').on('click', '.eliminar-producto', function() {
        $(this).closest('tr').remove();
        calcularTotales();
    });

    $('#tabla-productos').on('change', '.select-producto', function() {
        var productoId = $(this).val();
        var fila = $(this).closest('tr');
        
        $.ajax({
            url: '<?= base_url('/producto_terminado/detalle') ?>/' + productoId,
            type: 'GET',
            dataType: 'json',
            success: function(producto) {
                if (producto) {
                    // Mostrar el label y ocultar el select
                    fila.find('.producto-label').text(producto.nombre).show();
                    fila.find('.select-producto').css('visibility', 'hidden');
                    
                    fila.find('.unidad_medida').text(producto.unidad_medida);
                    fila.find('.costo_unitario').text(producto.costo_unidad);
                    var cantidad = parseFloat(fila.find('.cantidad').val()) || 0;
                    var descuento = parseFloat(fila.find('.descuento').val()) || 0;
                    var subtotal = (cantidad * producto.costo_unidad) - descuento;
                    fila.find('.subtotal').text(subtotal.toFixed(2));
                    calcularTotales();
                } else {
                    alert("Producto no encontrado.");
                }
            }
        });
    });

    $('#tabla-productos').on('input', '.cantidad, .descuento', function() {
        var fila = $(this).closest('tr');
        var cantidad = parseFloat(fila.find('.cantidad').val()) || 0;
        var costo = parseFloat(fila.find('.costo_unitario').text()) || 0;
        var descuento = parseFloat(fila.find('.descuento').val()) || 0;
        var subtotal = (cantidad * costo) - descuento;
        fila.find('.subtotal').text(subtotal.toFixed(2));
        calcularTotales();
    });

    function calcularTotales() {
        var total = 0;
        $('#tabla-productos tbody tr').each(function() {
            var subtotal = parseFloat($(this).find('.subtotal').text()) || 0;
            total += subtotal;
        });
        $('#total').text(total.toFixed(2));
    }

    inicializarSelect2();
});
</script>


<?= $this->endSection() ?>
