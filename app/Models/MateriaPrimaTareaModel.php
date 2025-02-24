<?php

namespace App\Models;

use CodeIgniter\Model;

class MateriaPrimaTareaModel extends Model
{
    protected $table = 'materia_prima_tareas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tarea_id', 'materia_prima_id', 'cantidad', 'desperdicio'];
}
