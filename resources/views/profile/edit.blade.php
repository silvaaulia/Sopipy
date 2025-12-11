@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-12 px-4 sm:px-6 lg:px-8 space-y-8">

    <h2 class="text-3xl font-bold text-gray-800 text-center mb-8">Edit Profil Saya</h2>
    
    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Notifikasi Error (Diubah: bg-red-100, border-red-400, text-red-700) --}}
    @if ($errors->any())
        <div class="bg-orange-100 border border-orange-400 text-orange-700 px-4 py-3 rounded relative">
            <strong class="font-bold">Oops!</strong>
            <span class="block sm:inline">Ada masalah dengan input Anda.</span>
            {{-- TAMBAHKAN LIST ERROR --}}
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            {{-- AKHIR LIST ERROR --}}
        </div>
    @endif
    
    {{-- FORM 1: INFORMASI PRIBADI & FOTO (ID: profileForm) --}}
    <form method="POST" action="{{ route('profile.updateprofile') }}" enctype="multipart/form-data" class="space-y-8" id="profileForm">
        @csrf
        @method('PUT')

        {{-- FOTO PROFIL (SECTION UNTUK UPLOAD FOTO) --}}
        <div class="bg-white shadow-lg rounded-xl p-6 flex flex-col items-center space-y-4">
            <h3 class="text-xl font-bold text-gray-700 mb-2 border-b w-full text-center pb-2">Ubah Foto Profil</h3>
            
            @if($user->profile_photo)
                {{-- border-red-500 diubah menjadi border-orange-500 --}}
                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Foto Profil" id="profile_preview" class="w-32 h-32 object-cover rounded-full border-4 border-orange-500">
            @else
                <div class="w-32 h-32 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 font-medium text-sm" id="profile_placeholder">
                    Tidak ada foto
                </div>
                {{-- border-red-500 diubah menjadi border-orange-500 --}}
                <img src="#" alt="Foto Profil" id="profile_preview" class="w-32 h-32 object-cover rounded-full border-4 border-orange-500 hidden">
            @endif

            {{-- File Input Button diubah: file:bg-red-50, file:text-red-700, hover:file:bg-red-100 --}}
            <input type="file" name="profile_photo" id="profile_photo" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100" onchange="previewFile(this);">
        </div>

        {{-- INFORMASI PRIBADI (FIELD INPUT) --}}
        <div class="bg-white shadow-lg rounded-xl p-6 space-y-6">
            <h3 class="text-xl font-bold text-gray-700 mb-4 border-b pb-2">Edit Informasi Akun</h3>
            
            {{-- Nama --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                {{-- focus:ring-red-500, focus:border-red-500, @error('name') border-red-500 @enderror diubah --}}
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-orange-500 focus:border-orange-500 @error('name') border-orange-500 @enderror">
                
                {{-- TAMBAHKAN BLOK ERROR INI --}}
                {{-- text-red-500 diubah menjadi text-orange-500 --}}
                @error('name')
                    <p class="text-xs text-orange-500 mt-1">{{ $message }}</p>
                @enderror
                
            </div>

            {{-- Email (Readonly) --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 bg-gray-100 cursor-not-allowed" readonly>
                <p class="text-xs text-gray-500 mt-1">Email tidak dapat diubah di sini.</p>
            </div>
            
            {{-- Telepon --}}
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Telepon</label>
                {{-- focus:ring-red-500, focus:border-red-500 diubah --}}
                <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-orange-500 focus:border-orange-500">
            </div>

            {{-- Tanggal Lahir --}}
            <div>
                <label for="birth_date" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                {{-- focus:ring-red-500, focus:border-red-500 diubah --}}
                <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date', $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('Y-m-d') : '') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-orange-500 focus:border-orange-500">
            </div>
            
            <button type="submit" id="hiddenProfileSubmit" class="hidden"></button>
        </div>
    </form>
    
    {{-- MANAJEMEN ALAMAT PENGIRIMAN --}}
    <div class="bg-white shadow-lg rounded-xl p-6 space-y-6">
        <h3 class="text-xl font-bold text-gray-700 mb-4 border-b pb-2">Manajemen Alamat Pengiriman</h3>

        {{-- DAFTAR ALAMAT YANG SUDAH ADA --}}
        @if($user->addresses && count($user->addresses) > 0)
            <div class="space-y-3">
                <p class="font-semibold text-sm text-gray-600">Alamat Tersimpan ({{ count($user->addresses) }})</p>
                @foreach($user->addresses as $address)
                    <div class="border border-gray-200 rounded-lg p-3 bg-gray-50 flex justify-between items-start">
                        <div>
                            {{-- text-red-600 diubah menjadi text-orange-600 --}}
                            <p class="font-bold text-orange-600">{{ $address->label }} 
                                {{-- bg-red-100 dan text-red-500 diubah menjadi orange --}}
                                @if($address->is_default) <span class="text-xs bg-orange-100 text-orange-500 px-2 py-0.5 rounded-full font-medium">Utama</span> @endif
                            </p>
                            <p class="text-sm text-gray-700">{{ $address->full_address }}</p>
                        </div>
                        <div class="flex space-x-2 text-sm">
                            <button class="text-blue-500 hover:text-blue-700">Edit</button>
                            {{-- text-red-500 dan hover:text-red-700 diubah menjadi orange --}}
                            <button class="text-orange-500 hover:text-orange-700">Hapus</button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 italic">Belum ada alamat tersimpan.</p>
        @endif

        <hr class="border-t border-gray-100">
        
        {{-- FORM 2: TAMBAH ALAMAT BARU (ID: addressForm) --}}
        <h4 class="text-lg font-bold text-gray-700 mb-4">Tambah Alamat Baru</h4>
        
        <form method="POST" action="{{ route('profile.storeaddress') }}" class="space-y-4" id="addressForm">
            @csrf
            
            {{-- Label Alamat (Rumah, Kantor, dll) --}}
            <div>
                <label for="label_address" class="block text-sm font-medium text-gray-700">Label Alamat (Contoh: Rumah)</label>
                {{-- focus:ring-red-500, focus:border-red-500 diubah --}}
                <input type="text" id="label_address" name="label" value="{{ old('label') }}" 
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-orange-500 focus:border-orange-500">
            </div>

            {{-- Alamat Lengkap --}}
            <div>
                <label for="full_address" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                {{-- focus:ring-red-500, focus:border-red-500 diubah --}}
                <textarea id="full_address" name="full_address" rows="3" 
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-orange-500 focus:border-orange-500">{{ old('full_address') }}</textarea>
            </div>
            
            {{-- Kota --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700">Kota/Kabupaten</label>
                    {{-- focus:ring-red-500, focus:border-red-500 diubah --}}
                    <input type="text" id="city" name="city" value="{{ old('city') }}" 
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-orange-500 focus:border-orange-500">
                </div>
                <div>
                    <label for="postal_code" class="block text-sm font-medium text-gray-700">Kode Pos</label>
                    {{-- focus:ring-red-500, focus:border-red-500 diubah --}}
                    <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}" 
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-orange-500 focus:border-orange-500">
                </div>
            </div>

            {{-- Set sebagai Alamat Utama --}}
            <div class="flex items-center pt-2">
                {{-- text-red-600 dan focus:ring-red-500 diubah menjadi orange --}}
                <input id="is_default" name="is_default" type="checkbox" value="1" 
                        class="h-4 w-4 text-orange-600 border-gray-300 rounded focus:ring-orange-500">
                <label for="is_default" class="ml-2 block text-sm text-gray-900">
                    Jadikan Alamat Utama
                </label>
            </div>
            
        </form>
    </div>
    
    {{-- Formulir Ganti Password (Tetap terpisah) --}}
    <div class="bg-white shadow-lg rounded-xl p-6 space-y-4">
        <h3 class="text-xl font-bold text-gray-700 mb-4 border-b pb-2">Ganti Kata Sandi</h3>
        <p class="text-gray-500 text-sm">Untuk keamanan, ganti kata sandi di formulir khusus.</p>
        <button class="text-sm font-semibold text-gray-600 hover:text-gray-700 transition border border-gray-300 px-4 py-2 rounded-lg">
            Ganti Password
        </button>
    </div>
    
    {{-- TOMBOL SIMPAN UTAMA (Diubah: bg-red-600, hover:bg-red-700) --}}
    <div class="flex justify-center pt-8 pb-4">
        <button type="button" onclick="submitCombinedForms()" class="bg-orange-600 text-white px-8 py-3 rounded-lg font-bold text-lg hover:bg-orange-700 transition shadow-lg w-full max-w-sm">
            SIMPAN SEMUA PERUBAHAN
        </button>
    </div>

</div>

<script>
    // --- Logika Preview Foto ---
    function previewFile(input) {
        var file = input.files[0];
        var preview = document.getElementById('profile_preview');
        var placeholder = document.getElementById('profile_placeholder');

        if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if (placeholder) {
                    placeholder.classList.add('hidden');
                }
            }
            reader.readAsDataURL(file);
        } else {
            if (placeholder) {
                placeholder.classList.remove('hidden');
            }
            if (preview && preview.src.includes('#')) { 
                preview.classList.add('hidden');
            }
        }
    }

    // --- Logika Pengiriman Form Gabungan (Single Submit) ---
    function submitCombinedForms() {
    const profileForm = document.getElementById('profileForm');
    const addressForm = document.getElementById('addressForm');
    
    // Ambil nilai dari field yang WAJIB diisi untuk Form Alamat (sesuai Controller)
    const requiredLabel = document.getElementById('label_address').value.trim();
    const requiredCity = document.getElementById('city').value.trim();
    const requiredPostalCode = document.getElementById('postal_code').value.trim();
    
    // Cek apakah SEMUA field required untuk alamat sudah diisi
    const isAddressFormReady = requiredLabel !== '' && requiredCity !== '' && requiredPostalCode !== '';

    if (isAddressFormReady) {
        // Jika SEMUA field required terisi, kirim form alamat
        addressForm.submit();
    } else {
        // Jika TIDAK SEMUA field required terisi, kirim form profil saja
        profileForm.submit();
    }
}
</script>
@endsection