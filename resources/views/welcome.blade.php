<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pesantren Nurul Amin</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-[#0f172a] text-white min-h-screen flex items-center justify-center selection:bg-indigo-500 selection:text-white" style="background-image: radial-gradient(circle at center, #1e293b 0%, #0f172a 100%);">
    
    <div class="relative w-full max-w-3xl px-6 flex flex-col items-center justify-center text-center animate-fade-in-up">
        
        <div class="mb-8">
            <img src="{{ asset('logo-pondok.png') }}" alt="Logo Pesantren" class="w-32 md:w-48 drop-shadow-2xl mx-auto transition-transform hover:scale-105 duration-300">
        </div>

        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight text-white mb-6 drop-shadow-md">
            WELCOME
        </h1>
        
        <p class="text-lg md:text-xl text-gray-400 mb-10 max-w-2xl mx-auto font-medium">
            Sistem Informasi Pesantren
        </p>

        @if (Route::has('login'))
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-8 py-3.5 border border-transparent text-base font-bold rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 transition-all shadow-lg hover:shadow-indigo-500/40">
                        Masuk ke Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-3.5 border border-transparent text-base font-bold rounded-lg text-white bg-[#0f9d58] hover:bg-[#0b8043] transition-all shadow-lg hover:shadow-green-500/40">
                        Masuk ke Aplikasi
                    </a>
                @endauth
            </div>
        @endif
    </div>

</body>
</html>