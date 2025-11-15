<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-gray-900 via-gray-800 to-gray-700 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-gray-900/90 backdrop-blur-lg rounded-3xl shadow-2xl p-8">
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-tr from-amber-400 via-amber-500 to-amber-600 mx-auto mb-4 shadow-lg">
                <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M2 17L12 22L22 17" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M2 12L12 17L22 12" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-100 tracking-tight">Welcome Back!</h2>
            <p class="text-gray-400 mt-1">Sign in to your account</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4 text-amber-400" :status="session('status')" />

        {{ $slot }}

        <div class="mt-6 text-center text-gray-400">
            <p>Don't have an account? 
                <a href="{{ route('register') }}" class="text-amber-400 font-semibold hover:text-amber-300">Sign up</a>
            </p>
        </div>
    </div>

</body>
</html>

<style>
    /* Input placeholder styling */
    input::placeholder {
        color: rgba(203, 213, 225, 0.5);
        font-weight: 500;
    }
</style>
