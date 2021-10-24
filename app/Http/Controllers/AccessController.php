<?php

namespace App\Http\Controllers;

use App\Access;
use Illuminate\Http\Request;
use App\User;
use DataTables;
use Auth;
use App\Http\Controllers\UserLogController as Log;

class AccessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $users = User::all();
 
            $data = collect();
            if(count($users) > 0) {
                foreach($users as $j) {
                    if(!empty($j->access)) {
                        if($j->access->access == ',') {
                            $data->push([
                                'name' => $this->accesslink($j->first_name . ' ' . $j->last_name, $j->id),
                                'action' => 'Not Defined'
                            ]);
                        }
                        else {
                            $data->push([
                                'name' => $this->accesslink($j->first_name . ' ' . $j->last_name, $j->id),
                                'action' => $this->accesslist($j->access->access)
                            ]);
                        }
                    }
                    else {
                        $data->push([
                            'name' => $this->accesslink($j->first_name . ' ' . $j->last_name, $j->id),
                            'action' => 'Not Defined'
                        ]);
                    }
                }
            }
            return DataTables::of($data)
                    ->rawColumns(['name','action'])
                    ->make(true);
        }
        return view('admin.access');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $user = User::findorfail($id);
        return view('admin.access-set',['user' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $access = Access::where('user_id', $request->user_id)->first();

        if(empty($access)) {
            $access = new Access();
            $access->user_id = $request->id;
        }
        if($request->access == '') {
            $acc = NULL;
        }
        else {
            $acc = implode(",",$request->access);
        }
        $access->access = "," . $acc;
        if($access->save()) {
            return redirect()->back()->with('success', 'Access Saved!');
        }
        else {
            return redirect()->back()->with('error', 'Error Occured! Please Try Again.');
        }
    }



    /**
     * Return Access List in badge
     */
    private function accesslist($acc)
    {
         $acc = substr($acc, 1);
         $arr = explode(',', $acc);

         $str = "";
         foreach($arr as $a) {
            $str .= " <span class='label label-primary'>". strtoupper($a) . "</span>";
         }

         return $str;
    }



    /**
     * access Link
     */
    private function accesslink($name, $id)
    {
        return "<a href='" . route('set.access', ['id' => $id]) . "'>" . $name . "</a>";
    }













    /**
     * Check Access to user
     */
    public static function checkAccess($id, $acc)
    {
        $user = User::findorfail($id);

        if($user->role_id == 1 || $user->role_id == 2) {
            return true;
        }

        $access = Access::where('user_id', $user->id)->first();

        if(empty($access)) {
            return false;
        }

        $str = strpos($access->access, ",".$acc);

        if($str === false) {
            return false;
        }
        else {
            return true;
        }
    } 




}
