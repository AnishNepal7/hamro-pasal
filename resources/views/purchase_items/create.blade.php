@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold metallic-text-gold font-orbitron">ADD PURCHASE ITEM</h2>
        <a href="{{ route('purchase_items.index') }}"
           class="metallic-btn px-6 py-3 rounded-lg text-metallic-light hover:text-white transition-colors duration-300">
           ← BACK TO PURCHASE ITEMS
        </a>
    </div>

    <div class="metallic-card p-8 rounded-xl">
        <form action="{{ route('purchase_items.store') }}" method="POST">
            @csrf
            @include('purchase_items._form')
        </form>
    </div>
</div>
@endsection
