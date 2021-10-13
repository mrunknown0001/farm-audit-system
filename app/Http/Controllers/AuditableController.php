<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DataTables;
use App\Location;
use App\Http\Controllers\GeneralController as GC;
use App\Http\Controllers\ActionController as AC;
use App\Http\Controllers\UserLogController as Log;

class AuditableController extends Controller
{
	/**
	 * Auditable Items (Locations and Sublocations)
	 */
    public function index(Request $request)
    {
    	return view('includes.common.auditable.index', ['system' => $this->system()]);
    }
}
