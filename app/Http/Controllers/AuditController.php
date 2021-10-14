<?php

namespace App\Http\Controllers;

use App\Audit;
use Illuminate\Http\Request;
use App\Location;
use App\SubLocation;
use Image;
use DB;

class AuditController extends Controller
{

    // Audit
    public function audit($cat, $id)
    {
        // Search Location/SubLocation Based on Cat and ID to be display on page
        
        // Validations

        // Audit Items

        // Save
    }


    // QR Reader
    public function qr()
    {
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
