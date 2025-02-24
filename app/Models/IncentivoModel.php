<?php
namespace App\Models;

use CodeIgniter\Model;

class IncentivoModel extends Model
{
    protected $table = 'incentivos';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nombre',
        'monto',
        'tipo_monto',
        'tipo_incentivo',
        'sfs',
        'afp',
        'isr',
        'infotep'
    ];
}
