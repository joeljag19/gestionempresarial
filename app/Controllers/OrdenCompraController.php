<?php
namespace App\Controllers;
use App\Models\MateriaPrimaModel;
use App\Models\SuplidorModel;
use App\Models\OrdenCompraModel;
use App\Models\DetalleOrdenCompraModel;
use CodeIgniter\Controller;

class OrdenCompraController extends Controller
{
    public function index()
    {
        $suplidorModel = new SuplidorModel();
        $materiaPrimaModel = new MateriaPrimaModel();

        $data = [
            'suplidores' => $suplidorModel->findAll(),
            'materiasPrimas' => $materiaPrimaModel->findAll()
        ];

        return view('orden_compra/index', $data);
    }

    public function guardarOrdenCompra()
    {
        $ordenCompraModel = new OrdenCompraModel();
        $detalleOrdenCompraModel = new DetalleOrdenCompraModel();

        $ordenData = [
            'suplidor_id' => $this->request->getPost('suplidor_id'),
            'fecha_orden' => $this->request->getPost('fecha_orden'),
            'estado' => $this->request->getPost('estado'),
            'total' => $this->request->getPost('total'),
            'detalle' => $this->request->getPost('detalle')
        ];

        $ordenCompraModel->save($ordenData);
        $ordenId = $ordenCompraModel->insertID();

        $materiasPrimas = $this->request->getPost('materias_primas');
        foreach ($materiasPrimas as $materiaPrima) {
            $detalleOrdenCompraModel->save([
                'orden_compra_id' => $ordenId,
                'materia_prima_id' => $materiaPrima['id'],
                'cantidad' => $materiaPrima['cantidad'],
                'precio_unitario' => $materiaPrima['precio_unitario'],
                'subtotal' => $materiaPrima['subtotal'],
                'itbis' => $materiaPrima['itbis']
            ]);
        }

        return redirect()->to('/ordenes-compra');
    }

    public function getMateriaPrimaDetails()
    {
        $materiaPrimaModel = new MateriaPrimaModel();
        $id = $this->request->getPost('materia_prima_id');
        $materiaPrima = $materiaPrimaModel->find($id);

        return $this->response->setJSON($materiaPrima);
    }
}
