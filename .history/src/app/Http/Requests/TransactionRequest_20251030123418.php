<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
            'message' => 'required|max:400',
            'image' => 'mimes:jpeg,png',
        ];
    }


    public function messages()
    {
    return [
        'message.required' => '本文を入力してください',
        'message.max' => '「.png」「」',
        'image.mimes' => ''
        ];
    }
}
