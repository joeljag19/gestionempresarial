<?php

namespace App\Models;

use CodeIgniter\Model;

class CotizacionModel extends Model
{
    protected $table = 'cotizaciones';
    protected $primaryKey = 'id';
    protected $allowedFields = ['cliente_id', 'producto_id', 'cantidad', 'precio', 'descuento', 'total'];

    public function obtenerCotizaciones()
    {
        return $this->findAll();
    }
}
