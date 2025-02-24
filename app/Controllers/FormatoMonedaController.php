<?php

namespace App\Controllers;

use App\Models\FormatoMonedaModel;

class FormatoMonedaController extends BaseController
{
    public function index()
    {
        $formatoMonedaModel = new FormatoMonedaModel();
        $formatos = $formatoMonedaModel->findAll();

        return view('formatos_moneda/index', ['formatos' => $formatos]);
    }

    public function guardar()
    {
        $formatoMonedaModel = new FormatoMonedaModel();
        $data = [
            'formato' => $this->request->getPost('formato'),
            'descripcion' => $this->request->getPost('descripcion')
        ];

        if ($formatoMonedaModel->save($data)) {
            return redirect()->to('/formatos_moneda')->with('success', 'Formato de moneda guardado exitosamente.');
        } else {
            return redirect()->to('/formatos_moneda')->with('error', 'Ocurrió un error al guardar el formato de moneda.');
        }
    }
}
