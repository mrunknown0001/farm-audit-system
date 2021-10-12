<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Auth;

class SubLocationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'location_name' => 'required',
            'sub_location_name' => 'required',
            'sub_location_code' => 'required|unique:sub_locations'
        ];
    }


    public function messages()
    {
        return [
            'location_name.required' => 'Location Name is Required!',
            'sub_location_name.required' => 'Sub Location Name is Required!',
            'sub_location_code.required' => 'Sub Location Code is Required!',
            'sub_location_code.unique' => 'Sub Location Code must be unique! Duplicate Sub Location Code Found!'
        ];
    }
}
