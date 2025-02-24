<?php
namespace App\Models;

use CodeIgniter\Model;

class PrestamoModel extends Model
{
    protected $table = 'prestamos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['empleado_id', 'monto', 'fecha_inicio', 'fecha_fin', 'frecuencia', 'monto_periodo', 'monto_pagado'];
}
