<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\BranchModel;
use CodeIgniter\Controller;

class Login extends Controller
{
    protected $userModel;
    protected $branchModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->branchModel = new BranchModel();
    }

    public function index()
    {
        // Check if user is already logged in
        if (session()->get('user_id')) {
            return $this->redirectToDashboard();
        }

        return view('login');
    }

    public function auth()
    {
        // Debug: Check if we're receiving the request
        log_message('debug', 'Login auth method called');
        
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        if (empty($username) || empty($password)) {
            return redirect()->back()->with('error', 'Please enter both username and password.');
        }

        $user = $this->userModel->authenticate($username, $password);

        if ($user) {
            // Set session data
            $sessionData = [
                'user_id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'role' => $user['role'],
                'branch_id' => $user['branch_id'],
                'is_logged_in' => true
            ];

            session()->set($sessionData);

            return $this->redirectToDashboard();
        } else {
            return redirect()->back()->with('error', 'Invalid username or password.');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }

    private function redirectToDashboard()
    {
        $role = session()->get('role');
        
        switch ($role) {
            case 'admin':
                return redirect()->to(base_url('dashboard'));
            case 'branch_manager':
                return redirect()->to(base_url('branchmanager'));
            case 'inventory_staff':
                return redirect()->to(base_url('staff'));
            case 'logistics_coordinator':
                return redirect()->to(base_url('logistics'));
            case 'supplier':
                return redirect()->to(base_url('supplier'));
            case 'franchise_manager':
                return redirect()->to(base_url('franchise'));
            default:
                return redirect()->to(base_url('dashboard'));
        }
    }
}
