<?php

namespace App\Models;

use CodeIgniter\Model;

class UnidadesMedidaModel extends Model
{
    protected $table = 'unidades_medida';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'abreviacion', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

    // Customize timestamps fields names
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Optional: define validation rules
    protected $validationRules    = [
        'nombre' => 'required|min_length[2]|max_length[255]',
        'abreviacion' => 'required|min_length[1]|max_length[10]'
    ];
    protected $validationMessages = [
        'nombre' => [
            'required' => 'El campo nombre es obligatorio',
            'min_length' => 'El nombre debe tener al menos 2 caracteres',
            'max_length' => 'El nombre no puede exceder los 255 caracteres'
        ],
        'abreviacion' => [
            'required' => 'El campo abreviación es obligatorio',
            'min_length' => 'La abreviación debe tener al menos 1 caracter',
            'max_length' => 'La abreviación no puede exceder los 10 caracteres'
        ]
    ];
}
