<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriasMateriaprimaModel extends Model
{
    protected $table = 'categorias_materiaprima';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

    // Customize timestamps fields names
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Optional: define validation rules
    protected $validationRules    = [
        'nombre' => 'required|min_length[3]|max_length[255]'
    ];
    protected $validationMessages = [
        'nombre' => [
            'required' => 'El campo nombre es obligatorio',
            'min_length' => 'El nombre debe tener al menos 3 caracteres',
            'max_length' => 'El nombre no puede exceder los 255 caracteres'
        ]
    ];
}
