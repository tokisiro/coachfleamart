<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MartController;
use App\Http\Controllers\Auth\RegisteredUserController;


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
Route::middleware('auth')->get('/purchase/{product}', [MartController::class, 'buy']);

//ユーザー登録画面表示
Route::view('/register', 'register')->name('register');

//ユーザー情報登録
Route::post('/register', [App\Http\Controllers\RegisterController::class,'store']);



//プロフィール設定画面表示
Route::get('/mypage/profile', [MartController::class, 'edit'])->name('mypage.profile');

//ユーザー住居情報登録
Route::put('/mypage/profile', [MartController::class, 'update']);

//商品詳細ページ表示
Route::get('/item/{product}', [MartController::class, 'detail']);
//商品一覧ページ表示
Route::get('/', [MartController::class, 'list']);

//いいね機能
Route::post('/product/{product}/toggle-nice', [MartController::class, 'toggleNice'])->name('product.toggleNice');

//コメント追加機能
Route::post('/comment', [MartController::class, 'comment']);

//配送先住所変更ページ表示
Route::get('/purchase/address/{product}', function () {
    return redirect()->route('mypage.profile');
    });

//商品購入機能
Route::post('/buy/{product}', [MartController::class,'purchase'])->name('product.purchase');

//マイページ画面表示
Route::get('/mypage',[MartController::class,'profile'])->middleware('auth');

//出品ページ画面表示
Route::get('/sell',[MartController::class,'sell'])->middleware('auth');

//出品機能 調整中
Route::post('/sell',[MartController::class,'sale']);

//検索機能
Route::post('/search', [MartController::class, 'search']);