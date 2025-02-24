<?php

namespace App\Models;

use CodeIgniter\Model;

class FormatoMonedaModel extends Model
{
    protected $table = 'formatos_moneda';
    protected $primaryKey = 'id';
    protected $allowedFields = ['formato', 'descripcion'];
}
