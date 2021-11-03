<?php

namespace App\Http\Controllers;

use App\AuditItemCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\AccessController;
use Auth;
use DB;
use DataTables;
use App\Http\Controllers\GeneralController as GC;
use App\Http\Controllers\ActionController as AC;
use App\Http\Controllers\UserLogController as Log;

class AuditItemCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!AccessController::checkAccess(Auth::user()->id, 'audit_name_module')) {
            return abort(403);
        }
        if($request->ajax()) {
            $items = AuditItemCategory::where('active', 1)->where('is_deleted', 0)->get();
 
            $data = collect();
            if(count($items) > 0) {
                foreach($items as $j) {
                    $data->push([
                        'name' => strtoupper($j->category_name),
                        'action' => '<button id="edit" class="btn btn-warning btn-xs" data-id="' . $j->id . '"><i class="fa fa-edit"></i> Edit</button> <button id="remove" data-id="' . $j->id . '" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Remove</button>'
                    ]);
                }
            }
            return DataTables::of($data)
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('includes.common.audit-name.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        if(!AccessController::checkAccess(Auth::user()->id, 'audit_name_module')) {
            return abort(403);
        }
        return view('includes.common.audit-name.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(Request $request)
    {
        if($request->ajax()) {
            $request->validate([
                'audit_name' => 'required'
            ]);

            $name = new AuditItemCategory();
            $name->category_name = $request->audit_name;
            $name->description = $request->description;
            if($name->save()) {
                return response('Audit Name Created', 200)
                  ->header('Content-Type', 'text/plain');
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit($id)
    {
        $cat = AuditItemCategory::whereId($id)->where('active', 1)->where('is_deleted', 0)->first();

        if(empty($cat)) {
            return abort(404);
        }

        return view('includes.common.audit-name.edit', ['name' => $cat]);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, $id)
    {
        if($request->ajax()) {
            $request->validate([
                'audit_name' => 'required'
            ]);

            $name = AuditItemCategory::whereId($id)->where('active', 1)->where('is_deleted', 0)->first();

            if(empty($name)) {
                return abort(404);
            }
            $name->category_name = $request->audit_name;
            $name->description = $request->description;
            if($name->save()) {
                return response('Audit Name Updated', 200)
                  ->header('Content-Type', 'text/plain');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function remove($id)
    {
        $name = AuditItemCategory::whereId($id)->where('active', 1)->where('is_deleted', 0)->first();

        if(empty($name)) {
            return response('Audit Name Not Found!', 404)
                  ->header('Content-Type', 'text/plain');
        }

        $name->is_deleted = 1;
        $name->save();

        return response('Audit Name Removed!', 200)
                  ->header('Content-Type', 'text/plain');
    }
}
