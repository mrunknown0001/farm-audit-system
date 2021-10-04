<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VpController extends Controller
{
    // Dashboard
    public function dashboard()
    {
    	return view('vp.dashboard', ['system' => $this->system()]);
    }
}
