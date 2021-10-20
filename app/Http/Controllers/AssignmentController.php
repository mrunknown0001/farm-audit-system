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
            $assignments = User::all();

            $data = collect();
            if(count($assignments) > 0) {
                foreach($assignments as $j) {
                    $data->push([
                        'name' => "<a href='" . route('update.user.assignment', ['id' => $j->id]) . "'>" . $j->first_name . ' ' . $j->last_name . "</a>",
                        'action' => 'edit|delete'
                    ]);
                }
            }
            return DataTables::of($data)
                    ->rawColumns(['name', 'action'])
                    ->make(true);
        }
        return view('includes.common.assignment.index', ['system' => $this->system()]);
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
                            ->where('is_deleted', 0)
                            ->select(['id', 'first_name', 'last_name'])
                            ->orderBy('last_name', 'asc')
                            ->get();

        $locations = Location::where('active', 1)
                            ->where('is_deleted', 0)
                            ->orderBy('location_name', 'asc')
                            ->get();

        return view('includes.common.assignment.add', ['system' => $this->system(), 'users' => $users, 'locations' => $locations]);
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
        if($user->active == 0 || $user->is_deleted == 1 || $user->id == 1) {
            return abort(500);
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
                }
                DB::table('assignments')->insert($data2);
            }

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

        $locations = Location::where('active', 1)
                            ->where('is_deleted', 0)
                            ->orderBy('location_name', 'asc')
                            ->get();

        return view('includes.common.assignment.add', ['system' => $this->system(), 'user' => $user, 'locations' => $locations]);
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

}
