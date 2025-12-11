<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // 1. TAMBAH ITEM KE KERANJANG (CREATE/UPDATE DB)
   // app/Http/Controllers/CartController.php

// app/Http/Controllers/CartController.php

public function add($id)
{
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Anda harus login untuk menambahkan produk ke keranjang.');
    }
    
    try {
        $userId = auth()->id();
        $cart = \App\Models\Cart::with('product') // Pastikan Eager Load ada
                    ->where('user_id', $userId)
                    ->where('product_id', $id)
                    ->first();

        if ($cart) {
            $cart->increment('quantity');
            $productName = $cart->product->name;
        } else {
            // **Ganti find() kembali ke findOrFail() jika Anda ingin 404 jika ID sangat aneh**
            // Atau biarkan find() dan tangani jika produk null (Lebih aman)
            $product = \App\Models\Product::find($id); 

            if (!$product) {
                // Sekarang kita tahu ID-nya hilang, kita bisa kembalikan error yang ramah
                return redirect()->back()->with('error', 'Produk tidak ditemukan atau sudah habis.'); 
            }
            
            \App\Models\Cart::create([
                'user_id' => $userId,
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
            $productName = $product->name;
        }
        
        // >>> INI AKAN DIEKSEKUSI SEKARANG <<<
        return redirect()->route('cart.index')->with('success', $productName . ' berhasil ditambahkan ke keranjang!');

    } catch (\Exception $e) {
        // Hapus semua kode diagnosis dd() dan ganti dengan logging yang aman
        \Log::error('Cart Add Failed: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Terjadi kesalahan sistem saat memproses keranjang. (Lihat log)');
    }
}

    // 2. TAMPILKAN ISI KERANJANG (READ DB)
    public function index()
    {
        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
        return view('cart.index', compact('cartItems'));
    }

    // 3. UPDATE KUANTITAS ITEM (UPDATE DB)
    public function update(Request $request, $id)
    {
        // ID di sini adalah ID item Cart, bukan ID Product
        $request->validate(['quantity' => 'required|integer|min:1']);
        
        $cart = Cart::where('user_id', auth()->id())
                    ->where('id', $id)
                    ->firstOrFail();

        // Mengambil kuantitas dari input yang disembunyikan pada form
        $cart->quantity = $request->quantity; 
        $cart->save();

        return redirect()->route('cart.index')->with('success', 'Kuantitas berhasil diperbarui.');
    }
    
    // 4. HAPUS ITEM DARI KERANJANG (DELETE DB)
    public function remove($id)
    {
        // ID di sini adalah ID item Cart, bukan ID Product
        Cart::where('user_id', auth()->id())
            ->where('id', $id)
            ->delete();

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}