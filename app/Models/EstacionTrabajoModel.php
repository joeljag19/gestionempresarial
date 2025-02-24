<?php

namespace App\Models;

use CodeIgniter\Model;

class EstacionTrabajoModel extends Model
{
    protected $table = 'estaciones_trabajo';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'descripcion'];
}
