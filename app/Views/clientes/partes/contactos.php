<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Cargo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($contactos as $contacto): ?>
            <tr>
                <td><?= esc($contacto['nombre']) ?></td>
                <td><?= esc($contacto['email']) ?></td>
                <td><?= esc($contacto['telefono']) ?></td>
                <td><?= esc($contacto['cargo']) ?></td>
                <td>
                    <button class="btn btn-danger eliminar-contacto" data-id="<?= $contacto['id'] ?>">Eliminar</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
