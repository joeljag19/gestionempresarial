<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductoEstacionModel extends Model
{
    protected $table = 'producto_estacion';
    protected $primaryKey = 'id';
    protected $allowedFields = ['producto_terminado_id', 'estacion_trabajo_id'];
}
