<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;

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
    		'email' => 'required|email',
    		'password' => 'required'
    	]);

    	if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'active' => 1])) {
            $user = User::where('email', $request['email'])->firstOrFail();

            $token = $user->createToken('auth_token')->plainTextToken;

            response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);

            switch (Auth::user()->role_id) {
                case 1;
                return redirect()->route('admin.dashboard')->with('success', 'Welcome Back!');
                break;
                case 2;
                return redirect()->route('admin.dashboard')->with('success', 'Welcome Back!');
                break;
                case 3;
                return redirect()->route('vp.dashboard')->with('success', 'Good Day!');
                break;
                case 4;
                return redirect()->route('divhead.dashboard')->with('success', 'Good Day!');
                break;
                case 5;
                return redirect()->route('manager.dashboard')->with('success', 'Good Day!');
                break;
                case 6;
                return redirect()->route('supervisor.dashboard')->with('success', 'Good Day!');
                break;
                case 7;
                return redirect()->route('officer.dashboard')->with('success', 'Good Day!');
                break;
                case 8;
                return redirect()->route('user.dashboard')->with('success', 'Good Day!');
                break;
            }
    		
    	}

    	return redirect()->route('login')->with('error', 'Invalid Credentials!');
    }


    /**
     * Login Page for Admin
     */
    public function adminLogin()
    {
    	return view('admin_login', ['system' => $this->system()]);
    }


    /**
     * Post Login for Admin
     */
    public function postAdminLogin(Request $request)
    {
    	$request->validate([
    		'email' => 'required|email',
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
            $user = Auth::user();
            $user->tokens()->delete();
            Auth::logout();
            return redirect()->route('login')->with('success', 'Logout Success!');
        }

        return redirect()->route('login')->with('error', 'Hey!');    	
    }
    
}
