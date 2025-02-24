<?php
namespace App\Models;

use CodeIgniter\Model;

class NominaModel extends Model
{
    protected $table = 'nomina';
    protected $primaryKey = 'id';
    protected $allowedFields = ['empleado_id', 'periodo_inicio', 'periodo_fin', 'salario_base', 'incentivos', 'bonificaciones', 'deducciones', 'salario_neto', 'fecha_pago'];
}
