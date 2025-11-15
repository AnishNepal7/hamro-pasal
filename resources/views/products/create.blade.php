@extends('layouts.app')
@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold metallic-text-gold font-orbitron">ADD NEW PRODUCT</h2>
            <a href="{{ route('products.index') }}" class="metallic-btn px-6 py-3 rounded-lg text-metallic-light hover:text-white transition-colors duration-300">
                ← BACK TO PRODUCTS
            </a>
        </div>

        <div class="metallic-card p-8 rounded-xl">
            <form action="{{ route('products.store') }}" method="POST">
                @csrf
                @include('products._form')
            </form>
        </div>
    </div>
@endsection
