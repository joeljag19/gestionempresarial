<?php
namespace App\Controllers;

use App\Models\NominaMaestroModel;
use App\Models\NominaEmpleadosModel;
use App\Models\PeriodoNominaModel;
use App\Models\EmpleadoModel;
use App\Models\EmpleadoIncentivoModel;
use App\Models\IncentivoModel;
use App\Models\NominaEmpleadoDetalleModel;
use App\Models\ContactoEmpleadoModel;
use App\Models\EmpleadoDescuentoModel;

use App\Models\DescuentoModel;

use Dompdf\Dompdf;

class NominaController extends BaseController
{
    private const TOPE_TSS = 463589;
    private const TASA_AFP = 0.0287;
    private const TASA_SFS = 0.0304;
    private const TASA_SRL = 0.0102;
    private const TASA_INFOTEP = 0.005;

    public function index()
    {
        $nominaMaestroModel = new NominaMaestroModel();
        $periodoNominaModel = new PeriodoNominaModel();

        $data['nominas'] = $nominaMaestroModel->obtenerNominas();
        $data['anios'] = array_column($periodoNominaModel->select('anno as anio')->groupBy('anno')->findAll(), 'anio');

        return view('nomina/index', $data);
    }

    public function obtenerPeriodosDisponibles()
    {
        $periodoNominaModel = new PeriodoNominaModel();
        $nominaMaestroModel = new NominaMaestroModel();
        
        $anio = $this->request->getGet('anio');
        $periodos = $periodoNominaModel->select('id, nombre')
            ->where('anno', $anio)
            ->findAll();

        $periodosDisponibles = array_filter($periodos, function($periodo) use ($nominaMaestroModel) {
            return !$nominaMaestroModel->isPeriodoTrabajado($periodo['id']);
        });

        return $this->response->setJSON(['periodos' => array_values($periodosDisponibles)]);
    }

    public function generar()
    {
        $nominaMaestroModel = new NominaMaestroModel();
        $periodoNominaModel = new PeriodoNominaModel();
    
        $periodoId = $this->request->getPost('periodo_id');
        $periodo = $periodoNominaModel->find($periodoId);
    
        $data = [
            'periodo_id' => $periodoId,
            'fecha_inicio' => $periodo['inicio'],
            'fecha_fin' => $periodo['fin'],
            'estado' => 'pendiente',
            'total_pago' => 0,
            'total_ingresos_adicionales' => 0,
            'total_deducciones' => 0
        ];
    
        $nominaMaestroModel->save($data);
        return redirect()->to('/nomina');
    }

    public function obtenerEmpleados()
    {
        $empleadoModel = new EmpleadoModel();
        return $this->response->setJSON($empleadoModel->findAll());
    }

    public function agregarEmpleados()
    {
        $empleadoIds = $this->request->getPost('empleado_id');
        $nominaId = $this->request->getPost('nomina_id');
    
        log_message('debug', "Iniciando agregarEmpleados - nominaId: $nominaId, empleadoIds: " . json_encode($empleadoIds));
    
        if (empty($empleadoIds)) {
            log_message('error', 'No se recibieron empleados');
            return $this->response->setJSON(['error' => 'No se recibieron empleados']);
        }
    
        $nominaEmpleadosModel = new NominaEmpleadosModel();
        $empleadoModel = new EmpleadoModel();
        $incentivoModel = new EmpleadoIncentivoModel();
        $descuentoModel = new EmpleadoDescuentoModel();
        $detallesModel = new NominaEmpleadoDetalleModel();
        $nominaMaestroModel = new NominaMaestroModel();
        $periodoNominaModel = new PeriodoNominaModel();
        $incentivoBaseModel = new IncentivoModel();
        $success = true;
    
        $nomina = $nominaMaestroModel->find($nominaId);
        if (!$nomina) {
            log_message('error', "No se encontró nómina con ID: $nominaId");
            return $this->response->setJSON(['error' => 'Nómina no encontrada']);
        }
        $periodoId = $nomina['periodo_id'];
        $periodoActual = $periodoNominaModel->find($periodoId);
        if (!$periodoActual) {
            log_message('error', "No se encontró período con ID: $periodoId");
            return $this->response->setJSON(['error' => 'Período no encontrado']);
        }
        $anno = $periodoActual['anno'];
        $inicioPeriodo = new \DateTime($periodoActual['inicio']);
        $mesPeriodo = $inicioPeriodo->format('m');
        $esUltimoPeriodo = ($inicioPeriodo->format('d') > 15);
        log_message('debug', "Nómina encontrada - nominaId: $nominaId, periodoId: $periodoId, anno: $anno, mes: $mesPeriodo, esUltimoPeriodo: " . ($esUltimoPeriodo ? 'true' : 'false'));
    
        $existingEmpleados = $nominaEmpleadosModel->where('nomina_maestro_id', $nominaId)
                                                 ->findColumn('empleado_id') ?? [];
    
        foreach ($empleadoIds as $empleadoId) {
            if (in_array($empleadoId, $existingEmpleados)) {
                log_message('info', "Empleado $empleadoId ya existe en nómina $nominaId, omitiendo");
                continue;
            }
    
            $empleadoData = $empleadoModel->find($empleadoId);
            if ($empleadoData) {
                $insertData = [
                    'nomina_maestro_id' => $nominaId,
                    'empleado_id' => $empleadoId,
                    'salario' => $empleadoData['sueldo'] / 2,
                    'total_ingresos_adicionales' => 0.00,
                    'total_deducciones' => 0.00,
                    'total_pago' => $empleadoData['sueldo'] / 2,
                    'estatus_completado' => 0 // No completado inicialmente
                ];
    
                $nominaEmpleadoId = $nominaEmpleadosModel->insert($insertData);
                if (!$nominaEmpleadoId) {
                    log_message('error', "Error al insertar empleado $empleadoId en nomina_empleados");
                    $success = false;
                    continue;
                }
                log_message('debug', "Empleado $empleadoId insertado con nomina_empleado_id: $nominaEmpleadoId");
    
                // Cargar incentivos automáticos
                $incentivos = $incentivoModel->where('empleado_id', $empleadoId)->findAll();
                log_message('debug', "Todos los incentivos encontrados para empleado $empleadoId: " . json_encode($incentivos));
    
                $detalles = [];
                $aplicaInfotep = false;
                foreach ($incentivos as $incentivo) {
                    $agregar = false;
                    $inicioIncentivo = $incentivo['periodo_inicio'];
                    $finIncentivo = $incentivo['periodo_fin'] ?? PHP_INT_MAX;
                    $periodoInicioIncentivo = $periodoNominaModel->find($inicioIncentivo);
                    if (!$periodoInicioIncentivo) {
                        log_message('debug', "Incentivo $incentivo[id] excluido - periodo_inicio $inicioIncentivo no encontrado");
                        continue;
                    }
                    $mesIncentivo = (new \DateTime($periodoInicioIncentivo['inicio']))->format('m');
                    $annoIncentivo = $periodoInicioIncentivo['anno'];
    
                    switch ($incentivo['frecuencia']) {
                        case 'norecurrente':
                            $agregar = ($inicioIncentivo == $periodoId);
                            break;
                        case 'quincenal':
                            $agregar = ($mesIncentivo == $mesPeriodo && $annoIncentivo == $anno &&
                                       $inicioIncentivo <= $periodoId && $finIncentivo >= $periodoId);
                            break;
                        case 'mensual':
                            $agregar = ($mesIncentivo == $mesPeriodo && $annoIncentivo == $anno &&
                                       $inicioIncentivo <= $periodoId && $finIncentivo >= $periodoId && $esUltimoPeriodo);
                            break;
                        default:
                            $agregar = ($inicioIncentivo == $periodoId);
                            break;
                    }
    
                    if ($agregar) {
                        $incentivoBase = $incentivoBaseModel->find($incentivo['incentivo_id']);
                        if ($incentivoBase && $incentivoBase['infotep']) {
                            $aplicaInfotep = true;
                        }
                        $detalles[] = [
                            'nomina_empleado_id' => (int)$nominaEmpleadoId,
                            'tipo' => 'incentivo',
                            'referencia_id' => (int)$incentivo['incentivo_id'],
                            'monto' => (float)$incentivo['monto'],
                            'origen' => 'automatico',
                            'empleado_incentivo_id' => (int)$incentivo['id']
                        ];
                        log_message('debug', "Incentivo $incentivo[id] agregado - frecuencia: " . ($incentivo['frecuencia'] ?? 'no definida') . ", monto completo: " . $incentivo['monto']);
                    } else {
                        log_message('debug', "Incentivo $incentivo[id] excluido - frecuencia: " . ($incentivo['frecuencia'] ?? 'no definida'));
                    }
                }
    
                // Cargar descuentos automáticos
                $descuentos = $descuentoModel->where('empleado_id', $empleadoId)->findAll();
                log_message('debug', "Todos los descuentos encontrados para empleado $empleadoId: " . json_encode($descuentos));
    
                foreach ($descuentos as $descuento) {
                    $agregar = false;
                    $inicioDescuento = $descuento['periodo_inicio'];
                    $finDescuento = $descuento['periodo_fin'] ?? PHP_INT_MAX;
                    $periodoInicioDescuento = $periodoNominaModel->find($inicioDescuento);
                    if (!$periodoInicioDescuento) {
                        log_message('debug', "Descuento $descuento[id] excluido - periodo_inicio $inicioDescuento no encontrado");
                        continue;
                    }
                    $mesDescuento = (new \DateTime($periodoInicioDescuento['inicio']))->format('m');
                    $annoDescuento = $periodoInicioDescuento['anno'];
    
                    switch ($descuento['frecuencia']) {
                        case 'norecurrente':
                        case null:
                            $agregar = ($inicioDescuento == $periodoId);
                            break;
                        case 'quincenal':
                            $agregar = ($mesDescuento == $mesPeriodo && $annoDescuento == $anno &&
                                       $inicioDescuento <= $periodoId && $finDescuento >= $periodoId);
                            break;
                        case 'mensual':
                            $agregar = ($mesDescuento == $mesPeriodo && $annoDescuento == $anno &&
                                       $inicioDescuento <= $periodoId && $finDescuento >= $periodoId && $esUltimoPeriodo);
                            break;
                        default:
                            $agregar = ($inicioDescuento == $periodoId);
                            break;
                    }
    
                    if ($agregar) {
                        $detalles[] = [
                            'nomina_empleado_id' => (int)$nominaEmpleadoId,
                            'tipo' => 'descuento',
                            'referencia_id' => (int)$descuento['descuento_id'],
                            'monto' => (float)$descuento['monto'],
                            'origen' => 'automatico',
                            'empleado_incentivo_id' => null
                        ];
                        log_message('debug', "Descuento $descuento[id] agregado - frecuencia: " . ($descuento['frecuencia'] ?? 'no definida') . ", monto completo: " . $descuento['monto']);
                    } else {
                        log_message('debug', "Descuento $descuento[id] excluido - frecuencia: " . ($descuento['frecuencia'] ?? 'no definida'));
                    }
                }
    
                // Deducciones legales
                $salarioBase = $empleadoData['sueldo'] / 2; // Mitad del sueldo por quincena
                $salarioTSS = min($salarioBase, self::TOPE_TSS / 2);
                $afp = $salarioTSS * self::TASA_AFP;
                $sfs = $salarioTSS * self::TASA_SFS;
                $isr = $esUltimoPeriodo ? $this->calcularISR($empleadoData['sueldo'] * 12) / 12 : 0;
                $infotep = $aplicaInfotep ? $salarioTSS * self::TASA_INFOTEP : 0;
    
                $detalles[] = [
                    'nomina_empleado_id' => (int)$nominaEmpleadoId,
                    'tipo' => 'afp',
                    'referencia_id' => null,
                    'monto' => (float)$afp,
                    'origen' => 'automatico',
                    'empleado_incentivo_id' => null
                ];
                $detalles[] = [
                    'nomina_empleado_id' => (int)$nominaEmpleadoId,
                    'tipo' => 'sfs',
                    'referencia_id' => null,
                    'monto' => (float)$sfs,
                    'origen' => 'automatico',
                    'empleado_incentivo_id' => null
                ];
                if ($esUltimoPeriodo && $isr > 0) {
                    $detalles[] = [
                        'nomina_empleado_id' => (int)$nominaEmpleadoId,
                        'tipo' => 'isr',
                        'referencia_id' => null,
                        'monto' => (float)$isr,
                        'origen' => 'automatico',
                        'empleado_incentivo_id' => null
                    ];
                }
                if ($aplicaInfotep && $infotep > 0) {
                    $detalles[] = [
                        'nomina_empleado_id' => (int)$nominaEmpleadoId,
                        'tipo' => 'infotep',
                        'referencia_id' => null,
                        'monto' => (float)$infotep,
                        'origen' => 'automatico',
                        'empleado_incentivo_id' => null
                    ];
                }
    
                if (!empty($detalles)) {
                    log_message('debug', "Detalles a insertar para empleado $empleadoId: " . json_encode($detalles));
                    if (!$detallesModel->insertBatch($detalles)) {
                        log_message('error', "Error al insertar detalles para empleado $empleadoId: " . json_encode($detallesModel->errors()));
                        $success = false;
                    } else {
                        log_message('debug', "Detalles insertados exitosamente para empleado $empleadoId");
                    }
                } else {
                    log_message('debug', "No hay detalles para insertar para empleado $empleadoId");
                }
            } else {
                log_message('error', "No se encontró empleado con ID: $empleadoId");
                $success = false;
            }
        }
    
        log_message('debug', "Finalizando agregarEmpleados con success: " . ($success ? 'true' : 'false'));
        return $this->response->setJSON([
            'message' => $success ? 'Empleados e incentivos/descuentos agregados exitosamente' : 'Hubo un problema'
        ]);
    }

    public function calcular($id)
    {
        $nominaMaestroModel = new NominaMaestroModel();
        $nominaEmpleadosModel = new NominaEmpleadosModel();
        $detallesModel = new NominaEmpleadoDetalleModel();
        $periodoNominaModel = new PeriodoNominaModel();
        $empleadoModel = new EmpleadoModel();
    
        $nomina = $nominaMaestroModel->find($id);
        $periodo = $periodoNominaModel->find($nomina['periodo_id']);
        $empleados = $nominaEmpleadosModel->where('nomina_maestro_id', $id)->findAll();
    
        // Contar total de empleados y completados basados en estatus_completado
        $totalEmpleados = count($empleados);
        $empleadosCompletados = $nominaEmpleadosModel->where('nomina_maestro_id', $id)
                                                    ->where('estatus_completado', 1)
                                                    ->countAllResults();
    
        foreach ($empleados as &$empleado) {
            $result = $this->calcularNominaEmpleado($empleado['empleado_id'], $id, $empleado['id']);
            $empleado['total_ingresos_adicionales'] = $result['incentivos'];
            $empleado['total_deducciones'] = $result['deducciones'];
            $empleado['total_pago'] = $result['neto'];
        }
    
        $total_salario = array_sum(array_column($empleados, 'salario'));
        $total_ingresos_adicionales = array_sum(array_column($empleados, 'total_ingresos_adicionales'));
        $total_deducciones = array_sum(array_column($empleados, 'total_deducciones'));
        $total_pago = array_sum(array_column($empleados, 'total_pago'));
        $total_costo = $total_salario + $total_ingresos_adicionales + array_sum(array_column($empleados, 'srl'));
    
        $data = [
            'nomina' => array_merge($nomina, [
                'total_salario' => $total_salario,
                'total_ingresos_adicionales' => $total_ingresos_adicionales,
                'total_deducciones' => $total_deducciones,
                'total_costo' => $total_costo,
                'total_pago' => $total_pago,
                'periodo_nombre' => $periodo['nombre'],
            ]),
            'empleados' => $empleados,
            'totalEmpleados' => $totalEmpleados, // Total de empleados en la nómina
            'empleadosCompletados' => $empleadosCompletados, // Empleados con estatus_completado = 1
            'empleadosDisponibles' => $empleadoModel->findAll(),
            'nomina_maestro_id' => $id,
            'empleadoModel' => $empleadoModel
        ];
    
        return view('nomina/calcular', $data);
    }
    
    private function calcularNominaEmpleado($empleadoId, $nominaId, $nominaEmpleadoId)
    {
        $salarioBase = $this->obtenerSalarioBase($empleadoId) / 2; // Mitad del sueldo para quincena
        $detallesModel = new NominaEmpleadoDetalleModel();
        $nominaEmpleadosModel = new NominaEmpleadosModel();
    
        // Leer todos los detalles almacenados
        $detalles = $detallesModel->where('nomina_empleado_id', $nominaEmpleadoId)->findAll();
        log_message('debug', "Detalles leídos para empleado $empleadoId, nomina_empleado_id $nominaEmpleadoId: " . json_encode($detalles));
    
        $incentivosTotal = 0;
        $deduccionesTotales = 0;
    
        // Sumar los montos directamente desde la base de datos
        foreach ($detalles as $detalle) {
            $monto = (float)$detalle['monto'];
            if ($detalle['tipo'] === 'incentivo') {
                $incentivosTotal += $monto;
            } elseif (in_array($detalle['tipo'], ['descuento', 'afp', 'sfs', 'isr', 'infotep'])) {
                $deduccionesTotales += $monto;
            }
        }
    
        // Calcular el neto usando el salario base quincenal y los totales de la base
        $neto = $salarioBase + $incentivosTotal - $deduccionesTotales;
    
        // Actualizar los totales en nomina_empleados sin cambiar estatus_completado
        $nominaEmpleadosModel->update($nominaEmpleadoId, [
            'total_ingresos_adicionales' => $incentivosTotal,
            'total_deducciones' => $deduccionesTotales,
            'total_pago' => $neto
        ]);
    
        log_message('debug', "Totales calculados - incentivos: $incentivosTotal, deducciones: $deduccionesTotales, neto: $neto");
    
        return [
            'salario' => $salarioBase,
            'incentivos' => $incentivosTotal,
            'deducciones' => $deduccionesTotales,
            'neto' => $neto,
            'srl' => 0,
            'infotep' => 0
        ];
    }

    private function obtenerSalarioBase($empleadoId)
    {
        $empleadoModel = new EmpleadoModel();
        $empleado = $empleadoModel->find($empleadoId);
        return $empleado['sueldo'] ?? 0;
    }

    private function calcularISR($salarioAnual)
    {
        if ($salarioAnual <= 416220) return 0;
        if ($salarioAnual <= 624329) return ($salarioAnual - 416220) * 0.15;
        if ($salarioAnual <= 867123) return 31203.75 + ($salarioAnual - 624329) * 0.20;
        return 79727.25 + ($salarioAnual - 867123) * 0.25;
    }

    public function eliminarEmpleado()
    {
        $nominaEmpleadosModel = new NominaEmpleadosModel();
        $detallesModel = new NominaEmpleadoDetalleModel();
    
        log_message('debug', "Intentando eliminar empleado");
    
        try {
            // Obtener nomina_empleado_id desde los datos POST
            $nominaEmpleadoId = $this->request->getPost('nomina_empleado_id');
            if (!$nominaEmpleadoId || !is_numeric($nominaEmpleadoId)) {
                log_message('error', "ID de empleado no válido o no proporcionado");
                return $this->response->setJSON(['error' => 'ID de empleado no válido']);
            }
    
            // Buscar el registro del empleado en nomina_empleados
            $nominaEmpleado = $nominaEmpleadosModel->find((int)$nominaEmpleadoId);
            if (!$nominaEmpleado) {
                log_message('error', "Registro de nómina no encontrado para ID: $nominaEmpleadoId");
                return $this->response->setJSON(['error' => 'Registro de nómina no encontrado']);
            }
    
            log_message('debug', "Empleado encontrado - estatus_completado: " . $nominaEmpleado['estatus_completado']);
    
            // Verificar si el empleado está completado (estatus_completado = 1)
            if ($nominaEmpleado['estatus_completado'] == 1) {
                log_message('error', "No se puede eliminar el empleado $nominaEmpleadoId porque está marcado como completado");
                return $this->response->setJSON(['error' => 'No se puede eliminar el empleado porque está marcado como completado']);
            }
    
            // Eliminar los detalles asociados
            $detallesEliminados = $detallesModel->where('nomina_empleado_id', (int)$nominaEmpleadoId)->delete();
            log_message('debug', "Detalles eliminados para empleado $nominaEmpleadoId: " . ($detallesEliminados ? 'Sí' : 'No'));
    
            // Eliminar el registro del empleado
            $nominaEmpleadosModel->delete((int)$nominaEmpleadoId);
            log_message('debug', "Empleado $nominaEmpleadoId eliminado exitosamente");
    
            return $this->response->setJSON(['message' => 'Empleado eliminado exitosamente']);
        } catch (\Exception $e) {
            log_message('error', "Error al eliminar empleado $nominaEmpleadoId: " . $e->getMessage());
            return $this->response->setJSON(['error' => 'Error al procesar la solicitud: ' . $e->getMessage()]);
        }
    }

    public function obtenerEmpleadosNominaActual($nominaId)
    {
        $nominaEmpleadosModel = new NominaEmpleadosModel();
        $empleados = $nominaEmpleadosModel->select('empleado_id')->where('nomina_maestro_id', $nominaId)->findAll();
        $empleadoIds = array_column($empleados, 'empleado_id');
        return $this->response->setJSON($empleadoIds);
    }

    public function agregarDetalleManual()
    {
        log_message('debug', 'Iniciando agregarDetalleManual');
    
        $nominaEmpleadoId = $this->request->getPost('nomina_empleado_id');
        $tipo = $this->request->getPost('tipo');
        $referenciaId = $this->request->getPost('referencia_id');
        $montoInput = $this->request->getPost('monto');
    
        log_message('debug', "Datos recibidos - nomina_empleado_id: $nominaEmpleadoId, tipo: $tipo, referencia_id: $referenciaId, monto: $montoInput");
    
        if (empty($nominaEmpleadoId) || empty($tipo) || empty($referenciaId) || empty($montoInput)) {
            log_message('error', 'Faltan datos requeridos');
            return $this->response->setJSON(['error' => 'Faltan datos requeridos']);
        }
    
        $detallesModel = new NominaEmpleadoDetalleModel();
        $nominaEmpleadosModel = new NominaEmpleadosModel();
        $incentivoModel = new IncentivoModel();
        $descuentoModel = new DescuentoModel();
    
        // Obtener el salario base del empleado
        $empleadoData = $nominaEmpleadosModel->find($nominaEmpleadoId);
        if (!$empleadoData) {
            log_message('error', "No se encontró empleado con nomina_empleado_id: $nominaEmpleadoId");
            return $this->response->setJSON(['error' => 'Empleado no encontrado']);
        }
        $salarioBase = $empleadoData['salario'];
        log_message('debug', "Salario base encontrado: $salarioBase");
    
        // Calcular el monto real según el tipo
        $monto = floatval($montoInput); // El monto ingresado (por ejemplo, horas)
        if ($tipo === 'incentivo') {
            $incentivo = $incentivoModel->find($referenciaId);
            if (!$incentivo) {
                log_message('error', "No se encontró incentivo con referencia_id: $referenciaId");
                return $this->response->setJSON(['error' => 'Incentivo no encontrado']);
            }
            log_message('debug', "Incentivo encontrado: " . json_encode($incentivo));
    
            // Calcular valor por hora según la fórmula dominicana
            $valorHora = $salarioBase / (23.83 * 8); // Sueldo ÷ (días promedio × horas diarias)
            log_message('debug', "Valor por hora calculado: $valorHora");
    
            // Ajustar el monto según el tipo de incentivo
            if ($incentivo['tipo_monto'] === 'porcentaje') {
                $monto = $valorHora * $monto * ($incentivo['monto'] / 100); // Horas × valor hora × porcentaje
            } else {
                switch ($incentivo['tipo_incentivo']) {
                    case 'extra_35':
                        $monto = $valorHora * $monto * 1.35; // 35% adicional sobre el valor normal
                        break;
                    case 'extra_100':
                        $monto = $valorHora * $monto * 2.00; // 100% adicional (doble)
                        break;
                    case 'extra_15':
                        $monto = $valorHora * $monto * 1.15; // 15% adicional
                        break;
                    case 'extra_no_labor_100':
                        $monto = $valorHora * $monto * 2.00; // 100% adicional (doble)
                        break;
                    default:
                        $monto = $valorHora * $monto; // Si no hay regla específica, usar valor normal
                        break;
                }
            }
        } elseif ($tipo === 'descuento') {
            $descuento = $descuentoModel->find($referenciaId);
            if (!$descuento) {
                log_message('error', "No se encontró descuento con referencia_id: $referenciaId");
                return $this->response->setJSON(['error' => 'Descuento no encontrado']);
            }
            log_message('debug', "Descuento encontrado: " . json_encode($descuento));
            if ($descuento['tipo_monto'] === 'porcentaje') {
                $monto = $salarioBase * ($monto / 100);
            }
        }
    
        $data = [
            'nomina_empleado_id' => $nominaEmpleadoId,
            'tipo' => $tipo,
            'referencia_id' => $referenciaId,
            'monto' => $monto,
            'origen' => 'manual',
            'empleado_incentivo_id' => null
        ];
    
        log_message('debug', "Datos a insertar: " . json_encode($data));
        if ($detallesModel->insert($data)) {
            log_message('debug', 'Detalle agregado exitosamente');
            return $this->response->setJSON(['message' => 'Detalle agregado manualmente']);
        } else {
            log_message('error', 'Error al insertar detalle: ' . json_encode($detallesModel->errors()));
            return $this->response->setJSON(['error' => 'Error al agregar detalle']);
        }
    }

    public function reciboPago($nominaId, $nominaEmpleadoId)
    {
        $nominaMaestroModel = new NominaMaestroModel();
        $nominaEmpleadosModel = new NominaEmpleadosModel();
        $empleadoModel = new EmpleadoModel();
        $periodoNominaModel = new PeriodoNominaModel();
        $detallesModel = new NominaEmpleadoDetalleModel();
        $contactoModel = new ContactoEmpleadoModel();
        $incentivoModel = new IncentivoModel(); // Añadido
        $descuentoModel = new DescuentoModel(); // Añadido
    
        // Obtener la nómina y el período
        $nomina = $nominaMaestroModel->find($nominaId);
        if (!$nomina) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Nómina no encontrada');
        }
        $periodo = $periodoNominaModel->find($nomina['periodo_id']);
    
        // Obtener el empleado y los datos de la nómina
        $nominaEmpleado = $nominaEmpleadosModel->find($nominaEmpleadoId);
        if (!$nominaEmpleado) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Registro de nómina no encontrado');
        }
        $empleado = $empleadoModel
            ->select('empleados.id, empleados.primer_nombre, empleados.apellido, empleados.cedula, contactos.correo_personal, contactos.correo_compania')
            ->join('contacto_empleados AS contactos', 'empleados.id = contactos.empleado_id')
            ->find($nominaEmpleado['empleado_id']);
    
        // Obtener detalles de ingresos y deducciones
        $detalles = $detallesModel->where('nomina_empleado_id', $nominaEmpleadoId)->findAll();
    
        $ingresos = [];
        $deducciones = [];
        foreach ($detalles as $detalle) {
            if ($detalle['tipo'] === 'incentivo') {
                $incentivo = $incentivoModel->find($detalle['referencia_id']);
                $concepto = $incentivo ? $incentivo['nombre'] : "Incentivo Desconocido (ID: {$detalle['referencia_id']})";
                $ingresos[] = [
                    'concepto' => $concepto,
                    'cantidad' => 1, // O ajusta según necesidad
                    'valor' => (float)$detalle['monto']
                ];
            } elseif (in_array($detalle['tipo'], ['descuento', 'afp', 'sfs', 'isr', 'infotep'])) {
                if ($detalle['tipo'] === 'descuento') {
                    $descuento = $descuentoModel->find($detalle['referencia_id']);
                    $concepto = $descuento ? $descuento['nombre'] : "Descuento Desconocido (ID: {$detalle['referencia_id']})";
                } else {
                    $concepto = ucfirst($detalle['tipo']);
                }
                $porcentaje = '';
                switch ($detalle['tipo']) {
                    case 'afp': $porcentaje = '2.87'; break;
                    case 'sfs': $porcentaje = '3.04'; break;
                    case 'isr': $porcentaje = 'Variable'; break;
                    case 'infotep': $porcentaje = '1.0'; break;
                    default: $porcentaje = ''; // Para descuentos manuales
                }
                $deducciones[] = [
                    'concepto' => $concepto,
                    'porcentaje' => $porcentaje,
                    'valor' => (float)$detalle['monto']
                ];
            }
        }
    
        // Pasar datos a la vista
        $data = [
            'nomina' => $nomina,
            'nominaEmpleado' => $nominaEmpleado,
            'empleado' => $empleado,
            'periodo' => $periodo,
            'ingresos' => $ingresos,
            'deducciones' => $deducciones
        ];
    
        return view('nomina/recibo_pago', $data);
    }

    public function marcarEmpleadoCompletado($nominaEmpleadoId)
    {
        $nominaEmpleadosModel = new NominaEmpleadosModel();
    
        $nominaEmpleado = $nominaEmpleadosModel->find($nominaEmpleadoId);
        if (!$nominaEmpleado) {
            return $this->response->setJSON(['error' => 'Registro de nómina no encontrado']);
        }
    
        $nominaEmpleadosModel->update($nominaEmpleadoId, [
            'estatus_completado' => 1
        ]);
    
        log_message('debug', "Empleado $nominaEmpleadoId marcado como completado");
    
        return $this->response->setJSON(['message' => 'Empleado marcado como completado exitosamente']);
    }

    public function marcarNominaCompletada($nominaId)
    {
        $nominaMaestroModel = new NominaMaestroModel();
        $nominaEmpleadosModel = new NominaEmpleadosModel();
    
        $nomina = $nominaMaestroModel->find($nominaId);
        if (!$nomina) {
            return $this->response->setJSON(['error' => 'Nómina no encontrada']);
        }
    
        // Verificar que todos los empleados estén completados
        $empleadosCompletados = $nominaEmpleadosModel->where('nomina_maestro_id', $nominaId)
                                                    ->where('estatus_completado', 1)
                                                    ->countAllResults();
        $totalEmpleados = $nominaEmpleadosModel->where('nomina_maestro_id', $nominaId)->countAllResults();
    
        if ($empleadosCompletados !== $totalEmpleados) {
            return $this->response->setJSON(['error' => 'No todos los empleados están completados']);
        }
    
        // Recalcular totales de la nómina
        $totalIngresos = $nominaEmpleadosModel->where('nomina_maestro_id', $nominaId)
                                              ->selectSum('total_ingresos_adicionales')
                                              ->first()['total_ingresos_adicionales'] ?? 0;
        $totalDeducciones = $nominaEmpleadosModel->where('nomina_maestro_id', $nominaId)
                                                ->selectSum('total_deducciones')
                                                ->first()['total_deducciones'] ?? 0;
        $totalPago = $nominaEmpleadosModel->where('nomina_maestro_id', $nominaId)
                                         ->selectSum('total_pago')
                                         ->first()['total_pago'] ?? 0;
    
        $nominaMaestroModel->update($nominaId, [
            'total_ingresos_adicionales' => $totalIngresos,
            'total_deducciones' => $totalDeducciones,
            'total_pago' => $totalPago,
            'estatus_completado' => 1
        ]);
    
        log_message('debug', "Nómina $nominaId marcada como completada - totales: ingresos $totalIngresos, deducciones $totalDeducciones, pago $totalPago");
    
        return $this->response->setJSON(['message' => 'Nómina marcada como completada exitosamente']);
    }

    public function reportePagos($nominaId = null, $formato = 'html')
    {
        $nominaMaestroModel = new NominaMaestroModel();
        $nominaEmpleadosModel = new NominaEmpleadosModel();
        $empleadoModel = new EmpleadoModel();
        $detallesModel = new NominaEmpleadoDetalleModel();
        $periodoNominaModel = new PeriodoNominaModel();
    
        // Si no se especifica nominaId, podrías redirigir o mostrar un error
        if (!$nominaId) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('ID de nómina no especificado');
        }
    
        // Obtener la nómina y el período
        $nomina = $nominaMaestroModel->find($nominaId);
        if (!$nomina) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Nómina no encontrada');
        }
        $periodo = $periodoNominaModel->find($nomina['periodo_id']);
    
        // Obtener solo los empleados de la nómina con estatus_completado = 1
        $empleados = $nominaEmpleadosModel->where('nomina_maestro_id', $nominaId)
                                         ->where('estatus_completado', 1)
                                         ->findAll();
    
        $reporte = [];
        $totales = [
            'incentivos' => 0,
            'descuentos' => 0,
            'afp' => 0,
            'sfs' => 0,
            'isr' => 0,
            'infotep' => 0,
            'totalDeducciones' => 0,
            'totalPago' => 0
        ];
    
        foreach ($empleados as $empleado) {
            $empleadoData = $empleadoModel->find($empleado['empleado_id']);
            $detalles = $detallesModel->where('nomina_empleado_id', $empleado['id'])->findAll();
    
            $salario = $empleado['salario'];
            $incentivos = [];
            $totalIncentivos = 0;
            $descuentos = [];
            $totalDescuentos = 0;
            $afp = 0;
            $sfs = 0;
            $isr = 0;
            $infotep = 0;
    
            // Procesar detalles para obtener incentivos, descuentos y deducciones legales
            foreach ($detalles as $detalle) {
                $monto = (float)$detalle['monto'];
                switch ($detalle['tipo']) {
                    case 'incentivo':
                        $incentivos[] = $monto;
                        $totalIncentivos += $monto;
                        break;
                    case 'descuento':
                        $descuentos[] = $monto;
                        $totalDescuentos += $monto;
                        break;
                    case 'afp':
                        $afp = $monto;
                        break;
                    case 'sfs':
                        $sfs = $monto;
                        break;
                    case 'isr':
                        $isr = $monto;
                        break;
                    case 'infotep':
                        $infotep = $monto;
                        break;
                }
            }
    
            // Total deducciones (legales + descuentos)
            $totalDeducciones = $afp + $sfs + $isr + $infotep + $totalDescuentos;
    
            // Total de pago
            $totalPago = $salario + $totalIncentivos - $totalDeducciones;
    
            // Acumular totales
            $totales['incentivos'] += $totalIncentivos;
            $totales['descuentos'] += $totalDescuentos;
            $totales['afp'] += $afp;
            $totales['sfs'] += $sfs;
            $totales['isr'] += $isr;
            $totales['infotep'] += $infotep;
            $totales['totalDeducciones'] += $totalDeducciones;
            $totales['totalPago'] += $totalPago;
    
            $reporte[] = [
                'empleado' => $empleadoData['primer_nombre'] . ' ' . $empleadoData['apellido'],
                'cedula' => $empleadoData['cedula'],
                'salario' => $salario,
                'incentivos' => $incentivos,
                'totalIncentivos' => $totalIncentivos,
                'descuentos' => $descuentos,
                'totalDescuentos' => $totalDescuentos,
                'afp' => $afp,
                'sfs' => $sfs,
                'isr' => $isr,
                'infotep' => $infotep,
                'totalDeducciones' => $totalDeducciones,
                'totalPago' => $totalPago
            ];
        }
    
        // Pasar datos a la vista o generar PDF
        $data = [
            'nomina' => $nomina,
            'periodo' => $periodo,
            'reporte' => $reporte,
            'totales' => $totales
        ];
    
        if ($formato === 'pdf') {
            return $this->generarPDFReporte($data);
        }
    
        return view('nomina/reporte_pagos', $data);
    }
    
    private function generarPDFReporte($data)
    {
        $html = view('nomina/reporte_pagos_pdf', $data); // Usaremos una vista específica para PDF
    
        // Cargar dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
    
        // Configurar el papel (puedes ajustar tamaño y orientación)
        $dompdf->setPaper('A4', 'portrait');
    
        // Renderizar el PDF
        $dompdf->render();
    
        // Descargar el PDF
        $dompdf->stream('reporte_pagos_' . $data['nomina']['id'] . '.pdf', ['Attachment' => true]);
    }


    






}//Fin Controlador

