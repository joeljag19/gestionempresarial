<?php

namespace App\Models;

use CodeIgniter\Model;

class BancoModel extends Model
{
    protected $table = 'informacion_bancaria';
    protected $primaryKey = 'id';
    protected $allowedFields = ['entidad_id', 'banco', 'numero_cuenta', 'tipo_cuenta', 'swift_bic', 'tipo_entidad'];
}
