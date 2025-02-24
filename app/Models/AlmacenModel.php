<?php

namespace App\Models;

use CodeIgniter\Model;

class AlmacenModel extends Model
{
    protected $table = 'Almacenes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'descripcion_ubicacion', 'creado_en'];
    protected $useTimestamps = true; // Habilita el uso de timestamps
    protected $createdField = 'created_at'; // Campo para la fecha de creación
    protected $updatedField = 'updated_at'; // Campo para la fecha de actualización
}
