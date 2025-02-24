<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Administración de Roles y Permisos
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Administración de Roles y Permisos</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <!-- Contenido de la página -->
        <div class="row">
            <div class="col-md-12">
              
                <?php if(session()->getFlashdata('msg')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
                <?php endif; ?>
                <h2>Asignar Permiso</h2>
                <form action="/admin/assignPermission" method="post">
                    <div class="form-group">
                        <label for="role_id">Rol:</label>
                        <select name="role_id" class="form-control" required>
                            <?php foreach($roles as $role): ?>
                                <option value="<?= $role['id'] ?>"><?= $role['role_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="permission_id">Permiso:</label>
                        <select name="permission_id" class="form-control" required>
                            <?php foreach($permissions as $permission): ?>
                                <option value="<?= $permission['id'] ?>"><?= $permission['permission_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Asignar Permiso</button>
                </form>

                <h2>Eliminar Permiso</h2>
                <form action="/admin/removePermission" method="post">
                    <div class="form-group">
                        <label for="role_id">Rol:</label>
                        <select name="role_id" class="form-control" required>
                            <?php foreach($roles as $role): ?>
                                <option value="<?= $role['id'] ?>"><?= $role['role_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="permission_id">Permiso:</label>
                        <select name="permission_id" class="form-control" required>
                            <?php foreach($permissions as $permission): ?>
                                <option value="<?= $permission['id'] ?>"><?= $permission['permission_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-danger">Eliminar Permiso</button>
                </form>

                <h2>Permisos Asignados</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Rol</th>
                            <th>Permiso</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($rolePermissions as $rolePermission): ?>
                            <tr>
                                <td><?= $rolePermission['role_id'] ?></td>
                                <td><?= $rolePermission['permission_id'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>






        
    </div>
</div>
<?= $this->endSection() ?>



