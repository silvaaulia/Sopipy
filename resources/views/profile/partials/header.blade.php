<header class="bg-orange-500 text-white py-3 shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto flex justify-between items-center px-4 gap-4">

        {{-- Logo --}}
        <h1 class="text-2xl font-bold tracking-wide flex items-center gap-1">
            <span class="bg-white text-orange-500 font-extrabold rounded-lg px-2 py-1">S</span>
            opipy
        </h1>

        {{-- Search Box --}}
<div class="hidden md:flex items-center bg-white border border-gray-300 rounded-full w-full max-w-lg mx-auto shadow-sm focus-within:ring-2 focus-within:ring-orange-400 transition">
    <input type="text"
           placeholder="Cari barang..."
           class="flex-grow px-4 py-2 rounded-l-full focus:outline-none text-gray-700 placeholder-gray-400">
    <button class="bg-orange-500 text-white px-4 py-2 rounded-r-full hover:bg-orange-600 transition-colors">
        <i class="fa-solid fa-magnifying-glass"></i>
    </button>
</div>



        {{-- Menu Auth & Keranjang --}}
        <div class="flex items-center gap-4">

            @php
                $cartCount = session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0;
            @endphp

            {{-- Cart --}}
            <a href="{{ route('cart.index') }}" class="relative text-gray-700 hover:text-gray-900 transition">
                <i class="fa-solid fa-cart-shopping text-2xl"></i>
                @if ($cartCount > 0)
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full px-2 py-0.5 shadow-md">
                        {{ $cartCount }}
                    </span>
                @endif
            </a>

            {{-- Akun & Logout --}}
            <nav class="space-x-4 text-sm font-medium text-white flex items-center">
                <a href="{{ route('profile.show') }}" class="hover:underline transition">Akun Saya</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="hover:underline transition">Logout</button>
                </form>
            </nav>

        </div>
    </div>
</header>
