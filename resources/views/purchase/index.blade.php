@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto">
    <!-- <div class="flex justify-between items-center mb-8">
        <h2 class="text-4xl font-bold metallic-text-gold font-orbitron">PURCHASES</h2>
        <a href="{{ route('purchase.create') }}" class="metallic-btn px-8 py-4 text-lg font-bold rounded-lg text-metallic-light hover:text-white transition-colors duration-300">
            + ADD NEW PURCHASE
        </a>
    </div> -->
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-4xl font-bold metallic-text-gold font-orbitron">PURCHASES</h2>
        <div class="space-x-4">

            <a href="{{ route('purchase.create') }}"
                class="metallic-btn px-8 py-4 text-lg font-bold rounded-lg text-metallic-light hover:text-white transition-colors duration-300">
                + ADD NEW PURCHASE
            </a>
        </div>
        <a href="{{ route('purchase.report.download') }}" 
           class="metallic-btn px-8 py-4 text-lg font-bold rounded-lg text-metallic-light hover:text-white transition-colors duration-300">
            📄 DOWNLOAD REPORT
        </a>
    </div>


    @if (session('success'))
    <div class="alert-success p-4 rounded-lg mb-6 flex items-center">
        <span class="text-2xl mr-3">✅</span>
        <span class="text-green-100 text-lg">{{ session('success') }}</span>
    </div>
    @endif

    <div class="metallic-card p-8 rounded-xl">
        <div class="overflow-x-auto">
            <table class="metallic-table min-w-full rounded-lg overflow-hidden">
                <thead>
                    <tr>
                        <th class="px-8 py-4 text-left text-lg font-bold">Product</th>
                        <th class="px-8 py-4 text-center text-lg font-bold">Supplier</th>
                        <th class="px-8 py-4 text-center text-lg font-bold">Quantity</th>
                        <th class="px-8 py-4 text-center text-lg font-bold">Purchase Price</th>
                        <th class="px-8 py-4 text-center text-lg font-bold">Purchase Date</th>
                        <th class="px-8 py-4 text-center text-lg font-bold">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($purchases as $purchase)
                    <tr class="hover:bg-steel-700/30 transition-colors duration-200">
                        <td class="px-8 py-6 text-lg">
                            <div>
                                <div class="font-semibold">{{ $purchase->name }}</div>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center text-lg">
                            {{ $purchase->supplier->name }}
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span class="text-lg font-mono text-metallic-mid">
                                {{ $purchase->quantity }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span class="text-lg font-mono text-metallic-gold">
                                Rs. {{ number_format($purchase->purchase_price, 2) }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-center text-metallic-mid">
                            {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d M, Y') }}
                        </td>
                        <td class="px-8 py-6 text-center">
                            <div class="flex justify-center space-x-4">
                                <a href="{{ route('purchase.edit', $purchase) }}"
                                    class="text-metallic-gold hover:text-yellow-300 transition-colors duration-200 font-semibold">
                                    ✏️ Edit
                                </a>
                                <form action="{{ route('purchase.destroy', $purchase) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Are you sure you want to delete this purchase?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-400 hover:text-red-300 transition-colors duration-200 font-semibold">
                                        🗑️ Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-12 text-center text-metallic-mid text-lg">
                            No purchases found. <a href="{{ route('purchase.create') }}" class="text-metallic-gold hover:text-yellow-300">Add one now</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Pagination --}}
        @if ($purchases->hasPages())
            <div class="mt-8 flex justify-center">
                <div class="bg-steel-700/50 rounded-lg p-4">
                    {{ $purchases->links() }}
                </div>
            </div>  
        @endif
    </div>
</div>
@endsection