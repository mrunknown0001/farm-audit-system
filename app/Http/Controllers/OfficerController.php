<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OfficerController extends Controller
{
    // Dashboard
    public function dashboard()
    {
    	return view('officer.dashboard', ['report' => 'report']);
    }
}
