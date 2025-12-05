@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-12 px-4 sm:px-6 lg:px-8 space-y-8">

    <h2 class="text-3xl font-bold text-gray-800 text-center mb-8">Profil Saya</h2>

    {{-- FOTO PROFIL --}}
    <div class="bg-white shadow-lg rounded-xl p-6 flex flex-col items-center space-y-4">
        @if($user->profile_photo)
            <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Foto Profil" class="w-32 h-32 object-cover rounded-full border">
        @else
            <div class="w-32 h-32 bg-gray-200 rounded-full flex items-center justify-center text-gray-400">
                Tidak ada foto
            </div>
        @endif

        <h3 class="text-xl font-semibold text-gray-700">{{ $user->name }}</h3>
        <p class="text-gray-500 text-sm">{{ $user->email }}</p>
        
        <a href="{{ route('profile.editprofile') }}"
        class="mt-4 bg-orange-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-orange-600 transition">
            Edit Profil
        </a>

    </div>

    {{-- INFORMASI PRIBADI --}}
    <div class="bg-white shadow-lg rounded-xl p-6 space-y-4">
        <h3 class="text-xl font-bold text-gray-700 mb-4">Informasi Pribadi</h3>
        <div class="space-y-2 text-gray-700">
            <div><span class="font-semibold">Nama:</span> {{ $user->name }}</div>
            <div><span class="font-semibold">Email:</span> {{ $user->email }}</div>
            <div><span class="font-semibold">Telepon:</span> {{ $user->phone ?? '-' }}</div>
            <div><span class="font-semibold">Tanggal Lahir:</span> {{ $user->birth_date ?? '-' }}</div>
        </div>
    </div>

    {{-- ALAMAT PENGIRIMAN --}}
    <div class="bg-white shadow-lg rounded-xl p-6 space-y-4">
        <h3 class="text-xl font-bold text-gray-700 mb-4">Alamat Pengiriman</h3>
        @if($user->addresses && count($user->addresses) > 0)
            <ul class="space-y-3 text-gray-700">
                @foreach($user->addresses as $address)
                    <li class="border rounded-lg p-3 bg-gray-50">
                        {{ $address->label }}: {{ $address->full_address }}
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">Belum ada alamat tersimpan.</p>
        @endif
    </div>

    {{-- RIWAYAT PESANAN --}}
    <div class="bg-white shadow-lg rounded-xl p-6 space-y-4">
        <h3 class="text-xl font-bold text-gray-700 mb-4">Riwayat Pesanan</h3>
        @if($user->orders && count($user->orders) > 0)
            <div class="space-y-3">
                @foreach($user->orders as $index => $order)
                    <div class="border rounded-lg p-4 bg-gray-50 flex flex-col space-y-2">
                        <div><span class="font-semibold">Pesanan #{{ $index + 1 }}</span></div>
                        <div><span class="font-semibold">Tanggal:</span> {{ $order->created_at->format('d M Y') }}</div>
                        <div><span class="font-semibold">Status:</span> {{ $order->status }}</div>
                        <div><span class="font-semibold">Total:</span> Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                        <div>
                            <a href="{{ route('orders.show', $order->id) }}" class="text-orange-500 hover:underline">Detail</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">Belum ada pesanan.</p>
        @endif
    </div>

</div>
@endsection
