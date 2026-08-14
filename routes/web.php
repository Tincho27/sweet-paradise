<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MesaDulceController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('root');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/cart', [CartController::class, 'index'])->middleware(['auth', 'verified'])->name('cart');
Route::post('/cart/add/{product_id}', [CartController::class, 'addToCart'])->middleware(['auth', 'verified'])->name('cartAdd');
Route::post('/cart/variant/{cart_item_id}', [CartController::class, 'updateVariant'])->middleware(['auth', 'verified'])->name('cartVariant');
Route::post('/cart/increase/{cart_item_id}', [CartController::class, 'increaseQuantity'])->middleware(['auth', 'verified'])->name('cartIncrease');
Route::post('/cart/decrease/{cart_item_id}', [CartController::class, 'decreaseQuantity'])->middleware(['auth', 'verified'])->name('cartDecrease');
Route::post('/cart/remove/{cart_item_id}', [CartController::class, 'removeItem'])->middleware(['auth', 'verified'])->name('cartRemove');
Route::get('/checkout', [CheckoutController::class, 'index'])->middleware(['auth', 'verified'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->middleware(['auth', 'verified'])->name('checkoutStore');
Route::get('/checkout/success/{order_number}', [CheckoutController::class, 'success'])->middleware(['auth', 'verified'])->name('confirmation');
Route::get('/mesa-dulce', [MesaDulceController::class, 'index'])->middleware(['auth', 'verified'])->name('mesa.dulce');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
