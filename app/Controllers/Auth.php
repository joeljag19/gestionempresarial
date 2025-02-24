<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function login()
    {
        return view('auth/login');
    }

    public function register()
    {
        return view('auth/register');
    }
public function loginSubmit()
{
    $session = session();
    $model = new UserModel();
    $username = $this->request->getVar('username');
    $password = $this->request->getVar('password');
    $data = $model->where('username', $username)->first();

    if ($data !== null) {
        if (isset($data['password']) && $data['password'] !== null) {
            $pass = $data['password'];
            $verify_pass = password_verify($password, $pass);
            if ($verify_pass) {
                $ses_data = [
                    'id' => $data['id'],
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'role' => $data['role'],
                    'logged_in' => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/dashboard');
            } else {
                $session->setFlashdata('msg', 'Contraseña incorrecta');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'Contraseña no encontrada');
            return redirect()->to('/login');
        }
    } else {
        $session->setFlashdata('msg', 'Usuario no encontrado');
        return redirect()->to('/login');
    }
}

    public function registerSubmit()
    {
        $model = new UserModel();
        $password = $this->request->getVar('password');
        $confirm_password = $this->request->getVar('confirm_password');
    
        if ($password !== $confirm_password) {
            return redirect()->to('/register')->with('msg', 'Las contraseñas no coinciden');
        }
    
        $data = [
            'username' => $this->request->getVar('username'),
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'email' => $this->request->getVar('email'),
            'role' => $this->request->getVar('role')  // Obtener el rol seleccionado
        ];
        $model->save($data);
        return redirect()->to('/login');
    }
    

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}
