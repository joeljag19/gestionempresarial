<?php

namespace App\Models;

use CodeIgniter\Model;

class DependenciaTareaModel extends Model
{
    protected $table = 'dependencias_tareas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tarea_id', 'tarea_dependiente_id'];
}
