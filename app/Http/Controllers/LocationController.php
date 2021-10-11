<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;
use Auth;
use DataTables;
use App\Http\Requests\LocationRequest;
use App\Http\Requests\LocationUpdateRequest;
use App\Http\Controllers\GeneralController as GC;
use App\Http\Controllers\ActionController as AC;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $loc = Location::where('active', 1)
                            ->where('is_deleted', 0)
                            ->get();
 
            $data = collect();
            if(count($loc) > 0) {
                foreach($loc as $j) {
                    $data->push([
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
        return view('includes.common.location.index', ['system' => $this->system()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('includes.common.location.add', ['system' => $this->system()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LocationRequest $request)
    {
        if($request->ajax()) {       
            $loc = new Location();
            $loc->location_name = $request->location_name;
            $loc->location_code = $request->location_code;
            $loc->description = $request->description;
            $loc->has_sublocation = $request->has_sublocation == 'on' ? 1 : 0;
            if($loc->save()) {
                return 'saved';
            }
            else {
                return 'error';
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $location = Location::findorfail($id);
        return view('includes.common.location.edit', ['system' => $this->system(), 'location' => $location]);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(LocationUpdateRequest $request, $id)
    {
        if($request->ajax()) {       
            $loc = Location::findorfail($id);
            $loc->location_name = $request->location_name;
            $loc->location_code = $request->location_code;
            $loc->description = $request->description;
            $loc->has_sublocation = $request->has_sublocation == 'on' ? 1 : 0;
            $loc->active = $request->active == 'on' ? 1 : 0;
            if($loc->save()) {
                return 'saved';
            }
            else {
                return 'error';
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function remove($id)
    {
        
    }
}
