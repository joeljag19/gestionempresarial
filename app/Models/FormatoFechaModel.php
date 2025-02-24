<?php

namespace App\Models;

use CodeIgniter\Model;

class FormatoFechaModel extends Model
{
    protected $table = 'formatos_fecha';
    protected $primaryKey = 'id';
    protected $allowedFields = ['formato', 'descripcion'];
}
