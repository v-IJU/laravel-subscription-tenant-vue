<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
            "parent_first_name" => "required",
            "parent_last_name" => "required",
            "parent_email" => "required|email",
            "parent_phone" => "required",
            "child_first_name" => "required",
            "child_last_name" => "required",
            "school_id" => "required",
            "class_id" => "required",
            "gender" => "required",
        ];
    }
}
