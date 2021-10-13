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

class AuditItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!AccessController::checkAccess(Auth::user()->id, 'audit_item_module')) {
            return abort(403);
        }
        return view('includes.common.audit-item.index', ['system' => $this->system()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
