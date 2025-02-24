<?php

namespace App\Controllers;

use App\Models\SalarioModel;
use App\Models\EmpleadoModel;
use CodeIgniter\HTTP\ResponseInterface;

class SalariosController extends BaseController
{
    public function index()
    {
        return view('salarios/index');
    }

    public function listar()
    {
        $model = new SalarioModel();
        $empleadoModel = new EmpleadoModel();
        $salarios = $model->findAll();
        foreach ($salarios as &$salario) {
            $empleado = $empleadoModel->find($salario['empleado_id']);
            $salario['empleado_nombre'] = $empleado['primer_nombre'] . ' ' . $empleado['apellido'];
        }
        return $this->response->setJSON(['salarios' => $salarios]);
    }

    public function listarEmpleados()
    {
        $model = new EmpleadoModel();
        $data['empleados'] = $model->like('primer_nombre', $this->request->getGet('query'))->findAll();
        return $this->response->setJSON($data);
    }

    public function guardar()
    {
        $model = new SalarioModel();
        $data = [
            'empleado_id' => $this->request->getPost('empleado_id'),
            'tipo_salario' => $this->request->getPost('tipo_salario'),
            'monto' => $this->request->getPost('monto'),
        ];
        $model->save($data);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function eliminar($id)
    {
        $model = new SalarioModel();
        $model->delete($id);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function actualizar($id)
    {
        $model = new SalarioModel();
        $data = [
            'empleado_id' => $id,
            'tipo_salario' => $this->request->getGet('tipo_salario'),
            'monto' => $this->request->getGet('monto'),
        ];
        $model->update($id, $data);
        return $this->response->setJSON(['status' => 'success']);
    }
}
