<?php

namespace App\Models;

use CodeIgniter\Model;

class MateriaPrimaModel extends Model
{
    protected $table = 'materia_prima';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'descripcion', 'unidad_de_medida', 'codigo_de_barra', 'grupo_de_materia','costo_unitario'];
    protected $useTimestamps = true; // Habilita el uso de timestamps
    protected $createdField = 'creado_en'; // Campo para la fecha de creación
    protected $updatedField = 'actualizado_en'; // Campo para la fecha de actualización


    public function getmateriaprima() { 
        $this->select('materia_prima.id, materia_prima.nombre, materia_prima.descripcion, categorias_materiaprima.nombre AS categoria, unidades_medida.nombre AS unidad, materia_prima.codigo_de_barra, materia_prima.costo_unitario, materia_prima.creado_en, materia_prima.actualizado_en'); 
        $this->join('categorias_materiaprima', 'materia_prima.grupo_de_materia = categorias_materiaprima.id', 'left'); 
        $this->join('unidades_medida', 'materia_prima.unidad_de_medida = unidades_medida.id', 'left');
        return $this->findAll(); 
    }
}
