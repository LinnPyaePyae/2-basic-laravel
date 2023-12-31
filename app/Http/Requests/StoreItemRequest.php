<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    public function authorize(): bool
    {
        return true;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
        "name"=> "required|min:3|max:50|unique:items,name",
        "price" => "required|numeric|gte:50",
        "stock" => "required|numeric|gt:3"

        ];

    }

    public function messages()
    {
        return [
            "name.required"=>"please enter name",
            "name.min"=>"at least 3 letters"
        ];
    }

}
