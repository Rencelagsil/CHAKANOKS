<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Login extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function auth()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        if ($username === 'manager' && $password === '1234') {
            return redirect()->to('branchmanager');
        } else {
            return redirect()->back()->with('error', 'Invalid login!');
        }
    }
}
