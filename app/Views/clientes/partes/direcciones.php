<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Dirección</th>
            <th>Ciudad</th>
            <th>Código Postal</th>
            <th>País</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($direcciones as $direccion): ?>
            <tr>
                <td><?= esc($direccion['nombre']) ?></td>
                <td><?= esc($direccion['direccion']) ?></td>
                <td><?= esc($direccion['ciudad']) ?></td>
                <td><?= esc($direccion['codigo_postal']) ?></td>
                <td><?= esc($direccion['pais']) ?></td>
                <td><?= esc($direccion['telefono']) ?></td>
                <td>
                    <button class="btn btn-danger eliminar-direccion" data-id="<?= $direccion['id'] ?>">Eliminar</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
