<?php

namespace App\Controllers;

use App\Models\ProductoTerminadoModel;
use App\Models\CategoriaProductoTerminadoModel;
use App\Models\InventarioProductoTerminadoModel;
use App\Models\UnidadesMedidaModel; // Asegúrate de importar este modelo

class ProductoTerminadoController extends BaseController
{
    public function index()
    {
        $model = new ProductoTerminadoModel();
        $categoriaModel = new CategoriaProductoTerminadoModel();

        $productos = $model->findAll();
        $categorias = $categoriaModel->findAll();

        foreach ($productos as &$producto) {
            $categoria = array_filter($categorias, function($categoria) use ($producto) {
                return $categoria['id'] == $producto['categoria_id'];
            })[0] ?? null;
            $producto['nombre_categoria'] = $categoria['nombre'] ?? 'Sin categoría';
        }

        $data['productos'] = $productos;
        
        return view('producto_terminado/index', $data);
    }

    public function crear()
    {
        $categoriaModel = new CategoriaProductoTerminadoModel();
        $unidadesModel = new UnidadesMedidaModel(); // Obtener las unidades de medida
        $data['categorias'] = $categoriaModel->findAll();
        $data['unidades'] = $unidadesModel->findAll(); // Pasar las unidades de medida a la vista

        return view('producto_terminado/crear', $data);
    }

    public function guardar()
    {
        $model = new ProductoTerminadoModel();
        $inventarioModel = new InventarioProductoTerminadoModel();

        // Guardar el producto terminado
        $data = [
            'codigo_de_barra' => $this->request->getPost('codigo_de_barra'),
            'nombre' => $this->request->getPost('nombre'),
            'categoria_id' => $this->request->getPost('categoria_id'),
            'unidad_medida_id' => $this->request->getPost('unidad_medida_id'), // Guardar unidad_medida_id
            'impuesto' => $this->request->getPost('impuesto'),
            'costo_unidad' => $this->request->getPost('costo_unidad'),
        ];

        $model->save($data);

        // Obtener el ID del producto guardado
        $producto_id = $model->insertID();

        // Crear el inventario inicial con cantidad 0
        $inventarioData = [
            'producto_terminado_id' => $producto_id,
            'cantidad' => 0,
            'id_almacen' => 1, // Asumiendo que tienes un almacén por defecto
        ];

        $inventarioModel->save($inventarioData);

        return redirect()->to('/producto_terminado');
    }

    public function editar($id)
    {
        $model = new ProductoTerminadoModel();
        $categoriaModel = new CategoriaProductoTerminadoModel();
        $unidadesModel = new UnidadesMedidaModel(); // Obtener las unidades de medida

        $data['producto'] = $model->find($id);
        $data['categorias'] = $categoriaModel->findAll();
        $data['unidades'] = $unidadesModel->findAll(); // Pasar las unidades de medida a la vista

        return view('producto_terminado/editar', $data);
    }

    public function actualizar($id)
    {
        $model = new ProductoTerminadoModel();

        $data = [
            'id' => $id,
            'codigo_de_barra' => $this->request->getPost('codigo_de_barra'),
            'nombre' => $this->request->getPost('nombre'),
            'categoria_id' => $this->request->getPost('categoria_id'),
            'unidad_medida_id' => $this->request->getPost('unidad_medida_id'), // Actualizar unidad_medida_id
            'impuesto' => $this->request->getPost('impuesto'),
            'costo_unidad' => $this->request->getPost('costo_unidad'),
        ];

        $model->save($data);

        return redirect()->to('/producto_terminado');
    }

    public function detalle($id)
    {
        $productoModel = new ProductoTerminadoModel();
        $producto = $productoModel->find($id);

        if ($producto) {
            return $this->response->setJSON($producto);
        } else {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)->setJSON(['mensaje' => 'Producto no encontrado.']);
        }
    }

    public function buscar()
    {
        $productoModel = new ProductoTerminadoModel();
        $term = $this->request->getGet('term');
        $productos = $productoModel->like('nombre', $term)->findAll();
        
        return $this->response->setJSON($productos);
    }
}
