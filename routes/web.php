<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController; 
use App\Models\Product; 

/*
|--------------------------------------------------------------------------
| Public & Guest Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');


/*
|--------------------------------------------------------------------------
| Authenticated Routes (Membutuhkan Login)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    
    // --- DASHBOARD ---
    Route::get('/dashboard', function () {
        $products = Product::all();
        return view('dashboard', compact('products'));
    })->middleware('verified')->name('dashboard');

    
    // --- PROFIL ---
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'editProfile'])->name('profile.editprofile');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.updateprofile'); 
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/address', [ProfileController::class, 'storeAddress'])->name('profile.storeaddress');


    // --- KERANJANG (CART) & CHECKOUT ---
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add'); 
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    // Catatan: Menggunakan POST dan @method('PUT') di form agar kompatibel dengan browser/framework
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update'); 
    
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
});


/*
|--------------------------------------------------------------------------
| Auth Routes (Login, Register, dll.)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';