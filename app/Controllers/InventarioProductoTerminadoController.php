<?php

namespace App\Controllers;

use App\Models\InventarioProductoTerminadoModel;
use App\Models\ProductoTerminadoModel;
use App\Models\AlmacenModel; // Asegúrate de tener el modelo AlmacenModel

class InventarioProductoTerminadoController extends BaseController
{
    public function index()
    {
        $model = new InventarioProductoTerminadoModel();
        $productoModel = new ProductoTerminadoModel();
        $almacenModel = new AlmacenModel(); // Obtener los almacenes

        $inventario = $model->findAll();
        $productos = $productoModel->findAll();
        $almacenes = $almacenModel->findAll(); // Obtener todos los almacenes

        foreach ($inventario as &$item) {
            $producto = array_filter($productos, function($producto) use ($item) {
                return $producto['id'] == $item['producto_terminado_id'];
            })[0] ?? null;
            $item['nombre_producto'] = $producto['nombre'] ?? 'Sin nombre';

            // Obtener el nombre del almacén
            $almacen = array_filter($almacenes, function($almacen) use ($item) {
                return $almacen['id'] == $item['id_almacen'];
            })[0] ?? null;
            $item['nombre_almacen'] = $almacen['nombre'] ?? 'Sin almacén';
        }

        $data['inventario'] = $inventario;
        
        return view('inventario_producto_terminado/index', $data);
    }

    public function crear()
    {
        $productoModel = new ProductoTerminadoModel();
        $data['productos'] = $productoModel->findAll();

        return view('inventario_producto_terminado/crear', $data);
    }

    public function guardar()
    {
        $model = new InventarioProductoTerminadoModel();

        $data = [
            'producto_terminado_id' => $this->request->getPost('producto_terminado_id'),
            'cantidad' => $this->request->getPost('cantidad'),
            'id_almacen' => $this->request->getPost('id_almacen'),
        ];

        $model->save($data);

        return redirect()->to('/inventario_producto_terminado');
    }

    public function editar($id)
    {
        $model = new InventarioProductoTerminadoModel();
        $productoModel = new ProductoTerminadoModel();

        $data['inventario'] = $model->find($id);
        $data['productos'] = $productoModel->findAll();

        return view('inventario_producto_terminado/editar', $data);
    }

    public function actualizar($id)
    {
        $model = new InventarioProductoTerminadoModel();

        $data = [
            'id' => $id,
            'producto_terminado_id' => $this->request->getPost('producto_terminado_id'),
            'cantidad' => $this->request->getPost('cantidad'),
            'id_almacen' => $this->request->getPost('id_almacen'),
        ];

        $model->save($data);

        return redirect()->to('/inventario_producto_terminado');
    }
}
