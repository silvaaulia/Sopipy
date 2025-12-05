@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-4 rounded-xl shadow">
    <img src="{{ asset('storage/'.$product->image) }}"
         class="w-full h-72 object-cover rounded-lg">

    <h2 class="text-xl font-bold mt-4">{{ $product->name }}</h2>
    <p class="text-orange-600 font-bold text-lg mt-2">
        Rp {{ number_format($product->price) }}
    </p>

    <form class="mt-4" method="POST"
          action="{{ route('cart.add', $product->id) }}">
        @csrf
        <button class="w-full bg-orange-500 text-white py-3 rounded-lg hover:bg-orange-600">
            + Keranjang
        </button>
    </form>
</div>
@endsection
