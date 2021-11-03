<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DataTables;
use App\Http\Requests\LocationRequest;
use App\Http\Controllers\GeneralController as GC;
use App\Http\Controllers\ActionController as AC;
use App\Http\Controllers\UserLogController as Log;
use App\Http\Controllers\AccessController;


class ReportController extends Controller
{
    public function index()
    {
        if(!AccessController::checkAccess(Auth::user()->id, 'reports')) {
            return abort(403);
        }
    	return view('includes.common.reports.index');
    }
}
