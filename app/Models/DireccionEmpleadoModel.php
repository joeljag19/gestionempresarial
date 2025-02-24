<?php

namespace App\Models;

use CodeIgniter\Model;

class DireccionEmpleadoModel extends Model
{
    protected $table = 'direccion_empleados';
    protected $primaryKey = 'id';
    protected $allowedFields = ['empleado_id', 'direccion', 'ciudad', 'pais'];
}