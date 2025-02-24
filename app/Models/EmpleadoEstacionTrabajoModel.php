<?php

namespace App\Models;

use CodeIgniter\Model;

class EmpleadoEstacionTrabajoModel extends Model
{
    protected $table = 'empleados_estaciones_trabajo';
    protected $primaryKey = 'id';
    protected $allowedFields = ['empleado_id', 'estacion_trabajo_id', 'fecha_asignacion'];
}
