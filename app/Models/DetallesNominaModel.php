<?php
namespace App\Models;

use CodeIgniter\Model;

class DetallesNominaModel extends Model
{
    protected $table = 'detalles_nomina';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nomina_id', 'descripcion', 'monto', 'tipo'];
}
