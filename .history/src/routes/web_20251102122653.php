<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Stripe\Stripe;
use Stripe\Checkout\Session;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//未認証ならば/loginにアクセス、認証済みなら商品購入ページを表示
Route::match(['get', 'post'], '/purchase/{product}', [ItemController::class, 'buy'])->middleware('auth')->name('purchase');

//ユーザー登録画面表示
Route::get('/register', function () {
        return view('register');
    })->name('register');

//ユーザー情報登録
Route::post('/register', [App\Http\Controllers\RegisterController::class,'store']);

//ユーザー登録画面表示
Route::get('/login', function () {
        return view('login');
    })->name('login');

//初回住所情報登録機能兼プロフィール変更機能
Route::middleware(['auth', 'verified'])->post('/mypage/profile', [ItemController::class, 'information']);

//ログイン機能
Route::post('/login',[App\Http\Controllers\LoginController::class,'store']);

//プロフィール設定画面表示
Route::get('/mypage/profile', [ItemController::class, 'edit'])->name('mypage.profile');

//アイコン登録
Route::put('/mypage/icon', [ItemController::class, 'Replacement']);

//商品詳細ページ表示
Route::get('/item/{product}', [ItemController::class, 'detail']);

//商品一覧ページ表示
Route::get('/', [ItemController::class, 'list'])->name('top');

//コメント追加機能
Route::middleware('auth')->post('/comment', [ItemController::class, 'comment']);

//stripeを使った購入機能
Route::post('/create-checkout-session', [ItemController::class, 'createCheckoutSession']);

//購入機能更新機能
Route::get('/complete', [ItemController::class, 'complete'])->name('complete');

//マイページ画面表示
Route::get('/mypage',[ItemController::class,'profile'])->middleware('auth');

//出品ページ画面表示
Route::get('/sell',[ItemController::class,'sell'])->middleware('auth');

//出品機能
Route::post('/sell',[ItemController::class,'sale']);

//検索機能
Route::get('/search', [ItemController::class, 'list'])->name('search');

//いいね機能
Route::post('/product/{product}/toggle-nice', [ItemController::class, 'toggleNice'])->name('product.toggleNice');

//配送先住所変更ページ表示
Route::get('/purchase/address/{product}', [ItemController::class, 'modification']);

//配送先住所変更機能
Route::post('/purchase/address/{product}', [ItemController::class, 'renawal'])->name('address.update');

//email認証ページ
Route::get('email/{id}/{token}', [ItemController::class, 'email'])->name('emaildisplay');

// 認証メール再送信機能
Route::get('/resend-verification/{id}', [ItemController::class, 'resendVerificationEmail'])->name('resendVerification');

//email認証機能
Route::get('/certification/{id}/{token}', [ItemController::class, 'verifyEmail'])->name('certification');

//取引(チャット)画面表示
Route::get('/item/{product}/transaction', [ItemController::class, 'transaction'])->name('transaction');

//チャット送信機能
Route::post('/messages/{product}', [ItemController::class, 'messages'])->name('messages');

// チャット内容編集機能
Route::put('/messages/{message}', [ItemController::class, 'update'])->name('messages.update');

// チャット内容削除
Route::delete('/messages/{message}', [ItemController::class, 'destroy'])->name('messages.destroy');


