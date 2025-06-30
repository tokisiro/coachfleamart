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

Route::get('/', [MartController::class, 'product']);

Route::middleware('auth')->group(function () {
    Route::get('/', [MartController::class, '']);
});
Route::get('/profile/edit', [ProfileController::class, 'edit']);