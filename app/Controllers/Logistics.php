<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Logistics extends Controller
{
    public function index()
    {
        return view('logistics/dashboard');
    }
}
