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
            'image' => 'required|image|mimes:jpeg,png',
            'product_name' => 'required|string|max:255',
            'situation' => 'required|string',
            'explanation' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'status' => 'required',
        ];
    }
}
