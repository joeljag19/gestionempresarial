<?php

namespace App\Controllers;

use App\Models\ProductoTerminadoModel;
use App\Models\CategoriaProductoTerminadoModel;
use App\Models\EstacionTrabajoModel;
use App\Models\TareaModel;

class TiemposProduccionController extends BaseController
{
    public function index()
    {
        $productoTerminadoModel = new ProductoTerminadoModel();
        $categoriaModel = new CategoriaProductoTerminadoModel();
        $tareaModel = new TareaModel();

        $productos = $productoTerminadoModel->findAll();

        $data['productos'] = [];

        foreach ($productos as $producto) {
            $categoria = $categoriaModel->find($producto['categoria_id']);
            $tiempoTotalMinutos = $tareaModel->selectSum('tiempo_estimado')
                                              ->where('producto_terminado_id', $producto['id'])
                                              ->first()['tiempo_estimado'];

            // Calcular horas y minutos
            $horas = intdiv($tiempoTotalMinutos, 60);
            $minutos = $tiempoTotalMinutos % 60;
            $tiempoTotal = ($horas > 0) ? "{$horas}h {$minutos}m" : "{$minutos}m";

            $data['productos'][] = [
                'id' => $producto['id'],
                'codigo_barras' => $producto['codigo_de_barra'],
                'nombre' => $producto['nombre'],
                'categoria' => $categoria['nombre'],
                'tiempo_total' => $tiempoTotal
            ];
        }

        return view('tiempos_produccion/index', $data);
    }

    public function detalle($productoId)
    {
        $productoTerminadoModel = new ProductoTerminadoModel();
        $estacionTrabajoModel = new EstacionTrabajoModel();
        $tareaModel = new TareaModel();

        $producto = $productoTerminadoModel->find($productoId);
        $estaciones = $estacionTrabajoModel->findAll();

        $data['producto'] = $producto;
        $data['estaciones'] = [];

        foreach ($estaciones as $estacion) {
            $tareas = $tareaModel->where('estacion_trabajo_id', $estacion['id'])
                                 ->where('producto_terminado_id', $productoId)
                                 ->findAll();

            if (count($tareas) > 0) {
                $data['estaciones'][] = [
                    'nombre' => $estacion['nombre'],
                    'tareas' => $tareas
                ];
            }
        }

        return view('tiempos_produccion/detalle', $data);
    }

    public function actualizar($tareaId)
    {
        $tareaModel = new TareaModel();
    
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'tiempo_estimado' => $this->request->getPost('tiempo_estimado')
        ];
    
        if ($tareaModel->update($tareaId, $data)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Tarea actualizada exitosamente.']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Ocurrió un error al actualizar la tarea.']);
        }
    }
    
    
}
