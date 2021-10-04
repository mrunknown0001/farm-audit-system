<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    // Dashboard
    public function dashboard()
    {
    	return view('supervisor.dashboard', ['system' => $this->system()]);
    }
}
