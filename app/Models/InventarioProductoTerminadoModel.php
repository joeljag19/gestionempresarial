<?php

namespace App\Models;

use CodeIgniter\Model;

class InventarioProductoTerminadoModel extends Model
{
    protected $table = 'inventario_producto_terminado';
    protected $primaryKey = 'id';
    protected $allowedFields = ['producto_terminado_id', 'cantidad', 'id_almacen', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

    // Customize timestamps fields names
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
