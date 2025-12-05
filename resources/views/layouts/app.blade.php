<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

</head>
<body class="bg-gray-50">

    {{-- Header --}}
    @include('profile.partials.header')

    {{-- Konten utama --}}
    <main class="max-w-7xl mx-auto mt-6 px-4">
        @yield('content')
    </main>

    @include('layouts.footer')

</body>
</html>
