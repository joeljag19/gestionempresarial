<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductoTerminadoEstacionTrabajoModel extends Model
{
    protected $table = 'producto_terminado_estaciones_trabajo';
    protected $primaryKey = 'id';
    protected $allowedFields = ['producto_terminado_id', 'estacion_trabajo_id', 'tarea_id', 'tiempo_total'];
}
