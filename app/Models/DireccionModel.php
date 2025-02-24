<?php

namespace App\Models;

use CodeIgniter\Model;

class DireccionModel extends Model
{
    protected $table = 'direcciones_entrega';
    protected $primaryKey = 'id';
    protected $allowedFields = ['entidad_id', 'nombre', 'direccion', 'ciudad', 'codigo_postal', 'pais', 'telefono', 'tipo_entidad'];
}
