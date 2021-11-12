<?php

namespace App\Http\Controllers;

use App\Farm;
use Illuminate\Http\Request;
use Auth;
use DataTables;
use App\Http\Requests\FarmRequest;
use App\Http\Controllers\GeneralController as GC;
use App\Http\Controllers\ActionController as AC;
use App\Http\Controllers\UserLogController as Log;
use App\Http\Controllers\AccessController;

class FarmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $farms = Farm::orderBy('name', 'asc')->get();
 
            $data = collect();
            if(count($farms) > 0) {
                foreach($farms as $j) {
                    $data->push([
                        'name' => $j->name,
                        'code' => $j->code,
                        'action' => '<button id="update" data-id="' . $j->id . '" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit</button>'
                    ]);
                }
            }
            return DataTables::of($data)
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.farms');
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return view('admin.farm-add');
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(FarmRequest $request)
    {
        if($request->ajax()) {
            $farm = new Farm();
            $farm->name = $request->farm_name;
            $farm->code = $request->farm_code;
            $farm->description = $request->description;
            $farm->save();

            return response('Farm Created', 200)
                    ->header('Content-Type', 'text/plain');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit($id)
    {
        $farm = Farm::findorfail($id);
        return view('admin.farm-edit', compact('farm'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, $id)
    {
        if($request->ajax()) {
            $farm = Farm::findorfail($id);

            $request->validate([
                'farm_name' => 'required',
                'farm_code' => 'required',
            ]);

            $code_check = Farm::where('code', $request->code)->first();
            if(!empty($code_check) && $farm->code != $code_check->code) {
                return response('Farm Code Exists!', 500)
                            ->header('Content-Type', 'text/plain');
            }

            $farm->name = $request->farm_name;
            $farm->code = $request->farm_code;
            $farm->description = $request->description;
            $farm->active = $request->active ? $request->active : 0;
            $farm->save();
            return response('Farm Updated', 200)
                    ->header('Content-Type', 'text/plain');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy($id)
    {
        //
    }
}
