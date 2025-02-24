<?php

namespace App\Controllers;

use App\Models\SuplidorModel;
use App\Models\ContactoModel;
use App\Models\DireccionModel;
use App\Models\BancoModel;

class SuplidoresController extends BaseController
{
    public function index()
    {
        $suplidorModel = new SuplidorModel();
        $suplidores = $suplidorModel->findAll();
        
        return view('suplidores/index', ['suplidores' => $suplidores]);
    }

    public function agregar()
    {
        return view('suplidores/agregar');
    }

    public function guardar()
    {
        $suplidorModel = new SuplidorModel();

        // Generar un código de suplidor único
        $codigoSuplidor = $this->generarCodigoSuplidor();

        $data = [
            'codigo_suplidor' => $codigoSuplidor,
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
        
        $suplidorModel->save($data);
        
        return redirect()->to('/suplidores/editar/' . $suplidorModel->insertID());
    }

    private function generarCodigoSuplidor()
    {
        $suplidorModel = new SuplidorModel();
        $ultimoSuplidor = $suplidorModel->orderBy('id', 'DESC')->first();
        $nuevoId = $ultimoSuplidor ? $ultimoSuplidor['id'] + 1 : 1;
        return 'SUP-' . str_pad($nuevoId, 6, '0', STR_PAD_LEFT);
    }

    public function editar($id)
    {
        $suplidorModel = new SuplidorModel();
        $suplidor = $suplidorModel->find($id);
        
        return view('suplidores/editar', ['suplidor' => $suplidor]);
    }

    public function actualizar($id)
    {
        $suplidorModel = new SuplidorModel();
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
        
        $suplidorModel->update($id, $data);
        
        return redirect()->to('/suplidores/editar/' . $id)->with('success', 'Suplidor actualizado exitosamente.');
    }

    public function eliminar($id)
    {
        $suplidorModel = new SuplidorModel();
        $suplidorModel->delete($id);
        
        return redirect()->to('/suplidores')->with('success', 'Suplidor eliminado exitosamente.');
    }

    public function detalles($id)
    {
        $suplidorModel = new SuplidorModel();
        $suplidor = $suplidorModel->find($id);
        
        return view('suplidores/detalles', ['suplidor' => $suplidor]);
    }

    // Métodos para gestionar contactos
    public function guardarContacto()
    {
        $contactoModel = new ContactoModel();
        $data = [
            'entidad_id' => $this->request->getPost('suplidor_id'),
            'nombre' => $this->request->getPost('nombre_contacto'),
            'email' => $this->request->getPost('email_contacto'),
            'telefono' => $this->request->getPost('telefono_contacto'),
            'cargo' => $this->request->getPost('cargo_contacto'),
            'tipo_entidad' => 'suplidor'
        ];
        $contactoModel->save($data);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function obtenerContactos($suplidor_id)
    {
        $contactoModel = new ContactoModel();
        $contactos = $contactoModel->where('entidad_id', $suplidor_id)->where('tipo_entidad', 'suplidor')->findAll();
        return view('suplidores/partes/contactos', ['contactos' => $contactos]);
    }

    // Métodos para gestionar direcciones de entrega
    public function guardarDireccion()
    {
        $direccionModel = new DireccionModel();
        $data = [
            'entidad_id' => $this->request->getPost('suplidor_id'),
            'nombre' => $this->request->getPost('nombre_direccion'),
            'direccion' => $this->request->getPost('direccion'),
            'ciudad' => $this->request->getPost('ciudad_direccion'),
            'codigo_postal' => $this->request->getPost('codigo_postal_direccion'),
            'pais' => $this->request->getPost('pais_direccion'),
            'telefono' => $this->request->getPost('telefono_direccion'),
            'tipo_entidad' => 'suplidor'
        ];
        $direccionModel->save($data);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function obtenerDirecciones($suplidor_id)
    {
        $direccionModel = new DireccionModel();
        $direcciones = $direccionModel->where('entidad_id', $suplidor_id)->where('tipo_entidad', 'suplidor')->findAll();
        return view('suplidores/partes/direcciones', ['direcciones' => $direcciones]);
    }

    // Métodos para gestionar información bancaria
    public function guardarBanco()
    {
        $bancoModel = new BancoModel();
        $data = [
            'entidad_id' => $this->request->getPost('suplidor_id'),
            'banco' => $this->request->getPost('banco'),
            'numero_cuenta' => $this->request->getPost('numero_cuenta'),
            'tipo_cuenta' => $this->request->getPost('tipo_cuenta'),
            'swift_bic' => $this->request->getPost('swift_bic'),
            'tipo_entidad' => 'suplidor'
        ];
        $bancoModel->save($data);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function obtenerBancos($suplidor_id)
    {
        $bancoModel = new BancoModel();
        $bancos = $bancoModel->where('entidad_id', $suplidor_id)->where('tipo_entidad', 'suplidor')->findAll();
        return view('suplidores/partes/bancos', ['bancos' => $bancos]);
    }
    
    // Métodos para eliminar contacto
    public function eliminarContacto()
    {
        $contactoModel = new ContactoModel();
        $id = $this->request->getPost('id');
        $contactoModel->delete($id);
        return $this->response->setJSON(['status' => 'success']);
    }
    
    // Métodos para eliminar dirección
    public function eliminarDireccion()
    {
        $direccionModel = new DireccionModel();
        $id = $this->request->getPost('id');
        $direccionModel->delete($id);
        return $this->response->setJSON(['status' => 'success']);
    }
    
    // Métodos para eliminar banco
    public function eliminarBanco()
    {
        $bancoModel = new BancoModel();
        $id = $this->request->getPost('id');
        $bancoModel->delete($id);
        return $this->response->setJSON(['status' => 'success']);
    }
}    