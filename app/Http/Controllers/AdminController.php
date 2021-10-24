<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use DB;
use Auth;
use Hash;
use DataTables;
use App\EmployeeLog;
use App\Http\Controllers\GeneralController as GC;
use App\Role;

class AdminController extends Controller
{

    /**
     * Admin Dashboard
     */
    public function dashboard()
    {
    	return view('admin.dashboard');
    }


    /**
     * Users
     */
    public function users(Request $request)
    {
        if($request->ajax()) {
            $users = User::all();
 
            $data = collect();
            if(count($users) > 0) {
                foreach($users as $j) {
                    $data->push([
                        'first_name' => $j->first_name,
                        'last_name' => $j->last_name,
                        'type' => GC::getUserType($j->role_id),
                        'active' => $j->active == 1 ? 'Active' : 'Inactive',
                        'action' => '<a href="' . route('admin.update.user', $j->id) . '" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Edit</a> <a href="' . route('set.access', ['id' => $j->id]) . '" class="btn btn-primary btn-xs"><i class="fa fa-universal-access"></i> Access</a>'
                    ]);
                }
            }
            return DataTables::of($data)
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.users');
    }



    /**
     * Add user
     */
    public function addUser()
    {
        $roles = Role::all();
        return view('admin.user-add', ['roles' => $roles]);
    }


    public function postAddUser(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'role' => 'required|min:1|max:4',
            'password' => 'required',
        ]);

        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->role_id = $request->role;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->back()->with('success', 'User Added!');
    }



    public function updateUser($id)
    {
        $user = User::findorfail($id);
        $roles = Role::all();
        return view('admin.user-update', compact('roles', 'user'));
    }


    public function postUpdateUser(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'role' => 'required|min:1|max:4',
        ]);

        $user = User::findorfail($id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->role_id = $request->role;
        if($request->password != null || $request->password != '') {
            $user->password = bcrypt($request->password);
        }
        $user->active = $request->active != NULL && $request->active == 'on' ? 1 : 0;
        $user->save();

        return redirect()->back()->with('success', 'User Updated!');
    }


    public function database()
    {
        return view('admin.backup');
    }



    public function punches (Request $request)
    {
        if($request->ajax()) {
            $punches = EmployeeLog::all();
 
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

        return view('admin.punches');
    }



    public function purgeLogs()
    {
        EmployeeLog::truncate();

        return 'ok';
    }
}
