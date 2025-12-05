@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-12 px-4 sm:px-6 lg:px-8 space-y-8">

    <h2 class="text-3xl font-bold text-gray-800 text-center mb-8">Edit Profil Saya</h2>

    <div class="bg-white shadow-lg rounded-xl p-6 space-y-6">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- FOTO PROFIL --}}
            <div class="flex flex-col items-center space-y-4">
                @if($user->profile_photo)
                    <img src="{{ asset('storage/' . $user->profile_photo) }}" class="w-32 h-32 rounded-full object-cover border">
                @else
                    <div class="w-32 h-32 bg-gray-200 rounded-full flex items-center justify-center text-gray-500">
                        Tidak ada foto
                    </div>
                @endif

                <label class="bg-gray-100 px-4 py-2 rounded-lg cursor-pointer hover:bg-gray-200">
                    Ganti Foto
                    <input type="file" name="profile_photo" class="hidden">
                </label>
            </div>

            {{-- INFORMASI PRIBADI --}}
            <div class="space-y-4">
                <div>
                    <label class="block font-medium text-gray-700 mb-1">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border p-3 rounded-lg">
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" value="{{ $user->email }}" disabled class="w-full border p-3 rounded-lg bg-gray-100">
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1">Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full border p-3 rounded-lg">
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date', $user->birth_date) }}" class="w-full border p-3 rounded-lg">
                </div>
            </div>

            {{-- PASSWORD --}}
            <div class="space-y-4">
                <div>
                    <label class="block font-medium text-gray-700 mb-1">Password Baru</label>
                    <input type="password" name="password" class="w-full border p-3 rounded-lg" placeholder="Opsional">
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="w-full border p-3 rounded-lg" placeholder="Opsional">
                </div>
            </div>

            <div class="flex justify-between pt-4">
                <a href="{{ route('profile.show') }}" class="text-gray-600 hover:text-black font-medium">
                    Batal
                </a>

                <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-orange-600">
                    Simpan Perubahan
                </button>
            </div>
        </form>
        @if ($errors->any())
    <div class="bg-red-100 text-red-700 p-3 rounded-md">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    </div>

</div>
@endsection
