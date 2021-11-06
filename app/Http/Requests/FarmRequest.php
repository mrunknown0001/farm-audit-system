<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class FarmRequest extends FormRequest
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
        else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'farm_name' => 'required',
            'farm_code' => 'required|unique:users'
        ];
    }


    public function messages()
    {
        return [
            'farm_name.required' => 'Farm Name is Required',
            'farm_code.required' => 'Farm Code is Required',
            'farm_code.unique' => 'Farm Code Exists',
        ];
    }
}
