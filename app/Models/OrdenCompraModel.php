<?php
namespace App\Models;
use CodeIgniter\Model;

class OrdenCompraModel extends Model
{
    protected $table = 'ordenes_compra';
    protected $primaryKey = 'id';
    protected $allowedFields = ['suplidor_id', 'fecha_orden', 'estado', 'total', 'detalle'];
}
