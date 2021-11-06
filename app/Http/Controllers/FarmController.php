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
            $farms = Farm::where('active', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();
 
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(FarmRequest $request)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, $id)
    {
        //
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
