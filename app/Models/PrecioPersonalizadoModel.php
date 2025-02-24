<?php

namespace App\Models;

use CodeIgniter\Model;

class PrecioPersonalizadoModel extends Model
{
    protected $table = 'precios_personalizados';
    protected $primaryKey = 'id';
    protected $allowedFields = ['cliente_id', 'producto_id', 'precio_personalizado'];
}
