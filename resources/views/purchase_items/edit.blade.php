@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold metallic-text-gold font-orbitron">EDIT PURCHASE ITEM</h2>
        <a href="{{ route('purchase_items.index') }}"
           class="metallic-btn px-6 py-3 rounded-lg text-metallic-light hover:text-white transition-colors duration-300">
           ← BACK TO PURCHASE ITEMS
        </a>
    </div>

    <div class="metallic-card p-8 rounded-xl">
        <div class="mb-6 p-4 bg-steel-700/30 rounded-lg border border-steel-600">
            <p class="text-metallic-mid text-lg">
                <span class="font-bold">Editing:</span> {{ $purchase_item->product->name ?? 'N/A' }}
            </p>
        </div>

        <form action="{{ route('purchase_items.update', $purchase_item) }}" method="POST">
            @csrf
            @method('PUT')
            @include('purchase_items._form', ['purchase_item' => $purchase_item])
        </form>
    </div>
</div>
@endsection
