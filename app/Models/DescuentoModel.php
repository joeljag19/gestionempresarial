<?php
namespace App\Models;

use CodeIgniter\Model;

class DescuentoModel extends Model
{
    protected $table = 'descuentos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'monto', 'tipo_monto', 'categoria_id'];
}
