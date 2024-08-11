<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Books App</title>
    <!-- Favicons -->
    <link href="{{ asset('images/android-chrome-192x192.png') }}" rel="icon" type="image/png">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="antialiased bg-gray-100 text-gray-900 selection:bg-red-500 selection:text-white">
    <div class="relative flex flex-col min-h-screen bg-gray-100">
        @if (Route::has('login'))
            <div class="absolute top-0 right-0 p-6">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="font-semibold text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-red-500">Dashboard</a>
                @else
                    <a href="{{ route('login') }}"
                        class="font-semibold text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-red-500">Log
                        in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-red-500">Register</a>
                    @endif
                @endauth
            </div>
        @endif

        <main class="flex flex-col items-center justify-center flex-grow py-6">
            <div class="text-center max-w-2xl mx-auto px-4">
                <h1 class="text-4xl md:text-5xl font-semibold mb-4">Welcome to E-book Apps</h1>
                <p class="text-base md:text-lg text-gray-600">Find your favorite eBooks here. Browse our collection and
                    enjoy reading!</p>
            </div>
        </main>
    </div>
</body>

</html>
