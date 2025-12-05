<?php

namespace App\Http\Controllers;
// use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;


use Illuminate\Http\Request;

class CartController extends Controller
{
 public function add($id)
{
    $userId = auth()->id();

    $cart = Cart::where('user_id', $userId)
                ->where('product_id', $id)
                ->first();

    if ($cart) {
        $cart->increment('quantity');
    } else {
        // Pastikan produk ada
        $product = Product::findOrFail($id);

        Cart::create([
            'user_id' => $userId,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
    }

    return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
}



public function index()
{
    $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
    return view('cart.index', compact('cartItems'));
}


}
