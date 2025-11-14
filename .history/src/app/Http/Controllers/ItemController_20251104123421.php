<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
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
use App\Models\Message;
use App\Models\Evaluation;



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

        //Userモデルのリレーションをロード
        $user->load('receivedEvaluations');

        //平均評価を取得
        $averageRating = $user->average_rating;

        //評価数を取得
        $evaluationsCount = $user->evaluations_count;

        // 全てのタブで必要な変数を初期化
        $listedProducts = collect();
        $purchasedProducts = collect();
        $transactionProducts = collect();

        $unreadCounts = [];
        $totalUnreadTransactionMessages = 0;

        $allTransactionProducts = Product::where(function ($query) use ($user) {
            $query->where('user_id', $user->id) // 自分が「出品者」の場合
                  ->orWhere('consider_id', $user->id); // 自分が「購入者」の場合
        })
        ->where('transaction_status', 'negotiation')
        ->leftJoinSub(
            Message::select('product_id', DB::raw('MAX(created_at) as latest_message_at'))
                ->groupBy('product_id'),
            'latest_messages',
            'products.id',
            '=',
            'latest_messages.product_id'
        )
        ->orderByDesc('latest_messages.latest_message_at') // 最新メッセージの新しい順にソート
        ->select('products.*')
        ->get();

        // 各取引中の商品ごとの未読メッセージ数を計算
        foreach ($allTransactionProducts as $product) {
            $unreadCount = Message::where('product_id', $product->id)
                ->where('receiver_id', $user->id) // メッセージの受信者が自分
                ->whereNull('receiver_read_at')// まだ読まれていないメッセージ
                ->count();
            $unreadCounts[$product->id] = $unreadCount;
            $totalUnreadTransactionMessages += $unreadCount;
        }

        // 次に、選択された $mode に基づいて表示する商品リストを準備
        if ($mode === 'buy') {
            $purchasedProducts = $user->userProducts()->with('product')->get()->pluck('product');

        } elseif ($mode === 'transaction') {
            // modeが'transaction'の場合は、allTransactionProductsをそのまま使用
            $transactionProducts = $allTransactionProducts;

        } else { // 'sell' またはその他の場合
            $listedProducts = Product::where('user_id', $user->id)
            ->get();
        }

        return view('profile', [
            'purchasedProducts' => $purchasedProducts,
            'listedProducts' => $listedProducts,
            'transactionProducts' => $transactionProducts,
            'mode' => $mode,
            'user' => $user,
            'unreadCounts' => $unreadCounts,
            'totalUnreadTransactionMessages' => $totalUnreadTransactionMessages,
            'averageRating' => $averageRating,
            'evaluationsCount' => $evaluationsCount,
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

    //取引(チャット)画面表示
    public function transaction(Product $product){

        $user = Auth::user();

        $product->load('buyerUserProduct.user');

        // 正式な購入者を取得
        $actualBuyer = $product->buyer;

        // この商品に関連するメッセージの中から、ログインユーザーではない相手のIDを特定
        $chatPartnerId = Message::where('product_id', $product->id)
            ->where(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })
            // ログインユーザーではないIDを取得
            ->where(function ($query) use ($user) {
                $query->where('sender_id', '!=', $user->id)
                    ->orWhere('receiver_id', '!=', $user->id);
            })
            ->pluck('sender_id', 'receiver_id') // sender_idとreceiver_idを両方取得
            ->flatten()
            ->unique()
            ->except($user->id)
            ->first();

        // $chatPartnerId からチャット相手ユーザーを取得
        $chatPartner = null;
        if ($chatPartnerId) {
            $chatPartner = User::find($chatPartnerId);
        }

        $isRelatedToProduct = ($product->user_id === $user->id); // 出品者
        if ($actualBuyer) { // 正式な購入者がいる場合
            $isRelatedToProduct = $isRelatedToProduct || ($actualBuyer->id === $user->id);
        }
        if ($chatPartner) { // チャット相手の場合
            $isRelatedToProduct = $isRelatedToProduct || ($chatPartner->id === $user->id);
        }
        if (!$isRelatedToProduct) {
            abort(403, 'Unauthorized action.');
        }

        //未読メッセージを既読にする処理
        Message::where('product_id', $product->id)
            ->where('receiver_id', $user->id)
            ->whereNull('receiver_read_at')
            ->update(['receiver_read_at' => now()]);

        // その他の取引中の商品を取得
        $otherTransactions = Product::where('transaction_status', 'negotiation') // ここを修正
            ->where('id', '!=', $product->id) // 現在表示中の商品を除く
            ->where(function ($query) use ($user) {
                // ログインユーザーが出品者である商品
                $query->where('user_id', $user->id)
                      // または、ログインユーザーがメッセージのやり取りをしている相手である商品
                    ->orWhereHas('messages', function ($q) use ($user) {
                        $q->where('sender_id', $user->id)
                        ->orWhere('receiver_id', $user->id);
                    });
            })
            ->get();

        //チャット内容
        $messages = Message::where('product_id', $product->id)
                    ->orderBy('created_at')
                    ->get();

        // 取引相手を特定（ビューで誰を相手として表示するか）
        $transactionPartner = null;
        if ($product->user_id === $user->id) { // ログインユーザーが出品者
            $transactionPartner = $actualBuyer ?? $chatPartner; // 購入者がいれば購入者、いなければチャット相手
        } elseif ($actualBuyer && $actualBuyer->id === $user->id) { // ログインユーザーが正式な購入者
            $transactionPartner = $product->user; // 取引相手は出品者
        } elseif ($chatPartner && $chatPartner->id === $user->id) { // ログインユーザーがチャット相手で、上記どちらでもない場合
            $transactionPartner = $product->user; // 取引相手は出品者
        }

        // 取引完了ステータスの判定 (products.status === 'sold' かどうか)
        $isTransactionCompleted = ($product->status === 'sold');

            // ログインユーザーが「取引相手」を評価済みかどうかを判定
        $isCurrentUserRated = false;
        if ($isTransactionCompleted && $actualBuyer) { // 正式な購入者が確定している場合に評価の状態を確認
            if ($user->id === $product->user_id) { // ログインユーザーが出品者の場合
                $isCurrentUserRated = Evaluation::where('product_id', $product->id)
                    ->where('reviewer_id', $user->id)
                    ->where('reviewed_user_id', $actualBuyer->id)
                    ->exists();
            } elseif ($user->id === $actualBuyer->id) { // ログインユーザーが正式な購入者の場合
                $isCurrentUserRated = Evaluation::where('product_id', $product->id)
                    ->where('reviewer_id', $user->id)
                    ->where('reviewed_user_id', $product->user_id)
                    ->exists();
            }
        }

        // 評価済みステータスの判定
        // 出品者が購入者を評価済みか
        $isSellerRated = false;
        if ($actualBuyer) { // 正式な購入者が特定できた場合のみ
            $isSellerRated = Evaluation::where('product_id', $product->id)
                ->where('reviewer_id', $product->user_id)
                ->where('reviewed_user_id', $actualBuyer->id)
                ->exists();
        }

        // 購入者が出品者を評価済みか
        $isBuyerRated = false;
        if ($actualBuyer) { // 正式な購入者が特定できた場合のみ
            $isBuyerRated = Evaluation::where('product_id', $product->id)
                ->where('reviewer_id', $actualBuyer->id)
                ->where('reviewed_user_id', $product->user_id)
                ->exists();
        }

        return view('transaction', [
            'user' => $user,
            'detail' => $product,
            'otherTransactions' => $otherTransactions,
            'messages' => $messages,
            'transactionPartner' => $transactionPartner,
            'actualBuyer' => $actualBuyer,
            'isTransactionCompleted' => $isTransactionCompleted,
            'isCurrentUserRated' => $isCurrentUserRated,
            'isSellerRated' => $isSellerRated,
            'isBuyerRated' => $isBuyerRated,
        ]);
    }

    private function getTransactionPartner(Product $product, $currentUser, ?User $buyer)
    {
        if ($buyer) {
            if ($product->user_id === $currentUser->id) {
                // ログインユーザーが出品者の場合、取引相手は$buyer
                return $buyer;
            } elseif ($buyer->id === $currentUser->id) {
                // ログインユーザーが$buyerの場合、取引相手は出品者
                return $product->user; // Productモデルにuserリレーションがある前提
            }
        }
        return null;
    }

    //チャット送信機能
    public function messages(TransactionRequest $request, Product $product)
    {
        $user = Auth::user();

        // ログインユーザーがこの取引に参加しているか確認
        if ($product->user_id !== $user->id && $product->consider_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized action.'], 403);
        }

        // 取引相手を特定
        $receiverId = ($product->user_id === $user->id) ? $product->consider_id : $product->user_id;

        $messageData = [
            'product_id' => $product->id,
            'sender_id' => $user->id,
            'receiver_id' => $receiverId,
            'message' => $request->input('message')
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('chat_images', $filename, 'public');
            // データベースには公開URLを保存
            $messageData['image'] = Storage::url($path);
        } else {
            $messageData['image'] = null;
        }

        $message = Message::create($messageData);

        // 作成したメッセージと送信者情報を取得してJSONで返す
        $message->load('sender');

        $senderIcon = $message->sender->icon ? Storage::url( $message->sender->icon) : asset('images/default_profile.png');

        return response()->json([
            'message' => 'メッセージが送信されました！',
            'data' => $message,
            'sender_name' => $message->sender->name,
            'sender_icon' => $senderIcon,
            'is_mine' => true, // 自分のメッセージであることをクライアント側で判断するために追加
        ]);
    }

    // メッセージ更新
    public function update(TransactionRequest $request, Message $message)
    {
        // Auth::user() が $message の送信者であることを確認する
        if (Auth::id() !== $message->sender_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $message->update([
            'message' => $request->message,
        ]);

        return response()->json([
            'message' => $message,
        ]);
    }

    // メッセージ削除
    public function destroy(Message $message)
    {
        // Auth::user() が $message の送信者であることを確認する
        if (Auth::id() !== $message->sender_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $message->delete();

        return response()->json([
            'message' => 'Message deleted successfully',
        ], 204); // 204 No Content を返すのが一般的
    }







    //取引を完了するAPIエンドポイント(URL)
    public function completeTransaction(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $user = Auth::user();

        $userProduct = $product->buyerUserProduct;

        // UserProduct レコードが存在しない、またはその user_id がログインユーザーと異なる場合
        if (!$userProduct || $userProduct->user_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'あなたはこの取引の購入者ではありません。'], 403);
        }

        // 商品ステータスが 'sold' でtransaction_statusカラムが'negotiation'の場合 transaction_statusカラムを'evaluation' に変更
        if ($product->status === 'sold' && $product->transaction_status === 'negotiation') {
            $product->transaction_status = 'evaluation';
            $product->updated_at = now(); // 完了日時を記録
            $product->save();
            return response()->json(['success' => true, 'message' => '取引を完了しました。相手を評価してください。']);
        } else if ($product->transaction_status === 'evaluated') {
            return response()->json(['success' => false, 'message' => 'この取引はすでに完了しています。'], 400);
        } else {
            return response()->json(['success' => false, 'message' => 'この取引はまだ完了できません。'], 400);
        }
    }

    //ユーザーを評価するAPIエンドポイント(URL)
    public function rateUser(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $user = Auth::user(); // 現在ログインしているユーザー = 評価者

        // 評価者IDとログインユーザーIDが一致することを確認
        if ($request->input('reviewer_id') != $user->id) {
            return response()->json(['success' => false, 'message' => '評価者IDが一致しません。'], 403);
        }

        // 評価対象のユーザーが、この商品の seller または buyer であることを確認
        if ($request->input('reviewed_user_id') != $product->seller_id && $request->input('reviewed_user_id') != $product->buyer_id) {
            return response()->json(['success' => false, 'message' => '評価対象のユーザーがこの取引に関わっていません。'], 400);
        }

        // ログインユーザーがこの取引の当事者（出品者または購入者）であることを確認
        if ($product->seller_id !== $user->id && $product->buyer_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'あなたはこの取引の当事者ではありません。'], 403);
        }

        // 同じ商品に対して、同じ評価者から同じ被評価者への評価が既に存在しないか確認
        $existingEvaluation = Evaluation::where('product_id', $productId)
            ->where('reviewer_id', $user->id)
            ->where('reviewed_user_id', $request->input('reviewed_user_id'))
            ->exists();

        if ($existingEvaluation) {
            return response()->json(['success' => false, 'message' => 'あなたはすでにこの取引の相手を評価済みです。'], 400);
        }

        DB::transaction(function () use ($request, $product, $user) {
            Evaluation::create([
                'product_id' => $product->id,
                'reviewer_id' => $user->id,
                'reviewed_user_id' => $request->input('reviewed_user_id'),
                'rating' => $request->input('rating'),
                'role_as_reviewed' => $request->input('role_as_reviewed'),
            ]);
        });

        return response()->json(['success' => true, 'message' => '評価を送信しました。']);
    }


    public function rateProduct(Request $request, Product $productId)
    {
        $validatedData = $request->validate([
            'reviewed_user_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'role_as_reviewed' => 'required|string|in:seller,buyer',
        ]);

        

        // フォームから送信された product_id と URLの $product->id が一致するか確認
        if ($validatedData['product_id'] != $productId->id) {
            return response()->json([
                'success' => false,
                'message' => '無効なリクエストです。'
            ], 400);
        }

        // 評価者が現在の認証済みユーザーであるか確認
        if ($validatedData['reviewer_id'] != Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => '認証情報が無効です。'
            ], 403);
        }

        // 既に評価済みか確認
        $existingEvaluation = Evaluation::where('product_id', $productId->id)
            ->where('reviewer_id', Auth::id())
            ->first();

        if ($existingEvaluation) {
            return response()->json([
                'success' => false,
                'message' => 'あなたはこの取引を既に評価済みです。'
            ], 409);
        }

        try {
            DB::beginTransaction();

            // 評価を保存
            Evaluation::create([
                'product_id' => $validatedData['product_id'],
                'reviewer_id' => $validatedData['reviewer_id'],
                'reviewed_user_id' => $validatedData['reviewed_user_id'],
                'rating' => $validatedData['rating'],
                'role_as_reviewed' => $validatedData['role_as_reviewed'],
            ]);


            DB::commit();

            return response()->json([
            'success' => true,
            'message' => '評価を送信しました。'
]);

        } catch (\Exception $e) {
            DB::rollBack();
            // エラーログ
            \Log::error('評価保存エラー: ' . $e->getMessage(), ['exception' => $e]);

            return redirect('/');
        }
    }
}
