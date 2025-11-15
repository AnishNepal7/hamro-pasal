@extends('layouts.app')
@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold metallic-text-gold font-orbitron">ADD STOCK MOVEMENT</h2>
        <a href="{{ route('stock_movements.index') }}" class="metallic-btn px-6 py-3 rounded-lg text-metallic-light hover:text-white">
            ← BACK TO STOCK MOVEMENTS
        </a>
    </div>

    <div class="metallic-card p-8 rounded-xl">
        <form action="{{ route('stock_movements.store') }}" method="POST">
            @csrf
            @include('stock_movements._form')
        </form>
    </div>
</div>
@endsection
