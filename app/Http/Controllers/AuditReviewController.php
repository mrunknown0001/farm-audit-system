<?php

namespace App\Http\Controllers;

use App\AuditReview;
use Illuminate\Http\Request;
use App\Audit;
use Auth;
use DataTables;

class AuditReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        if(!AccessController::checkAccess(Auth::user()->id, 'audit_reviewer')) {
            return abort(403);
        }

        if($request->ajax()) {
            $audits = Audit::where('reviewed', 0)
                            ->where('verified', 0)
                            ->get();
 
            $data = collect();
            if(count($audits) > 0) {
                foreach($audits as $j) {
                    $data->push([
                        'location' => $j->field1 == 'loc' ? $j->location->location_name : $j->sub_location->location->location_name . ' - ' . $j->sub_location->sub_location_name,
                        'item' => $j->audit_item->item_name,
                        'date_time' => date('F j, Y H:i:s', strtotime($j->created_at)),
                        'action' => $this->reviewaction($j->id, $j->latitude, $j->longitude, $j->images)
                    ]);
                }
            }
            return DataTables::of($data)
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('includes.common.review.index', ['system' => $this->system()]);
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
     * @param  \App\AuditReview  $auditReview
     * @return \Illuminate\Http\Response
     */
    public function show(AuditReview $auditReview)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AuditReview  $auditReview
     * @return \Illuminate\Http\Response
     */
    public function edit(AuditReview $auditReview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AuditReview  $auditReview
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AuditReview $auditReview)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AuditReview  $auditReview
     * @return \Illuminate\Http\Response
     */
    public function destroy(AuditReview $auditReview)
    {
        //
    }





    private function reviewaction($id, $lat, $lon, $images)
    {
        if(count($images) > 0) {
            $img = $images->first();
            return '<a href="" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a> <a href="https://www.google.com/search?q=' . $lat  . '%2C+' . $lon . '" target="_blank" class="btn btn-primary btn-xs"><i class="fa fa-map-marked-alt"></i></a> <a href="/uploads/images/' . $img->filename . '" target="_blank" class="btn btn-danger btn-xs"><i class="fa fa-image"></i></a>';
        }
        else {
            return '<a href="" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a> <a href="https://www.google.com/search?q=' . $lat  . '%2C+' . $lon . '" target="_blank" class="btn btn-primary btn-xs"><i class="fa fa-map-marked-alt"></i></a>';
        }
        

        //https://www.google.com/search?q=15.336105%2C+120.5953213
    }
}
