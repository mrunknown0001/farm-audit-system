<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

class ActionController extends Controller
{
    // Location and Sub Location Action 
    public static function locationAction($id, $name)
    {
    	if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {
	    	return "<button id='edit' class='btn btn-warning btn-xs' data-text='Do you want to edit " . $name . "?' data-id='" . $id . "'><i class='fa fa-edit'></i> Edit</button> <button id='remove' class='btn btn-danger btn-xs' data-text='Do you want to remove " . $name . "?' data-id='" . $id . "'><i class='fa fa-trash'></i> Remove</button>";
    	}
    	else {
    		return "<button id='edit' class='btn btn-warning btn-xs' data-text='Do you want to edit " . $name . "?' data-id='" . $id . "'><i class='fa fa-edit'></i> Edit</button>";
    	}
    }

}
