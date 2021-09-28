<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\EmployeeLog;
use DB;
use Auth;

class GeneralController extends Controller
{
    /**
     * Get Location
     */
    public static function getLocation($lat, $lon, $id)
    {
    	// Latlon.net
    	// $action = "<a href='https://www.latlong.net/c/?lat=" . $lat . "&long=" . $lon . "' target='_blank'>Location</a>";
    	//<a href='" . route('user.map.location', ['lat' => $lat, 'lon' => $lon]) . "'>Maps</a>
    	// google search :)
    	// $action = "<a href='https://www.google.com/search?q=" . $lat . "%2C+" . $lon . "' target='_blank'>Location</a>";
        if(Auth::user()->role_id == 3) {
            $action = "<a href='" . route('user.map.location', ['id' => $id]) . "'>Maps</a>";
        }
        else {
            $action = "<a href='https://www.google.com/search?q=" . $lat . "%2C+" . $lon . "' target='_blank'>Location</a>";
        }

    	return $action;
    }



    public static function showLogs($id)
    {
        $action = '<a href="' . route('user.show.emp.log', $id) . '">Show Logs</a>';

        return $action;
    }



    /**
     * Time in and out 
     */
    public static function punchType($id)
    {
    	$log = EmployeeLog::where('user_id', $id)
    					->whereDate('created_at', DB::raw('CURDATE()'))
    					->first();

    	if(empty($log)) {
    		return 'In';
    	}
    	else {
    		return 'Out';
    	}

    }


    /**
     * Admin User Action
     */
    public static function adminUserAction($id, $name)
    {
        return "<button id='updateuser' data-id='" . $id . "' data-text='Do you want to update user: " . $name . "?' class='btn btn-info btn-xs'><i class='fa fa-pen'></i> Update</button>";
    }


    public static function getUserType($type)
    {
        if($type == 1) {
            return "Super Admin";
        }
        else if($type == 2) {
            return "Admin";
        }
        else if ($type == 3) {
            return "Manager";
        }
        else {
            return 'Employee';
        }
    }



    public static function getFirstName($id)
    {
        $user = User::find($id);
        return strtoupper($user->first_name);
    }

    public static function getLastName($id)
    {
        $user = User::find($id);
        return strtoupper($user->last_name);
    }













    public function qr()
    {
        return view('qr');
    }
}
