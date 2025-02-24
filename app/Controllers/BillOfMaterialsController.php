<?php

namespace App\Controllers;

use App\Models\BillOfMaterialsModel;
use App\Models\RawMaterialsModel;
use App\Models\MateriaPrimaModel;
use CodeIgniter\Controller;

class BillOfMaterialsController extends Controller
{
    public function index()
    {
        $model = new BillOfMaterialsModel();
        $data['boms'] = $model->findAll();

        return view('bom/index', $data);
    }

    public function crear()
    {
        $materiaprimaModel = new MateriaPrimaModel();
        $data['materiaprima'] = $materiaprimaModel->findAll();

        return view('bom/crear', $data);
    }

    public function guardar()
    {
        $model = new BillOfMaterialsModel();

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'materiaprima_id' => $this->request->getPost('producto_fabricado_id'),
            'costo_total' => 0, // Se calculará después
        ];

        $bom_id = $model->insert($data);

        // Guardar los materiales
        $materiales = $this->request->getPost('materiales');
        $rawMaterialsModel = new RawMaterialsModel();
        $materiaprimaModel = new MateriaPrimaModel();
        $costo_total = 0;

        foreach ($materiales as $material) {
            if (isset($material['producto_id'], $material['cantidad'], $material['desperdicio'])) {
                $producto = $materiaprimaModel->find($material['producto_id']);
                $costo_unitario = $producto['costo_unitario'];
                $cantidad = $material['cantidad'];
                $desperdicio = $material['desperdicio'];
                $subtotal = $cantidad * $costo_unitario * (1 + $desperdicio / 100);

                $material_data = [
                    'bom_id' => $bom_id,
                    'producto_id' => $material['producto_id'],
                    'cantidad' => $cantidad,
                    'desperdicio' => $desperdicio,
                    'subtotal'=> $subtotal
                ];
                $rawMaterialsModel->insert($material_data);
                $costo_total += $subtotal;
            }
        }

        // Actualizar el costo total del BoM
        $model->update($bom_id, ['costo_total' => $costo_total]);

        return redirect()->to('/bom');
    }

    public function editar($id)
    {
        $model = new BillOfMaterialsModel();
        $materiaprimaModel = new MateriaPrimaModel();
        $rawMaterialsModel = new RawMaterialsModel();

        $data['bom'] = $model->find($id);
        $data['materiaprimas'] = $materiaprimaModel->findAll();
        $data['materiales'] = $rawMaterialsModel->where('bom_id', $id)->findAll();

        return view('bom/editar', $data);
    }

    public function actualizar($id)
    {
        $model = new BillOfMaterialsModel();

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'materiaprima_id' => $this->request->getPost('producto_fabricado_id'),
            'costo_total' => 0, // Se calculará después
        ];

        $model->update($id, $data);

        // Guardar los materiales
        $materiales = $this->request->getPost('materiales');
        $rawMaterialsModel = new RawMaterialsModel();
        $materiaprimaModel = new MateriaPrimaModel();
        $costo_total = 0;

        // Eliminar materiales existentes
        $rawMaterialsModel->where('bom_id', $id)->delete();

        foreach ($materiales as $material) {
            if (isset($material['producto_id'], $material['cantidad'], $material['desperdicio'])) {
                $producto = $materiaprimaModel->find($material['producto_id']);
                $costo_unitario = $producto['costo_unitario'];
                $cantidad = $material['cantidad'];
                $desperdicio = $material['desperdicio'];
                $subtotal = $cantidad * $costo_unitario * (1 + $desperdicio / 100);

                $material_data = [
                    'bom_id' => $id,
                    'producto_id' => $material['producto_id'],
                    'cantidad' => $cantidad,
                    'desperdicio' => $desperdicio,
                    'subtotal'=> $subtotal
                ];
                $rawMaterialsModel->insert($material_data);
                $costo_total += $subtotal;
            }
        }

        // Actualizar el costo total del BoM
        $model->update($id, ['costo_total' => $costo_total]);

        return redirect()->to('/bom');
    }
}
