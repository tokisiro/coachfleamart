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

class MartController extends Controller
{
    public function buy(){
        return view('buy');
    }

    public function create(Request $request){
        $form = $request->all();
        User::create($form);
        return redirect('/mypage/profile');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'postal_code' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'building' => 'nullable|string|max:255',
        ]);

        $user->update($validated);

        return redirect()->route('profile.edit')->with('status', 'プロフィール更新しました！');
    }

}