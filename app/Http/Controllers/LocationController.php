<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;
use Auth;
use DataTables;
use DB;
use Hash;
use App\Http\Requests\LocationRequest;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
                        'action' => 'action'
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
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('includes.common.location.add', ['system' => $this->system()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
                return abort(500);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        //
    }
}
