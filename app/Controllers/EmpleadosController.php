<?php
namespace App\Controllers;

use App\Models\EmpleadoModel;
use App\Models\IncentivoModel;
use App\Models\EmpleadoIncentivoModel;
use App\Models\PrestamoModel;
use App\Models\DescuentoModel;
use App\Models\DescuentoDisponibleModel;
use App\Models\EmployeeMovementModel;
use App\Models\DireccionEmpleadoModel;
use App\Models\ContactoEmpleadoModel;
use App\Models\IncentivoRecurrenteModel;
use App\Models\EmpleadoDescuentoModel;
use App\Models\DescuentoRecurrenteModel;
use App\Models\PeriodoNominaModel;


use CodeIgniter\HTTP\ResponseInterface;


class EmpleadosController extends BaseController
{
    public function index()
    {
        $model = new EmpleadoModel();
        $data['empleados'] = $model->findAll();
        return view('empleados/index', $data);
    }

    public function crear()
    {
        return view('empleados/crear');
    }

    public function guardar()
    {
        $empleadoModel = new EmpleadoModel();
        $direccionModel = new DireccionEmpleadoModel();
        $contactoModel = new ContactoEmpleadoModel();
    
        $empleadoData = [
            'primer_nombre' => $this->request->getPost('primer_nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'cedula' => $this->request->getPost('cedula'),
            'genero' => $this->request->getPost('genero'),
            'fecha_nacimiento' => $this->request->getPost('fecha_nacimiento'),
            'estado' => 'active',
            'sueldo' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
    
        // Inserta el empleado primero
        $empleadoModel->insert($empleadoData);
        $empleadoId = $empleadoModel->insertID();
    
        // Verifica si se ha insertado el empleado antes de insertar en direccion_empleados
        if ($empleadoId) {
            $direccionData = [
                'empleado_id' => $empleadoId,
                'direccion' => $this->request->getPost('direccion'),
                'ciudad' => $this->request->getPost('ciudad'),
                'pais' => $this->request->getPost('pais')
            ];
    
            $contactoData = [
                'empleado_id' => $empleadoId,
                'numero_celular' => $this->request->getPost('numero_celular'),
                'correo_personal' => $this->request->getPost('correo_personal'),
                'correo_compania' => $this->request->getPost('correo_compania')
            ];
    
            $direccionModel->insert($direccionData);
            $contactoModel->insert($contactoData);
        } else {
            // Manejo del error si no se inserta el empleado
            return $this->response->setJSON(['status' => 'error', 'message' => 'Error al insertar el empleado']);
        }
    
        return redirect()->to('/empleados');
    }
    

    public function despedir($id)
    {
        $empleadoModel = new EmpleadoModel();
        $movementModel = new EmployeeMovementModel();

        // Actualizar estado del empleado
        $empleadoModel->update($id, ['estado' => 'inactive']);

        // Guardar movimiento de salida
        $movementModel->save([
            'employee_id' => $id,
            'movement_type' => 'fire',
            'movement_date' => date('Y-m-d')
        ]);

        return redirect()->to('/empleados');
    }

    public function recontratar($id)
    {
        $empleadoModel = new EmpleadoModel();
        $movementModel = new EmployeeMovementModel();

        // Actualizar estado del empleado
        $empleadoModel->update($id, ['estado' => 'active']);

        // Guardar movimiento de reingreso
        $movementModel->save([
            'employee_id' => $id,
            'movement_type' => 'hire',
            'movement_date' => date('Y-m-d')
        ]);

        return redirect()->to('/empleados');
    }

    // Nueva función para guardar movimientos
    public function guardarMovimiento($id)
    {
        $movementModel = new EmployeeMovementModel();

        $data = [
            'employee_id' => $id,
            'movement_type' => $this->request->getPost('tipo_movimiento'),
            'movement_date' => $this->request->getPost('fecha_movimiento')
        ];

        // Validar si el tipo de movimiento es "hire" y el empleado ya está activo
        $empleadoModel = new EmpleadoModel();
        $empleado = $empleadoModel->find($id);
        if ($data['movement_type'] == 'hire' && $empleado['estado'] == 'active') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'El empleado ya está activo']);
        }

        // Actualizar estado del empleado
        $newEstado = $data['movement_type'] == 'hire' ? 'active' : 'inactive';
        $empleadoModel->update($id, ['estado' => $newEstado]);

        $movementModel->save($data);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function editar($id)
    {
        $empleadoModel = new EmpleadoModel();
        $data['empleado'] = $empleadoModel->find($id);

        $direccionModel = new DireccionEmpleadoModel();
        $data['direccion'] = $direccionModel->where('empleado_id', $id)->first();

        $contactoModel = new ContactoEmpleadoModel();
        $data['contacto'] = $contactoModel->where('empleado_id', $id)->first();

        $movementModel = new EmployeeMovementModel();
        $data['movimientos'] = $movementModel->where('employee_id', $id)->findAll();

        $descuentoModel = new DescuentoModel();
        $descuentoDisponibleModel = new DescuentoDisponibleModel();

        $empleadoDescuentoModel = new EmpleadoDescuentoModel();

        $data['descuentos'] = $empleadoDescuentoModel
        ->select('empleado_descuentos.*, descuentos.nombre, descuentos.monto, descuentos.tipo_monto')
        ->join('descuentos', 'empleado_descuentos.descuento_id = descuentos.id')
        ->where('empleado_id', $id)
        ->findAll();

        $data['descuentos_disponibles'] = $descuentoModel->findAll();

        return view('empleados/editar', $data);
    }

    public function actualizarDatos($id)
    {
        $empleadoModel = new EmpleadoModel();
        $data = [
            'primer_nombre' => $this->request->getPost('primer_nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'cedula' => $this->request->getPost('cedula'),
            'genero' => $this->request->getPost('genero'),
            'fecha_nacimiento' => $this->request->getPost('fecha_nacimiento'),
            'estado' => $this->request->getPost('estado'),
            'sueldo' => $this->request->getPost('sueldo'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $empleadoModel->update($id, $data);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function actualizarDireccion($id)
    {
        $direccionModel = new DireccionEmpleadoModel();
        $data = [
            'direccion' => $this->request->getPost('direccion'),
            'ciudad' => $this->request->getPost('ciudad'),
            'pais' => $this->request->getPost('pais')
        ];

        $direccionModel->where('empleado_id', $id)->set($data)->update();
        return $this->response->setJSON(['status' => 'success']);
    }

    public function actualizarContacto($id)
    {
        $contactoModel = new ContactoEmpleadoModel();
        $data = [
            'numero_celular' => $this->request->getPost('numero_celular'),
            'correo_personal' => $this->request->getPost('correo_personal'),
            'correo_compania' => $this->request->getPost('correo_compania')
        ];
        $contactoModel->where('empleado_id', $id)->set($data)->update();
        return $this->response->setJSON(['status' => 'success']);
    }

    // // Nueva función para guardar descuentos
    // public function guardarDescuento($id)
    // {
    //     $descuentoModel = new DescuentoModel();

    //     // Eliminar todos los descuentos actuales del empleado
    //     $descuentoModel->where('empleado_id', $id)->delete();

    //     // Guardar los nuevos descuentos seleccionados
    //     $descuentosSeleccionados = $this->request->getPost('descuentos');
    //     if ($descuentosSeleccionados) {
    //         foreach ($descuentosSeleccionados as $descuentoId) {
    //             $data = [
    //                 'empleado_id' => $id,
    //                 'descuento_disponible_id' => $descuentoId
    //             ];
    //             $descuentoModel->save($data);
    //         }
    //     }

    //     return $this->response->setJSON(['status' => 'success']);
    // }


    //prestamos
    // Funciones para la gestión de préstamos
    public function prestamos($id)
    {
        $prestamoModel = new PrestamoModel();
        $data['prestamos'] = $prestamoModel->where('empleado_id', $id)->findAll();
        $data['empleado_id'] = $id;
        return view('empleados/prestamos', $data);
    }

    public function guardarPrestamo($id)
    {
        $prestamoModel = new PrestamoModel();
    
        // Calcular monto a descontar en cada período
        $monto = $this->request->getPost('monto');
        $fecha_inicio = $this->request->getPost('fecha_inicio');
        $fecha_fin = $this->request->getPost('fecha_fin');
        $frecuencia = $this->request->getPost('frecuencia');
    
        $start_date = new DateTime($fecha_inicio);
        $end_date = new DateTime($fecha_fin);
        $interval = $start_date->diff($end_date);
        $periodos = $frecuencia == 'quincenal' ? floor($interval->days / 15) : floor($interval->days / 30);
    
        $monto_periodo = $monto / $periodos;
    
        $data = [
            'empleado_id' => $id,
            'monto' => $monto,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'frecuencia' => $frecuencia,
            'monto_periodo' => $monto_periodo,
            'monto_pagado' => 0
        ];
    
        $prestamoModel->save($data);
    
        return $this->response->setJSON(['status' => 'success']);
    }


    //fin prestamos

    


    //Incentivos 

    public function incentivos()
    {
        $incentivoModel = new IncentivoModel();
        $empleadoIncentivoModel = new EmpleadoIncentivoModel();
        $empleadoModel = new EmpleadoModel();
        $periodoNominaModel = new PeriodoNominaModel();
    
        $data['incentivos'] = $empleadoIncentivoModel
            ->select('empleado_incentivos.*, incentivos.nombre, incentivos.tipo_incentivo, empleados.primer_nombre, empleados.apellido, p1.nombre as periodo_inicio_nombre, p2.nombre as periodo_fin_nombre')
            ->join('incentivos', 'empleado_incentivos.incentivo_id = incentivos.id')
            ->join('empleados', 'empleado_incentivos.empleado_id = empleados.id')
            ->join('periodos_nomina p1', 'empleado_incentivos.periodo_inicio = p1.id', 'left')
            ->join('periodos_nomina p2', 'empleado_incentivos.periodo_fin = p2.id', 'left')
            ->findAll();
    
        $data['incentivos_disponibles'] = $incentivoModel->findAll();
        $data['empleados'] = $empleadoModel->select('id, primer_nombre, apellido')->findAll();
        $data['periodos'] = $periodoNominaModel->findAll();
    
        return view('empleados/incentivos', $data);
    }
    
    
    
    public function guardarIncentivo()
    {
        $empleadoIncentivoModel = new EmpleadoIncentivoModel();
    
        $incentivo = $this->request->getPost('incentivo');
        $empleado_id = $this->request->getPost('empleado_id');
        $monto = $this->request->getPost('monto');
        $cantidad = $this->request->getPost('cantidad');  // Nuevo campo
        $frecuencia = $this->request->getPost('frecuencia') ?: null;
        $periodo_inicio = $this->request->getPost('periodo_inicio') ?: null;
        $periodo_fin = $this->request->getPost('periodo_fin') ?: null;
        $comentario = $this->request->getPost('comentario');
        $fecha = $this->request->getPost('fecha');
    
        // Obtener el tipo de incentivo
        $incentivoModel = new IncentivoModel();
        $incentivoData = $incentivoModel->find($incentivo);
    
        // Calcular el monto si es un incentivo especial (extra_35, extra_100, extra_15, extra_no_labor_100)
        if (in_array($incentivoData['tipo_incentivo'], ['extra_35', 'extra_100', 'extra_15', 'extra_no_labor_100'])) {
            $empleadoModel = new EmpleadoModel();
            $empleadoData = $empleadoModel->find($empleado_id);
            $sueldoMensual = $empleadoData['sueldo'];
    
            $sueldoDiario = $sueldoMensual / 23.83;
            $sueldoHora = $sueldoDiario / 8;
    
            switch ($incentivoData['tipo_incentivo']) {
                case 'extra_35':
                    $monto = $sueldoHora * 1.35 * $cantidad;
                    break;
                case 'extra_100':
                    $monto = $sueldoHora * 2 * $cantidad;
                    break;
                case 'extra_15':
                    $monto = $sueldoHora * 1.15 * $cantidad;
                    break;
                case 'extra_no_labor_100':
                    $monto = $sueldoHora * 2 * $cantidad; // Asumimos que se paga al 100%
                    break;
            }
        }
    
        $data = [
            'empleado_id' => $empleado_id,
            'incentivo_id' => $incentivo,
            'monto' => $monto,
            'cantidad' => $cantidad,  // Nuevo campo
            'fecha' => $fecha,
            'frecuencia' => $frecuencia,
            'periodo_inicio' => $periodo_inicio,
            'periodo_fin' => $periodo_fin,
            'comentario' => $comentario
        ];
    
        if ($empleadoIncentivoModel->save($data)) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Error al guardar el incentivo']);
        }
    }
    
    
    public function eliminarIncentivo($id)
    {
        $empleadoIncentivoModel = new EmpleadoIncentivoModel();
    
        if ($empleadoIncentivoModel->delete($id)) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Error al eliminar el incentivo']);
        }
    }
    
    //fin incentivos





        


        //Descuentos
        public function descuentos()
        {
            $descuentoModel = new DescuentoModel();
            $empleadoDescuentoModel = new EmpleadoDescuentoModel();
            $empleadoModel = new EmpleadoModel();
            $periodoNominaModel = new PeriodoNominaModel();
        
            $data['descuentos'] = $empleadoDescuentoModel
                ->select('empleado_descuentos.*, descuentos.nombre, descuentos.monto AS descuento_base_monto, descuentos.tipo_monto, empleados.primer_nombre, empleados.apellido, p1.nombre AS periodo_inicio_nombre, p2.nombre AS periodo_fin_nombre')
                ->join('descuentos', 'empleado_descuentos.descuento_id = descuentos.id')
                ->join('empleados', 'empleado_descuentos.empleado_id = empleados.id')
                ->join('periodos_nomina p1', 'empleado_descuentos.periodo_inicio = p1.id', 'left')
                ->join('periodos_nomina p2', 'empleado_descuentos.periodo_fin = p2.id', 'left')
                ->findAll();
        
            $data['descuentos_disponibles'] = $descuentoModel->findAll();
            $data['empleados'] = $empleadoModel->select('id, primer_nombre, apellido')->findAll();
            $data['periodos'] = $periodoNominaModel->findAll();
        
            return view('empleados/descuentos', $data);
        }
        

        public function guardarDescuento()
        {
            $empleadoDescuentoModel = new EmpleadoDescuentoModel();
        
            $data = [
                'empleado_id' => $this->request->getPost('empleado_id'),
                'descuento_id' => $this->request->getPost('descuento'),
                'monto' => $this->request->getPost('monto'),
                'fecha' => $this->request->getPost('fecha'),
                'frecuencia' => $this->request->getPost('frecuencia') ?: null,
                'periodo_inicio' => $this->request->getPost('periodo_inicio') ?: null,
                'periodo_fin' => $this->request->getPost('periodo_fin') ?: null,
                'comentario' => $this->request->getPost('comentario')
            ];
        
            // Forzar periodo_fin = periodo_inicio para no recurrentes
            if (empty($data['frecuencia'])) {
                $data['periodo_fin'] = $data['periodo_inicio'];
            }
        
            if ($empleadoDescuentoModel->save($data)) {
                return $this->response->setJSON(['status' => 'success']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Error al guardar el descuento']);
            }
        }

        public function eliminarDescuento($id)
        {
            $empleadoDescuentoModel = new EmpleadoDescuentoModel();

            if ($empleadoDescuentoModel->delete($id)) {
                return $this->response->setJSON(['status' => 'success']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Error al eliminar el descuento']);
            }
        }

                            
    
    
}
