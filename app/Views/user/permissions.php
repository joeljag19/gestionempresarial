<!DOCTYPE html>
<html>
<head>
    <title>Permisos del Usuario</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1>Permisos del Usuario</h1>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID del Permiso</th>
                            <th>Nombre del Permiso</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($permissions as $permission): ?>
                            <tr>
                                <td><?= $permission['permission_id'] ?></td>
                                <td><?= $permission['permission_name'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
