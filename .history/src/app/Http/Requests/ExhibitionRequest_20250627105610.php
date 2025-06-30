<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'image' => 'mimes:jpeg,png',
            'brand_name' => 'nullable',
            'product_name' => 'required',
            'situation' => 'nullable',
            'explanation' => 'required|max:255',
            'price' => 'required|string|min:0',
            'status' => 'nullable',
        ];
    }
}
