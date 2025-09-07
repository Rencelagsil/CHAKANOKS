<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // Check if user is already logged in
        if (session()->get('is_logged_in')) {
            return redirect()->to(base_url('dashboard'));
        }
        
        return view('login');
    }
}
