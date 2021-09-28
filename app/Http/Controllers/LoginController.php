<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

// use App\Http\Controllers\LogController;

class LoginController extends Controller
{
	/**
	 * Login Page for User
	 */
    public function login()
    {
    	return view('login');
    }


    /**
     * Post Login Function for User
     */
    public function postLogin(Request $request)
    {
    	$request->validate([
    		'email' => 'required',
    		'password' => 'required'
    	]);

    	if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'active' => 1, 'role_id' => 3])) {
    		// return redirect()->route('user.dashboard')->with('success', 'Welcome to Sales and Marketing Dashboard!');
    		// $ip = LogController::getIPAddress2();
            // LogController::log(Auth::user()->id, 'Login');
    		return redirect()->route('user.dashboard')->with('success', 'Good Day!');
    	}
        elseif(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'active' => 1, 'role_id' => 4])) {
            // return redirect()->route('user.dashboard')->with('success', 'Welcome to Sales and Marketing Dashboard!');
            // $ip = LogController::getIPAddress2();
            // LogController::log(Auth::user()->id, 'Login');
            return redirect()->route('emp.dashboard')->with('success', 'Good Day!');
        }

    	return redirect()->route('login')->with('error', 'Invalid Credentials!');
    }


    /**
     * Login Page for Admin
     */
    public function adminLogin()
    {
    	return view('admin_login');
    }


    /**
     * Post Login for Admin
     */
    public function postAdminLogin(Request $request)
    {
    	$request->validate([
    		'email' => 'required',
    		'password' => 'required'
    	]);

    	if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'active' => 1, 'role_id' => [1,2]])) {
    		return redirect()->route('admin.dashboard')->with('success', 'Welcome!');
    	}

    	return redirect()->route('login')->with('error', 'Invalid Credentials!');
    }




    /**
     * Logout Function for All Users
     */
    public function logout()
    {
        if(Auth::user()) {
            // LogController::log(Auth::user()->id, 'Logout');
            Auth::logout();
            return redirect()->route('login')->with('success', 'Logout Success!');
        }

        return redirect()->route('login')->with('error', 'Hey!');    	
    }
    
}
