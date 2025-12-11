@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-8">

    {{-- Kolom 1 & 2: Detail Produk --}}
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white p-6 rounded-xl shadow-lg">
            {{-- Bagian Atas Detail Produk --}}
            <img src="{{ asset('storage/'.$product->image) }}"
                class="w-full h-80 object-cover rounded-lg shadow-md">

            <h2 class="text-3xl font-bold mt-6 text-gray-800">{{ $product->name }}</h2>
            <p class="text-red-600 font-bold text-2xl mt-3">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </p>

            <form class="mt-6" method="POST"
                action="{{ route('cart.add', $product->id) }}">
                @csrf
                <button class="w-full bg-red-600 text-white py-3 rounded-lg font-semibold text-lg hover:bg-red-700 transition shadow-md">
                    + Tambah ke Keranjang
                </button>
            </form>
        </div>
        
        {{-- Deskripsi Produk (Opsional, ditambahkan untuk konten) --}}
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <h3 class="text-xl font-bold text-gray-700 mb-4 border-b pb-2">Deskripsi Produk</h3>
            <p class="text-gray-600">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime, voluptatum. (Ganti dengan $product->description)</p>
        </div>
    </div>
    
    {{-- Kolom 3: Alamat Pengiriman (Informasi Profil yang Diintegrasikan) --}}
    <div class="lg:col-span-1 space-y-6">
        
        {{-- ALAMAT PENGIRIMAN --}}
        <div class="bg-white shadow-lg rounded-xl p-6 space-y-4 border border-gray-200">
            <h3 class="text-xl font-bold text-gray-700 border-b pb-2 flex justify-between items-center">
                Alamat Pengiriman
                {{-- Link untuk mengarahkan ke halaman edit profil --}}
                <a href="{{ route('profile.editprofile') }}" class="text-sm text-red-500 hover:text-red-700 font-semibold">Ubah</a>
            </h3>
            
            @auth
                @if($user->addresses && count($user->addresses) > 0)
                    {{-- Tampilkan hanya Alamat Utama, atau alamat pertama --}}
                    @php
                        $defaultAddress = $user->addresses->where('is_default', 1)->first() ?? $user->addresses->first();
                    @endphp

                    @if($defaultAddress)
                        <div class="space-y-1 text-gray-700">
                            <p class="font-bold text-lg">{{ $user->name }}</p>
                            <p class="font-semibold text-red-600">{{ $defaultAddress->label }} 
                                @if($defaultAddress->is_default) 
                                    <span class="text-xs bg-red-100 text-red-500 px-2 py-0.5 rounded-full font-medium ml-1">Utama</span> 
                                @endif
                            </p>
                            <p class="text-sm text-gray-700">{{ $defaultAddress->full_address }}, {{ $defaultAddress->city }}, {{ $defaultAddress->postal_code }}</p>
                        </div>
                    @endif
                @else
                    <p class="text-gray-500 italic text-sm">Anda belum menyimpan alamat pengiriman.</p>
                @endif
            @else
                <p class="text-gray-500 italic text-sm">Login untuk melihat alamat pengiriman Anda.</p>
            @endauth
        </div>
        
        {{-- RINGKASAN BELANJA (Opsional) --}}
        <div class="bg-white shadow-lg rounded-xl p-6 space-y-4 border border-gray-200">
            <h3 class="text-xl font-bold text-gray-700 border-b pb-2">Ringkasan Belanja</h3>
            <div class="flex justify-between text-gray-600">
                <span>Harga Satuan</span>
                <span>Rp {{ number_format($product->price, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between font-bold text-red-600 border-t pt-3">
                <span>Total</span>
                <span>Rp {{ number_format($product->price, 0, ',', '.') }}</span>
            </div>
        </div>
        
    </div>
    
</div>
@endsection