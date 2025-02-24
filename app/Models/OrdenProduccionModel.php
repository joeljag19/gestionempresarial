<?php

namespace App\Models;

use CodeIgniter\Model;

class OrdenProduccionModel extends Model
{
    protected $table = 'ordenes_produccion';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'cotizacion_id', 'fecha_creacion', 'fecha_inicio', 'fecha_fin', 'estado'
    ];
}
