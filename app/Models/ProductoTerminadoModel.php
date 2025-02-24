<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductoTerminadoModel extends Model
{
    protected $table = 'producto_terminado';
    protected $primaryKey = 'id';
    protected $allowedFields = ['codigo_de_barra', 'nombre', 'categoria_id', 'unidad_medida_id', 'impuesto', 'costo_unidad', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

    // Customize timestamps fields names
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
