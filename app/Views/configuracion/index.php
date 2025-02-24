<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Configuración
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Configuración</h1>
            </div>
        </div>
    </div>
</div>

<p>Precio: <?= formatear_moneda(1234.56) ?></p>
<p>Fecha: <?= formatear_fecha('2024-12-19') ?></p>
<p><?= lang('App.product_name') ?>: Producto 1</p>

<div class="content">
    <div class="container-fluid">
        <p>Bienvenido a la página de ejemplo de <?= esc(nombre_empresa()) ?>.</p>
        <p>Dirección: <?= esc(direccion_empresa()) ?></p>
        <p>Teléfono: <?= esc(telefono_empresa()) ?></p>
        <p>RNC: <?= esc(empresa_rnc()) ?></p>
        <!-- Resto del contenido de la vista -->
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        
        <?php if ($configuracion): // Verificar si $configuracion no es null ?>
            <form action="<?= base_url('/configuracion/actualizar') ?>" method="post">
                <input type="hidden" name="id" value="<?= $configuracion['id'] ?>">
                <div class="form-group">
                    <label for="nombre_empresa">Nombre de la Empresa</label>
                    <input type="text" class="form-control" id="nombre_empresa" name="nombre_empresa" value="<?= $configuracion['nombre_empresa'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" value="<?= $configuracion['direccion'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" value="<?= $configuracion['telefono'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="rnc">RNC</label>
                    <input type="text" class="form-control" id="rnc" name="rnc" value="<?= $configuracion['rnc'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="formato_moneda_id">Formato de Moneda</label>
                    <select class="form-control" id="formato_moneda_id" name="formato_moneda_id" required>
                        <?php foreach ($formatosMoneda as $formatoMoneda): ?>
                            <option value="<?= $formatoMoneda['id'] ?>" <?= ($configuracion['formato_moneda_id'] == $formatoMoneda['id']) ? 'selected' : '' ?>>
                                <?= $formatoMoneda['descripcion'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="formato_fecha_id">Formato de Fecha</label>
                    <select class="form-control" id="formato_fecha_id" name="formato_fecha_id" required>
                        <?php foreach ($formatosFecha as $formatoFecha): ?>
                            <option value="<?= $formatoFecha['id'] ?>" <?= ($configuracion['formato_fecha_id'] == $formatoFecha['id']) ? 'selected' : '' ?>>
                                <?= $formatoFecha['descripcion'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="idioma_id">Idioma</label>
                    <select class="form-control" id="idioma_id" name="idioma_id" required>
                        <?php foreach ($idiomas as $idioma): ?>
                            <option value="<?= $idioma['id'] ?>" <?= ($configuracion['idioma_id'] == $idioma['id']) ? 'selected' : '' ?>>
                                <?= $idioma['nombre'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </form>
        <?php else: ?>
            <div class="alert alert-warning">No se ha encontrado configuración. Por favor, asegúrate de que la configuración está creada en la base de datos.</div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
