<?php

namespace App\Http\Controllers;

use App\Assignment;
use Illuminate\Http\Request;
use Auth;
use DB;
use DataTables;
use App\User;
use App\Location;
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
            $assignments = Assignment::all();

            $data = collect();
            if(count($assignments) > 0) {
                foreach($assignments as $j) {
                    $data->push([
                        'name' => $j->user->first_name . ' ' . $j->user->last_name,
                        'action' => 'show|edit'
                    ]);
                }
            }
            return DataTables::of($data)
                    ->rawColumns(['action'])
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
        if($request->ajax()) {       
            if(!empty($request->sub_location)) {
                $data1 = [];
                foreach($request->sub_location as $s) {
                    // check assigned if exist
                    $data1[] = [
                        'user_id' => $request->user,
                        'cat' => 'sub',
                        'sub_location_id' => $s
                    ];

                    DB::table('assignments')->where('user_id', $request->user)->where('cat', 'sub')->delete();
                    DB::table('assignments')->insert($data1);
                }
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
            }
        }
        else {
            return abort(500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function show(Assignment $assignment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function edit(Assignment $assignment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Assignment $assignment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assignment $assignment)
    {
        //
    }
}
