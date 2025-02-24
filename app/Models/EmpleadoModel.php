<?php

namespace App\Models;

use CodeIgniter\Model;

class EmpleadoModel extends Model
{
    protected $table = 'empleados';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'primer_nombre', 'apellido', 'cedula', 'genero', 
        'fecha_nacimiento', 'estado', 'sueldo', 'created_at', 'updated_at'
    ];
    
}
