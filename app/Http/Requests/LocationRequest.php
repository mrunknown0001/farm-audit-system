<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Auth;

class LocationRequest extends FormRequest
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
            'location_name' => 'required|unique:locations',
            'location_code' => 'required|unique:locations',
            'farm' => 'required'
        ];
    }


    public function messages()
    {
        return [
            'location_name.required' => 'Location Name is Required!',
            'location_code.required' => 'Location Code is Required!',
            'farm.required' => 'Farm is Required!',
            'location_name.unique' => 'Location Name must be unique! Duplicate Location Found!',
            'location_code.unique' => 'Location Code must be unique! Duplicate Location Found!'
        ];
    }
}
