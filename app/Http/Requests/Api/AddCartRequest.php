<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AddCartRequest extends FormRequest
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
            "product_id" => "required|exists:products,id",
            "parent_id" => "required|exists:parents,id",
            "child_id" => "required|exists:children,id",
            "school_id" => "required|exists:school_master,id",
            "class_id" => "required|exists:school_class,id",
            "variant_id" => "required|exists:product_variants,id",

            'product_meta' => 'required|array|min:1',

            'product_size' => 'required|string',
            'product_meta' => 'required|array|min:1',
            'product_price' => 'required|numeric|between:0,10000',
            'product_gst_percentage' => 'required|numeric|between:0,100',
            'product_quantity' => 'required|integer|min:1',
        ];

    }
}
