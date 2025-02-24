<?php
namespace App\Models;

use CodeIgniter\Model;

class EmpleadoIncentivoModel extends Model
{
    protected $table = 'empleado_incentivos';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'empleado_id',
        'incentivo_id',
        'monto',
        'fecha',
        'frecuencia',
        'periodo_inicio',
        'periodo_fin',
        'comentario'
    ];
}
