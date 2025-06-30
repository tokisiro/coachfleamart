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
Route::middleware('auth')->group(function () {
    Route::get('/purchase/{item_id}', [MartController::class, 'buy']);
});
//ユーザー情報登録
Route::post('/register', [MartController::class, 'create']);
//設定
Route::get('/mypage/profile', function() {
    return view('setting');
});
//ユーザー住居情報登録
Route::post('/mypage/profile', [MartController::class, 'update']);
