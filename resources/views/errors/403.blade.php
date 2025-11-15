@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto text-center">
            <!-- Error Code -->
            <div class="mb-8">
                <h1 class="text-9xl font-bold metallic-text font-orbitron tracking-tight">
                    403
                </h1>
                <div class="h-1 w-32 bg-gradient-to-r from-red-600 to-red-400 mx-auto mb-6"></div>
            </div>

            <!-- Error Icon -->
            <div class="mb-8">
                <div class="inline-flex items-center justify-center w-32 h-32 bg-gradient-to-br from-red-600/20 to-red-800/20 rounded-full border-2 border-red-600/50">
                    <div class="text-6xl text-red-400">🔒</div>
                </div>
            </div>

            <!-- Error Content -->
            <div class="metallic-card backdrop-blur-sm p-8 rounded-xl border border-red-600/50">
                <h2 class="text-3xl font-bold text-red-400 mb-4">
                    ACCESS FORBIDDEN
                </h2>
                
                <p class="text-metallic-mid text-lg mb-8 leading-relaxed">
                    You don't have the necessary permissions to access this resource. 
                    Contact your administrator if you believe this is an error.
                </p>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ url()->previous() }}" 
                       class="metallic-btn px-8 py-3 text-lg font-bold rounded-lg text-metallic-light hover:text-white transition-all duration-300">
                        <span class="mr-2">←</span> Go Back
                    </a>
                    
                    <a href="{{ route('dashboard') }}" 
                       class="bg-gradient-to-r from-metallic-gold/20 to-metallic-gold/10 border-2 border-metallic-gold/50 text-metallic-gold hover:text-yellow-200 px-8 py-3 text-lg font-bold rounded-lg transition-all duration-300">
                        <span class="mr-2">🏠</span> Dashboard
                    </a>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="mt-8 text-steel-100 text-sm">
                <p>Error Code: 403 | Access Denied</p>
            </div>
        </div>
    </div>
</div>
@endsection
