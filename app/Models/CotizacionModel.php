<?php

namespace App\Models;

use CodeIgniter\Model;

class CotizacionModel extends Model
{
    protected $table = 'cotizaciones';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'cliente_id', 'numero_cotizacion', 'fecha_cotizacion', 'fecha_vencimiento',
        'gastos_envio', 'forma_entrega', 'segunda_unidad', 'modo_pago', 'moneda',
        'agente_ventas', 'factura_recurrente', 'tipo_descuento', 'nota_admin'
    ];
}
