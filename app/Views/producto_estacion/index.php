<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Productos Terminados
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Productos Terminados</h1>
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
                        <h3 class="card-title">Lista de Productos Terminados</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($productos as $producto): ?>
                                <tr>
                                    <td><?= $producto['id'] ?></td>
                                    <td><?= $producto['nombre'] ?></td>
                                    <td><?= isset($producto['descripcion']) ? $producto['descripcion'] : 'Sin descripción' ?></td>
                                    <td>
                                        <a href="/producto_estacion/asignar/<?= $producto['id'] ?>" class="btn btn-primary">Asignar Estaciones</a>
                                        <button class="btn btn-info" onclick="verEstaciones(<?= $producto['id'] ?>)">Ver Estaciones</button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Popup -->
<div class="modal fade" id="estacionesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Estaciones Asignadas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="estacionesBody">
        <!-- Contenido dinámico aquí -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>

function verEstaciones(productoId) {

     $.ajax({
         url: '/producto_estacion/verEstaciones/' + productoId,
         method: 'GET',
         success: function(response) {
             $('#estacionesBody').html(response);
             $('#estacionesModal').modal('show');
         }
     });
}
</script>

<?= $this->endSection() ?>




