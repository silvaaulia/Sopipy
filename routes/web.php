<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Models\Product; // <- ini wajib


Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
// Route
Route::get('/profile/edit', [ProfileController::class,'editProfile'])->name('profile.editprofile');
Route::put('/profile/update', [ProfileController::class,'updateProfile'])->name('profile.update');
Route::put('/profile/delete', [ProfileController::class,'deleteProfile'])->name('profile.destroy');


Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

// Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
// Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

Route::get('/product/{id}', [ProductController::class, 'show'])
    ->name('product.show');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $products = Product::all(); // ambil semua produk
    return view('dashboard', compact('products'));
})->middleware(['auth', 'verified'])->name('dashboard');


// Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');



require __DIR__.'/auth.php';
