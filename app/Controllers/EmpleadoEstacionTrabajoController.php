<?php

namespace App\Controllers;

use App\Models\EmpleadoEstacionTrabajoModel;
use App\Models\EmpleadoModel;
use App\Models\EstacionTrabajoModel;

class EmpleadoEstacionTrabajoController extends BaseController
{
    public function index()
    {
        $model = new EmpleadoEstacionTrabajoModel();
        $empleadosModel = new EmpleadoModel();
        $estacionesModel = new EstacionTrabajoModel();

        $asignaciones = $model->findAll();
        $empleados = $empleadosModel->findAll();
        $estaciones = $estacionesModel->findAll();

        foreach ($asignaciones as &$asignacion) {
            $empleado = array_filter($empleados, function($empleado) use ($asignacion) {
                return $empleado['id'] == $asignacion['empleado_id'];
            })[0] ?? null;
            $asignacion['nombre_empleado'] = $empleado['nombre'] . ' ' . $empleado['apellido'];

            $estacion = array_filter($estaciones, function($estacion) use ($asignacion) {
                return $estacion['id'] == $asignacion['estacion_trabajo_id'];
            })[0] ?? null;
            $asignacion['nombre_estacion'] = $estacion['nombre'];
        }

        $data['asignaciones'] = $asignaciones;
        
        return view('empleado_estacion_trabajo/index', $data);
    }

    public function crear()
    {
        $empleadosModel = new EmpleadoModel();
        $estacionesModel = new EstacionTrabajoModel();
        $data['empleados'] = $empleadosModel->findAll();
        $data['estaciones'] = $estacionesModel->findAll();

        return view('empleado_estacion_trabajo/crear', $data);
    }

    public function guardar()
    {
        $model = new EmpleadoEstacionTrabajoModel();

        $data = [
            'empleado_id' => $this->request->getPost('empleado_id'),
            'estacion_trabajo_id' => $this->request->getPost('estacion_trabajo_id'),
        ];

        $model->save($data);

        return redirect()->to('/empleado_estacion_trabajo');
    }

    public function editar($id)
    {
        $model = new EmpleadoEstacionTrabajoModel();
        $empleadosModel = new EmpleadoModel();
        $estacionesModel = new EstacionTrabajoModel();

        $data['asignacion'] = $model->find($id);
        $data['empleados'] = $empleadosModel->findAll();
        $data['estaciones'] = $estacionesModel->findAll();

        return view('empleado_estacion_trabajo/editar', $data);
    }

    public function actualizar($id)
    {
        $model = new EmpleadoEstacionTrabajoModel();

        $data = [
            'id' => $id,
            'empleado_id' => $this->request->getPost('empleado_id'),
            'estacion_trabajo_id' => $this->request->getPost('estacion_trabajo_id'),
        ];

        $model->save($data);

        return redirect()->to('/empleado_estacion_trabajo');
    }
}
