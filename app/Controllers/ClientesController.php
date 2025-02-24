<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\ProductoTerminadoModel;
use App\Models\ContactoModel;
use App\Models\DireccionModel;
use App\Models\BancoModel;
use App\Models\PrecioPersonalizadoModel;

class ClientesController extends BaseController
{
    public function index()
    {
        $clienteModel = new ClienteModel();
        $clientes = $clienteModel->findAll();
        
        return view('clientes/index', ['clientes' => $clientes]);
    }

    public function agregar()
    {
        return view('clientes/agregar');
    }

    public function guardar()
    {
        $clienteModel = new ClienteModel();

        // Generar un código de cliente único
        $codigoCliente = $this->generarCodigoCliente();

        $data = [
            'codigo_cliente' => $codigoCliente,
            'tipo' => $this->request->getPost('tipo'),
            'nombre' => $this->request->getPost('nombre'),
            'email' => $this->request->getPost('email'),
            'telefono' => $this->request->getPost('telefono'),
            'direccion' => $this->request->getPost('direccion'),
            'ciudad' => $this->request->getPost('ciudad'),
            'codigo_postal' => $this->request->getPost('codigo_postal'),
            'pais' => $this->request->getPost('pais'),
            'rnc_cedula' => $this->request->getPost('rnc_cedula'),
            'estado' => 1 // Activo por defecto
        ];
        
        $clienteModel->save($data);
        
        return redirect()->to('/clientes/editar/' . $clienteModel->insertID());
    }

    private function generarCodigoCliente()
    {
        $clienteModel = new ClienteModel();
        $ultimoCliente = $clienteModel->orderBy('id', 'DESC')->first();
        $nuevoId = $ultimoCliente ? $ultimoCliente['id'] + 1 : 1;
        return 'CLI-' . str_pad($nuevoId, 6, '0', STR_PAD_LEFT);
    }

    public function editar($id)
    {
        $clienteModel = new ClienteModel();
        $productoModel = new ProductoTerminadoModel();

        $cliente = $clienteModel->find($id);
        $productos = $productoModel->findAll();

        return view('clientes/editar', [
            'cliente' => $cliente,
            'productos' => $productos
        ]);
    }

    public function actualizar($id)
    {
        $clienteModel = new ClienteModel();
        $data = [
            'id' => $id,
            'tipo' => $this->request->getPost('tipo'),
            'nombre' => $this->request->getPost('nombre'),
            'email' => $this->request->getPost('email'),
            'telefono' => $this->request->getPost('telefono'),
            'direccion' => $this->request->getPost('direccion'),
            'ciudad' => $this->request->getPost('ciudad'),
            'codigo_postal' => $this->request->getPost('codigo_postal'),
            'pais' => $this->request->getPost('pais'),
            'rnc_cedula' => $this->request->getPost('rnc_cedula'),
            'estado' => $this->request->getPost('estado')
        ];
        
        $clienteModel->update($id, $data);
        
        return redirect()->to('/clientes/editar/' . $id)->with('success', 'Cliente actualizado exitosamente.');
    }

    public function eliminar($id)
    {
        $clienteModel = new ClienteModel();
        $clienteModel->delete($id);
        
        return redirect()->to('/clientes')->with('success', 'Cliente eliminado exitosamente.');
    }

    public function detalles($id)
    {
        $clienteModel = new ClienteModel();
        $cliente = $clienteModel->find($id);
        
        return view('clientes/detalles', ['cliente' => $cliente]);
    }

    // Métodos para gestionar contactos
    public function guardarContacto()
    {
        $contactoModel = new ContactoModel();
        $data = [
            'entidad_id' => $this->request->getPost('cliente_id'),
            'nombre' => $this->request->getPost('nombre_contacto'),
            'email' => $this->request->getPost('email_contacto'),
            'telefono' => $this->request->getPost('telefono_contacto'),
            'cargo' => $this->request->getPost('cargo_contacto'),
            'tipo_entidad' => 'cliente'
        ];
        $contactoModel->save($data);
        return $this->response->setJSON(['status' => 'success']);
    }
    

    public function obtenerContactos($cliente_id)
    {
        $contactoModel = new ContactoModel();
        $contactos = $contactoModel->where('entidad_id', $cliente_id)->where('tipo_entidad', 'cliente')->findAll();
        return view('clientes/partes/contactos', ['contactos' => $contactos]);
    }

    // Métodos para gestionar direcciones de entrega
    public function guardarDireccion()
    {
        $direccionModel = new DireccionModel();
        $data = [
            'entidad_id' => $this->request->getPost('cliente_id'),
            'nombre' => $this->request->getPost('nombre_direccion'),
            'direccion' => $this->request->getPost('direccion'),
            'ciudad' => $this->request->getPost('ciudad_direccion'),
            'codigo_postal' => $this->request->getPost('codigo_postal_direccion'),
            'pais' => $this->request->getPost('pais_direccion'),
            'telefono' => $this->request->getPost('telefono_direccion'),
            'tipo_entidad' => 'cliente'
        ];
        $direccionModel->save($data);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function obtenerDirecciones($cliente_id)
    {
        $direccionModel = new DireccionModel();
        $direcciones = $direccionModel->where('entidad_id', $cliente_id)->where('tipo_entidad', 'cliente')->findAll();
        return view('clientes/partes/direcciones', ['direcciones' => $direcciones]);
    }

    // Métodos para gestionar información bancaria
    public function guardarBanco()
    {
        $bancoModel = new BancoModel();
        $data = [
            'entidad_id' => $this->request->getPost('cliente_id'),
            'banco' => $this->request->getPost('banco'),
            'numero_cuenta' => $this->request->getPost('numero_cuenta'),
            'tipo_cuenta' => $this->request->getPost('tipo_cuenta'),
            'swift_bic' => $this->request->getPost('swift_bic'),
            'tipo_entidad' => 'cliente'
        ];
        $bancoModel->save($data);
        return $this->response->setJSON(['status' => 'success']);
    }
    
    public function obtenerBancos($cliente_id)
    {
        $bancoModel = new BancoModel();
        $bancos = $bancoModel->where('entidad_id', $cliente_id)->where('tipo_entidad', 'cliente')->findAll();
        return view('clientes/partes/bancos', ['bancos' => $bancos]);
    }

    // Métodos para gestionar precios personalizados
    public function guardarPrecio()
    {
        $precioModel = new PrecioPersonalizadoModel();
        $data = [
            'cliente_id' => $this->request->getPost('cliente_id'),
            'producto_id' => $this->request->getPost('producto_id'),
            'precio_personalizado' => $this->request->getPost('precio_personalizado')
        ];
        $precioModel->save($data);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function obtenerPrecios($cliente_id)
    {
        $precioModel = new PrecioPersonalizadoModel();
        $precios = $precioModel->where('cliente_id', $cliente_id)->findAll();
        return view('clientes/partes/precios', ['precios' => $precios]);
    }
       // Métodos para eliminar contactos
       public function eliminarContacto($id)
       {
           $contactoModel = new ContactoModel();
           $contactoModel->delete($id);
           return $this->response->setJSON(['status' => 'success']);
       }
   
       // Métodos para eliminar direcciones
       public function eliminarDireccion($id)
       {
           $direccionModel = new DireccionModel();
           $direccionModel->delete($id);
           return $this->response->setJSON(['status' => 'success']);
       }
   
       // Métodos para eliminar información bancaria
       public function eliminarBanco($id)
       {
           $bancoModel = new BancoModel();
           $bancoModel->delete($id);
           return $this->response->setJSON(['status' => 'success']);
       }
   
       // Métodos para eliminar precios personalizados
       public function eliminarPrecio($id)
       {
           $precioModel = new PrecioPersonalizadoModel();
           $precioModel->delete($id);
           return $this->response->setJSON(['status' => 'success']);
       }
}
