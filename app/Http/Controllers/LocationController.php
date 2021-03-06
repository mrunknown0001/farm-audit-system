<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;
use Auth;
use DataTables;
use App\Farm;
use App\Http\Requests\LocationRequest;
use App\Http\Controllers\GeneralController as GC;
use App\Http\Controllers\ActionController as AC;
use App\Http\Controllers\UserLogController as Log;
use App\Http\Controllers\AccessController;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if(!AccessController::checkAccess(Auth::user()->id, 'location_module')) {
            return abort(403);
        }

        if($request->ajax()) {
            if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {
                $loc = Location::all();
            }
            else {
                $loc = Location::where('active', 1)
                                ->where('is_deleted', 0)
                                ->get();
            }
 
            $data = collect();
            if(count($loc) > 0) {
                foreach($loc as $j) {
                    $data->push([
                        'farm' => $j->farm ? $j->farm->code : 'No Farm',
                        'name' => $j->location_name,
                        'code' => $j->location_code,
                        'action' => AC::locationAction($j->id, $j->location_name)
                    ]);
                }
            }
            return DataTables::of($data)
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('includes.common.location.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!AccessController::checkAccess(Auth::user()->id, 'location_add')) {
            return abort(403);
        }

        $farms = Farm::where('active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();
        return view('includes.common.location.add', compact('farms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LocationRequest $request)
    {
        if(!AccessController::checkAccess(Auth::user()->id, 'location_add')) {
            return abort(403);
        }
        if($request->ajax()) {       
            $loc = new Location();
            $loc->location_name = $request->location_name;
            $loc->location_code = $request->location_code;
            $loc->description = $request->description;
            $loc->has_sublocation = $request->has_sublocation == 'on' ? 1 : 0;
            $loc->farm_id = $request->farm;
            if($loc->save()) {
                $log = Log::log('create', 'locations', '', $loc, '', '');
                return response('Location Saved', 200)
                  ->header('Content-Type', 'text/plain');
            }
            else {
                return response('Error Saving Location', 500)
                  ->header('Content-Type', 'text/plain');
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if(!AccessController::checkAccess(Auth::user()->id, 'location_edit')) {
            return abort(403);
        }
        $location = Location::findorfail($id);
        $farms = Farm::where('active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();
        return view('includes.common.location.edit', ['location' => $location, 'farms' => $farms]);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, $id)
    {
        if(!AccessController::checkAccess(Auth::user()->id, 'location_edit')) {
            return abort(403);
        }
        if($request->ajax()) {
            $request->validate([
                'location_name' => 'required',
                'location_code' => 'required',
                'farm' => 'required'
            ]);

            $loc = Location::findorfail($id);
            $old_val = $loc;
            // Check for Location Name
            $check_loc_name = Location::where('location_name', $request->location_name)
                        ->where('is_deleted', 0)
                        ->where('active', 1)
                        ->first();
            if(!empty($check_loc_name)) {
                if($check_loc_name->id != $loc->id) {
                    return $request->validate([
                        'location_name' => 'unique:locations'
                    ]);
                }
            }

            // Check for Location Code
            $check_loc_code = Location::where('location_code', $request->location_code)
                        ->where('is_deleted', 0)
                        ->where('active', 1)
                        ->first();
            if(!empty($check_loc_code)) {
                if($check_loc_code->id != $loc->id) {
                    return $request->validate([
                        'location_code' => 'unique:locations'
                    ]);
                }
            }

            $loc->location_name = $request->location_name;
            $loc->location_code = $request->location_code;
            $loc->description = $request->description;
            $loc->has_sublocation = $request->has_sublocation == 'on' ? 1 : 0;
            $loc->active = $request->active == 'on' ? 1 : 0;
            $loc->is_deleted = $request->is_deleted == 'on' ? 1 : 0;
            $loc->farm_id = $request->farm;
            if($loc->save()) {
                $log = Log::log('update', 'locations', '', $loc, $old_val, '');
                return response('Location Updated', 200)
                  ->header('Content-Type', 'text/plain');
            }
            else {
                return response('Error Updating Location', 500)
                  ->header('Content-Type', 'text/plain');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function remove($id)
    {
        if(!AccessController::checkAccess(Auth::user()->id, 'location_delete')) {
            return abort(403);
        }
        $loc = Location::findorfail($id);
        $old_val = $loc;
        $loc->is_deleted = 1;
        if($loc->save()) {
            $log = Log::log('delete', 'locations', '', $loc, $old_val, '');
            return response('Location Removed', 403)
                  ->header('Content-Type', 'text/plain');
        }
        else {
            return response('Error in Removing Location', 500)
                  ->header('Content-Type', 'text/plain');
        }
    }






    /**
     * getLoationFarm
     */
    public function getLoationFarm($id)
    {
        $locations = Location::where('farm_id', $id)->where('active', 1)->where('is_deleted',0)->get();

        if(count($locations) < 1) {
            return false;
        }
        else {
            $data = [];

            foreach($locations as $l) {
                $data[] = [
                    'id' => $l->id,
                    'name' => $l->location_name,
                ];
            }

            return response()->json($data, 200);
        }
    }
}
