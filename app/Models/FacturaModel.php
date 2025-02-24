<?php

namespace App\Models;

use CodeIgniter\Model;

class FacturaModel extends Model
{
    protected $table = 'facturas';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'cliente_id', 'numero_factura', 'fecha_factura', 'fecha_vencimiento', 'total',
        'moneda', 'estado'
    ];
}
