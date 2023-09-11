<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItemRequest extends FormRequest
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
        //ဒါကသူက request() ပဲခေါ်လိုက် ရင် Illuminate/Http/Request ထွက်မှာကို item ဆိုရင်က App/Models/Item ထွက်လာတယ် အဲ့ကနေ id ပြန်ခေါ်တာ
        //request()->item may return a separate model object (App\Models\Item)

        // dd($id=request()->item->id);
        $id=request()->item->id;
            return [
            //unique => table name, the column name, and an optional parameter=except အဲ့ id ရဲ့ name ကိုထည့်မစစ်တော့တာ တခြား id တွေရဲ့ name နဲ့တူရင်မရဘူး
                "name"=> "required|min:3|max:50|unique:items,name,$id",
                "price" => "required|numeric|gte:50",
                "stock" => "required|numeric|gte:5"

                ];

    }


}
