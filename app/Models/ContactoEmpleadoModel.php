<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactoEmpleadoModel extends Model
{
    protected $table = 'contacto_empleados';
    protected $primaryKey = 'id';
    protected $allowedFields = ['empleado_id', 'numero_celular', 'correo_personal', 'correo_compania', 'no_suscrito', 'contato_emergencia','telefono_emergencia','relacion'];
}
