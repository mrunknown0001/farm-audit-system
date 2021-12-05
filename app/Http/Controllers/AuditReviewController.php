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
                            ->where('done', 1)
                            ->get();
 
            $data = collect();
            if(count($audits) > 0) {
                foreach($audits as $j) {
                    $data->push([
                        'stat' => $j->read == 0 ? '<span class="label label-warning badge-pill">NEW</span>' : '<span class="label label-success badge-pill">SEEN</span>',
                        'location' => $j->field1 == 'loc' ? $j->location->farm->code . ' - ' . $j->location->location_name : $j->sub_location->location->farm->code . ' - ' . $j->sub_location->location->location_name . ' - ' . $j->sub_location->sub_location_name,
                        'item' => $j->audit_item->item_name,
                        'date_time' => date('F j, Y H:i:s', strtotime($j->created_at)),
                        'action' => $this->reviewaction($j->id, $j->latitude, $j->longitude, $j->images)
                    ]);
                }
            }
            return DataTables::of($data)
                    ->orderColumn('date_time', '-name $1')
                    ->rawColumns(['stat', 'action'])
                    ->make(true);
        }
        return view('includes.common.review.index');
    }


    /**
     * Store a newly created resource in storage.
     *
     */
    public function review(Request $request, $id)
    {
        if($request->ajax()) {
            // validation
            $verified = 0;
            if($request->verified != null) {
                $verified = $request->verified;
            }
            $audit = Audit::findorfail($id);
            if($audit->reviewed == 1) {
                return response('This is already reviewed.', 500)
                      ->header('Content-Type', 'text/plain');
            }
            $audit->reviewed = 1;
            $audit->date_reviewed = date('Y-m-d h:i:s', strtotime(now()));
            $audit->verified = $verified;
            $audit->field3 = Auth::user()->id;
            $audit->save();

            $review = new AuditReview();
            $review->audit_id = $audit->id;
            $review->user_id = Auth::user()->id;
            $review->verified = $verified;
            $review->review = $request->editordata;
            $review->save();


        }
    }

    /**
     * Display the specified resource.
     *
     */
    public function show($id)
    {
        $audit = Audit::findorfail($id);
        $audit->read = 1;
        $audit->read_by = Auth::user()->id;
        $audit->read_timestamp = date('Y-m-d h:i:s', strtotime(now()));
        $audit->save();

        return view('includes.common.review.review', ['audit' => $audit]);
    }

    /**
     * Show the reviewed audit
     *
     */
    public function reviewed(Request $request)
    {
        if(!AccessController::checkAccess(Auth::user()->id, 'audit_reviewer')) {
            return abort(403);
        }

        if($request->ajax()) {
            $audits = Audit::where('reviewed', 1)
                            ->where('done', 1)
                            ->get();
 
            $data = collect();
            if(count($audits) > 0) {
                foreach($audits as $j) {
                    $data->push([
                        'stat' => $j->read == 0 ? '<span class="label label-warning badge-pill">NEW</span>' : '<span class="label label-success badge-pill">SEEN</span>',
                        'location' => $j->field1 == 'loc' ? $j->location->location_name : $j->sub_location->location->location_name . ' - ' . $j->sub_location->sub_location_name,
                        'item' => $j->audit_item->item_name,
                        'date_time' => date('F j, Y H:i:s', strtotime($j->created_at)),
                        'action' => $this->reviewaction($j->id, $j->latitude, $j->longitude, $j->images)
                    ]);
                }
            }
            return DataTables::of($data)
                    ->rawColumns(['stat', 'action'])
                    ->make(true);
        }
        return view('includes.common.review.reviewed');
    }




    public function auditorreview($id)
    {
        $audit = Audit::whereId($id)->first();

        if(!empty($audit)) {
            return '<p>Reviewed by: <strong>'. $audit->reviewer->first_name . ' ' . $audit->reviewer->last_name . '</strong></p><p>Review Timestamp: <strong>' . $audit->review->created_at . '</strong></p>';
        }
        else {
            return 'Data Not Available.';
        }
    }





    private function reviewaction($id, $lat, $lon, $images)
    {
        # Old menu
        // if(count($images) > 0) {
        //     $img = $images->first();
        //     return '<button id="view" data-id="' . $id . '" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></button> <a href="https://www.google.com/search?q=' . $lat  . '%2C+' . $lon . '" target="_blank" class="btn btn-primary btn-xs"><i class="fa fa-map-marked-alt"></i></a> <a href="/uploads/images/' . $img->filename . '" target="_blank" class="btn btn-danger btn-xs"><i class="fa fa-image"></i></a>';
        // }
        // else {
        //     return '<button id="view" data-id="' . $id . '" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></button> <a href="https://www.google.com/search?q=' . $lat  . '%2C+' . $lon . '" target="_blank" class="btn btn-primary btn-xs"><i class="fa fa-map-marked-alt"></i></a>';
        // }
        
        return '<button id="view" data-id="' . $id . '" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></button>';
    }
}
