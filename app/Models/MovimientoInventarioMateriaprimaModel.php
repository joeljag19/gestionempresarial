<?php

namespace App\Models;

use CodeIgniter\Model;

class MovimientoInventarioMateriaprimaModel extends Model
{
    protected $table = 'movimiento_inventario_materiaprima';
    protected $primaryKey = 'id';
    protected $allowedFields = ['materia_prima_id', 'cantidad', 'tipo_movimiento', 'motivo', 'usuario_id', 'fecha'];
    protected $useTimestamps = false;

    // Optional: define validation rules
    protected $validationRules = [
        'materia_prima_id' => 'required|is_natural_no_zero',
        'cantidad' => 'required|decimal',
        'tipo_movimiento' => 'required|in_list[entrada,salida]',
        'motivo' => 'required|string',
        'usuario_id' => 'required|is_natural_no_zero'
    ];
    protected $validationMessages = [
        'materia_prima_id' => [
            'required' => 'El campo materia_prima_id es obligatorio',
            'is_natural_no_zero' => 'El materia_prima_id debe ser un número natural mayor a cero'
        ],
        'cantidad' => [
            'required' => 'El campo cantidad es obligatorio',
            'decimal' => 'La cantidad debe ser un número decimal válido'
        ],
        'tipo_movimiento' => [
            'required' => 'El campo tipo_movimiento es obligatorio',
            'in_list' => 'El tipo_movimiento debe ser "entrada" o "salida"'
        ],
        'motivo' => [
            'required' => 'El campo motivo es obligatorio',
            'string' => 'El motivo debe ser una cadena de texto'
        ],
        'usuario_id' => [
            'required' => 'El campo usuario_id es obligatorio',
            'is_natural_no_zero' => 'El usuario_id debe ser un número natural mayor a cero'
        ]
    ];
}
