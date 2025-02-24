<?php
namespace App\Controllers;

use App\Models\DescuentoDisponibleModel;

class DescuentosController extends BaseController
{
    public function index()
    {
        $descuentoDisponibleModel = new DescuentoDisponibleModel();
        $data['descuentos_disponibles'] = $descuentoDisponibleModel->findAll();
        return view('descuentos/descuentos_disponibles', $data);
    }

    public function guardarDisponible()
    {
        $descuentoDisponibleModel = new DescuentoDisponibleModel();

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'monto' => $this->request->getPost('monto'),
            'tipo_monto' => $this->request->getPost('tipo_monto')
        ];

        $descuentoDisponibleModel->save($data);

        return $this->response->setJSON(['status' => 'success']);
    }
}
