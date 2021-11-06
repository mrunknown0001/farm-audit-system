<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManagerController extends Controller
{
    // Dashboard
    public function dashboard()
    {
    	return view('manager.dashboard', ['report' => 'report']);
    }
}
