<?php

namespace App\Controllers;

use App\Models\FormatoFechaModel;

class FormatoFechaController extends BaseController
{
    public function index()
    {
        $formatoFechaModel = new FormatoFechaModel();
        $formatos = $formatoFechaModel->findAll();

        return view('formatos_fecha/index', ['formatos' => $formatos]);
    }

    public function guardar()
    {
        $formatoFechaModel = new FormatoFechaModel();
        $data = [
            'formato' => $this->request->getPost('formato'),
            'descripcion' => $this->request->getPost('descripcion')
        ];

        if ($formatoFechaModel->save($data)) {
            return redirect()->to('/formatos_fecha')->with('success', 'Formato de fecha guardado exitosamente.');
        } else {
            return redirect()->to('/formatos_fecha')->with('error', 'Ocurrió un error al guardar el formato de fecha.');
        }
    }
}
