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
    public function buy($product){

        $user = auth()->user();

        $detail = Product::findOrFail($product);

    // 必要な情報だけを取り出す
    $post_code = $user->post_code;
    $address = $user->address;
    $building = $user->building;

    // ビューに渡す
    return view('buy', [
        'post_code' => $post_code,
        'address' => $address,
        'building' => $building,
        'detail' => $detail,
        'user' => $user,
    ]);
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

    //いいね機能
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
    return redirect('/item/' . $productId);
}

//コメント追加機能 未実装
    public function comment(Request $request)
    {
        // 入力値を直接取得
        $product_id = $request->input('product_id');
        $content = $request->input('content');

        // ユーザIDを追加
    $user_id = Auth::id();

    // 直接作成（入力値に誤りがあってもエラーにならない）
    ProductComment::create([
        'user_id' => $user_id,
        'product_id' => $product_id,
        'content' => $content,
    ]);

    // 商品IDを使ってリダイレクト
    return redirect('/item/' . $product_id);
}
}