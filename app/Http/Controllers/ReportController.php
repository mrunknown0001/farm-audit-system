<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Excel;
use DataTables;
use App\Audit;
use App\Farm;
use App\UserFarm;
use App\Location;
use App\SubLocation;
use App\Http\Requests\LocationRequest;
use App\Http\Controllers\GeneralController as GC;
use App\Http\Controllers\ActionController as AC;
use App\Http\Controllers\UserLogController as Log;
use App\Http\Controllers\AccessController;

use App\Exports\MarshalAudit;


class ReportController extends Controller
{
    public function index()
    {
        if(!AccessController::checkAccess(Auth::user()->id, 'reports')) {
            return response('Unauthorized Access!', 403)
                      ->header('Content-Type', 'text/plain');
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



    public function marshal()
    {
        if(!AccessController::checkAccess(Auth::user()->id, 'reports')) {
            return response('Unauthorized Access!', 403)
                      ->header('Content-Type', 'text/plain');
        }

        $farms = UserFarm::where('user_id', Auth::user()->id)->get();

        return view('includes.common.reports.marshal', compact('farms'));
    }


    public function postExportMarshal(Request $request)
    {
        $request->validate([
            'farm' => 'required',
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from'
        ]);

        $from = date('Y-m-d', strtotime($request->from));
        $to = date('Y-m-d', strtotime($request->to));

        // get users/auditors
        $auditors = Audit::where('done', 1)
                    ->whereDate('created_at', '>=', $from)
                    ->whereDate('created_at', '<=', $to)
                    ->groupBy('user_id')
                    ->get(['user_id']);

        $auditor = '';
        $total_compliance = 0;
        $total_non_compliance = 0;
        $total_verified_compliance = 0;
        $total_verified_non_compliance = 0;


        // loop auditors
        if(count($auditors)) {
            foreach($auditors as $au) {
                $audits = Audit::where('user_id', $au->user_id)
                    ->where('done', 1)
                    ->whereDate('created_at', '>=', $from)
                    ->whereDate('created_at', '<=', $to)
                    ->get();

                if(count($audits) > 0) {
                    foreach($audits as $a) {
                        if($a->sub_location) {
                            if($a->sub_location->location->farm_id == $request->farm) {
                                
                            }                    
                        }
                        else if($a->location) {
                            if($a->location->farm_id == $request->farm) {
                                                     
                            }
                        }
                    }
                }
            }
        }



        return $data;
    }



    public function locationCompliance()
    {
        if(!AccessController::checkAccess(Auth::user()->id, 'reports')) {
            return response('Unauthorized Access!', 403)
                      ->header('Content-Type', 'text/plain');
        }

        return view('includes.common.reports.loc-comp');
    }



    public function assignedPersonnel()
    {
        if(!AccessController::checkAccess(Auth::user()->id, 'reports')) {
            return response('Unauthorized Access!', 403)
                      ->header('Content-Type', 'text/plain');
        }

        return view('includes.common.reports.supervisor-caretaker');
    }



    public function sampleExport()
    {
        $data = [1, 2, 3, 4, 5, 6];
        $export = new MarshalAudit($data);
        $filename = date('F j, Y', strtotime(now())) . '.xlsx';
        return Excel::download($export, $filename);
    }
}
