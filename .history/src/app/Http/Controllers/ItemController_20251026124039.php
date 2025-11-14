<?php

namespace App\Http\Controllers;

use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
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
use Illuminate\Support\Facades\DB;
use Laravel\Fortify\Http\Controllers;
use Illuminate\Support\Facades\Storage;


class ItemController extends Controller
{


    //プロフィールアイコン登録
    public function Replacement(ProfileRequest $request)
        {
        $user = Auth::user();


        // 画像ファイルの処理
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');

            $path = $file->store('icons', 'public');

        if ($user->icon) {
            Storage::disk('public')->delete($user->icon);
        }
            $user->icon = $path;
            $user->save();
        }

        return redirect('/mypage/profile');
    }



    //商品詳細ページ表示
    public function detail($product){

        $detail = Product::with(['categories', 'comments.user', 'nices'])->findOrFail($product);

        $comments = $detail->comments;

        $commentsCount = $detail->comments->count();
        $niceCount = $detail->nices->count();

            $hasNice = false;
        if (auth()->check()) {
            $hasNice = $detail->nices()->where('user_id', auth()->id())->exists();
            }

            $categoriesArray = $detail->categories->pluck('category')->toArray();

            $situation = $detail->situation;

        return view('detail', compact(
            'detail',
            'comments',
            'commentsCount',
            'niceCount',
            'hasNice',
            'categoriesArray',
            'situation'
        ));
        }

    //商品一覧ページ表示
    public function list(Request $request){

        $tab = $request->query('page', 'recommendation');
        $searchTerm = $request->query('query', '');
        $userId = Auth::id();

        $searchQuery = '%' . $searchTerm . '%';

        if ($request->query('page') === 'mylist' && !Auth::check()) {
    return redirect()->route('login');
}

        if ($tab === 'mylist') {
            // マイリスト
            $liked_products = Product::whereIn('id', function($query) use ($userId) {
            $query->select('product_id')->from('nices')->where('user_id', $userId);
            })->where('user_id', '<>', $userId)->when($searchTerm != '', function($query) use ($searchQuery) {
            $query->where('product_name', 'LIKE', $searchQuery);
            })->get();

            $products = [];
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


    //stripeを使った購入機能
    public function createCheckoutSession(Request $request)
{
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $productId = $request->input('product_id');
        $paymentMethod = $request->input('payment_method');

        $product = Product::findOrFail($productId);

        $paymentMethodTypes = ['card'];
    if ($paymentMethod === 'コンビニ払い') {
        // Stripeがサポートしている場合、設定
        $paymentMethodTypes = ['konbini']; // 実際にStripeがサポートしているか確認
    }

try {
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => $paymentMethodTypes,
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'jpy',
                        'product_data' => [
                            'name' => $product->product_name,
                        ],
                        'unit_amount' => (int)str_replace(['¥', ','], '', $product->price),
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'metadata' => [
                'product_id' => $product->id,
                'user_id' => auth()->user()->id,
                'address' => $request->input('address'),
                'post_code' => $request->input('post_code'),
                'building' => $request->input('building'),
                'payment-method' => $request->input('payment_method'),
                ],
                'success_url' => route('complete') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('top'),
            ]);
            return response()->json(['checkoutUrl' => $session->url]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
}
}


    //コンビニ決済完了の通知機能
    public function handleWebhook(Request $request)
    {
        \Log::info('Webhook received');
        $payload = $request->getContent();
        // 署名ヘッダー
        $sig_header = $request->header('Stripe-Signature');
        // Stripe設定で取得したWebhook秘密値
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

    try {
        $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
    } catch (\Stripe\Exception\SignatureVerificationException $e) {
        return response()->json(['error' => 'Invalid signature'], 400);
        } catch (\Exception $e) {
        \Log::error('Webhook parse error: '.$e->getMessage());     // パースエラーをログに記録
        return response()->json(['error' => 'Webhook parse error'], 400);
    }

    // イベントタイプに応じて処理
    if ($event->type === 'checkout.session.completed') {
        $session = $event->data->object;

        $metadata = $session->metadata ?? [];
        $product_id = $metadata['product_id'] ?? null;
        $user_id = $metadata['user_id'] ?? null;

        if ($product_id && $user_id) {
            // 購入履歴登録または更新
            \DB::table('user_products')->updateOrInsert(
                ['product_id' => $product_id, 'user_id' => $user_id],
                [
                    // 追加情報
                    'post_code' => $metadata['post_code'] ?? '',
                    'address' => $metadata['address'] ?? '',
                    'building' => $metadata['building'] ?? '',
                    'updated_at' => now()
                ]
            );

            \DB::table('products')->where('id', $product_id)->update([
                'status' => 'sold',
                'updated_at' => now()
            ]);
        }
        return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'ignored']);
    }


    //カード払い購入履歴更新機能
    public function complete(Request $request)
{
    $paymentMethod = '';
            $sessionId = $request->query('session_id');
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $session = \Stripe\Checkout\Session::retrieve($sessionId);
            $paymentMethod = $session->metadata->{'payment-method'} ?? '';

        $userId = auth()->id();
            $productId = $session->metadata->product_id ?? null;

            $address = $session->metadata->address ?? '';
            $post_code = $session->metadata->post_code ?? '';
            $building = $session->metadata->building ?? '';

            $product = Product::find($productId);

            DB::transaction(function () use (
                $userId,
                $productId,
                $address,
                $post_code,
                $building,
                $product
            ) {
            DB::table('user_products')->insert([
                'product_id' => $productId,
                'user_id' => $userId,
                'post_code' => $post_code,
                'address' => $address,
                'building' => $building,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('products')->where('id', $productId)->update([
                'status' => 'sold',
            ]);
        });
        return redirect('/');
}

    //マイページ画面表示
    public function profile(Request $request)
    {
        $mode = $request->query('page', 'sell');
        $user = Auth::user();
dd($mode);
        // 全てのタブで必要な変数を初期化
        $listedProducts = collect();
        $purchasedProducts = collect();
        $transactionProducts = collect();

        if ($mode === 'buy') {
            $purchasedProducts = $user->userProducts()->with('product')->get()->pluck('product');

        } elseif ($mode === 'transaction') {
            // 取引中の商品
            $transactionProducts = Product::where(function ($query) use ($user) {
                $query->where('user_id', $user->id) // 自分が「出品者」の場合
                      ->orWhere('consider_id', $user->id); // 自分が「購入者」の場合
            })
            ->where('status', '取引中')
            ->get();

        } else {
            $listedProducts = Product::where('user_id', $user->id)
            ->get();
        }

        return view('profile', [
            'purchasedProducts' => $purchasedProducts,
            'listedProducts' => $listedProducts,
            'transactionProducts' => $transactionProducts,
            'mode' => '$mode',
            'user' => $user
            ]);
    }

    //出品画面表示
    public function sell(){

        $user = auth()->user();

        return view('sell',compact('user'));
    }

    //出品機能
    public function sale(ExhibitionRequest $request){

        $form = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage'), $filename);
            $form['image'] = 'storage/' .$filename;
        } else {
            $form['image'] = null;
            }

        \DB::transaction(function () use ($form) {

        $product = new product();
        $product->user_id = auth()->id();
        $product->product_name = $form['product_name'];
        $product->brand_name = $form['brand_name'];
        $product->explanation = $form['explanation'];
        $product->price = $form['price'];
        $product->situation = $form['situation'];
        $product->image = $form['image'];
        $product->status = '販売中';
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
                    \DB::table('product_categories')    ->insert([
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
            return redirect()->route('login');
        }

        $nice = Nice::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($nice) {
            $nice->delete();
        } else {
            Nice::create([
                'user_id' => $userId,
                'product_id' => $productId,
            ]);
        }

        // いいね数を取得
        $niceCount = Product::find($productId)->nices()->count();

        return redirect('/item/' . $productId);
    }

    //初回プロフィール設定画面表示
    public function edit()
    {
        $user = Auth::user();
        return view('address', compact('user'));
    }

    //初回住所情報登録機能兼プロフィール変更機能
    public function information(AddressRequest $request)
    {
        $user = Auth::user();

        $address_value = $user->address;
        $address = $request->all();

        unset($address['_token']);

        $user->update($address);

        if (empty($address_value)) {
            return redirect('/login');
        } else {
            return redirect('/');
        }
    }


    //配送先住所変更機能
    public function renawal(Request $request,$product)
    {
        $user = Auth::user();

        $address = $request->all();

        unset($address['_token']);
        $user->update($address);

        return redirect()->route('purchase', ['product' => $product]);
    }

    //配送先住所変更ページ表示
    public function modification($product)
    {
        $user = Auth::user();
        return view('sending', compact('user', 'product'));
    }

    //メール認証
    public function verifyEmail($id, $token)
    {
        $user = User::findOrFail($id);
        if ($user->verification_token === $token) {
            $user->email_verified = true;
            $user->save();
dd($user);
            return redirect('mypage.profile')->with('status', '認証が完了しました。プロフィールを登録してください。');
        } else {
            abort(403, 'Invalid verification token.');
        }
    }


    //認証メール再送機能
    public function resendVerificationEmail($id)
    {
        $user = User::findOrFail($id);
        $user->verification_token = Str::random(40);
        $user->save();

        Mail::to($user->email)->send(new VerifyEmail($user));

        return redirect()->route('emaildisplay',['id' => $user->id,'token' => $user->verification_token])->with('status', '認証メールを再送しました。');
    }

    //email認証ページ表示
    public function email($id){

        $user = User::findOrFail($id);

        $verificationUrl = route('certification', ['id' => $user->id, 'token' => $user->verification_token]);

        return response()->view('email', [
        'verificationUrl' => $verificationUrl,
        'user' => $user,
        ]);
    }
}