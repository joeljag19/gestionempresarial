<?php
namespace App\Models;

use CodeIgniter\Model;

class PeriodoNominaModel extends Model
{
    protected $table = 'periodos_nomina';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'inicio', 'fin', 'tipo', 'anno'];
}
