@extends('layouts.app')
@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold metallic-text-gold font-orbitron">EDIT PRODUCT</h2>
            <a href="{{ route('products.index') }}" class="metallic-btn px-6 py-3 rounded-lg text-metallic-light hover:text-white transition-colors duration-300">
                ← BACK TO PRODUCTS
            </a>
        </div>

        <div class="metallic-card p-8 rounded-xl">
            <div class="mb-6 p-4 bg-steel-700/30 rounded-lg border border-steel-600">
                <p class="text-metallic-mid text-lg">
                    <span class="font-bold">Editing:</span> {{ $product->name }}
                </p>
            </div>

            <form action="{{ route('products.update', $product) }}" method="POST">
                @csrf
                @method('PUT')
                @include('products._form', ['product' => $product])
            </form>
        </div>
    </div>
@endsection
