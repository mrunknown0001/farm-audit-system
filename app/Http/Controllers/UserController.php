<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DataTables;
use App\User;
use App\EmployeeLog;
use Auth;
use DB;
use Hash;
use App\Http\Controllers\GeneralController as GC;
use Excel;
use App\Exports\EmployeeLogExport;

class UserController extends Controller
{

    /**
     * Profile
     */
    public function profile()
    {
        return view('includes.common.profile', ['system' => $this->system()]);
    }

    /**
     * Change Password
     */
    public function changePassword()
    {
        return view('includes.common.change-password', ['system' => $this->system()]);
    }


    public function postChangePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        $user = Auth::user();
        if(Hash::check($request->current_password, $user->password)) {
            $user->password = bcrypt($request->new_password);
            $user->save();
            return redirect()->back()->with('success', 'Password Changed!');

        }
        else {
            return redirect()->back()->with('error', 'Current Password Invalid!');
        }
    }


    /**
     * User Dashboard
     */
    public function dashboard()
    {
        $uploads = DB::table('upload')->select('filename')->get();
    	return view('user.dashboard', ['system' => $this->system(), 'uploads' => $uploads]);
    }






## Start of old codes

    public function employees (Request $request)
    {
        if($request->ajax()) {
            $employees = User::where('manager_id', Auth::user()->id)->get();
 
            $data = collect();
            if(count($employees) > 0) {
                foreach($employees as $j) {
                    $data->push([
                        'first_name' => $j->first_name,
                        'last_name' => $j->last_name,
                        'action' => GC::showLogs($j->id)
                    ]);
                }
            }
            return DataTables::of($data)
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('user.employees');
    }


    public function employeeShowLog(Request $request, $id)
    {
        if($request->ajax()) {
            $punches = EmployeeLog::where('manager_id', Auth::user()->id)
                                ->where('user_id', $id)
                                ->get();
 
            $data = collect();
            if(count($punches) > 0) {
                foreach($punches as $j) {
                    $data->push([
                        'type' => $j->type,
                        'date_time' => date('F j, Y h:i:s A', strtotime($j->created_at)),
                        'uuid' => $j->uuid,
                        'ip' => $j->ip_address,
                        'action' => GC::getLocation($j->latitude, $j->longitude, $j->id)
                    ]);
                }
            }
            return DataTables::of($data)
                    ->rawColumns(['action'])
                    ->make(true);

        }
        $emp = User::findorfail($id);
        return view('user.emp-punches', ['emp' => $emp]);
    }


    public function punches(Request $request)
    {
        if($request->ajax()) {
        	$punches = EmployeeLog::where('manager_id', Auth::user()->id)->get();
 
            $data = collect();
            if(count($punches) > 0) {
                foreach($punches as $j) {
                    $data->push([
                    	'emp' => $j->employee->first_name . ' ' . $j->employee->last_name,
                        'type' => $j->type,
                        'date_time' => date('F j, Y h:i:s A', strtotime($j->created_at)),
                        'uuid' => $j->uuid,
                        'ip' => $j->ip_address,
                        'action' => GC::getLocation($j->latitude, $j->longitude, $j->id)
                    ]);
                }
            }
            return DataTables::of($data)
                    ->rawColumns(['action'])
                    ->make(true);

        }

    	return view('user.punches');
    }


    public function exportLogs()
    {
        $logs = new EmployeeLogExport();
        $filename = date('F j, Y', strtotime(now())) . '.xlsx';
        return Excel::download($logs, $filename);
    }



    public function mapLocation($id)
    {
        if(Auth::user()->role_id == 4) {
            return redirect()->back()->with('info', 'User Not Able to View Map.');
        }
        $log = EmployeeLog::findorfail($id);
        $lat = $log->latitude;
        $lon = $log->longitude;
        return view('user.location', ['lat' => $lat, 'lon' => $lon, 'log' => $log]);
    }


    ## End Codes
}
