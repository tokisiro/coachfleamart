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
            'image.required' => '画像を選択してください',
            'image.mimes' => 'アップロードされたファイルは画像形式（JPEGまたはPNG）でなければなりません。',
            'image.mimes' => '画像はJPEGまたはPNG形式のファイルを使用してください。',
            'product_name.required' => '商品名を入力してください',
            '' 
        ];
    }
}
