<?php

namespace App\Controllers;

use App\Models\ConfiguracionModel;
use App\Models\FormatoFechaModel;
use App\Models\FormatoMonedaModel;
use App\Models\IdiomaModel;

class ConfiguracionController extends BaseController
{
    public function index()
    {
        $configModel = new ConfiguracionModel();
        $formatoFechaModel = new FormatoFechaModel();
        $formatoMonedaModel = new FormatoMonedaModel();
        $idiomaModel = new IdiomaModel();

        $configuracion = $configModel->first();
        $formatosFecha = $formatoFechaModel->findAll();
        $formatosMoneda = $formatoMonedaModel->findAll();
        $idiomas = $idiomaModel->findAll();

        return view('configuracion/index', [
            'configuracion' => $configuracion,
            'formatosFecha' => $formatosFecha,
            'formatosMoneda' => $formatosMoneda,
            'idiomas' => $idiomas
        ]);
    }

    public function actualizar()
    {
        $configModel = new ConfiguracionModel();
        $data = [
            'id' => $this->request->getPost('id'),
            'nombre_empresa' => $this->request->getPost('nombre_empresa'),
            'direccion' => $this->request->getPost('direccion'),
            'telefono' => $this->request->getPost('telefono'),
            'rnc' => $this->request->getPost('rnc'),
            'formato_moneda_id' => $this->request->getPost('formato_moneda_id'),
            'formato_fecha_id' => $this->request->getPost('formato_fecha_id'),
            'idioma_id' => $this->request->getPost('idioma_id')
        ];

        if ($configModel->save($data)) {
            return redirect()->to('/configuracion')->with('success', 'Configuración actualizada exitosamente.');
        } else {
            return redirect()->to('/configuracion')->with('error', 'Ocurrió un error al actualizar la configuración.');
        }
    }
}
