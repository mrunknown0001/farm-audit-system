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
use App\AuditItemLocation;

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
        return view('includes.common.audit-item.index');
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
        $locations = Location::where('active', 1)
                            ->where('is_deleted', 0)
                            ->orderBy('location_name', 'asc')
                            ->orderBy('LENGTH(location_name)', 'ASC')
                            ->get();
        return view('includes.common.audit-item.add', ['locations' => $locations]);
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

        // return
        return response('Audit Item Created', 200)
                  ->header('Content-Type', 'text/plain');
    }



    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit($id)
    {
        $item = AuditItem::where('id', $id)->where('active', 1)->where('is_deleted', 0)->first();
        $locations = Location::where('active', 1)
                            ->where('is_deleted', 0)
                            ->orderBy('location_name', 'asc')
                            ->orderBy('LENGTH(location_name)', 'ASC')
                            ->get();
        return view('includes.common.audit-item.edit', ['locations' => $locations, 'item' => $item]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AuditItemRequest $request, $id)
    {
        $ai = AuditItem::findorfail($request->id);
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
            // Remove and Insert
            DB::table('audit_item_locations')->where('audit_item_id', $ai->id)->delete();
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
            // Remove and Insert
            DB::table('audit_item_checklists')->where('audit_item_id', $ai->id)->delete();
            DB::table('audit_item_checklists')->insert($insert2);
        }

        // return
        return response('Audit Item Updated', 200)
                  ->header('Content-Type', 'text/plain');
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function remove($id)
    {
        $data = AuditItem::findorfail($id);
        $data->is_deleted = 1;
        if($data->save()) {
            // Log
            return response('Audit Item Removed', 200)
                      ->header('Content-Type', 'text/plain');
        }
    }





    /**
     * Check if Location is set in audit item
     */
    public static function checkifset($audit_item_id, $location_id)
    {
        $item_loc = AuditItemLocation::where('audit_item_id', $audit_item_id)
                            ->where('location_id', $location_id)
                            ->first();
        if(isset($item_loc)) {
            return true;
        }
        else {
            return false;
        }
    }



    /**
     * [timecheck description]
     * return array type of time
     */
    public static function timecheck($timerange)
    {
        // exployed using ,
        $range = explode(",", $timerange);

        // check if more that 1
        foreach($range as $r) {
            // explode using -

            // check current time from|to
            $time = explode("-", $r);
            $time_now = date('h:i a', strtotime(now()));
            $time0 = date('h:i a', strtotime($time[0]));
            $time1 = date('h:i a', strtotime($time[1]));
            if($time_now >= $time0 && $time_now <= $time1) {
                return true;
            }
        }

        return false;
    }
}
