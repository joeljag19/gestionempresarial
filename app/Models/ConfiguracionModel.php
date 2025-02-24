<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfiguracionModel extends Model
{
    protected $table = 'configuracion';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nombre_empresa',
        'direccion',
        'telefono',
        'rnc',
        'formato_moneda_id',
        'formato_fecha_id',
        'idioma_id'
    ];
}
