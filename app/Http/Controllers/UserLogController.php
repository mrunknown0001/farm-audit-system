<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\UserLog;
use DataTables;

class UserLogController extends Controller
{
    // User Log
    public static function log($action = NULL, $table = NULL, $url = NULL, $data1 = NULL, $data2 = NULL, $data3 = NULL)
    {
    	$log = new UserLog();
    	$log->user_id = Auth::user()->id;
    	$log->action = $action;
    	$log->table = $table;
    	$log->url = $url;
    	$log->data1 = $data1;
    	$log->data2 = $data2;
    	$log->data3 = $data3;
    	$log->save();
    }


    public function index(Request $request)
    {
        if($request->ajax()) {
            $logs = UserLog::all();

            $data = collect();
            if(count($logs) > 0) {
                foreach($logs as $j) {
                    $data->push([
                        'id' => $j->id,
                        'user' => $j->user->first_name . ' ' . $j->user->last_name,
                        'email' => $j->user->email,
                        'table_name' => $j->table,
                        'url' => $j->url,
                        'data1' => $j->data1,
                        'data2' => $j->data2,
                        'data3' => $j->data3,
                        'created_at' => date('F j, Y h:i:s', strtotime($j->created_at)),
                        'action' => $j->action,
                    ]);
                }
            }
            return DataTables::of($data)
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.logs', ['system' => $this->system()]);
    }
}
