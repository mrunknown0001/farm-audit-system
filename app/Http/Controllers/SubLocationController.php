<?php

namespace App\Http\Controllers;

use App\SubLocation;
use App\Location;
use Illuminate\Http\Request;
use Auth;
use DataTables;
use App\Farm;
use App\Http\Controllers\GeneralController as GC;
use App\Http\Controllers\ActionController as AC;
use App\Http\Controllers\UserLogController as Log;
use App\Http\Requests\SubLocationRequest;
use App\Http\Controllers\AccessController;

class SubLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        if(!AccessController::checkAccess(Auth::user()->id, 'sub_location_module')) {
            return abort(403);
        }
        if($request->ajax()) {
            if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {
                $sub = SubLocation::all();
            }
            else {
                $sub = SubLocation::where('active', 1)
                                ->where('is_deleted', 0)
                                ->get();
            }
 
            $data = collect();
            if(count($sub) > 0) {
                foreach($sub as $j) {
                    $data->push([
                        'location' => $j->location->farm->code . '-' . $j->location->location_name,
                        'name' => $j->sub_location_name,
                        'code' => $j->sub_location_code,
                        'action' => AC::subLocationAction($j->id, $j->sub_location_name)
                    ]);
                }
            }
            return DataTables::of($data)
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('includes.common.sublocation.index', ['system' => $this->system()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        if(!AccessController::checkAccess(Auth::user()->id, 'sub_location_add')) {
            return abort(403);
        }
        $locations = Location::where('active', 1)
                            ->where('is_deleted', 0)
                            ->where('has_sublocation', 1)
                            ->get();

        return view('includes.common.sublocation.add', ['system' => $this->system(), 'locations' => $locations]);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(SubLocationRequest $request)
    {
        if(!AccessController::checkAccess(Auth::user()->id, 'sub_location_add')) {
            return abort(403);
        }
        $sub = new SubLocation();
        $location = Location::findorfail($request->location_name);

        $sub->location_id = $request->location_name; // Location ID
        $sub->sub_location_name = $request->sub_location_name;
        $sub->sub_location_code = $request->sub_location_code;
        $sub->description = $request->description;
        $sub->farm_id = $location->farm_id;
        if($sub->save()) {
            $log = Log::log('create', 'sub_locations', '', $sub, '', '');
            return 'saved';
        }
        else {
            'error';
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit($id)
    {
        if(!AccessController::checkAccess(Auth::user()->id, 'sub_location_edit')) {
            return abort(403);
        }
        $sub = SubLocation::findorfail($id);
        $locations = Location::where('active', 1)
                            ->where('is_deleted', 0)
                            ->where('has_sublocation', 1)
                            ->get();
        return view('includes.common.sublocation.edit', ['system' => $this->system(), 'sublocation' => $sub, 'locations' => $locations]);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, $id)
    {
        if(!AccessController::checkAccess(Auth::user()->id, 'sub_location_edit')) {
            return abort(403);
        }
        if($request->ajax()) {
            $request->validate([
                'location_name' => 'required',
                'sub_location_code' => 'required',
                'sub_location_name' => 'required'
            ]);

            $sub = SubLocation::findorfail($id);
            $old_val = $sub;

            // Check for Sub Location Code
            $check_sub_loc_code = SubLocation::where('sub_location_code', $request->sub_location_code)
                        ->where('is_deleted', 0)
                        ->where('active', 1)
                        ->first();
            if(!empty($check_sub_loc_code)) {
                if($check_sub_loc_code->id != $sub->id) {
                    return $request->validate([
                        'sub_location_code' => 'unique:sub_locations'
                    ]);
                }
            }
            $location = Location::findorfail($request->location_name);

            $sub->location_id = $request->location_name; // Location ID
            $sub->sub_location_name = $request->sub_location_name;
            $sub->sub_location_code = $request->sub_location_code;
            $sub->description = $request->description;
            $sub->active = $request->active == 'on' ? 1 : 0;
            $sub->is_deleted = $request->is_deleted == 'on' ? 1 : 0;
            $sub->farm_id = $location->farm_id;
            if($sub->save()) {
                $log = Log::log('update', 'sub_locations', '', $sub, $old_val, '');
                return 'saved';
            }
            else {
                'error';
            }

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function remove($id)
    {
        if(!AccessController::checkAccess(Auth::user()->id, 'sub_location_delete')) {
            return abort(403);
        }
        $sub = SubLocation::findorfail($id);
        $old_val = $sub;
        $sub->is_deleted = 1;
        if($sub->save()) {
            $log = Log::log('delete', 'locations', '', $sub, $old_val, '');
            return 'deleted';
        }
        else {
            return 'error';
        }
    }
}
