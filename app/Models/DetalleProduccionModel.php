<?php

namespace App\Models;

use CodeIgniter\Model;

class DetalleProduccionModel extends Model
{
    protected $table = 'detalle_produccion';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'orden_produccion_id', 'producto_id', 'cantidad'
    ];
}
