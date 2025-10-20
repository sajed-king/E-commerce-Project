<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
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
            'name_en'=>['required','string'],
            'description_en'=>['required','string'],
            'price'=>['required','digits_between:0,10'],
            'amount'=>['required','digits_between:0,10'],
            'image'=>['image','required','mimes:jpeg,png,gif,webp'], 
            'package_insert' => ['required','file','mimes:pdf','max:2048'],
   
        ];
    }
}
