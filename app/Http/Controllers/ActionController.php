<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActionController extends Controller
{
    // Location Action 
    public static function locationAction($id, $name)
    {
    	return "<button id='edit' class='btn btn-primary btn-xs' data-text='Do you want to edit " . $name . "?' data-id='" . $id . "'><i class='fa fa-pen'></i></button> <button id='remove' class='btn btn-danger btn-xs' data-text='Do you want to remove " . $name . "?' data-id='" . $id . "'><i class='fa fa-trash'></i></button>";
    }
}
