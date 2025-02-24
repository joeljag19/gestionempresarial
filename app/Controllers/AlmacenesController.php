<?php

namespace App\Controllers;

use App\Models\AlmacenModel;
use CodeIgniter\Controller;

class AlmacenesController extends Controller
{
    public function index()
    {
        $model = new AlmacenModel();
        $data['almacenes'] = $model->findAll();

        return view('almacenes/index', $data);
    }

    public function crear()
    {
        return view('almacenes/crear');
    }

    public function guardar()
    {
        $model = new AlmacenModel();

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion_ubicacion' => $this->request->getPost('descripcion_ubicacion'),
        ];

        $model->save($data);

        return redirect()->to('/almacenes');
    }

    public function editar($id)
    {
        $model = new AlmacenModel();
        $data['almacen'] = $model->find($id);

        return view('almacenes/editar', $data);
    }

    public function actualizar($id)
    {
        $model = new AlmacenModel();

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion_ubicacion' => $this->request->getPost('descripcion_ubicacion'),
        ];

        $model->update($id, $data);

        return redirect()->to('/almacenes');
    }
}
