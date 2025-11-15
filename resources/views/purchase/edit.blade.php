@extends('layouts.app')
@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold metallic-text-gold font-orbitron">EDIT PURCHASE</h2>
            <a href="{{ route('purchase.index') }}" 
               class="metallic-btn px-6 py-3 rounded-lg text-metallic-light hover:text-white transition-colors duration-300">
                ← BACK TO PURCHASES
            </a>
        </div>

        <div class="metallic-card p-8 rounded-xl">
            <div class="mb-6 p-4 bg-steel-700/30 rounded-lg border border-steel-600">
                <p class="text-metallic-mid text-lg">
                    <span class="font-bold">Editing Purchase of:</span> {{ $purchase->product->name }}
                </p>
            </div>

            <form action="{{ route('purchase.update', $purchase) }}" method="POST">
                @csrf
                @method('PUT')
                @include('purchase._form', ['purchase' => $purchase])
            </form>
        </div>
    </div>
@endsection
