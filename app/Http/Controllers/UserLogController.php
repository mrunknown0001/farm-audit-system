<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\UserLog;

class UserLogController extends Controller
{
    // User Log
    public static function log($action = NULL, $table = NULL, $url = NULL, $data1 = NULL, $data2 = NULL, $data3 = NULL)
    {
    	$log = new UserLog();
    	$log->user_id = Auth::user()->id;
    	$log->action = $action;
    	$log->table = $table;
    	$log->url = $url;
    	$log->data1 = $data1;
    	$log->data2 = $data2;
    	$log->data3 = $data3;
    	$log->save();
    }
}
