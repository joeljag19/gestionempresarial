<?php

namespace App\Controllers;

use App\Models\ProductoTerminadoModel;
use App\Models\EstacionTrabajoModel;
use App\Models\ProductoEstacionModel;

class ProductoEstacionController extends BaseController
{
    public function index()
    {
        $productoTerminadoModel = new ProductoTerminadoModel();
        $productos = $productoTerminadoModel->findAll();
        $data['productos'] = $productos;

        return view('producto_estacion/index', $data);
    }

    public function asignar($productoId)
    {
        $productoTerminadoModel = new ProductoTerminadoModel();
        $estacionTrabajoModel = new EstacionTrabajoModel();
        $productoEstacionModel = new ProductoEstacionModel();

        $producto = $productoTerminadoModel->find($productoId);
        $estaciones = $estacionTrabajoModel->findAll();
        $asignaciones = $productoEstacionModel->where('producto_terminado_id', $productoId)->findAll();

        $data['producto'] = $producto;
        $data['estaciones'] = $estaciones;
        $data['asignaciones'] = $asignaciones;

        return view('producto_estacion/asignar', $data);
    }

    public function guardarAsignacion()
    {
        $productoEstacionModel = new ProductoEstacionModel();

        $productoTerminadoId = $this->request->getPost('producto_terminado_id');
        $estacionTrabajoId = $this->request->getPost('estacion_trabajo_id');

        // Verificar si ya existe una asignación para este producto y estación
        $exists = $productoEstacionModel->where('producto_terminado_id', $productoTerminadoId)
                                        ->where('estacion_trabajo_id', $estacionTrabajoId)
                                        ->first();

        if ($exists) {
            return redirect()->back()->with('error', 'Esta estación ya está asignada a este producto terminado.');
        }

        $data = [
            'producto_terminado_id' => $productoTerminadoId,
            'estacion_trabajo_id' => $estacionTrabajoId
        ];

        $productoEstacionModel->save($data);

        return redirect()->to('/producto_estacion');
    }

    public function verEstaciones($productoId)
    {
        $productoEstacionModel = new ProductoEstacionModel();
        $estacionTrabajoModel = new EstacionTrabajoModel();

        $asignaciones = $productoEstacionModel->where('producto_terminado_id', $productoId)->findAll();
        $estaciones = $estacionTrabajoModel->findAll();

        $output = '<table class="table table-bordered"><thead><tr><th>ID</th><th>Estación de Trabajo</th></tr></thead><tbody>';

        foreach ($asignaciones as $asignacion) {
            $estacion = array_filter($estaciones, function($e) use ($asignacion) {
                return $e['id'] == $asignacion['estacion_trabajo_id'];
            });

            if (!empty($estacion)) {
                // Reindexar el array para acceder correctamente al primer elemento
                $estacion = array_values($estacion)[0];
                $output .= '<tr>';
                $output .= '<td>' . $asignacion['id'] . '</td>';
                $output .= '<td>' . $estacion['nombre'] . '</td>';
                $output .= '</tr>';
            }
        }

        $output .= '</tbody></table>';

        return $output;
    }
}
