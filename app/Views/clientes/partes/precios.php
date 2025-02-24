<table class="table table-bordered">
    <thead>
        <tr>
            <th>Producto</th>
            <th>Precio Personalizado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($precios as $precio): ?>
            <tr>
                <td><?= esc($precio['producto_id']) ?></td>
                <td><?= esc($precio['precio_personalizado']) ?></td>
              
                <td>
                    <button class="btn btn-danger btn-sm eliminar-precios" data-id="<?= $precio['id'] ?>">Eliminar</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
