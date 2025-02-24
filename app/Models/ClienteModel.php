<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'codigo_cliente', 'tipo', 'nombre', 'email', 'telefono', 'direccion',
        'ciudad', 'codigo_postal', 'pais', 'rnc_cedula', 'fecha_registro', 'estado'
    ];
}
