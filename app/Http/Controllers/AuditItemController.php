<?php

namespace App\Http\Controllers;

use App\AuditItem;
use Illuminate\Http\Request;
use App\Http\Controllers\AccessController;
use Auth;
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
            $items = AuditItem::all();
 
            $data = collect();
            if(count($items) > 0) {
                foreach($items as $j) {
                    $data->push([
                        'name' => strtoupper($j->item_name),
                        'action' => 'action'
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
        if(count($request->locations) > 0) {
            $loc = ',';
            foreach($request->locations as $l) {
                $loc .= $l . ',';
            }
            $ai->location_ids = $loc;
        }
        
        $ai->save();

        // checklists

        // reeturn
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AuditItem  $auditItem
     * @return \Illuminate\Http\Response
     */
    public function show(AuditItem $auditItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AuditItem  $auditItem
     * @return \Illuminate\Http\Response
     */
    public function edit(AuditItem $auditItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AuditItem  $auditItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AuditItem $auditItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AuditItem  $auditItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(AuditItem $auditItem)
    {
        //
    }
}
