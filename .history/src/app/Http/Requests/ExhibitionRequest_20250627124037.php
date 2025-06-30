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
            'explanation' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'situation' => 'required|string',
            'category_ids' => 'required|array', // 商品カテゴリー
            'category_ids.*' => 'required|exists:categories,id',
            'brand_name' => 'nullable'
        ];
    }

    public function messages(){
        return[
        'image.required' => '商品画像をアップロードしてください。',
        'image.image' => 'アップロードされたファイルは画像形式（JPEGまたはPNG）でなければなりません。',
        'image.mimes' => '画像の形式はJPEGまたはPNGを選択してください。',

        'product_name.required' => '商品名を入力してください。',
        'product_name.string' => '商品名は文字列で入力してください。',
        'product_name.max' => '商品名は255文字以内で入力してください。',
        
        'explanation.required' => '商品の説明を入力してください。',
        'explanation.string' => '商品の説明は文字列で入力してください。',
        'explanation.max' => '商品の説明は255文字以内で入力してください。',
        
        'price.required' => '販売価格を入力してください。',
        'price.numeric' => '販売価格は数値で入力してください。',
        'price.min' => '販売価格は0以上の数字で入力してください。',
        
        'situation.required' => '商品の状態を選択してください。',
        'situation.string' => '商品の状態は文字列で入力してください。',
        
        'category_ids.required' => 'カテゴリーを選択してください。',
        'category_ids.array' => 'カテゴリーは複数選択可能です。',
        'category_ids.*.required' => 'カテゴリーIDが選択されていません。',
        'category_ids.*.exists' => '選択されたカテゴリーは存在しません。',
        ];
    }
}
