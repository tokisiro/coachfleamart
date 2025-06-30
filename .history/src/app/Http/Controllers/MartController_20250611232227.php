<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Nice;
use App\Models\ProductCategory;
use App\Models\ProductComment;
use App\Models\Product;
use App\Models\UserProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MartController extends Controller
{
    public function buy(){
        return view('buy');
    }

    //ユーザー情報登録機能
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

        // 既存のコードに追加
        $liked_products = Product::whereIn('id', function($query) {
        $query->select('product_id')
            ->from('nices')
            ->where('user_id', Auth::id());
        })->where('status', '販売中')->get();

        return view('product',compact('products','liked_products'));
    }

    //商品詳細ページ表示
    public function detail($product){

        $detail = Product::findOrFail($product);
        // 商品に紐づくコメントを取得
        $comments = $detail->comments()->with('user')->get();
        // ※Eloquentリレーションを定義している前提

        // コメント件数
        $commentsCount = $comments->count();

        // いいね総件数
        $niceCount = $detail->nices()->count();

        // 現在のユーザがいいねしてるかどうか
        $hasNice = false;
        if (auth()->check()) {
        $hasNice = $detail->nices()->where('user_id', auth()->id())->exists();
    }

        return view('detail',compact('detail','comments','commentsCount',
        'niceCount',
        'hasNice'));
    }

    //商品一覧ページ表示
    public function list(){
    // 商品一覧の取得（例：販売中の商品）
    $products = Product::where('status', '販売中')->get();

    // 既存のコードに追加
    $liked_products = Product::whereIn('id', function($query) {
    $query->select('product_id')
        ->from('nices')
        ->where('user_id', Auth::id());
    })->where('status', '販売中')->get();

    return view('product',compact('products','liked_products'));
    }

    //いいね機能 調整中
    public function toggleNice($productId)
{
    $userId = auth()->id();

    if (!$userId) {
        return redirect()->route('login'); // 未ログインの場合はログインページへ
    }

    $nice = Nice::where('user_id', $userId)
                ->where('product_id', $productId)
                ->first();

    if ($nice) {
        // 既にいいねしている場合は解除
        $nice->delete();
    } else {
        // いいね登録
        Nice::create([
            'user_id' => $userId,
            'product_id' => $productId,
        ]);
    }

    // いいね数を取得
    $niceCount = Product::find($productId)->nices()->count();

    // 商品詳細ページにリダイレクト
    return redirect()->route('product.detail', ['product' => $productId]);
}

public function comment(Request $request){
    $comment = $request->all();
    
}
}