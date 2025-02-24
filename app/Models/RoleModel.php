<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $allowedFields = ['role_name'];

    public function getRolId($role_id)
    {
        return $this->select('id')
                    ->where('role_name', $role_id)
                    ->first();
    }
}
