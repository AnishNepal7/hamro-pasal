@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="max-w-2xl mx-auto text-center">
        <!-- Error Icon with Metallic Styling -->
        <div class="logo-container pulse mb-8">
            <div class="bg-gradient-to-br from-yellow-400 via-yellow-500 to-yellow-600 rounded-full p-8 shadow-metallic">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>
        </div>

        <!-- Error Code -->
        <h1 class="text-8xl md:text-9xl font-bold mb-4 metallic-text font-orbitron tracking-tighter">
            404
        </h1>

        <!-- Error Title -->
        <h2 class="text-3xl md:text-4xl font-bold mb-6 text-metallic-light font-orbitron tracking-tight">
            PAGE NOT FOUND
        </h2>

        <!-- Error Description -->
        <p class="text-xl text-metallic-mid mb-12 max-w-lg mx-auto font-light tracking-wide">
            The requested resource could not be located. The page may have been moved or deleted.
        </p>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-6 justify-center">
            <a href="{{ url()->previous() }}" class="metallic-btn px-8 py-4 text-lg font-bold rounded-lg text-metallic-light hover:text-white transition-colors duration-300">
                <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                GO BACK
            </a>
            <a href="{{ url('/') }}" class="metallic-btn px-8 py-4 text-lg font-bold rounded-lg bg-gradient-to-r from-metallic-gold/20 to-metallic-gold/10 text-metallic-gold border-metallic-gold hover:text-yellow-200 transition-colors duration-300">
                <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                RETURN HOME
            </a>
        </div>

        <!-- Footer -->
        <div class="mt-16 text-center text-steel-100 text-sm">
            <p>© {{ date('Y') }} Bazaar Buddy. All rights reserved.</p>
        </div>
    </div>
</div>
@endsection
