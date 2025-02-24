<?php

namespace App\Controllers;

use App\Models\ProductoTerminadoModel;
use App\Models\EstacionTrabajoModel;
use App\Models\ProductoEstacionModel;
use App\Models\TareaModel;
use App\Models\MateriaPrimaModel; 
use App\Models\MateriaPrimaTareaModel;

class TareasProduccionController extends BaseController
{
    public function index()
    {
        $materiaPrimaModel = new MateriaPrimaModel();
        $materiasPrimas = $materiaPrimaModel->findAll();
        $data['materias_primas']=$materiasPrimas;

        $productoTerminadoModel = new ProductoTerminadoModel();
        $productos = $productoTerminadoModel->findAll();
        $data['productos'] = $productos;

        return view('tareas_produccion/index', $data);
    }

    public function cargarEstaciones($productoId)
    {
        $productoEstacionModel = new ProductoEstacionModel();
        $estacionTrabajoModel = new EstacionTrabajoModel();

        $asignaciones = $productoEstacionModel->where('producto_terminado_id', $productoId)->findAll();
        $estaciones = $estacionTrabajoModel->findAll();

        $output = '<table class="table table-bordered"><thead><tr><th>ID</th><th>Estación de Trabajo</th><th>Acciones</th></tr></thead><tbody>';

        foreach ($asignaciones as $asignacion) {
            $estacion = array_filter($estaciones, function($e) use ($asignacion) {
                return $e['id'] == $asignacion['estacion_trabajo_id'];
            });

            if (!empty($estacion)) {
                $estacion = array_values($estacion)[0];
                $output .= '<tr>';
                $output .= '<td>' . $estacion['id'] . '</td>';
                $output .= '<td>' . $estacion['nombre'] . '</td>';
                $output .= '<td>';
                $output .= '<a class="btn btn-primary btn-sm showtasks" type="button" id="showProductTasks"><i class="fas fa-eye"></i></a> ';
                $output .= '<a class="btn btn-success btn-sm addnewtask" type="button" id="addNewProductTask"><i class="fas fa-plus"></i></a>';
                $output .= '</td>';
                $output .= '</tr>';
            }
        }

        $output .= '</tbody></table>';

        return $output;
    }

    public function verTareas($estacionId, $productoId)
    {
        $tareaModel = new TareaModel();
        $estacionTrabajoModel = new EstacionTrabajoModel();
        $productoTerminadoModel = new ProductoTerminadoModel();
    
        $tareas = $tareaModel->where('estacion_trabajo_id', $estacionId)
                             ->where('producto_terminado_id', $productoId)
                             ->findAll();
        $estacion = $estacionTrabajoModel->find($estacionId);
        $producto = $productoTerminadoModel->find($productoId);
    
        $output = '<div>';
        $output .= '<h3>' . $producto['nombre'] . '</h3>';
        $output .= '<p><strong>Código de Barras: </strong>' . $producto['codigo_de_barra'] . '</p>';
        $output .= '<p><strong>Estación de Trabajo: </strong>' . $estacion['nombre'] . '</p>';
        $output .= '</div>';
    
        $output .= '<table class="table table-bordered"><thead><tr><th>ID</th><th>Nombre de la Tarea</th><th>Descripción</th><th>Tiempo Estimado</th><th>Acciones</th></tr></thead><tbody>';
    
        foreach ($tareas as $tarea) {
            $output .= '<tr>';
            $output .= '<td>' . $tarea['id'] . '</td>';
            $output .= '<td>' . $tarea['nombre'] . '</td>';
            $output .= '<td>' . $tarea['descripcion'] . '</td>';
            $output .= '<td>' . $tarea['tiempo_estimado'] . '</td>';
            $output .= '<td>';
            $output .= '<button class="btn btn-primary btn-sm addMaterials" type="button" data-tarea-id="' . $tarea['id'] . '"><i class="fas fa-plus"></i> Materias Primas</button>';
            $output .= '</td>';
            $output .= '</tr>';
        }
    
        $output .= '</tbody></table>';
    
        return $output;
    }
    

    public function nuevaTarea()
    {
        $tareaModel = new TareaModel();

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'tiempo_estimado' => $this->request->getPost('tiempo_estimado'),
            'producto_terminado_id' => $this->request->getPost('producto_terminado_id'),
            'estacion_trabajo_id' => $this->request->getPost('estacion_trabajo_id')
        ];

        $tareaModel->save($data);

        return $this->verTareas($data['estacion_trabajo_id'], $data['producto_terminado_id']);
    }


    public function getEstacionProducto($estacionId, $productoId)
    {
    $estacionTrabajoModel = new EstacionTrabajoModel();
    $productoTerminadoModel = new ProductoTerminadoModel();

    $estacion = $estacionTrabajoModel->find($estacionId);
    $producto = $productoTerminadoModel->find($productoId);

    return json_encode(['estacion' => $estacion, 'producto' => $producto]);
}


public function cargarMateriasPrimas($tareaId)
{
    $materiaPrimaModel = new MateriaPrimaModel();
    $materiaPrimaTareaModel = new MateriaPrimaTareaModel();
    $materiasPrimasTarea = $materiaPrimaTareaModel->where('tarea_id', $tareaId)->findAll();
    $materiasPrimas = $materiaPrimaModel->findAll();

    $output = '<div class="form-group">';
    // $output .= '<label for="materia_prima_id">Nombre de la Materia Prima</label>';
    // $output .= '<select class="form-control" id="materia_prima_id" name="materia_prima_id" required>';
    // foreach ($materiasPrimas as $materia) {
    //     $output .= '<option value="' . $materia['id'] . '">' . $materia['nombre'] . '</option>';
    // }
    // $output .= '</select>';
    $output .= '</div>';

    $output .= '<table class="table table-bordered"><thead><tr><th>ID</th><th>Nombre</th><th>Cantidad</th><th>Desperdicio</th><th>Acciones</th></tr></thead><tbody>';

    foreach ($materiasPrimasTarea as $materiaTarea) {
        $materia = $materiaPrimaModel->find($materiaTarea['materia_prima_id']);
        $output .= '<tr>';
        $output .= '<td>' . $materiaTarea['id'] . '</td>';
        $output .= '<td>' . $materia['nombre'] . '</td>';
        $output .= '<td>' . $materiaTarea['cantidad'] . '</td>';
        $output .= '<td>' . $materiaTarea['desperdicio'] . '</td>';
        $output .= '<td>';
        $output .= '<button class="btn btn-danger btn-sm deleteMaterial" data-id="' . $materiaTarea['id'] . '"><i class="fas fa-trash"></i></button>';
        $output .= '</td>';
        $output .= '</tr>';
    }

    $output .= '</tbody></table>';

    return $output;
}
public function agregarMateriaPrima()
{
    $materiaPrimaTareaModel = new MateriaPrimaTareaModel();

    $data = [
        'materia_prima_id' => $this->request->getPost('materia_prima_id'),
        'cantidad' => $this->request->getPost('cantidad'),
        'desperdicio' => $this->request->getPost('desperdicio'),
        'tarea_id' => $this->request->getPost('tarea_id')
    ];

    $materiaPrimaTareaModel->save($data);

    return $this->cargarMateriasPrimas($data['tarea_id']);
}

public function eliminarMateriaPrima($id)
{
    $materiaPrimaTareaModel = new MateriaPrimaTareaModel();
    $materiaPrimaTarea = $materiaPrimaTareaModel->find($id);
    $tareaId = $materiaPrimaTarea['tarea_id'];

    $materiaPrimaTareaModel->delete($id);

    return $this->cargarMateriasPrimas($tareaId);
}

}
