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
        $user = Auth::user();

        // 既に設定している場合はトップにリダイレクト
        if ($user->post_code && $user->address && $user->building) {
            return redirect('/');
        }

        return view('profile.', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'post_code' => 'required|string|max:20',
            'address' => 'required|string',
            'building' => 'nullable|string',
        ]);

        $user->update($validated);

        return redirect('/home');
    }
}
