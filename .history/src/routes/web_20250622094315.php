<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MartController;

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

//ユーザー情報登録
Route::post('/register', [MartController::class, 'create']);


//プロフィール設定画面表示
Route::get('/mypage/profile', [MartController::class, 'edit'])->name('setting.edit');

//ユーザー住居情報登録
Route::put('/mypage/profile', [MartController::class, 'update'])->name('setting.update');

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
    return view('address');
    });

//商品購入機能 調整中
Route::post('/buy/{product}', [MartController::class,'purchase']);

//マイページ画面表示
Route::get('/mypage',[MartController::class,'profile'])->middleware('auth');

//出品ページ画面表示
Route::get('/sell',[MartController::class,'sell'])->middleware('auth');

//search
Route::post('/search', [AuthorController::class, 'search']);