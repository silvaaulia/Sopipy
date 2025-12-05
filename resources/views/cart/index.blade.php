@extends('layouts.app')
@section('title', 'Keranjang Belanja')
@section('content')
<div class="max-w-7xl mx-auto mt-8 px-4">

    <h2 class="text-2xl font-bold mb-6">Keranjang Belanja</h2>

    @if(session('cart') && count(session('cart')) > 0)
        <div class="space-y-6">

            @php
                $totalPrice = 0;
            @endphp

            @foreach(session('cart') as $id => $item)
                @php
                    $itemTotal = $item['price'] * $item['quantity'];
                    $totalPrice += $itemTotal;
                @endphp

                <div class="flex flex-col md:flex-row justify-between items-center p-4 bg-white rounded-lg shadow hover:shadow-lg transition">
                    {{-- Gambar --}}
                    <img src="{{ asset('storage/'.$item['image']) }}" alt="{{ $item['name'] }}" class="w-24 h-24 md:w-32 md:h-32 object-cover rounded-lg">

                    {{-- Detail Produk --}}
                    <div class="flex-1 md:ml-6 mt-3 md:mt-0">
                        <h3 class="font-semibold text-gray-800">{{ $item['name'] }}</h3>
                        <p class="text-orange-600 font-bold mt-1">Rp {{ number_format($item['price']) }}</p>

                        {{-- Quantity --}}
                        <div class="flex items-center mt-2 space-x-2">
                            <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center space-x-2">
                                @csrf
                                @method('PUT')
                                <button type="submit" name="action" value="decrease" class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">-</button>
                                <input type="text" name="quantity" value="{{ $item['quantity'] }}" class="w-10 text-center border rounded">
                                <button type="submit" name="action" value="increase" class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">+</button>
                            </form>
                            <span class="text-gray-500">Subtotal: Rp {{ number_format($itemTotal) }}</span>
                        </div>
                    </div>

                    {{-- Hapus Produk --}}
                    <form action="{{ route('cart.remove', $id) }}" method="POST" class="mt-3 md:mt-0">
                        @csrf
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
