<?php

namespace App\Models;

use CodeIgniter\Model;

class IdiomaModel extends Model
{
    protected $table = 'idiomas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['codigo', 'nombre'];
}
