<?php

namespace App\Controllers;

use App\Models\TareaModel;
use App\Models\EstacionTrabajoModel;
use App\Models\ProductoTerminadoModel;

class TareaController extends BaseController
{
    public function index()
    {
        $tareaModel = new TareaModel();
        $estacionTrabajoModel = new EstacionTrabajoModel();
        $productoTerminadoModel = new ProductoTerminadoModel();

        $tareas = $tareaModel->findAll();
        $estaciones = $estacionTrabajoModel->findAll();
        $productos = $productoTerminadoModel->findAll();

        // Convertir las listas de estaciones y productos a arrays asociativos por ID
        $estacionesPorId = [];
        foreach ($estaciones as $estacion) {
            $estacionesPorId[$estacion['id']] = $estacion['nombre'];
        }

        $productosPorId = [];
        foreach ($productos as $producto) {
            $productosPorId[$producto['id']] = $producto['nombre'];
        }

        // Asignar los nombres a las tareas
        foreach ($tareas as &$tarea) {
            $tarea['nombre_estacion'] = $estacionesPorId[$tarea['estacion_trabajo_id']] ?? 'Sin estación';
            $tarea['nombre_producto'] = $productosPorId[$tarea['producto_terminado_id']] ?? 'Sin producto';
        }

        $data['tareas'] = $tareas;
        
        return view('tarea/index', $data);
    }

    public function crear()
    {
        $estacionTrabajoModel = new EstacionTrabajoModel();
        $productoTerminadoModel = new ProductoTerminadoModel();
        $data['estaciones'] = $estacionTrabajoModel->findAll();
        $data['productos'] = $productoTerminadoModel->findAll();

        return view('tarea/crear', $data);
    }

    public function guardar()
    {
        $model = new TareaModel();

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'tiempo_estimado' => $this->request->getPost('tiempo_estimado'),
            'estacion_trabajo_id' => $this->request->getPost('estacion_trabajo_id'),
            'producto_terminado_id' => $this->request->getPost('producto_terminado_id'),
        ];

        $model->save($data);

        return redirect()->to('/tarea');
    }

    public function editar($id)
    {
        $model = new TareaModel();
        $estacionTrabajoModel = new EstacionTrabajoModel();
        $productoTerminadoModel = new ProductoTerminadoModel();

        $data['tarea'] = $model->find($id);
        $data['estaciones'] = $estacionTrabajoModel->findAll();
        $data['productos'] = $productoTerminadoModel->findAll();

        return view('tarea/editar', $data);
    }

    public function actualizar($id)
    {
        $model = new TareaModel();

        $data = [
            'id' => $id,
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'tiempo_estimado' => $this->request->getPost('tiempo_estimado'),
            'estacion_trabajo_id' => $this->request->getPost('estacion_trabajo_id'),
            'producto_terminado_id' => $this->request->getPost('producto_terminado_id'),
        ];

        $model->save($data);

        return redirect()->to('/tarea');
    }
}
