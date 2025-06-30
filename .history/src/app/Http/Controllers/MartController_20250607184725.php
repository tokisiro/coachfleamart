<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Nice;
use App\Models\Product_Category;
use App\Models\Product_Comment;
use App\Models\Product;
use App\Models\User_Product;
use App\Models\User;
use Illuminate\Http\Request;

class MartController extends Controller
{
    public function product()
    {
    return view('product');
    }

    public function sell()
    {
    return view('sell');
    }

    public function profile()
    {
    return view('profile');
    }

    public function register(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:6',
    ]);

    $user = \App\Models\User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
    ]);

    // 登録後、プロフィール設定ページへリダイレクト
    return redirect()->route('profile')->with('user_id', $user->id);
}

    public function showProfileForm()
{
    $userId = session('user_id'); // セッションから取得
    $user = \App\Models\User::find($userId);
    return view('profile.edit', compact('user'));
}
}
