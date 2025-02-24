<table class="table table-bordered">
    <thead>
        <tr>
            <th>Banco</th>
            <th>Número de Cuenta</th>
            <th>Tipo de Cuenta</th>
            <th>SWIFT/BIC</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($bancos as $banco): ?>
            <tr>
                <td><?= esc($banco['banco']) ?></td>
                <td><?= esc($banco['numero_cuenta']) ?></td>
                <td><?= esc($banco['tipo_cuenta']) ?></td>
                <td><?= esc($banco['swift_bic']) ?></td>
                <td>
                    <button class="btn btn-danger btn-sm eliminar-banco" data-id="<?= $banco['id'] ?>">Eliminar</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
