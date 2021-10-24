<?php

namespace App\Http\Controllers;

use App\Assignment;
use Illuminate\Http\Request;
use Auth;
use DB;
use DataTables;
use App\User;
use App\Location;
use App\SubLocation;
use App\Http\Controllers\AccessController;
use App\Http\Requests\AssignmentRequest;
use App\Http\Controllers\UserLogController as Log;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        if(!AccessController::checkAccess(Auth::user()->id, 'assignment_module')) {
            return abort(403);
        }

        if($request->ajax()) {
            $assignments = User::whereBetween('role_id', [4,8])->get();

            $data = collect();
            if(count($assignments) > 0) {
                foreach($assignments as $j) {
                    $data->push([
                        'name' => "<a href='" . route('update.user.assignment', ['id' => $j->id]) . "'>" . $j->first_name . ' ' . $j->last_name . "</a>",
                        'action' => "<button id='update' class='btn btn-warning btn-xs' data-id='" . $j->id . "'><i class='fa fa-edit'></i> Update</button> <button id='remove' class='btn btn-danger btn-xs' data-id='" . $j->id . "'><i class='fa fa-trash'></i> Remove</button>"
                    ]);
                }
            }
            return DataTables::of($data)
                    ->rawColumns(['name', 'action'])
                    ->make(true);
        }
        return view('includes.common.assignment.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!AccessController::checkAccess(Auth::user()->id, 'assignment_module')) {
            return abort(403);
        }
        $users = User::where('active', 1)
                            ->whereBetween('role_id', [4,8])
                            ->where('is_deleted', 0)
                            ->select(['id', 'first_name', 'last_name'])
                            ->orderBy('last_name', 'asc')
                            ->get();

        $locations = Location::where('active', 1)
                            ->where('is_deleted', 0)
                            ->orderBy('location_name', 'asc')
                            ->get();

        return view('includes.common.assignment.add', ['users' => $users, 'locations' => $locations]);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(AssignmentRequest $request)
    {
        if(!AccessController::checkAccess(Auth::user()->id, 'assignment_module')) {
            return abort(403);
        }
        $user = User::findorfail($request->user);
        if($user->active == 0 || $user->is_deleted == 1 || $user->id == 1 || $user->role_id < 4) {
            return abort(500); // 'Unable to Assign to User';
        }

        if($request->ajax()) {

            $dat1 = DB::table('assignments')->where('user_id', $request->user)->where('cat', 'sub')->get();
            if(count($dat1) > 0) {
                DB::table('assignments')->where('user_id', $request->user)->where('cat', 'sub')->delete();
            }

            $dat2 = DB::table('assignments')->where('user_id', $request->user)->where('cat', 'loc')->get();
            if(count($dat2) > 0) {
                DB::table('assignments')->where('user_id', $request->user)->where('cat', 'loc')->delete();
            }
            if(!empty($request->sub_location)) {
                $data1 = [];
                foreach($request->sub_location as $s) {
                    $data1[] = [
                        'user_id' => $request->user,
                        'cat' => 'sub',
                        'sub_location_id' => $s
                    ];
                }
                DB::table('assignments')->insert($data1);
            }
            if(!empty($request->location)) {
                $data2 = [];
                foreach($request->location as $l) {
                    $data2[] = [
                        'user_id' => $request->user,
                        'cat' => 'loc',
                        'location_id' => $l
                    ];

                    $loc = Location::findorfail($l);

                    if(!empty($loc)) {
                        if($loc->has_sublocation == 1) {
                            if(count($loc->sub_locations) > 0) {
                                $data3 = [];
                                foreach($loc->sub_locations as $s) {
                                    $sub = Assignment::where('user_id', $request->user)
                                                    ->where('sub_location_id', $s->id)
                                                    ->first();

                                    if(empty($sub)) {
                                        $data3[] = [
                                            'user_id' => $request->user,
                                            'cat' => 'sub',
                                            'sub_location_id' => $s->id
                                        ];
                                    }
                                }
                            }
                            DB::table('assignments')->insert($data3);
                        }
                    }
                }
                DB::table('assignments')->insert($data2);
            }
            $log = Log::log('create/update', 'assignments', '', 'Create/Update Auditable Location', 'User ID: ' . $request->user, '');
            return 'success';
        }
        else {
            return 'error';
        }
    }


    /**
     * Update the specified resource in storage.
     *
     */
    public function update($id)
    {
        if(!AccessController::checkAccess(Auth::user()->id, 'assignment_module')) {
            return abort(403);
        }
        $user = User::where('id', $id)
                            ->where('active', 1)
                            ->where('is_deleted', 0)
                            ->first();


        if(empty($user) || $user->role_id < 4) {
            return abort(500);
        }

        $locations = Location::where('active', 1)
                            ->where('is_deleted', 0)
                            ->orderBy('location_name', 'asc')
                            ->get();

        return view('includes.common.assignment.add', ['user' => $user, 'locations' => $locations]);
    }


    /**
     * Remove User Assignment
     */
    public function remove($id)
    {
        if(!AccessController::checkAccess(Auth::user()->id, 'assignment_module')) {
            return abort(403);
        }
        $user = User::where('id', $id)
                            ->where('active', 1)
                            ->where('is_deleted', 0)
                            ->first();


        if(empty($user) || $user->role_id < 4) {
            return abort(500);
        }

        if(DB::table('assignments')->where('user_id', $id)->delete()) {
            $log = Log::log('delete', 'assignments', '', 'Deleted Auditable Location', $user, '');
            return 'success';
        }

        return 'error';

    }




    /**
     * check assignment in blade
     */
    public static function checkAssignment($user_id, $cat, $id)
    {
        if($cat == 'loc') {
            $assign = Assignment::where('user_id', $user_id)
                            ->where('location_id', $id)
                            ->first();
            if(!empty($assign)) {
                return true;
            }
            else {
                return false;
            }
        }
        if($cat == 'sub') {
            $assign = Assignment::where('user_id', $user_id)
                            ->where('sub_location_id', $id)
                            ->first();



            if(!empty($assign)) {
                return true;
            }
            else {
                return false;
            }
        }
    }



    /**
     * Get Caretackers
     * # 8 - caretaker/first line employee/user
     */
    public static function getCaretakers($cat, $id)
    {
        $data = [];

        if($cat == 'loc') {
            $dat = Assignment::where('location_id', $id)
                            ->get();

            if(count($dat) > 0) {
                foreach($dat as $d) {
                    if($d->user->role_id == 8) {
                        $data[] = [
                            'name' => $d->user->first_name . ' ' . $d->user->last_name
                        ];
                    }
                }
                // Return Array of Assigned Supervisors
                return $data;
            }
            else {
                // This can be audited cause no assigned 
                return 'No Assigned Caretakers';
            }
        }
        elseif($cat == 'sub') {
            $dat = Assignment::where('sub_location_id', $id)
                            ->get();

            if(count($dat) > 0) {
                foreach($dat as $d) {
                    if($d->user->role_id == 8) {                 
                        $data[] = [
                            'name' => $d->user->first_name . ' ' . $d->user->last_name
                        ];
                    }


                }
                // Return Array of Assigned Supervisors
                return $data;
            }
            else {
                // This can be audited cause no assigned 
                return 'No Assigned Caretakers';
            }
        }
        else {
            return abort(500);
        }

    }


    /**
     * Get Supervisors
     * # 6 - supervisor
     */
    public static function getSupervisors($cat, $id)
    {
        $data = [];

        if($cat == 'loc') {
            $dat = Assignment::where('location_id', $id)
                            ->get();

            if(count($dat) > 0) {
                foreach($dat as $d) {
                    if($d->user->role_id == 6) {
                        $data[] = [
                            'name' => $d->user->first_name . ' ' . $d->user->last_name
                        ];
                    }
                }
                // Return Array of Assigned Supervisors
                return $data;
            }
            else {
                // This can be audited cause no assigned 
                return 'No Assigned Supervisor';
            }
        }
        elseif($cat == 'sub') {
            $dat = Assignment::where('sub_location_id', $id)
                            ->get();

            if(count($dat) > 0) {
                foreach($dat as $d) {
                    if($d->user->role_id == 6) {                 
                        $data[] = [
                            'name' => $d->user->first_name . ' ' . $d->user->last_name
                        ];
                    }
                    else {
                        $sub = SubLocation::find($id);
                        $check = Assignment::where('location_id', $sub->location->id)
                                        ->get();
                        if(count($check) > 0) {
                            foreach($check as $c) {
                                $data[] = [
                                    'name' => $c->user->first_name . ' ' . $c->user->last_name
                                ];
                            }
                        }
                    }

                }
                // Return Array of Assigned Supervisors
                return $data;
            }
            else {
                // This can be audited cause no assigned 
                return 'No Assigned Supervisor';
            }
        }
        else {
            return abort(500);
        }

    }

}
