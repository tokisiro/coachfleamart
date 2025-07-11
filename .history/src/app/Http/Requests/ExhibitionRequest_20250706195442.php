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
            'image' => 'required|mimes:jpeg,png',
            'product_name' => 'required',
            'explanation' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'situation' => 'required|string',
            'category_ids' => 'required', // 商品カテゴリー
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
        'situation.string' => '商品の状態は文字列で入力してください。',

        'category_ids.required' => 'カテゴリーを選択してください。',
        ];
    }
}
