<?php
namespace App\Models;

use CodeIgniter\Model;

class EmpleadoDescuentoModel extends Model
{
    protected $table = 'empleado_descuentos';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'empleado_id',
        'descuento_id',
        'monto',
        'fecha',
        'frecuencia',
        'periodo_inicio',
        'periodo_fin',
        'comentario'
    ];
}