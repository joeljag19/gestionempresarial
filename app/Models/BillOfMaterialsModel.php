<?php

namespace App\Models;

use CodeIgniter\Model;

class BillOfMaterialsModel extends Model
{
    protected $table = 'BillOfMaterials';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'descripcion', 'materiaprima_id', 'costo_total'];
    protected $useTimestamps = true;
    protected $createdField = 'creado_en';
    protected $updatedField = 'actualizado_en';
}
