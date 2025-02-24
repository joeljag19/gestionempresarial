<?php

namespace App\Controllers;

use App\Models\ProductoTerminadoModel;

class InventarioController extends BaseController
{
    public function index()
    {
        $productoModel = new ProductoTerminadoModel();
        $productos = $productoModel->findAll();

        return view('inventario/index', ['productos' => $productos]);
    }

    public function actualizar()
    {
        $productoModel = new ProductoTerminadoModel();
        $productos = $productoModel->findAll();

        return view('inventario/actualizar', ['productos' => $productos]);
    }

    public function guardarActualizacion()
    {
        $productoModel = new ProductoTerminadoModel();

        $productoId = $this->request->getPost('producto');
        $cantidad = $this->request->getPost('cantidad');

        // Obtener el producto actual
        $producto = $productoModel->find($productoId);

        if ($producto) {
            // Actualizar la cantidad en el inventario
            $nuevaCantidad = $producto['cantidad'] + $cantidad;
            $productoModel->update($productoId, ['cantidad' => $nuevaCantidad]);

            return redirect()->to('/inventario')->with('success', 'Inventario actualizado correctamente.');
        } else {
            return redirect()->to('/inventario/actualizar')->with('error', 'Producto no encontrado.');
        }
    }
}
