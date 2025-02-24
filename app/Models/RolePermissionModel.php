<?php

namespace App\Models;

use CodeIgniter\Model;

class RolePermissionModel extends Model
{
    protected $table = 'role_permissions';
    protected $primaryKey = ['role_id', 'permission_id'];
    protected $allowedFields = ['role_id', 'permission_id'];

    public function getPermissionsWithNames($role_id)
    {
        return $this->select('role_permissions.*, permissions.permission_name')
                    ->join('permissions', 'permissions.id = role_permissions.permission_id')
                    ->where('role_permissions.role_id', $role_id)
                    ->findAll();
    }
}
