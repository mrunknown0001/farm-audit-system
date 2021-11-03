<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Audit;
use App\ReviewerNotification;

class ReviewerNotificationController extends Controller
{
    public function notif(Request $request)
    {
    	if($request->ajax()) {
    		// check new audit with the reviewer
    		$review = Audit::where('done', 1)->orderBy('created_at', 'desc')->first();

    		if(!empty($review)) {
	    		$check = ReviewerNotification::where('audit_id', $review->id)
	    								->where('user_id', Auth::user()->id)
	    								->first();

	    		if(empty($check)) {
	    			$not = new ReviewerNotification();
	    			$not->audit_id = $review->id;
	    			$not->user_id = Auth::user()->id;
	    			$not->save();

	    			return response()->json([
	    				'id' => 1,
	    				'auditor' => $review->auditor->first_name . ' ' . $review->auditor->last_name
	    			]);
	    		}

	    	}

    		return null;

    	}
    }
}
