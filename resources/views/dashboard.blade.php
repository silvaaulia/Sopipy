@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="max-w-7xl mx-auto mt-8 px-4 space-y-8">

    {{-- Halo User --}}
    <div class="bg-orange-100 p-6 rounded-xl shadow-md">
        <h2 class="text-xl font-semibold text-gray-800">Selamat Datang, {{ auth()->user()->name }} 👋</h2>
        <p class="text-gray-600 mt-1">Semoga harimu menyenangkan!</p>
    </div>

    {{-- Promo Banner --}}
    <div class="rounded-xl overflow-hidden shadow-xl">
        <img src="https://source.unsplash.com/1200x350/?shopping,ecommerce" class="w-full object-cover">
    </div>

    {{-- Kategori Populer --}}
    <div>
        <h3 class="text-xl font-bold text-gray-800 mb-5">Kategori Populer</h3>
        <div class="grid grid-cols-3 sm:grid-cols-6 lg:grid-cols-8 gap-4">
            @foreach (['Fashion', 'Elektronik', 'Kecantikan', 'Makanan', 'Olahraga', 'Rumah', 'HP', 'Aksesoris'] as $kategori)
                <div class="bg-white border rounded-xl py-4 text-center hover:shadow-xl hover:-translate-y-1 transition cursor-pointer">
                    <div class="w-14 h-14 mx-auto mb-2 bg-orange-400 rounded-full shadow-inner"></div>
                    <p class="text-xs font-medium text-gray-700">{{ $kategori }}</p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Flash Sale --}}
    {{-- <section>
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-orange-600">🔥 Flash Sale</h3>
            <a class="text-sm text-gray-600 hover:text-gray-800 cursor-pointer">Lihat Semua ></a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            @foreach ($products as $product)
            <div class="p-4 bg-white shadow rounded-lg hover:shadow-xl transition">
                <img src="{{ asset('storage/'.$product->image) }}"
                     class="w-full h-40 object-cover rounded-lg">
                <h3 class="font-semibold mt-2 line-clamp-2 text-sm">{{ $product->name }}</h3>
                <p class="text-orange-600 font-bold text-sm mt-1">
                    Rp {{ number_format($product->price) }}
                </p>

                {{-- Tambah Keranjang --}}
                {{-- <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <button class="bg-orange-500 text-white px-4 py-2 rounded-lg mt-3 w-full text-sm hover:bg-orange-600">
                        + Keranjang
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </section> --}} 

  {{-- Rekomendasi --}}
    <section>
        <h3 class="text-lg font-bold text-gray-900 mb-4">✨ Rekomendasi Untuk Kamu</h3>
        <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
            
            {{-- UBAH: Ganti @for dengan @foreach ($products) --}}
            @foreach ($products as $product)
            <div class="bg-white rounded-xl border hover:shadow-lg transition">
                
                {{-- Gunakan data produk asli di sini --}}
                <img src="{{ asset('storage/'.$product->image) }}"
                     class="w-full h-40 object-cover rounded-t-xl">

                <div class="p-3 space-y-2">
                    <p class="text-xs line-clamp-2">{{ $product->name }}</p>
                    <p class="text-orange-600 font-bold text-sm">
                        Rp {{ number_format($product->price) }}
                    </p>

                    {{-- Form menggunakan ID produk yang asli --}}
                    <form method="POST" action="{{ route('cart.add', $product->id) }}">
                        @csrf
                        <button class="w-full bg-gray-900 text-white rounded-lg py-1 text-sm hover:bg-black">
                            + Keranjang
                        </button>
                    </form>

                </div>
            </div>
            @endforeach
            
        </div>
    </section>

</div>
@endsection
