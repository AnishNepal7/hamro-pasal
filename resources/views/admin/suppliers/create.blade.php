@extends('layouts.app')
@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold metallic-text-gold font-orbitron">ADD NEW SUPPLIER</h2>
            <a href="{{ route('admin.suppliers.index') }}" class="metallic-btn px-6 py-3 rounded-lg text-metallic-light hover:text-white transition-colors duration-300">
                ← BACK TO SUPPLIERS
            </a>
        </div>

        <div class="metallic-card p-8 rounded-xl">
            <form action="{{ route('admin.suppliers.store') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label for="name" class="block text-metallic-mid font-bold mb-3 text-lg">Supplier Name:</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                           class="metallic-input shadow-lg appearance-none border rounded-lg w-full py-4 px-4 text-lg" 
                           placeholder="Enter supplier name..." required>
                    @error('name') 
                        <p class="text-red-400 text-sm mt-2 flex items-center">
                            <span class="mr-2">⚠️</span>{{ $message }}
                        </p> 
                    @enderror
                </div>
                @csrf
                <div class="mb-6">
                    <label for="company" class="block text-metallic-mid font-bold mb-3 text-lg">Company:</label>
                    <input type="text" name="company" id="company" value="{{ old('company') }}" 
                           class="metallic-input shadow-lg appearance-none border rounded-lg w-full py-4 px-4 text-lg" 
                           placeholder="Enter Company name..." required>
                    @error('Company') 
                        <p class="text-red-400 text-sm mt-2 flex items-center">
                            <span class="mr-2">⚠️</span>{{ $message }}
                        </p> 
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="contact" class="block text-metallic-mid font-bold mb-3 text-lg">Contact:</label>
                    <input type="text" name="contact" id="contact" value="{{ old('contact') }}" 
                           class="metallic-input shadow-lg appearance-none border rounded-lg w-full py-4 px-4 text-lg" 
                           placeholder="Enter contact name..." required>
                    @error('contact') 
                        <p class="text-red-400 text-sm mt-2 flex items-center">
                            <span class="mr-2">⚠️</span>{{ $message }}
                        </p> 
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="email" class="block text-metallic-mid font-bold mb-3 text-lg">Email:</label>
                    <input type="text" name="email" id="email" value="{{ old('email') }}" 
                           class="metallic-input shadow-lg appearance-none border rounded-lg w-full py-4 px-4 text-lg" 
                           placeholder="Enter email ..." required>
                    @error('email') 
                        <p class="text-red-400 text-sm mt-2 flex items-center">
                            <span class="mr-2">⚠️</span>{{ $message }}
                        </p> 
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="address" class="block text-metallic-mid font-bold mb-3 text-lg">Address:</label>
                    <input type="text" name="address" id="address" value="{{ old('address') }}" 
                           class="metallic-input shadow-lg appearance-none border rounded-lg w-full py-4 px-4 text-lg" 
                           placeholder="Enter address name..." required>
                    @error('address') 
                        <p class="text-red-400 text-sm mt-2 flex items-center">
                            <span class="mr-2">⚠️</span>{{ $message }}
                        </p> 
                    @enderror
                </div>
                
                <div class="flex items-center justify-between pt-6">
                    <button type="submit" class="metallic-btn metallic-btn-success px-8 py-4 text-lg font-bold rounded-lg text-white transition-all duration-300">
                        ✓ CREATE SUPPLIER
                    </button>
                    <a href="{{ route('admin.suppliers.index') }}" class="text-metallic-mid hover:text-metallic-gold transition-colors duration-300 text-lg">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
