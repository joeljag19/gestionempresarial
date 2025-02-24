<?php

namespace App\Models;

use CodeIgniter\Model;

class RawMaterialsModel extends Model
{
    protected $table = 'RawMaterials';
    protected $primaryKey = 'id';
    protected $allowedFields = ['bom_id', 'materiaprima_id', 'cantidad', 'costo_unitario', 'desperdicio', 'subtotal'];
    protected $useTimestamps = true;
    protected $createdField = 'creado_en';
    protected $updatedField = 'actualizado_en';
}
