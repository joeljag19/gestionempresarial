<?php

namespace App\Controllers;

use App\Models\PuestoModel;
use CodeIgniter\HTTP\ResponseInterface;

class PuestosController extends BaseController
{
    public function index()
    {
        return view('puestos/index');
    }

    public function listar()
    {
        $model = new PuestoModel();
        $data['puestos'] = $model->findAll();
        return $this->response->setJSON($data);
    }

    public function guardar()
    {
        $model = new PuestoModel();
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
        ];
        $model->save($data);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function eliminar($id)
    {
        $model = new PuestoModel();
        $model->delete($id);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function actualizar($id)
    {
        $model = new PuestoModel();
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
        ];
        $model->update($id, $data);
        return $this->response->setJSON(['status' => 'success']);
    }
}
