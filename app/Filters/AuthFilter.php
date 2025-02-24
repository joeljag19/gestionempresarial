<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\RolePermissionModel;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        if ($arguments) {
            $role = $session->get('role');
            $rolePermissionModel = new RolePermissionModel();
            $permissions = $rolePermissionModel->where('role_id', $role)->findAll();

            $hasPermission = false;
            foreach ($permissions as $permission) {
                if (in_array($permission['permission_id'], $arguments)) {
                    $hasPermission = true;
                    break;
                }
            }

            if (!$hasPermission) {
                return redirect()->to('/unauthorized');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No se necesita hacer nada aquí
    }
}
