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
use App\AuditItem;
use App\AuditItemLocation;
use Carbon\Carbon;

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
            
            // get audit items under this location 
            $audit_locs = AuditItemLocation::where('location_id', $dat->id)->get();

            return view('includes.common.audit.audit', ['system' => $this->system(), 'dat' => $dat, 'cat' => 'loc']);
        }
        elseif($cat == 'sub') {
            $dat = SubLocation::findorfail($id);
            // validate if location and date is not audited

            // get audit items under the location of this sublocation 
            $audit_locs = AuditItemLocation::where('location_id', $dat->location->id)->get();

            return view('includes.common.audit.audit', ['system' => $this->system(), 'dat' => $dat, 'cat' => 'sub', 'audit_locs' => $audit_locs]);
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
     * Store a newly created resource in storage.
     *
     */
    public function store(Request $request)
    {
        if($request->ajax()) {
            // check
            // $request->cat
            // $request->dat_id
            // date today
            $current = Carbon::now();
            if($request->cat == 'loc') {
                $check = Audit::where('field1', 'loc')
                            ->where('location_id', $request->dat_id)
                            ->where('audit_item_id', $request->audit_item_id)
                            ->whereDate('created_at', '>=', date('Y-m-d', strtotime($current->addHour(8))))
                            ->first();
            }
            elseif($request->cat == 'sub') {
                $check = Audit::where('field1', 'sub')
                            ->where('sub_location_id', $request->dat_id)
                            ->where('audit_item_id', $request->audit_item_id)
                            ->whereDate('created_at', '>=', date('Y-m-d', strtotime($current->addHour(8))))
                            ->first();
            }
            else {
                return abort(500);
            }


            if(!empty($check)) {
                return abort(500);
            }

            $audit = new Audit();
            $audit->user_id = Auth::user()->id;
            $audit->audit_item_id = $request->audit_item_id;
            $audit->field1 = $request->cat;
            if($request->cat == 'loc') {
                $audit->location_id = $request->dat_id;
            }
            else {
                $audit->sub_location_id = $request->dat_id;
            }
            $audit->compliance = $request->compliance; // 1 or 0
            $audit->non_compliance_remarks = $request->remarks;
            $audit->latitude = $request->lat;
            $audit->longitude = $request->lon;
            $audit->save();

            $upload = $request->file('upload');
            $ts = date('m-j-Y H-i-s', strtotime(now()));
            $filename =  $ts . '.jpg';
            $upload->move(public_path('/uploads/images/'), $filename);

            $img = Image::make(public_path('uploads/test/'. $filename));  
            $timestamp = date('F j, Y H:i:s', strtotime(now()));
            $img->text($timestamp, 50, 120, function($font) {  
                $font->file(public_path('fonts/RobotoMonoBold.ttf'));  
                $font->size(80);
                $font->color('#ffa500');
                $font->align('left');
            });  

           $img->save(public_path('uploads/images/' . $filename));  

           DB::table('audit_images')->insert([
            'audit_id' => $audit->id,
            'filename' => $filename,
            'latitude' => $audit->latitude,
            'longitude'
           ]);

           return 'success';
        }
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
