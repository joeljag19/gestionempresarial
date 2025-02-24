<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Crear Bill of Materials
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Crear Bill of Materials</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Nuevo Bill of Materials</h3>
                    </div>
                    <div class="card-body">
                        <form action="/bom/guardar" method="post">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="materiaprima_fabricado_id">materiaprima Fabricado</label>
                                <select class="form-control" id="materiaprima_fabricado_id" name="materiaprima_fabricado_id" required>
                                    <?php foreach ($materiaprimas as $materiaprima): ?>
                                    <option value="<?= $materiaprima['id'] ?>" data-costo="<?= $materiaprima['costo_unitario'] ?>"><?= $materiaprima['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="materiales">Materiales</label>
                                <table class="table table-bordered" id="materiales">
                                    <thead>
                                        <tr>
                                            <th>materiaprima</th>
                                            <th>Cantidad</th>
                                            <th>Desperdicio (%)</th>
                                            <th>Subtotal</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Aquí se agregarán dinámicamente los materiales -->
                                    </tbody>
                                </table>
                                <button type="button" id="agregar-material" class="btn btn-secondary">Agregar Material</button>
                            </div>
                            <div class="form-group">
                                <label for="costo_total">Costo Total</label>
                                <input type="number" class="form-control" id="costo_total" name="costo_total" readonly>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    var materialIndex = 0;

    $('#agregar-material').click(function() {
        var materialHtml = `
            <tr>
                <td>
                    <select class="form-control" name="materiales[` + materialIndex + `][materiaprima_id]" required>
                        <?php foreach ($materiaprimas as $materiaprima): ?>
                        <option value="<?= $materiaprima['id'] ?>" data-costo="<?= $materiaprima['costo_unitario'] ?>"><?= $materiaprima['nombre'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control" name="materiales[` + materialIndex + `][cantidad]" required>
                </td>
                <td>
                    <input type="number" class="form-control" name="materiales[` + materialIndex + `][desperdicio]" required>
                </td>
                <td>
                    <input type="number" class="form-control" name="materiales[` + materialIndex + `][subtotal]" readonly>
                </td>
                <td>
                    <button type="button" class="btn btn-danger eliminar-material">Eliminar</button>
                </td>
            </tr>
        `;
        $('#materiales tbody').append(materialHtml);
        materialIndex++;
    });

    $(document).on('change', 'select[name^="materiales["]', function() {
        var $row = $(this).closest('tr');
        var cantidad = parseFloat($row.find('input[name*="[cantidad]"]').val()) || 0;
        var desperdicio = parseFloat($row.find('input[name*="[desperdicio]"]').val()) || 0;
        var costoUnitario = parseFloat($(this).find('option:selected').data('costo')) || 0;
        var subtotal = cantidad * costoUnitario * (1 + desperdicio / 100);
        $row.find('input[name*="[subtotal]"]').val(subtotal.toFixed(2));
        calcularCostoTotal();
    });

    $(document).on('input', 'input[name*="[cantidad]"], input[name*="[desperdicio]"]', function() {
        var $row = $(this).closest('tr');
        var cantidad = parseFloat($row.find('input[name*="[cantidad]"]').val()) || 0;
        var desperdicio = parseFloat($row.find('input[name*="[desperdicio]"]').val()) || 0;
        var costoUnitario = parseFloat($row.find('select[name*="[materiaprima_id]"] option:selected').data('costo')) || 0;
        var subtotal = cantidad * costoUnitario * (1 + desperdicio / 100);
        $row.find('input[name*="[subtotal]"]').val(subtotal.toFixed(2));
        calcularCostoTotal();
    });

    $(document).on('click', '.eliminar-material', function() {
        $(this).closest('tr').remove();
        calcularCostoTotal();
    });

    function calcularCostoTotal() {
        var costoTotal = 0;
        $('#materiales tbody tr').each(function() {
            var subtotal = parseFloat($(this).find('input[name*="[subtotal]"]').val()) || 0;
            costoTotal += subtotal;
        });
        $('#costo_total').val(costoTotal.toFixed(2));
    }
});
</script>
<?= $this->endSection() ?>
