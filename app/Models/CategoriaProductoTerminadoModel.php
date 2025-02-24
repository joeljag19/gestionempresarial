<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriaProductoTerminadoModel extends Model
{
    protected $table = 'categoria_producto_terminado';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'descripcion', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

    // Customize timestamps fields names
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
