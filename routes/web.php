<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\HomeController;
use App\Models\CartItem;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'index']);
Route::get('/checkout', [HomeController::class, 'checkout']);
Route::post('/checkout', [HomeController::class, 'doCheckout']);
Route::get('/data/trending-items', [HomeController::class, 'trending_items']);
Route::get('/data/recent-purchases', [HomeController::class, 'recent_purchases']);

Route::resource('cart-items', CartItemController::class);
Route::resource('cart', CartController::class);


