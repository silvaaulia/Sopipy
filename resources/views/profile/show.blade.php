@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-12 px-4 sm:px-6 lg:px-8 space-y-8">

    <h2 class="text-3xl font-bold text-gray-800 text-center mb-8">Profil Saya</h2>
    
    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    {{-- FOTO PROFIL --}}
    <div class="bg-white shadow-lg rounded-xl p-6 flex flex-col items-center space-y-4">
        @if($user->profile_photo)
            {{-- border-red-500 diubah menjadi border-orange-500 --}}
            <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Foto Profil" class="w-32 h-32 object-cover rounded-full border-4 border-orange-500">
        @else
            <div class="w-32 h-32 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 font-medium text-sm border-2 border-gray-300">
                Tidak ada foto
            </div>
        @endif

        <h3 class="text-2xl font-semibold text-gray-700">{{ $user->name }}</h3>
        <p class="text-gray-500 text-sm">{{ $user->email }}</p>
        
        <a href="{{ route('profile.editprofile') }}"
        {{-- bg-red-600 diubah menjadi bg-orange-600 --}}
        {{-- hover:bg-red-700 diubah menjadi hover:bg-orange-700 --}}
        class="mt-4 bg-orange-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-orange-700 transition shadow-md">
            Edit Profil & Alamat
        </a>
    </div>

    {{-- INFORMASI PRIBADI --}}
    <div class="bg-white shadow-lg rounded-xl p-6 space-y-4">
        <h3 class="text-xl font-bold text-gray-700 mb-4 border-b pb-2">Informasi Akun</h3>
        <div class="space-y-3 text-gray-700">
            <div class="grid grid-cols-2">
                <span class="font-semibold text-gray-500">Nama:</span> 
                <span class="text-right">{{ $user->name }}</span>
            </div>
            <div class="grid grid-cols-2">
                <span class="font-semibold text-gray-500">Email:</span> 
                <span class="text-right">{{ $user->email }}</span>
            </div>
            
            {{-- DATA BARU: Telepon --}}
            <div class="grid grid-cols-2">
                <span class="font-semibold text-gray-500">Telepon:</span> 
                <span class="text-right">{{ $user->phone ?? 'Belum disetel' }}</span>
            </div>
            
            {{-- DATA BARU: Tanggal Lahir --}}
            <div class="grid grid-cols-2">
                <span class="font-semibold text-gray-500">Tanggal Lahir:</span> 
                <span class="text-right">
                    @if($user->birth_date)
                        {{ \Carbon\Carbon::parse($user->birth_date)->format('d F Y') }}
                    @else
                        Belum disetel
                    @endif
                </span>
            </div>
        </div>
    </div>

    {{-- ALAMAT PENGIRIMAN --}}
    <div class="bg-white shadow-lg rounded-xl p-6 space-y-4">
        <h3 class="text-xl font-bold text-gray-700 mb-4 border-b pb-2">Alamat Pengiriman</h3>
        @if($user->addresses && count($user->addresses) > 0)
            <ul class="space-y-3 text-gray-700">
                @foreach($user->addresses as $address)
                    <li class="border border-gray-200 rounded-lg p-3 bg-gray-50">
                        {{-- text-red-600 diubah menjadi text-orange-600 --}}
                        <p class="font-bold text-orange-600">
                            {{ $address->label }}
                            {{-- bg-red-100 dan text-red-500 diubah menjadi orange --}}
                            @if($address->is_default) <span class="text-xs bg-orange-100 text-orange-500 px-2 py-0.5 rounded-full font-medium ml-2">Utama</span> @endif
                        </p>
                        <p class="text-sm text-gray-700">{{ $address->full_address }}, {{ $address->city }}, {{ $address->postal_code }}</p>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">Belum ada alamat tersimpan.</p>
        @endif
        
        {{-- TOMBOL TAMBAH ALAMAT BARU DIHAPUS DARI SINI --}}
    </div>

    {{-- RIWAYAT PESANAN (Komentar tidak diubah) --}}
    {{-- <div class="bg-white shadow-lg rounded-xl p-6 space-y-4">
        <h3 class="text-xl font-bold text-gray-700 mb-4 border-b pb-2">Riwayat Pesanan</h3>
        @if(isset($user->orders) && count($user->orders) > 0)
            <div class="space-y-3">
                @foreach($user->orders as $order)
                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50 flex flex-col space-y-1">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-800">Pesanan #{{ $order->id }}</span>
                            <span class="text-xs font-medium px-2 py-1 rounded-full text-white 
                            @if($order->status == 'Selesai') bg-green-500 
                            @elseif($order->status == 'Diproses') bg-yellow-500
                            @else bg-gray-500 @endif">
                                {{ $order->status }}
                            </span>
                        </div>
                        <div class="text-sm text-gray-600">Tanggal: {{ $order->created_at->format('d M Y') }}</div>
                        <div class="text-sm font-bold text-orange-600">Total: Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                        <div class="pt-2">
                            <a href="{{ route('orders.show', $order->id) }}" class="text-orange-500 hover:underline text-sm font-semibold">Lihat Detail Pesanan &rarr;</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">Belum ada pesanan.</p>
        @endif
    </div> --}} 

</div>
@endsection