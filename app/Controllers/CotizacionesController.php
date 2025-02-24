<?php

namespace App\Controllers;

use App\Models\CotizacionModel;
use App\Models\DetalleCotizacionModel;
use App\Models\ClienteModel;
use App\Models\ProductoTerminadoModel;
use App\Models\AgenteVentasModel;

class CotizacionesController extends BaseController
{
    public function index()
    {
        $cotizacionModel = new CotizacionModel();
        $cotizaciones = $cotizacionModel->findAll();
        
        return view('cotizaciones/index', ['cotizaciones' => $cotizaciones]);
    }

    public function crear()
    {
        $clienteModel = new ClienteModel();
        $productoModel = new ProductoTerminadoModel();
        // $agenteModel = new AgenteVentasModel();

        $clientes = $clienteModel->findAll();
        $productos = $productoModel->findAll();
        // $agentes = $agenteModel->findAll();

        return view('cotizaciones/crear', [
            'clientes' => $clientes,
            'productos' => $productos,
            
        ]);
    }

    public function guardar()
    {
        $cotizacionModel = new CotizacionModel();
        $detalleCotizacionModel = new DetalleCotizacionModel();

        $cotizacionData = [
            'cliente_id' => $this->request->getPost('cliente'),
            'numero_cotizacion' => $this->request->getPost('numero_cotizacion'),
            'fecha_cotizacion' => $this->request->getPost('fecha_cotizacion'),
            'fecha_vencimiento' => $this->request->getPost('fecha_vencimiento'),
            'gastos_envio' => $this->request->getPost('gastos_envio'),
            'forma_entrega' => $this->request->getPost('forma_entrega'),
            'segunda_unidad' => $this->request->getPost('segunda_unidad'),
            'modo_pago' => implode(',', $this->request->getPost('modo_pago')),
            'moneda' => $this->request->getPost('moneda'),
            'agente_ventas' => $this->request->getPost('agente_ventas'),
            'factura_recurrente' => $this->request->getPost('factura_recurrente'),
            'tipo_descuento' => $this->request->getPost('tipo_descuento'),
            'nota_admin' => $this->request->getPost('nota_admin')
        ];

        $cotizacionModel->save($cotizacionData);
        $cotizacionId = $cotizacionModel->insertID();

        $productos = $this->request->getPost('productos');
        $cantidades = $this->request->getPost('cantidades');
        $precios_unitarios = $this->request->getPost('precios_unitarios');
        $descuentos = $this->request->getPost('descuentos');

        foreach ($productos as $index => $producto_id) {
            $detalleData = [
                'cotizacion_id' => $cotizacionId,
                'producto_id' => $producto_id,
                'cantidad' => $cantidades[$index],
                'precio_unitario' => $precios_unitarios[$index],
                'descuento' => $descuentos[$index]
            ];

            $detalleCotizacionModel->save($detalleData);
        }

        return redirect()->to('/cotizaciones');
    }

    public function detalle($cotizacion_id)
    {
        $detalleCotizacionModel = new DetalleCotizacionModel();
        $detalles = $detalleCotizacionModel->where('cotizacion_id', $cotizacion_id)->findAll();

        return view('cotizaciones/detalle', ['detalles' => $detalles]);
    }
}
