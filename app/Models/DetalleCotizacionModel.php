<?php

namespace App\Models;

use CodeIgniter\Model;

class DetalleCotizacionModel extends Model
{
    protected $table = 'detalle_cotizacion';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'cotizacion_id', 'producto_id', 'cantidad', 'precio_unitario', 'descuento'
    ];
}
