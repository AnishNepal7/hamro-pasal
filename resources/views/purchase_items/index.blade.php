@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold metallic-text-gold font-orbitron">PURCHASE ITEMS</h2>
        <a href="{{ route('purchase_items.create') }}" 
           class="metallic-btn px-6 py-3 rounded-lg text-metallic-light hover:text-white transition-colors duration-300">
            + ADD ITEM
        </a>
    </div>

    <div class="metallic-card p-6 rounded-xl">
        <table class="w-full border-collapse text-left">
            <thead>
                <tr class="border-b border-metallic-light/30">
                    <th class="py-3 px-4 text-metallic-mid">#</th>
                    <th class="py-3 px-4 text-metallic-mid">Purchase</th>
                    <th class="py-3 px-4 text-metallic-mid">Product</th>
                    <th class="py-3 px-4 text-metallic-mid">Quantity</th>
                    <th class="py-3 px-4 text-metallic-mid">Price</th>
                    <th class="py-3 px-4 text-metallic-mid">Total</th>
                    <th class="py-3 px-4 text-metallic-mid text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($purchase_items as $item)
                    <tr class="border-b border-metallic-light/10 hover:bg-steel-800/30">
                        <td class="py-3 px-4">{{ $loop->iteration }}</td>
                        <td class="py-3 px-4">{{ $item->purchase->id ?? 'N/A' }}</td>
                        <td class="py-3 px-4">{{ $item->product->name ?? 'N/A' }}</td>
                        <td class="py-3 px-4">{{ $item->quantity }}</td>
                        <td class="py-3 px-4">{{ number_format($item->cost_price, 2) }}</td>
                        <td class="py-3 px-4">{{ number_format($item->quantity * $item->cost_price, 2) }}</td>
                        <td class="py-3 px-4 text-center">
                            <div class="flex justify-center gap-3">
                                <a href="{{ route('purchase_items.edit', $item) }}" class="text-yellow-400 hover:text-yellow-300">✏️</a>
                                <form action="{{ route('purchase_items.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this item?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-400">🗑️</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-4 text-center text-metallic-mid">No purchase items found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
