<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Crear Factura
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">
    <h2>Crear Factura</h2>
    <form id="form-factura" action="<?= base_url('/facturas/guardar') ?>" method="post">
        <div class="form-group">
            <label for="cliente">Cliente</label>
            <select class="form-control" id="cliente" name="cliente" required>
                <?php foreach ($clientes as $cliente): ?>
                    <option value="<?= $cliente['id'] ?>"><?= $cliente['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="numero_factura">Número de Factura</label>
            <input type="text" class="form-control" id="numero_factura" name="numero_factura" required>
        </div>
        <div class="form-group">
            <label for="fecha_factura">Fecha de Factura</label>
            <input type="date" class="form-control" id="fecha_factura" name="fecha_factura" required>
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
            <select class="form-control" id="agente_ventas" name="agente_ventas" required>
                <?php foreach ($agentes as $agente): ?>
                    <option value="<?= $agente['id'] ?>"><?= $agente['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
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
        <div id="lista-productos"></div>
        <button type="button" class="btn btn-success" id="agregar-producto">Agregar Producto</button>
        <br><br>
        <button type="submit" class="btn btn-primary">Guardar Factura</button>
    </form>
</div>

<script>
$(document).ready(function() {
    $('#cliente, #modo_pago, #moneda, #agente_ventas, #tipo_descuento').select2();

    $('#agregar-producto').click(function() {
        var productoHtml = `
            <div class="producto-item">
                <div class="form-group">
                    <label for="producto">Producto</label>
                    <select class="form-control producto" name="productos[]">
                        <?php foreach ($productos as $producto): ?>
                            <option value="<?= $producto['id'] ?>"><?= $producto['nombre'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="cantidad">Cantidad</label>
                    <input type="number" class="form-control cantidad" name="cantidades[]">
                </div>
                <div class="form-group">
                    <label for="precio_unitario">Precio Unitario</label>
                    <input type="number" class="form-control precio_unitario" name="precios_unitarios[]">
                </div>
                <div class="form-group">
                    <label for="descuento">Descuento</label>
                    <input type="number" class="form-control descuento" name="descuentos[]">
                </div>
                <button type="button" class="btn btn-danger eliminar-producto">Eliminar</button>
            </div>
        `;
        $('#lista-productos').append(productoHtml);
        $('.producto').select2();
    });

    $('#lista-productos').on('click', '.eliminar-producto', function() {
        $(this).closest('.producto-item').remove();
    });

    function calcularTotales() {
        var total = 0;
        $('.producto-item').each(function() {
            var cantidad = parseFloat($(this).find('.cantidad').val()) || 0;
            var precio_unitario = parseFloat($(this).find('.precio_unitario').val()) || 0;
            var descuento = parseFloat($(this).find('.descuento').val()) || 0;
            total += (cantidad * precio_unitario) - descuento;
        });
        $('#total').text(total.toFixed(2));
    }

    $('#lista-productos').on('input', '.cantidad, .precio_unitario, .descuento', function() {
        calcularTotales();
    });
});
</script>
<?= $this->endSection() ?>
