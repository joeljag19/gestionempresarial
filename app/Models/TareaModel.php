<?php

namespace App\Models;

use CodeIgniter\Model;

class TareaModel extends Model
{
    protected $table = 'tareas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'descripcion', 'tiempo_estimado', 'estacion_trabajo_id', 'producto_terminado_id', 'estado'];
}
