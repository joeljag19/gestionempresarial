<?php

namespace App\Controllers;

use App\Models\RolePermissionModel;
use CodeIgniter\Controller;

class UserController extends Controller
{
    public function viewPermissions()
    {
        $session = session();
        //$role = $session->get('role');
        $role = 1;

    echo "Rol: ". $role;
        $rolePermissionModel = new RolePermissionModel();
        $permissions = $rolePermissionModel->getPermissionsWithNames($role);
    
        $data = [
            'permissions' => $permissions
        ];
    
        return view('user/permissions', $data);
    }
    
}
