<?php

namespace App\Models;

use CodeIgniter\Model;

class SalarioModel extends Model
{
    protected $table = 'Salarios';
    protected $primaryKey = 'id';
    protected $allowedFields = ['empleado_id', 'tipo_salario', 'monto', 'created_at', 'updated_at'];
}
