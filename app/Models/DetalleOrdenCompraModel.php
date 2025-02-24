<?php
namespace App\Models;
use CodeIgniter\Model;

class DetalleOrdenCompraModel extends Model
{
    protected $table = 'detalle_orden_compra';
    protected $primaryKey = 'id';
    protected $allowedFields = ['orden_compra_id', 'materia_prima_id', 'cantidad', 'precio_unitario', 'subtotal', 'itbis'];
}
