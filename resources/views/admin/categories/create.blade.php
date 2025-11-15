@extends('layouts.app')
@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold metallic-text-gold font-orbitron">ADD NEW CATEGORY</h2>
            <a href="{{ route('admin.categories.index') }}" class="metallic-btn px-6 py-3 rounded-lg text-metallic-light hover:text-white transition-colors duration-300">
                ← BACK TO CATEGORIES
            </a>
        </div>

        <div class="metallic-card p-8 rounded-xl">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label for="name" class="block text-metallic-mid font-bold mb-3 text-lg">Category Name:</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                           class="metallic-input shadow-lg appearance-none border rounded-lg w-full py-4 px-4 text-lg " 
                           placeholder="Enter category name..." required>
                    @error('name') 
                    
                        <p class="text-red-400 text-sm mt-2 flex items-center">
                            <span class="mr-2">⚠️</span>{{ $message }}
                        </p> 
                    @enderror
                </div>
                
                <div class="flex items-center justify-between pt-6">
                    <button type="submit" class="metallic-btn metallic-btn-success px-8 py-4 text-lg font-bold rounded-lg text-white transition-all duration-300">
                        ✓ CREATE CATEGORY
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="text-metallic-mid hover:text-metallic-gold transition-colors duration-300 text-lg">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
