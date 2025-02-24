<?php
namespace App\Models;

use CodeIgniter\Model;

class NominaMaestroModel extends Model
{
    protected $table = 'nomina_maestro';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'periodo_id',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'total_pago',
        'total_ingresos_adicionales',
        'total_deducciones',
        'estatus_completado'
    ];

    public function isPeriodoTrabajado($periodoId)
    {
        return $this->where('periodo_id', $periodoId)->countAllResults() > 0;
    }

    public function obtenerNominas()
    {
        return $this->select('nomina_maestro.*, periodos_nomina.nombre as periodo_nombre')
            ->join('periodos_nomina', 'nomina_maestro.periodo_id = periodos_nomina.id')
            ->orderBy('nomina_maestro.periodo_id', 'DESC')
            ->findAll();
    }
}
