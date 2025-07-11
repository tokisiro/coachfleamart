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
        'image.required' => '商品画像をアップロードしてください。',
        'image.mimes' => '画像の形式はJPEGまたはPNGを選択してください。',

        'product_name.required' => '商品名を入力してください。',

        'explanation.required' => '商品の説明を入力してください。',
        'explanation.max' => '商品の説明は255文字以内で入力してください。',

        'price.required' => '販売価格を入力してください。',
        'price.numeric' => '販売価格は数値で入力してください。',
        'price.min' => '販売価格は0以上の数字で入力してください。',

        'situation.required' => '商品の状態を選択してください。',

        'category_ids.required' => 'カテゴリーを選択してください。',
        ];
    }
}
