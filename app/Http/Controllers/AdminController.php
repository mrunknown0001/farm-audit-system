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
use App\Farm;
use App\Http\Requests\CreateUserRequest;
use App\DatabaseBackup;

class AdminController extends Controller
{

    /**
     * Admin Dashboard
     */
    public function dashboard()
    {
    	return view('admin.dashboard', ['report' => 'report']);
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
                        'name' => $j->first_name . ' ' . $j->last_name,
                        'farm' => GC::getFarms($j->id),
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
        $farms = Farm::where('active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();
        return view('admin.user-add', ['roles' => $roles, 'farms' => $farms]);
    }


    public function postAddUser(CreateUserRequest $request)
    {
        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->role_id = $request->role;
        $user->password = bcrypt($request->password);
        // $user->farm_id = $request->farm; // old code

        $user->save();

        if(isset($request->farms)) {
            $insert2 = [];
            foreach($request->farms as $c) {
                $insert2[] = [
                    'user_id' => $user->id,
                    'farm_id' => $c
                ];
            }
            DB::table('user_farms')->insert($insert2);
        }

        return response('User Added', 200)
                ->header('Content-Type', 'text/plain');
    }



    public function updateUser($id)
    {
        $user = User::findorfail($id);
        $roles = Role::all();
        $farms = Farm::where('active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();
        return view('admin.user-update', compact('roles', 'user', 'farms'));
    }


    public function postUpdateUser(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'role' => 'required|min:1|max:4',
            'farms' => 'required'
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
        // $user->farm_id = $request->farm;
        $user->save();
        if(isset($request->farms)) {
            DB::table('user_farms')->where('user_id', $user->id)->delete();
            $insert2 = [];
            foreach($request->farms as $c) {
                $insert2[] = [
                    'user_id' => $user->id,
                    'farm_id' => $c
                ];
            }
            DB::table('user_farms')->insert($insert2);
        }

        return response('User Updated', 200)
                ->header('Content-Type', 'text/plain');
    }


    public function database(Request $request)
    {
        if($request->ajax()) {
            $db = DatabaseBackup::orderBy('created_at', 'desc')->get();
 
            $data = collect();
            if(count($db) > 0) {
                foreach($db as $j) {
                    $data->push([
                        'filename' => $j->filename,
                        'datetime' => date('m d, Y H:i:s', strtotime($j->created_at)),
                        'action' => "<a href='" . $j->url . "'>Download</a>"
                    ]);
                }
            }
            return DataTables::of($data)
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.backup');
    }


}
