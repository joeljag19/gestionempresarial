<?php
namespace App\Models;

use CodeIgniter\Model;

class NominaEmpleadosModel extends Model
{
    protected $table = 'nomina_empleados';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nomina_maestro_id',
        'empleado_id',
        'salario',
        'ingresos_adicionales',
        'deducciones',
        'total_pago',
        'estatus_completado'
    ];
}
