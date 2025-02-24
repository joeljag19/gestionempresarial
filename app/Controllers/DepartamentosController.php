<?php

namespace App\Controllers;

use App\Models\DepartamentoModel;
use CodeIgniter\HTTP\ResponseInterface;

class DepartamentosController extends BaseController
{
    public function index()
    {
        return view('departamentos/index');
    }

    public function listar()
    {
        $model = new DepartamentoModel();
        $data['departamentos'] = $model->findAll();
        return $this->response->setJSON($data);
    }

    public function guardar()
    {
        $model = new DepartamentoModel();
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
        ];
        $model->save($data);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function eliminar($id)
    {
        $model = new DepartamentoModel();
        $model->delete($id);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function actualizar($id)
    {
        $model = new DepartamentoModel();
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
        ];
        $model->update($id, $data);
        return $this->response->setJSON(['status' => 'success']);
    }
}
