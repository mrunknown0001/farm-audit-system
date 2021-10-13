<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DataTables;
use App\Location;
use App\SubLocation;
use App\Http\Controllers\GeneralController as GC;
use App\Http\Controllers\ActionController as AC;
use App\Http\Controllers\UserLogController as Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AuditableController extends Controller
{
	/**
	 * Auditable Items (Locations and Sublocations)
	 */
    public function index(Request $request)
    {
    	if($request->ajax()) {
    		$loc = Location::where('active', 1)
    						->where('is_deleted', 0)
    						->get();

    		$data = collect();
            if(count($loc) > 0) {
                foreach($loc as $j) {
	                if($j->has_sublocation == 1) {	
	                	if(count($j->sub_locations) > 0) {
		                    foreach($j->sub_locations as $s) {
			                    $data->push([
			                        'name' => $j->location_name . ' - ' . $s->sub_location_name,
			                        'action' => "<a href='" . route('auditable.view.qr', ['cat' => 'sub', 'id' => $s->id]) . "' class='btn btn-success btn-xs'><i class='fa fa-qrcode'></i> View</a> <a href='' class='btn btn-primary btn-xs'><i class='fa fa-file-download'></i> QR</a>"
			                    ]);
		                    }
	                	}
	                }
	                else {
	                    $data->push([
	                        'name' => $j->location_name,
	                        'action' => "<a href='" . route('auditable.view.qr', ['cat' => 'loc', 'id' => $j->id]) . "' class='btn btn-success btn-xs'><i class='fa fa-qrcode'></i> View</a> <a href='' class='btn btn-primary btn-xs'><i class='fa fa-file-download'></i> QR</a>"
	                    ]);
	                }
                }
            }
            return DataTables::of($data)
                    ->rawColumns(['action'])
                    ->make(true);
    	}
    	return view('includes.common.auditable.index', ['system' => $this->system()]);
    }


    /**
     * Auditable View QR
     */
    public function viewQr($cat, $id)
    {
    	// Validate
    	if($cat == 'sub') {
    		$auditable = SubLocation::where('id', $id)
    							->where('active', 1)
    							->where('is_deleted', 0)
    							->first();
    		$name = $auditable->location->location_name . ' - ' . $auditable->sub_location_name;
    	}
    	elseif($cat == 'loc') {
    		$auditable = Location::where('id', $id)
    							->where('active', 1)
    							->where('is_deleted', 0)
    							->first();
    		$name = $auditable->location_name;
    	}
    	else {
    		return abort(500);
    	}

    	$qrname = $cat . '-' . $id . '.svg';

    	// Create
    	QrCode::size(300)->format('svg')->generate(route('audit', ['cat' => $cat, 'id' => $id]), public_path('uploads/qr/' . $qrname));

    	// Show
    	return view('includes.common.auditable.view-qr', ['qrname' => $qrname, 'name' => $name, 'system' => $this->system()]);
    }


    /**
     * Auditable Download QR
     */
    public function downloadQr($cat, $id)
    {
    	// Validate
    	if($cat == 'sub') {

    	}
    	elseif($cat == 'loc') {

    	}
    	else {
    		return abort(500);
    	}

    	// Create

    	// Download
    }
}
