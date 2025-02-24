<?php

namespace App\Models;

use CodeIgniter\Model;

class SuplidorModel extends Model
{
    protected $table = 'suplidores';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'codigo_suplidor', 'tipo', 'nombre', 'email', 'telefono', 'direccion',
        'ciudad', 'codigo_postal', 'pais', 'rnc_cedula', 'fecha_registro', 'estado'
    ];
}
