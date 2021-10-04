<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DivHeadController extends Controller
{
    // Dashboard
    public function dashboard()
    {
    	return view('divhead.dashboard', ['system' => $this->system()]);
    }
}
