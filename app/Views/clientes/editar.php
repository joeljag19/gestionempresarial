<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Editar Cliente
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Editar Cliente</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="datos-basicos-tab" data-toggle="tab" href="#datos-basicos" role="tab" aria-controls="datos-basicos" aria-selected="true">Datos Básicos</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="contactos-tab" data-toggle="tab" href="#contactos" role="tab" aria-controls="contactos" aria-selected="false">Contactos</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="direcciones-tab" data-toggle="tab" href="#direcciones" role="tab" aria-controls="direcciones" aria-selected="false">Direcciones de Entrega</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="bancos-tab" data-toggle="tab" href="#bancos" role="tab" aria-controls="bancos" aria-selected="false">Información Bancaria</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="precios-tab" data-toggle="tab" href="#precios" role="tab" aria-controls="precios" aria-selected="false">Precios Personalizados</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <!-- Datos Básicos -->
            <div class="tab-pane fade show active" id="datos-basicos" role="tabpanel" aria-labelledby="datos-basicos-tab">
                <form id="form-actualizar-cliente" action="<?= base_url('/clientes/actualizar/'.$cliente['id']) ?>" method="post">
                    <div class="form-group">
                        <label for="tipo">Tipo de Cliente</label>
                        <select class="form-control" id="tipo" name="tipo" required>
                            <option value="Empresa" <?= $cliente['tipo'] == 'Empresa' ? 'selected' : '' ?>>Empresa</option>
                            <option value="Persona Física" <?= $cliente['tipo'] == 'Persona Física' ? 'selected' : '' ?>>Persona Física</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $cliente['nombre'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= $cliente['email'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" value="<?= $cliente['telefono'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" value="<?= $cliente['direccion'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="ciudad">Ciudad</label>
                        <input type="text" class="form-control" id="ciudad" name="ciudad" value="<?= $cliente['ciudad'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="codigo_postal">Código Postal</label>
                        <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" value="<?= $cliente['codigo_postal'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="pais">País</label>
                        <input type="text" class="form-control" id="pais" name="pais" value="<?= $cliente['pais'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="rnc_cedula">RNC/Cédula</label>
                        <input type="text" class="form-control" id="rnc_cedula" name="rnc_cedula" value="<?= $cliente['rnc_cedula'] ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar Cliente</button>
                </form>
            </div>

            <!-- Contactos -->
            <div class="tab-pane fade" id="contactos" role="tabpanel" aria-labelledby="contactos-tab">
                <button type="button" class="btn btn-success" id="agregar-contacto" data-toggle="modal" data-target="#modalAgregarContacto">Agregar Contacto</button>
                <div id="lista-contactos">
                    <!-- Lista de Contactos Aquí -->
                </div>
            </div>

            <!-- Direcciones de Entrega -->
            <div class="tab-pane fade" id="direcciones" role="tabpanel" aria-labelledby="direcciones-tab">
                <button type="button" class="btn btn-success" id="agregar-direccion" data-toggle="modal" data-target="#modalAgregarDireccion">Agregar Dirección</button>
                <div id="lista-direcciones">
                    <!-- Lista de Direcciones Aquí -->
                </div>
            </div>

            <!-- Información Bancaria -->
            <div class="tab-pane fade" id="bancos" role="tabpanel" aria-labelledby="bancos-tab">
                <button type="button" class="btn btn-success" id="agregar-banco" data-toggle="modal" data-target="#modalAgregarBanco">Agregar Información Bancaria</button>
                <div id="lista-bancos">
                    <!-- Lista de Información Bancaria Aquí -->
                </div>
            </div>

            <!-- Precios Personalizados -->
            <div class="tab-pane fade" id="precios" role="tabpanel" aria-labelledby="precios-tab">
                <button type="button" class="btn btn-success" id="agregar-precio" data-toggle="modal" data-target="#modalAgregarPrecio">Agregar Precio Personalizado</button>
                <div id="lista-precios">
                    <!-- Lista de Precios Personalizados Aquí -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modales -->
<div class="modal fade" id="modalAgregarContacto" tabindex="-1" role="dialog" aria-labelledby="modalAgregarContactoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarContactoLabel">Agregar Contacto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario para agregar contacto -->
                <form id="form-agregar-contacto">
                    <input type="hidden" name="cliente_id" value="<?= $cliente['id'] ?>">
                    <div class="form-group">
                        <label for="nombre_contacto">Nombre</label>
                        <input type="text" class="form-control" id="nombre_contacto" name="nombre_contacto" required>
                    </div>
                    <div class="form-group">
                        <label for="email_contacto">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email_contacto" name="email_contacto" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono_contacto">Teléfono</label>
                        <input type="text" class="form-control" id="telefono_contacto" name="telefono_contacto" required>
                    </div>
                    <div class="form-group">
                        <label for="cargo_contacto">Cargo</label>
                        <input type="text" class="form-control" id="cargo_contacto" name="cargo_contacto" required>
                    </div>
                    <button type="button" class="btn btn-primary" id="guardar-contacto">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Direcciones de Entrega -->
<div class="modal fade" id="modalAgregarDireccion" tabindex="-1" role="dialog" aria-labelledby="modalAgregarDireccionLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarDireccionLabel">Agregar Dirección de Entrega</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario para agregar dirección -->
                <form id="form-agregar-direccion">
                    <input type="hidden" name="cliente_id" value="<?= $cliente['id'] ?>">
                    <div class="form-group">
                        <label for="nombre_direccion">Nombre de la Dirección</label>
                        <input type="text" class="form-control" id="nombre_direccion" name="nombre_direccion" required>
                    </div>
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" required>
                    </div>
                    <div class="form-group">
                        <label for="ciudad_direccion">Ciudad</label>
                        <input type="text" class="form-control" id="ciudad_direccion" name="ciudad_direccion" required>
                    </div>
                    <div class="form-group">
                        <label for="codigo_postal_direccion">Código Postal</label>
                        <input type="text" class="form-control" id="codigo_postal_direccion" name="codigo_postal_direccion" required>
                    </div>
                    <div class="form-group">
                        <label for="pais_direccion">País</label>
                        <input type="text" class="form-control" id="pais_direccion" name="pais_direccion" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono_direccion">Teléfono</label>
                        <input type="text" class="form-control" id="telefono_direccion" name="telefono_direccion">
                    </div>
                    <button type="button" class="btn btn-primary" id="guardar-direccion">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Información Bancaria -->
<div class="modal fade" id="modalAgregarBanco" tabindex="-1" role="dialog" aria-labelledby="modalAgregarBancoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarBancoLabel">Agregar Información Bancaria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario para agregar banco -->
                <form id="form-agregar-banco">
                    <input type="hidden" name="cliente_id" value="<?= $cliente['id'] ?>">
                    <div class="form-group">
                        <label for="banco">Banco</label>
                        <input type="text" class="form-control" id="banco" name="banco" required>
                    </div>
                    <div class="form-group">
                        <label for="numero_cuenta">Número de Cuenta</label>
                        <input type="text" class="form-control" id="numero_cuenta" name="numero_cuenta" required>
                    </div>
                    <div class="form-group">
                        <label for="tipo_cuenta">Tipo de Cuenta</label>
                        <input type="text" class="form-control" id="tipo_cuenta" name="tipo_cuenta" required>
                    </div>
                    <div class="form-group">
                        <label for="swift_bic">SWIFT/BIC</label>
                        <input type="text" class="form-control" id="swift_bic" name="swift_bic">
                    </div>
                    <button type="button" class="btn btn-primary" id="guardar-banco">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Precios Personalizados -->
<div class="modal fade" id="modalAgregarPrecio" tabindex="-1" role="dialog" aria-labelledby="modalAgregarPrecioLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarPrecioLabel">Agregar Precio Personalizado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario para agregar precio personalizado -->
                <form id="form-agregar-precio">
                    <input type="hidden" name="cliente_id" value="<?= $cliente['id'] ?>">
                    <div class="form-group">
                        <label for="producto_id">Producto</label>
                        <select class="form-control" id="producto_id" name="producto_id" required>
                            <!-- Llenar opciones con los productos -->
                            <?php foreach ($productos as $producto): ?>
                                <option value="<?= $producto['id'] ?>"><?= $producto['nombre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="precio_personalizado">Precio Personalizado</label>
                        <input type="number" step="0.01" class="form-control" id="precio_personalizado" name="precio_personalizado" required>
                    </div>
                    <button type="button" class="btn btn-primary" id="guardar-precio">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    // Inicializar pestañas de Bootstrap
    $('#myTab a').on('click', function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    // Funcionalidad para guardar contacto
    $('#guardar-contacto').click(function() {
        var formData = $('#form-agregar-contacto').serialize();
        $.post('<?= base_url('/clientes/guardarContacto') ?>', formData, function(data) {
            $('#modalAgregarContacto').modal('hide');
            cargarContactos();
        });
    });

    // Funcionalidad para guardar dirección
    $('#guardar-direccion').click(function() {
        var formData = $('#form-agregar-direccion').serialize();
        $.post('<?= base_url('/clientes/guardarDireccion') ?>', formData, function(data) {
            $('#modalAgregarDireccion').modal('hide');
            cargarDirecciones();
        });
    });

    // Funcionalidad para guardar banco
    $('#guardar-banco').click(function() {
        var formData = $('#form-agregar-banco').serialize();
        $.post('<?= base_url('/clientes/guardarBanco') ?>', formData, function(data) {
            $('#modalAgregarBanco').modal('hide');
            cargarBancos();
        });
    });

    // Funcionalidad para guardar precio personalizado
    $('#guardar-precio').click(function() {
        var formData = $('#form-agregar-precio').serialize();
        $.post('<?= base_url('/clientes/guardarPrecio') ?>', formData, function(data) {
            $('#modalAgregarPrecio').modal('hide');
            cargarPrecios();
        });
    });

    // Cargar listas de contactos, direcciones, información bancaria y precios personalizados
    cargarContactos();
    cargarDirecciones();
    cargarBancos();
    cargarPrecios();

    function cargarContactos() {
        var cliente_id = <?= $cliente['id'] ?>;
        $.get('<?= base_url('/clientes/obtenerContactos') ?>/' + cliente_id, function(data) {
            $('#lista-contactos').html(data);
        });
    }

    function cargarDirecciones() {
        var cliente_id = <?= $cliente['id'] ?>;
        $.get('<?= base_url('/clientes/obtenerDirecciones') ?>/' + cliente_id, function(data) {
            $('#lista-direcciones').html(data);
        });
    }

    function cargarBancos() {
        var cliente_id = <?= $cliente['id'] ?>;
        $.get('<?= base_url('/clientes/obtenerBancos') ?>/' + cliente_id, function(data) {
            $('#lista-bancos').html(data);
        });
    }

    function cargarPrecios() {
        var cliente_id = <?= $cliente['id'] ?>;
        $.get('<?= base_url('/clientes/obtenerPrecios') ?>/' + cliente_id, function(data) {
            $('#lista-precios').html(data);
        });
    }

    // Funcionalidad para eliminar contacto
    $('#lista-contactos').on('click', '.eliminar-contacto', function() {
        if(confirm('¿Estás seguro de eliminar este contacto?')) {
            var contacto_id = $(this).data('id');
            $.post('<?= base_url('/clientes/eliminarContacto') ?>/' + contacto_id, function(data) {
                cargarContactos();
            });
        }
    });

    // Funcionalidad para eliminar dirección
    $('#lista-direcciones').on('click', '.eliminar-direccion', function() {
        if(confirm('¿Estás seguro de eliminar esta dirección?')) {
            var direccion_id = $(this).data('id');
            $.post('<?= base_url('/clientes/eliminarDireccion') ?>/' + direccion_id, function(data) {
                cargarDirecciones();
            });
        }
    });

    // Funcionalidad para eliminar banco
    $('#lista-bancos').on('click', '.eliminar-banco', function() {
        if(confirm('¿Estás seguro de eliminar esta información bancaria?')) {
            var banco_id = $(this).data('id');
            $.post('<?= base_url('/clientes/eliminarBanco') ?>/' + banco_id, function(data) {
                cargarBancos();
            });
        }
    });

    // Funcionalidad para eliminar precio personalizado
    $('#lista-precios').on('click', '.eliminar-precio', function() {
        if(confirm('¿Estás seguro de eliminar este precio personalizado?')) {
            var precio_id = $(this).data('id');
            $.post('<?= base_url('/clientes/eliminarPrecio') ?>/' + precio_id, function(data) {
                cargarPrecios();
            });
        }
    });
});
</script>
<?= $this->endSection() ?>
