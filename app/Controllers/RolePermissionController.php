<?php

namespace App\Controllers;

use App\Models\RoleModel;
use App\Models\PermissionModel;
use App\Models\RolePermissionModel;
use CodeIgniter\Controller;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roleModel = new RoleModel();
        $permissionModel = new PermissionModel();
        $rolePermissionModel = new RolePermissionModel();

        $roles = $roleModel->findAll();
        $permissions = $permissionModel->findAll();
        $rolePermissions = $rolePermissionModel->findAll();

        $data = [
            'roles' => $roles,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions
        ];

        return view('admin/role_permissions', $data);
    }

    public function assignPermission()
    {
        $rolePermissionModel = new RolePermissionModel();
        $role_id = $this->request->getVar('role_id');
        $permission_id = $this->request->getVar('permission_id');
    
        // Verificar si la combinación ya existe
        $existing = $rolePermissionModel->where('role_id', $role_id)
                                        ->where('permission_id', $permission_id)
                                        ->first();
    
        if ($existing) {
            // La combinación ya existe, mostrar un mensaje de error
            return redirect()->to('/admin/role_permissions')->with('msg', 'La combinación de rol y permiso ya existe.');
        }
    
        $data = [
            'role_id' => $role_id,
            'permission_id' => $permission_id
        ];
    
        $rolePermissionModel->insert($data);
    
        return redirect()->to('/admin/role_permissions')->with('msg', 'Permiso asignado correctamente.');
    }
    

    public function removePermission()
    {
        $rolePermissionModel = new RolePermissionModel();
        $role_id = $this->request->getVar('role_id');
        $permission_id = $this->request->getVar('permission_id');

        $rolePermissionModel->where('role_id', $role_id)
                            ->where('permission_id', $permission_id)
                            ->delete();

        return redirect()->to('/admin/role_permissions');
    }
}
