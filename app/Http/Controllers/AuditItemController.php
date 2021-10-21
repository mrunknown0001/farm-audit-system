<?php

namespace App\Http\Controllers;

use App\AuditItem;
use Illuminate\Http\Request;
use App\Http\Controllers\AccessController;
use Auth;
use DB;
use DataTables;
use App\Http\Controllers\GeneralController as GC;
use App\Http\Controllers\ActionController as AC;
use App\Http\Controllers\UserLogController as Log;
use App\Http\Requests\AuditItemRequest;
use App\Location;

class AuditItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        if(!AccessController::checkAccess(Auth::user()->id, 'audit_item_module')) {
            return abort(403);
        }
        if($request->ajax()) {
            $items = AuditItem::where('active', 1)->where('is_deleted', 0)->get();
 
            $data = collect();
            if(count($items) > 0) {
                foreach($items as $j) {
                    $data->push([
                        'name' => strtoupper($j->item_name),
                        'action' => '<button id="edit" class="btn btn-warning btn-xs" data-id="' . $j->id . '"><i class="fa fa-edit"></i> Edit</button> <button id="remove" data-id="' . $j->id . '" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Remove</button>'
                    ]);
                }
            }
            return DataTables::of($data)
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('includes.common.audit-item.index', ['system' => $this->system()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        if(!AccessController::checkAccess(Auth::user()->id, 'audit_item_module')) {
            return abort(403);
        }
        $locations = Location::where('active', 1)->where('is_deleted', 0)->get();

        return view('includes.common.audit-item.add', ['system' => $this->system(), 'locations' => $locations]);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(AuditItemRequest $request)
    {
        $ai = new AuditItem();
        $ai->item_name = $request->audit_item_name;
        $ai->description = $request->description;
        $ai->time_range = $request->time_range;
        $ai->save();
        
        if(count($request->locations) > 0) {
            $insert1 = [];
            foreach($request->locations as $l) {
                $insert1[] = [
                    'audit_item_id' => $ai->id,
                    'location_id' => $l
                ];
            }
            DB::table('audit_item_locations')->insert($insert1);
        }
        

        // checklists
        if(isset($request->checklist)) {
            $insert2 = [];
            foreach($request->checklist as $c) {
                $insert2[] = [
                    'audit_item_id' => $ai->id,
                    'checklist' => $c
                ];
            }
            DB::table('audit_item_checklists')->insert($insert2);
        }

        // reeturn
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
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function remove($id)
    {
        $data = AuditItem::findorfail($id);
        $data->is_deleted = 1;
        $data->save();
    }
}
