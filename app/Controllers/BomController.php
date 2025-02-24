<?php

namespace App\Controllers;

use App\Models\ProductoTerminadoModel;
use App\Models\EstacionTrabajoModel;
use App\Models\MateriaPrimaModel;
use App\Models\MateriaPrimaTareaModel;
use App\Models\TareaModel;

class BomController extends BaseController
{
    public function index()
    {
        $productoTerminadoModel = new ProductoTerminadoModel();
        $productos = $productoTerminadoModel->findAll();

        return view('bom/index', ['productos' => $productos]);
    }

    public function obtenerDetalles($productoId)
    {
        $tareaModel = new TareaModel();
        $materiaPrimaTareaModel = new MateriaPrimaTareaModel();
        $materiaPrimaModel = new MateriaPrimaModel();

        // Obtener las tareas asociadas al producto terminado
        $tareas = $tareaModel->where('producto_terminado_id', $productoId)->findAll();
        $detalles = [];

        foreach ($tareas as $tarea) {
            $materiasPrimaTarea = $materiaPrimaTareaModel->where('tarea_id', $tarea['id'])->findAll();

            $detallesTarea = [];
            $subtotal = 0;

            foreach ($materiasPrimaTarea as $materiaTarea) {
                $materiaPrima = $materiaPrimaModel->find($materiaTarea['materia_prima_id']);
                $cantidadDesperdicio = $materiaTarea['cantidad'] + ($materiaTarea['cantidad'] * ($materiaTarea['desperdicio'] / 100));
                $subtotalMaterial = $materiaPrima['costo_unitario'] * $cantidadDesperdicio;

                $subtotal += $subtotalMaterial;

                $detallesTarea[] = [
                    'nombre' => $materiaPrima['nombre'],
                    'codigo_de_barra' => $materiaPrima['codigo_de_barra'],
                    'cantidad' => $materiaTarea['cantidad'],
                    'desperdicio' => $materiaTarea['desperdicio'],
                    'cantidad_material' => $cantidadDesperdicio,
                    'costo_unitario' => $materiaPrima['costo_unitario'],
                    'subtotal' => $subtotalMaterial
                ];
            }

            $detalles[] = [
                'nombre_tarea' => $tarea['nombre'],
                'materiales' => $detallesTarea,
                'subtotal_tarea' => $subtotal
            ];
        }

        return $this->response->setJSON(['detalles' => $detalles]);
    }
}
