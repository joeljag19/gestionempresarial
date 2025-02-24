<?php

namespace App\Controllers;

use App\Models\IdiomaModel;

class IdiomaController extends BaseController
{
    public function index()
    {
        $idiomaModel = new IdiomaModel();
        $idiomas = $idiomaModel->findAll();

        return view('idiomas/index', ['idiomas' => $idiomas]);
    }

    public function guardar()
    {
        $idiomaModel = new IdiomaModel();
        $data = [
            'codigo' => $this->request->getPost('codigo'),
            'nombre' => $this->request->getPost('nombre')
        ];

        if ($idiomaModel->save($data)) {
            return redirect()->to('/idiomas')->with('success', 'Idioma guardado exitosamente.');
        } else {
            return redirect()->to('/idiomas')->with('error', 'Ocurrió un error al guardar el idioma.');
        }
    }
}
