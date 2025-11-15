@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold metallic-text-gold font-orbitron">ADD NEW PURCHASE</h2>
        <a href="{{ route('purchase.index') }}" 
           class="metallic-btn px-6 py-3 rounded-lg text-metallic-light hover:text-white transition-colors duration-300">
            ← BACK TO PURCHASES
        </a>
    </div>

    <div class="metallic-card p-8 rounded-xl">
        <form action="{{ route('purchase.store') }}" method="POST">
            @csrf
            @include('purchase._form')
        </form>
    </div>
</div>
@endsection
