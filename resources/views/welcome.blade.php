<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - My App</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    <div class="min-h-screen flex items-center justify-center px-4">
        
        <div class="bg-white w-full max-w-md rounded-xl shadow-lg p-8">

            <!-- Logo -->
            <div class="flex justify-center mb-8">
                <div class="flex items-center gap-3">
                    <div class="bg-orange-500 text-white w-12 h-12 flex justify-center items-center rounded-lg text-2xl font-bold">
                        S
                    </div>
                    <span class="text-3xl font-bold text-orange-500 tracking-wide">Sopipy</span>
                </div>
            </div>

            <!-- Title -->
            <h2 class="text-xl font-semibold text-gray-800 text-center mb-6">
                Log in to Your Account
            </h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <input type="email" name="email" required autofocus
                        class="w-full border rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                        placeholder="Email">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <input type="password" name="password" required
                        class="w-full border rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                        placeholder="Password">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Forgot Password -->
                <div class="text-right mb-4">
                    <a href="#" class="text-orange-600 text-xs hover:underline">
                        Lupa Password?
                    </a>
                </div>

                <!-- Button -->
                <button type="submit"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-lg transition-all duration-200">
                    Login
                </button>

                <!-- OR Divider -->
                <div class="flex items-center my-6">
                    <div class="border-b flex-1"></div>
                    <span class="text-xs text-gray-400 px-3">ATAU</span>
                    <div class="border-b flex-1"></div>
                </div>

                <!-- Register -->
                <p class="text-center text-sm text-gray-700">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-orange-600 font-semibold hover:underline">
                        Daftar
                    </a>
                </p>

            </form>

        </div>

    </div>

</body>
</html>
