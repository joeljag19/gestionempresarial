<?php

namespace App\Models;

use CodeIgniter\Model;

class DetalleFacturaModel extends Model
{
    protected $table = 'detalle_factura';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'factura_id', 'producto_id', 'cantidad', 'precio_unitario', 'descuento'
    ];
}
