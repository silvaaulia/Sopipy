@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <h2 class="text-xl font-bold mb-4">Produk</h2>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @foreach($products as $p)
        <a href="{{ route('product.detail', $p->id) }}"
           class="bg-white shadow rounded-xl p-4">
            <img src="{{ asset('images/'.$p->image) }}" class="rounded-lg">
            <h3 class="font-semibold mt-2">{{ $p->name }}</h3>
            <p class="text-orange-500">Rp {{ number_format($p->price) }}</p>
        </a>
        @endforeach
    </div>
</div>
@endsection
