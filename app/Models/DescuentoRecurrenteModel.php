<?php
namespace App\Models;

use CodeIgniter\Model;

class DescuentoRecurrenteModel extends Model
{
    protected $table = 'descuentos_recurrentes';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'empleado_id',
        'descuento_id',
        'nombre',
        'monto',
        'tipo_monto',
        'frecuencia',
        'periodo_inicio',
        'periodo_fin',
        'comentario'
    ];
}
