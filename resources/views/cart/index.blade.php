@extends('layouts.app')
@section('title', 'Keranjang Belanja')
@section('content')
<div class="max-w-7xl mx-auto mt-8 px-4">

    <h2 class="text-2xl font-bold mb-6">Keranjang Belanja</h2>

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Menggunakan $cartItems dari Controller --}}
    @if($cartItems && count($cartItems) > 0)
        
        <div class="space-y-6">

            @php
                $totalPrice = 0;
            @endphp

            @foreach($cartItems as $item)
                @php
                    $itemTotal = $item->product->price * $item->quantity; 
                    $totalPrice += $itemTotal;
                @endphp

                <div class="flex flex-col md:flex-row justify-between items-center p-4 bg-white rounded-lg shadow hover:shadow-lg transition">
                    {{-- Gambar --}}
                    <img src="{{ asset('storage/'.$item->product->image) }}" alt="{{ $item->product->name }}" class="w-24 h-24 md:w-32 md:h-32 object-cover rounded-lg">

                    {{-- Detail Produk --}}
                    <div class="flex-1 md:ml-6 mt-3 md:mt-0">
                        <h3 class="font-semibold text-gray-800">{{ $item->product->name }}</h3>
                        <p class="text-orange-600 font-bold mt-1">Rp {{ number_format($item->product->price) }}</p>

                        {{-- Quantity --}}
                        <div class="flex items-center mt-2 space-x-4">
                            
                            {{-- Form Update Kuantitas --}}
                            {{-- Menggunakan $item->id (ID ITEM KERANJANG) --}}
                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center space-x-2">
                                @csrf
                                @method('PUT')
                                
                                {{-- Tombol minus --}}
                                <button type="submit" name="quantity" value="{{ max(1, $item->quantity - 1) }}" 
                                        class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">-</button>
                                
                                <span class="w-10 text-center border rounded">{{ $item->quantity }}</span>
                                
                                {{-- Tombol plus --}}
                                <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" 
                                        class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">+</button>
                            </form>

                            <span class="text-gray-500">Subtotal: <span class="font-bold text-gray-700">Rp {{ number_format($itemTotal) }}</span></span>
                        </div>
                    </div>

                    {{-- Hapus Produk --}}
                    {{-- Menggunakan $item->id (ID ITEM KERANJANG) --}}
                    <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="mt-3 md:mt-0">
                        @csrf
                        @method('DELETE') 
                        <button class="text-red-500 hover:underline">Hapus</button>
                    </form>
                </div>
            @endforeach

            {{-- Total & Checkout --}}
            <div class="flex flex-col md:flex-row justify-between items-center bg-white p-4 rounded-lg shadow">
                <h3 class="text-lg font-bold text-gray-800">Total: Rp {{ number_format($totalPrice) }}</h3>
                <a href="{{ route('checkout.index') }}" class="mt-3 md:mt-0 bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 transition">
                    Checkout
                </a>
            </div>

        </div>
    @else
        <p class="text-gray-500 text-center mt-10 text-lg">Keranjangmu kosong 😢</p>
    @endif

</div>
@endsection