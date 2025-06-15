<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function login()
    {
        helper(['form']);
        if ($this->request->getMethod() === 'POST') {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $userModel = new UserModel();
            $user = $userModel->where('username', $username)->first();
            if ($user && password_verify($password, $user['password'])) {
                // Set session data
                session()->set('isLoggedIn', true);
                session()->set('username', $user['username']);
                return redirect()->to('/');
            } else {
                return view('login', ['error' => 'Invalid username or password']);
            }
        }
        return view('login');
    }

    public function logout()
    {
        // $this->createAdmin(); // Create admin user if not exists
        session()->destroy();
        return redirect()->to('login');
    }
    public function createAdmin()
    {
        $userModel = new \App\Models\UserModel();
        $userModel->insert([
            'username' => 'admin',
            'password' => password_hash('bhusaria$2025', PASSWORD_DEFAULT)
        ]);
        return 'Admin user created!';
    }
}