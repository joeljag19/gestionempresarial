<?php
namespace App\Models;

use CodeIgniter\Model;

class NominaEmpleadoDetalleModel extends Model
{
    protected $table = 'nomina_empleados_detalles';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array'; // Puedes cambiar a 'object' si prefieres objetos
    protected $allowedFields = [
        'nomina_empleado_id',
        'tipo',
        'referencia_id',
        'monto',
        'origen',
        'empleado_incentivo_id'
    ];

    // Habilitar timestamps si deseas registrar creación/actualización (opcional)
    protected $useTimestamps = false;
    // protected $createdField = 'created_at';
    // protected $updatedField = 'updated_at';

    // Validación básica (opcional, puedes personalizarla)
    protected $validationRules = [
        'nomina_empleado_id' => 'required|integer',
        'tipo' => 'required|in_list[incentivo,descuento,afp,sfs,infotep,isr]',
        'monto' => 'required|decimal',
        'origen' => 'required|in_list[automatico,manual]',
        'referencia_id' => 'permit_empty|integer',
        'empleado_incentivo_id' => 'permit_empty|integer'
    ];

    protected $validationMessages = [
        'nomina_empleado_id' => [
            'required' => 'El ID del empleado en la nómina es obligatorio.',
            'integer' => 'El ID del empleado debe ser un número entero.'
        ],
        'tipo' => [
            'required' => 'El tipo de detalle es obligatorio.',
            'in_list' => 'El tipo debe ser uno de: incentivo, descuento, afp, sfs, infotep, isr.'
        ],
        'monto' => [
            'required' => 'El monto es obligatorio.',
            'decimal' => 'El monto debe ser un valor numérico.'
        ],
        'origen' => [
            'required' => 'El origen es obligatorio.',
            'in_list' => 'El origen debe ser automático o manual.'
        ]
    ];

    // Evitar que se eliminen registros accidentalmente (opcional)
    protected $useSoftDeletes = false;
    // protected $deletedField = 'deleted_at';

    // Método para obtener detalles con joins (opcional)
    public function getDetallesConRelaciones($nominaEmpleadoId)
    {
        return $this->select('nomina_empleados_detalles.*, incentivos.nombre as incentivo_nombre')
            ->join('incentivos', 'incentivos.id = nomina_empleados_detalles.referencia_id', 'left')
            ->where('nomina_empleado_id', $nominaEmpleadoId)
            ->findAll();
    }
}