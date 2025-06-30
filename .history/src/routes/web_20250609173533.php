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
//未認証されていなければ/loginにアクセス。
Route::middleware('auth')->group(function () {
    Route::get('/purchase/{item_id}', [MartController::class, 'profile']);
});
Route::get('/mypage/profile', [MartController::class, 'profile']);
Route::post('/mypage/profile', [MartController::class, 'update']);