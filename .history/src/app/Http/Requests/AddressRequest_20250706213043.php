<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'name' => 'required',
            'post_code' => 'required|regex:/^\d{4}-\d{4}$/',
            'address' => 'required',
            'building' => 'required',
        ];
    }

    public function messages(){
        return[
        'name.required' => '名前を入力してください。',

        'post_code.required' => '郵便番号を入力してください。',
        'post_code.regex' => 'ハイフンを含めた8文字以内。',

        'price.required' => '販売価格を入力してください。',
        'price.numeric' => '販売価格は数値で入力してください。',
        'price.min' => '販売価格は0以上の数字で入力してください。',

        'situation.required' => '商品の状態を選択してください。',

        'category_ids.required' => 'カテゴリーを選択してください。',
        ];
    }
}
