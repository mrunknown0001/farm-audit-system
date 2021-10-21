<?php

namespace App\Http\Controllers;

use App\Audit;
use Illuminate\Http\Request;
use App\Location;
use App\SubLocation;
use Image;
use DB;
use Auth;
use App\Assignment;
use App\Http\Controllers\AccessController;

class AuditController extends Controller
{

    // Audit 
    public function audit($cat, $id)
    {
        if(!AccessController::checkAccess(Auth::user()->id, 'audit_marshal')) {
            return abort(403);
        }
        // Show 
        if($cat == 'loc') {
            $dat = Location::findorfail($id);
            // validate if location and date is not audited
            return view('includes.common.audit.audit', ['system' => $this->system(), 'dat' => $dat, 'cat' => 'loc']);
        }
        elseif($cat == 'sub') {
            $dat = SubLocation::findorfail($id);
            // validate if location and date is not audited
            return view('includes.common.audit.audit', ['system' => $this->system(), 'dat' => $dat, 'cat' => 'sub']);
        }
        else {
            return abort(500);
        }

    }


    // QR Reader
    public function qr()
    {
        if(!AccessController::checkAccess(Auth::user()->id, 'audit_marshal')) {
            return abort(403);
        }
        return view('includes.common.audit.qr-reader', ['system' => $this->system()]);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('includes.common.audit.index', ['system' => $this->system()]);
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
     * @param  \App\Audit  $audit
     * @return \Illuminate\Http\Response
     */
    public function show(Audit $audit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Audit  $audit
     * @return \Illuminate\Http\Response
     */
    public function edit(Audit $audit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Audit  $audit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Audit $audit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Audit  $audit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Audit $audit)
    {
        //
    }
}
