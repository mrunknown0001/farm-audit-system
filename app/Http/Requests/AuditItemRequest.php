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
            'from_hour' => 'required',
            'from_minute' => 'required',
            'to_hour' => 'required',
            'to_minute' => 'required',
            'locations' => 'required',
        ];
    }


    public function messages()
    {
        return [
            'audit_name.required' => 'Audit Name is Required',
            'audit_item_name.required' => 'Audit Item Name is Required',
            'locations.required' => 'Location is Required',
            'from_hour.require' => 'Start Hour is required',
            'from_minute.required' => 'Start Minute is required',
            'to_hour.required' => 'End Hour is required',
            'to_minute.required' => 'End Minute is required',
            // 'from_hour.numeric' => 'Start Hour must be a number',
            // 'from_minute.numeric' => 'Start Minute must be a number',
            // 'to_hour.numeric' => 'End Hour must be a number',
            // 'to_minute.numeric' => 'End Minute must be a number'
        ];
    }
}
