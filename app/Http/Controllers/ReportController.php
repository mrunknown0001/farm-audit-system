<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
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


    public function getFarms()
    {
        $farms = Farm::where('active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get(['id', 'code']);

        return response()->json($farms);
    }


    public function getFarmLocation($id)
    {
        $locations = DB::table('locations')
                        ->where('farm_id', $id)
                        ->where('active', 1)
                        ->where('is_deleted', 0)
                        ->orderByRaw('LENGTH(location_name)', 'ASC')
                        ->orderBy('location_name', 'ASC')
                        ->select(['id', 'location_name', 'has_sublocation'])
                        ->get();

        return response()->json($locations);
    }

    
    public function getFarmSubLocation($id)
    {
        $sub_locations = SubLocation::where('location_id', $id)
                        ->where('active', 1)
                        ->where('is_deleted', 0)
                        ->orderByRaw('LENGTH(sub_location_name)', 'ASC')
                        ->orderBy('sub_location_name', 'ASC')
                        ->select(['id', 'sub_location_name'])
                        ->get();

        return response()->json($sub_locations);
    }



    // ID of location with no sub location
    public function dailyLocCompliance($id)
    {
        $month = date('F');
        $data = [
                  [$month, 'Non-Compliant', 'Compliant'],
                  ['1', 1000, 400],
                  ['2', 1170, 460],
                  ['3', 660, 1120],
                  ['4', 1030, 540],
                  ['5', 1000, 400],
                  ['6', 1170, 460],
                  ['7', 660, 1120],
                  ['8', 1030, 540],
                  ['9', 1000, 400],
                  ['10', 1170, 460],
                  ['11', 660, 1120],
                  ['12', 1030, 540]
                ];

        return response()->json($data);
    }
}
