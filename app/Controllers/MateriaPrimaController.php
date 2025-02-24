<?php

namespace App\Controllers;

use App\Models\MateriaPrimaModel;
use App\Models\CategoriasMateriaprimaModel;
use App\Models\UnidadesMedidaModel;
use CodeIgniter\Controller;


class MateriaPrimaController extends Controller
{
    public function index()
    {
        $model = new MateriaPrimaModel();
       // $data['materiaprimas'] = $model->findAll();
      
        $data['materiaprimas'] = $model->getmateriaprima();
    

        return view('materiaprimas/index', $data);
    }

    public function crear()
    {
        $materia = new CategoriasMateriaprimaModel;
        $data['categorias']= $materia->findAll();
        $medidas = new UnidadesMedidaModel;
        $data['medidas'] = $medidas->findAll();
        return view('materiaprimas/crear',$data);
    }

    public function guardar()
    {
        $model = new MateriaPrimaModel();

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'unidad_de_medida' => $this->request->getPost('unidad_de_medida'),
            'codigo_de_barras' => $this->request->getPost('codigo_de_barra'),
            'grupo_de_materia' => $this->request->getPost('categoria'),
        ];

        $model->save($data);

        return redirect()->to('/materiaprimas');
    }

    public function editar($id)
    {
        $model = new MateriaPrimaModel();
        $data['materiaprima'] = $model->find($id);

        $materia = new CategoriasMateriaprimaModel;
        $data['categorias']= $materia->findAll();
        
        $medidas = new UnidadesMedidaModel;
        $data['medidas'] = $medidas->findAll();

        return view('materiaprimas/editar', $data);
    }

    public function actualizar($id)
    {
        $model = new MateriaPrimaModel();

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'unidad_de_medida' => $this->request->getPost('unidad_de_medida'),
            'codigo_de_barras' => $this->request->getPost('codigo_de_barra'),
            'grupo_de_materia' => $this->request->getPost('categoria'),
        ];

        $model->update($id, $data);

        return redirect()->to('/materiaprimas');
    }
}
