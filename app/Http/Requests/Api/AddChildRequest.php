<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AddChildRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "first_name" => "required",
            "last_name" => "required",
            "school_id" => "required",
            "class_id" => "required",
            "gender" => "required",
        ];
    }

    public function messages()
    {
        return [
            'school_id.required' => 'School name is required',
            'class_id.required' => 'Class name is required',
        ];

    }
}
