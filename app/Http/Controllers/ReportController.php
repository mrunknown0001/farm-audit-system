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
        $year = date('Y');
        $month = date('F') . ' ' . $year; // Current Month
        $month_num = date('m');
        $numb_of_days = date('t'); // Currenet Month Number of Days
        $data = [];
        // get audit of the current month per day
        $data[] = [$month, 'Compliant', 'Non-Compliant'];
        for($i = 1; $i <= $numb_of_days; $i++) {
            $date = $year . '-' . $month_num . '-' . $i;
            $audit_compliance_count = Audit::where('field1', 'loc')
                        ->where('compliance', 1)
                        ->where('location_id', $id)
                        ->where('done', 1)
                        ->whereDate('created_at', date('Y-m-d', strtotime($date)))
                        ->count();
            $audit_non_compliance_count = Audit::where('field1', 'loc')
                        ->where('compliance', 0)
                        ->where('done', 1)
                        ->where('location_id', $id)
                        ->whereDate('created_at', date('Y-m-d', strtotime($date)))
                        ->count();

            $data[] = [$i, $audit_compliance_count, $audit_non_compliance_count];
        }
        

        return response()->json($data);
    }


    // ID of sub location
    public function dailySubCompliance($id)
    {
        $year = date('Y');
        $month = date('F') . ' ' . $year; // Current Month
        $month_num = date('m');
        $numb_of_days = date('t'); // Currenet Month Number of Days
        $data = [];
        // get audit of the current month per day
        $data[] = [$month, 'Compliant', 'Non-Compliant'];
        for($i = 1; $i <= $numb_of_days; $i++) {
            $date = $year . '-' . $month_num . '-' . $i;
            $audit_compliance_count = Audit::where('field1', 'sub')
                        ->where('compliance', 1)
                        ->where('done', 1)
                        ->where('sub_location_id', $id)
                        ->whereDate('created_at', date('Y-m-d', strtotime($date)))
                        ->count();
            $audit_non_compliance_count = Audit::where('field1', 'sub')
                        ->where('compliance', 0)
                        ->where('done', 1)
                        ->where('sub_location_id', $id)
                        ->whereDate('created_at', date('Y-m-d', strtotime($date)))
                        ->count();

            $data[] = [$i, $audit_compliance_count, $audit_non_compliance_count];
        }
        

        return response()->json($data);
    }
}
