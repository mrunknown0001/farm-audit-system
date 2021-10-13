<?php

namespace App\Http\Controllers;

use App\Access;
use Illuminate\Http\Request;
use App\User;

class AccessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return view('admin.access', ['system' => $this->system()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $user = User::findorfail($id);
        return view('admin.access-set', ['system' => $this->system(), 'user' => $user]);
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
