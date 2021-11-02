<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuditItemRequest extends FormRequest
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
            'audit_name' => 'required',
            'audit_item_name' => 'required',
            'time_range' => 'required',
            'locations' => 'required',
        ];
    }


    public function messages()
    {
        return [
            'audit_name.required' => 'Audit Name is Required',
            'audit_item_name.required' => 'Audit Item Name is Required',
            'time_range' => 'Time Range is Required',
            'locations.required' => 'Location is Required',
        ];
    }
}
