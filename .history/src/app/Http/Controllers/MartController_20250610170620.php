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

    

    public function update(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'post_code' => 'required|string|max:20',
            'address' => 'required|string',
            'building' => 'nullable|string',
            'icon' => 'nullable|image|max:2048',
        ]);

        // 画像の保存
    if ($request->hasFile('icon')) {
        $file = $request->file('icon')->store('public/icons');
        // 適切な保存先フォルダに保存（例：public/storage/icons）
        $user->icon = str_replace('public/', 'storage/', $path);
    }

    $user = $request->user();

    $user->post_code = $validated['post_code'];
    $user->address = $validated['address'];
    $user->building = $validated['building'] ?? '';

    
        return redirect('/');
    }
}
