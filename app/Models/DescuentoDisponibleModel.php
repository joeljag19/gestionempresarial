<?php

namespace App\Models;

use CodeIgniter\Model;

class DescuentoDisponibleModel extends Model
{
    protected $table = 'descuentos_disponibles';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'monto', 'tipo_monto'];
}
