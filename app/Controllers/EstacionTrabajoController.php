<?php

namespace App\Controllers;

use App\Models\EstacionTrabajoModel;

class EstacionTrabajoController extends BaseController
{
    public function index()
    {
        $model = new EstacionTrabajoModel();
        $data['estaciones'] = $model->findAll();
        
        return view('estacion_trabajo/index', $data);
    }

    public function crear()
    {
        return view('estacion_trabajo/crear');
    }

    public function guardar()
    {
        $model = new EstacionTrabajoModel();

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
        ];

        $model->save($data);

        return redirect()->to('/estacion_trabajo');
    }

    public function editar($id)
    {
        $model = new EstacionTrabajoModel();
        $data['estacion'] = $model->find($id);

        return view('estacion_trabajo/editar', $data);
    }

    public function actualizar($id)
    {
        $model = new EstacionTrabajoModel();

        $data = [
            'id' => $id,
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
        ];

        $model->save($data);

        return redirect()->to('/estacion_trabajo');
    }
}
