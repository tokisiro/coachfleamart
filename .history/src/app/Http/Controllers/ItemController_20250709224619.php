<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\ExhibitionRequest;
use App\Http\Requests\CommentRequest;
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
use Illuminate\Support\Facades\DB;
use Laravel\Fortify\Http\Controllers;
use Laravel\Fortify\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Storage;


class ItemController extends Controller
{
    
    //商品購入ページ表示
    public function buy($product){

        $user = auth()->user();

        $detail = Product::findOrFail($product);

        $post_code = $user->post_code;
        $address = $user->address;
        $building = $user->building;

        return view('buy', [
            'post_code' => $post_code,
            'address' => $address,
            'building' => $building,
            'detail' => $detail,
            'user' => $user,
        ]);
    }


    //初回プロフィール設定画面表示
    public function edit()
    {
        $user = Auth::user();
        return view('address', compact('user'));
    }

    //プロフィールアイコン登録 バリデーション調整中
    public function Replacement(ProfileRequest $request)
        {
        $user = Auth::user();


        // 画像ファイルの処理
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');

        // 画像を保存場所に保存（例：publicのstorage）
        $path = $file->store('icons', 'public'); //例：storage/app/public/icons/xxxxx.png

        if ($user->icon) {
            Storage::disk('public')->delete($user->icon);
        }

        // アイコンのパスを保存
        $user->icon = $path;
        $user->save();
        }

        return redirect('/mypage/profile');
    }



    //商品詳細ページ表示
    public function detail($product){

        // 商品詳細を取得
        $detail = Product::with(['categories', 'comments.user', 'nices'])->findOrFail($product);
        // comments()リレーションに対してuser()をロード（既に書いてある通り）

        $comments = $detail->comments;

        // コメント件数
        $commentsCount = $detail->comments->count();
        // いいね総件数
        $niceCount = $detail->nices->count();

        // 現在のユーザがいいねしているか
        $hasNice = false;
        if (auth()->check()) {
        $hasNice = $detail->nices()->where('user_id', auth()->id())->exists();
        }

        // カテゴリ名を取得（複数の場合も対応）
        $categoriesArray = $detail->categories->pluck('category')->toArray();

        // 商品のstatusも取得済みと仮定（`status`カラムが存在）
        $situation = $detail->situation;

        return view('detail', compact(
            'detail',
            'comments',
            'commentsCount',
            'niceCount',
            'hasNice',
            'categoriesArray',
            'situation'       // 商品のステータス
        ));
        }

    //商品一覧ページ表示
    public function list(Request $request){

        $tab = $request->query('tab', 'recommendation'); // デフォルトはrecommendation
        $searchTerm = $request->query('query', '');
        $userId = Auth::id();

        // 検索条件
        $searchQuery = '%' . $searchTerm . '%';

        if ($tab === 'mylist') {
        // マイリスト
        $liked_products = Product::whereIn('id', function($query) use ($userId) {
            $query->select('product_id')->from('nices')->where('user_id', $userId);
        })->when($searchTerm != '', function($query) use ($searchQuery) {
            $query->where('product_name', 'LIKE', $searchQuery);
        })->get();

        $products = []; // 推奨は空もしくは別に取得
        // 購入済み
        $purchasedProductIds = \App\Models\UserProduct::where('user_id', $userId)
            ->pluck('product_id')
            ->toArray();

        foreach ($liked_products as $product) {
            $product->isSold = in_array($product->id, $purchasedProductIds);
            $product->isSoldOut=($product->status === 'sold');
        }

        return view('product', [
            'products' => [],
            'liked_products' => $liked_products,
            'mode' => 'liked',
            'searchTerm' => $searchTerm
            ]);
        } else {

        // おすすめ
        $products = Product::where('user_id', '<>', $userId)
        ->when($searchTerm != '', function($query) use ($searchQuery) {
            $query->where('product_name', 'LIKE', $searchQuery);
        })->get();

        $purchasedProductIds = \App\Models\UserProduct::where('user_id', $userId)
            ->pluck('product_id')
            ->toArray();

        foreach ($products as $product) {
            $product->isSold = in_array($product->id, $purchasedProductIds);
            $product->isSoldOut=($product->status === 'sold');
        }

        return view('product', [
            'products' => $products,
            'liked_products' => [],
            'mode' => 'recommendation',
            'searchTerm' => $searchTerm
        ]);
        }

    }

    //コメント追加機能
    public function comment(CommentRequest $request){
        if (!Auth::check()) {
            // ログインしていなかったらリダイレクトやエラー
            return redirect('/login');
        }

        $product_id = $request->input('product_id');
        $content = $request->input('content');
        $user_id = Auth::id();

        ProductComment::create([
            'user_id' => $user_id,
            'product_id' => $product_id,
            'content' => $content,
        ]);

        return redirect('/item/' . $product_id);
    }

    //購入機能
    public function purchase(PurchaseRequest $request,$product){
        $userId = auth()->id();

        $shippingAddress = $request->input('shipping_address');
        $postCode = $request->input('post_code');
        $building = $request->input('building');

        DB::transaction(function () use ($userId, $product, $shippingAddress, $postCode, $building) {
        DB::table('user_products')->insert([
            'product_id' => $product,
            'user_id' => $userId,
            'post_code' => $postCode,
            'shipping_address' => $shippingAddress,
            'building' => $building,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('products')->where('id', $product)->update([
            'status' => 'sold',
        ]);
        });
        return redirect('/');
    }


    //マイページ画面表示
    public function profile(Request $request){

        $tab = $request->query('tab', 'sell');
        $user = Auth::user();

        if ($tab === 'buy') {
        // 購入した商品
        $purchasedProducts = $user->userProducts()->with('product')->get()->pluck('product');
        $listedProducts = [];
        $mode = 'buy';

        return view('profile', [
            'purchasedProducts' => $purchasedProducts,
            'listedProducts' => $listedProducts,
            'mode' => 'buy',
            'user' => $user
        ]);

        } else {

        // 出品商品
        $listedProducts = Product::where('user_id', $user->id)
        ->get();
        $purchasedProducts = [];
        $mode = 'sell';

        return view('profile', [
            'purchasedProducts' => $purchasedProducts,
            'listedProducts' => $listedProducts,
            'mode' => 'sell',
            'user' => $user
        ]);
        }
    }

    //出品画面表示
    public function sell(){

        $user = auth()->user();

        return view('sell',compact('user'));
    }

    //出品機能
    public function sale(ExhibitionRequest $request){

        $form = $request->all();

        // 画像の保存
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage'), $filename);
            $form['image'] = 'storage/' .$filename;
        } else {
            $form['image'] = null;
        }

        // トランザクションを利用して確実に保存
        \DB::transaction(function () use ($form) {
        // 商品登録
        $product = new product();
        $product->user_id = auth()->id(); // 出品者ID
        $product->product_name = $form['product_name'];
        $product->brand_name = $form['brand_name'];
        $product->explanation = $form['explanation'];
        $product->price = $form['price'];
        $product->situation = $form['situation'];
        $product->image = $form['image'];
        $product->status = '販売中'; // 初期状態
        $product->save();

        // カテゴリー登録（複数選択の対応）
        if (isset($form['category_ids']) && is_array($form['category_ids'])) {
            foreach ($form['category_ids'] as $categoryName) {
                $category = \DB::table('categories')->where('category', $categoryName)->first();
                if (!$category) {
                    $categoryId = \DB::table('categories')->insertGetId([
                        'category' => $categoryName,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } else {
                    $categoryId = $category->id;
                }

                \DB::table('product_categories')->insert([
                    'product_id' => $product->id,
                    'category_id' => $categoryId,
                ]);
            }

        }
        });
        return redirect('/');
    }

    //いいね機能
    public function toggleNice($productId){

        $userId = Auth::id();

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

    //初回住所情報登録機能
    public function update(AddressRequest $request)
    {
        $user = Auth::user();

        $address = $request->all();

        unset($address['_token']);
        $user->update($address);

        return redirect('/');
    }

    //配送先住所変更機能
    public function renawal(Request $request)
    {
        $user = Auth::user();

        $address = $request->all();

        unset($address['_token']);
        $user->update($address);

        return redirect('');
    }

    //配送先住所変更ページ表示
    public function modification()
    {
        $user = Auth::user();
        return view('sending', compact('user'));
    }
}

