<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'role' => 'required|min:1|max:4',
            'password' => 'required',
            'farms' => 'required'
        ];
    }


    public function messages()
    {
        return [
            'first_name.required' => 'First Name is Required',
            'last_name.required' => 'Last Name is Required',
            'email.required' => 'Email is Required and Must be a Valid Email Address',
            'email.email' => 'Email is Required and Must be a Valid Email Address',
            'password.required' => 'Password is Required',
            'farms.required' => 'Farm is Required'
        ];
    }
}
