<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Nice;
use App\Models\Product_Category;
use App\Models\Product_Comment;
use App\Models\Product;
use App\Models\User_Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MartController extends Controller
{
    public function buy(){
        return view('buy');
    }

    public function create(Request $request){
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        // ここで登録後にプロフィール入力画面に遷移
        auth()->login($user); // ログインさせる場合
        return redirect()->route('setting.edit'); //後述
    }

    //プロフィール設定画面表示
    public function edit()
    {
        $user = Auth::user();
        return view('setting', compact('user'));
    }

    //ユーザー住居情報登録
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'post_code' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'building' => 'nullable|string|max:255',
            'icon' => 'nullable',
        ]);

        $user->update($validated);

        // 商品一覧の取得（例：販売中の商品）
        $products = Product::where('status', '販売中')->get();
        return view('product'compact('products'));
    }

}