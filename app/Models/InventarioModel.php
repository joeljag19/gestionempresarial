<?php

namespace App\Models;

use CodeIgniter\Model;

class InventarioModel extends Model
{
    protected $table = 'Inventario';
    protected $primaryKey = 'id';
    protected $allowedFields = ['materiaprima_id', 'cantidad', 'id_almacen'];
    protected $useTimestamps = true; // Habilita el uso de timestamps
    protected $createdField = 'creado_en'; // Campo para la fecha de creación
    protected $updatedField = 'actualizado_en'; // Campo para la fecha de actualización
}
