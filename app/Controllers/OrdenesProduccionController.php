<?php

namespace App\Controllers;

use App\Models\OrdenProduccionModel;
use App\Models\DetalleProduccionModel;
use App\Models\CotizacionModel;

class OrdenesProduccionController extends BaseController
{
    public function index()
    {
        $ordenProduccionModel = new OrdenProduccionModel();
        $ordenesProduccion = $ordenProduccionModel->findAll();
        
        return view('ordenes_produccion/index', ['ordenesProduccion' => $ordenesProduccion]);
    }

    public function crear()
    {
        $cotizacionModel = new CotizacionModel();
        $cotizaciones = $cotizacionModel->findAll();

        return view('ordenes_produccion/crear', ['cotizaciones' => $cotizaciones]);
    }

    public function guardar()
    {
        $ordenProduccionModel = new OrdenProduccionModel();
        $detalleProduccionModel = new DetalleProduccionModel();

        $ordenProduccionData = [
            'cotizacion_id' => $this->request->getPost('cotizacion'),
            'fecha_creacion' => date('Y-m-d'),
            'fecha_inicio' => $this->request->getPost('fecha_inicio'),
            'fecha_fin' => $this->request->getPost('fecha_fin'),
            'estado' => 'en_proceso'
        ];

        $ordenProduccionModel->save($ordenProduccionData);
        $ordenProduccionId = $ordenProduccionModel->insertID();

        // Asumiendo que se obtendrá una lista de productos a producir desde la cotización
        $productos = $this->request->getPost('productos');
        $cantidades = $this->request->getPost('cantidades');

        foreach ($productos as $index => $producto_id) {
            $detalleData = [
                'orden_produccion_id' => $ordenProduccionId,
                'producto_id' => $producto_id,
                'cantidad' => $cantidades[$index]
            ];

            $detalleProduccionModel->save($detalleData);
        }

        return redirect()->to('/ordenes_produccion');
    }
}
