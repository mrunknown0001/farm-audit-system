<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DataTables;
use App\Audit;
use App\Farm;
use App\Location;
use App\SubLocation;
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



    public function allNonCompliant()
    {
    	$data = [65, 59, 80, 81, 56, 55, 40, 30, 50, 75, 60, 30];

    	return response()->json($data);
    }


    public function allCompliant()
    {
        $data = [28, 48, 40, 19, 86, 27, 90, 40, 100, 90, 75, 80];

        return response()->json($data);
    }


    public function getFarms()
    {
        $farms = Farm::where('active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get(['id', 'code']);

        return response()->json($farms);
    }


    public function getFarmLocation($id)
    {
        $locations = Location::where('farm_id', $id)->where('active', 1)->where('is_deleted', 0)->orderBy('location_name', 'asc')->get(['id', 'location_name', 'has_sublocation']);

        return response()->json($locations);
    }

    
    public function getFarmSubLocation($id)
    {
        $sub_locations = SubLocation::where('location_id', $id)->where('active', 1)->where('is_deleted', 0)->orderBy('sub_location_name', 'asc')->get(['id', 'sub_location_name']);

        return response()->json($sub_locations);
    }
}
