<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Audit;

class DataController extends Controller
{
	/*
	 * Returns the count of to review audit
	 */
    public function getToReview()
    {
    	$audit_count_to_review = Audit::where('reviewed', 0)->count();

    	return $audit_count_to_review;
    }
}
