<?php

namespace App\Controllers;

use App\Models\CategoriaProductoTerminadoModel;

class CategoriaProductoTerminadoController extends BaseController
{
    public function index()
    {
        $model = new CategoriaProductoTerminadoModel();
        $data['categorias'] = $model->findAll();
        
        return view('categoria_producto_terminado/index', $data);
    }

    public function crear()
    {
        return view('categoria_producto_terminado/crear');
    }

    public function guardar()
    {
        $model = new CategoriaProductoTerminadoModel();

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
        ];

        $model->save($data);

        return redirect()->to('/categoria_producto_terminado');
    }

    public function editar($id)
    {
        $model = new CategoriaProductoTerminadoModel();
        $data['categoria'] = $model->find($id);

        return view('categoria_producto_terminado/editar', $data);
    }

    public function actualizar($id)
    {
        $model = new CategoriaProductoTerminadoModel();

        $data = [
            'id' => $id,
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
        ];

        $model->save($data);

        return redirect()->to('/categoria_producto_terminado');
    }
}
