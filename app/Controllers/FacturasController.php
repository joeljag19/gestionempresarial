<?php

namespace App\Controllers;

use App\Models\FacturaModel;
use App\Models\DetalleFacturaModel;
use App\Models\ClienteModel;
use App\Models\ProductoTerminadoModel;
use App\Models\AgenteVentasModel;

class FacturasController extends BaseController
{
    public function index()
    {
        $facturaModel = new FacturaModel();
        $facturas = $facturaModel->findAll();

        return view('facturas/index', ['facturas' => $facturas]);
    }

    public function crear()
    {
        $clienteModel = new ClienteModel();
        $productoModel = new ProductoTerminadoModel();
        $agenteModel = new AgenteVentasModel();

        $clientes = $clienteModel->findAll();
        $productos = $productoModel->findAll();
        $agentes = $agenteModel->findAll();

        return view('facturas/crear', [
            'clientes' => $clientes,
            'productos' => $productos,
            'agentes' => $agentes
        ]);
    }

    public function guardar()
    {
        $facturaModel = new FacturaModel();
        $detalleFacturaModel = new DetalleFacturaModel();

        $facturaData = [
            'cliente_id' => $this->request->getPost('cliente'),
            'numero_factura' => $this->request->getPost('numero_factura'),
            'fecha_factura' => $this->request->getPost('fecha_factura'),
            'fecha_vencimiento' => $this->request->getPost('fecha_vencimiento'),
            'total' => 0, // Se actualizará más adelante
            'moneda' => $this->request->getPost('moneda'),
            'estado' => 'pendiente'
        ];

        $facturaModel->save($facturaData);
        $facturaId = $facturaModel->insertID();

        $total = 0;
        $productos = $this->request->getPost('productos');
        $cantidades = $this->request->getPost('cantidades');
        $precios_unitarios = $this->request->getPost('precios_unitarios');
        $descuentos = $this->request->getPost('descuentos');

        foreach ($productos as $index => $producto_id) {
            $cantidad = $cantidades[$index];
            $precio_unitario = $precios_unitarios[$index];
            $descuento = $descuentos[$index];
            $subtotal = ($cantidad * $precio_unitario) - $descuento;
            $total += $subtotal;

            $detalleData = [
                'factura_id' => $facturaId,
                'producto_id' => $producto_id,
                'cantidad' => $cantidad,
                'precio_unitario' => $precio_unitario,
                'descuento' => $descuento
            ];

            $detalleFacturaModel->save($detalleData);
        }

        $facturaModel->update($facturaId, ['total' => $total]);

        return redirect()->to('/facturas');
    }
}
