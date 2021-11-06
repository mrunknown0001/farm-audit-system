<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\EmployeeLog;
use DB;
use Auth;
use App\UserFarm;

class GeneralController extends Controller
{
    # User Role
    public static function getUserType($type)
    {
        if($type == 1) {
            return "Super Admin";
        }
        else if($type == 2) {
            return "Admin";
        }
        else if ($type == 3) {
            return "VP";
        }
        else if ($type == 4) {
            return "Division Head";
        }
        else if ($type == 5) {
            return "Manager";
        }
        else if ($type == 6) {
            return "Supervisor";
        }
        else if ($type == 7) {
            return "Officer";
        }
        else {
            return 'User';
        }
    }


    # First Name
    public static function getFirstName($id)
    {
        $user = User::find($id);
        return strtoupper($user->first_name);
    }

    # Last Name
    public static function getLastName($id)
    {
        $user = User::find($id);
        return strtoupper($user->last_name);
    }


    # User Farms Assigned
    public static function getFarms($id)
    {
        $user = User::find($id);
        if(count($user->uf) > 0) {
            $str = '';
            foreach ($user->uf as $key => $f) {
                $str .= $f->farm->code . '|';
            }

            $str = rtrim($str, '|');
            return $str;
        }
        else {
            return 'No Farm Assigned';
        }
    }


    # Check Farm Assigned
    public static function getAssignedFarm($id, $farm_id)
    {
        $uf = UserFarm::where('user_id', $id)->where('farm_id', $farm_id)->first();

        if(empty($uf)) {
            return false;
        }
        return true;
    }

}
