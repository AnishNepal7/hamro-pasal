@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    <div class="flex justify-between items-center mb-8">
        <h2 class="text-4xl font-bold metallic-text-gold font-orbitron">STOCK MOVEMENTS</h2>

        <a href="{{ route('stock_movement.report') }}"
           class="metallic-btn px-8 py-4 text-lg font-bold rounded-lg text-metallic-light hover:text-white transition-colors duration-300">
            ⬇ DOWNLOAD REPORT
        </a>
    </div>

    @include('partials.alerts')

    <div class="metallic-card p-8 rounded-xl">
        <div class="overflow-x-auto">
            <table class="metallic-table min-w-full rounded-lg overflow-hidden">
                <thead>
                    <tr>
                        <th class="px-8 py-4 text-left text-lg font-bold">#</th>
                        <th class="px-8 py-4 text-left text-lg font-bold">Date</th>
                        <th class="px-8 py-4 text-left text-lg font-bold">Product</th>
                        <th class="px-8 py-4 text-left text-lg font-bold">Type</th>
                        <th class="px-8 py-4 text-left text-lg font-bold">Quantity</th>
                        <!-- <th class="px-8 py-4 text-left text-lg font-bold">Description</th> -->
                    </tr>
                </thead>

                <tbody>
                    @forelse($movements as $movement)
                        <tr class="hover:bg-steel-700/30 transition-colors duration-200">
                            <td class="px-8 py-6 text-lg">{{ $loop->iteration }}</td>
                            <td class="px-8 py-6 text-lg">{{ $movement->created_at->format('Y-m-d H:i') }}</td>

                            <td class="px-8 py-6 text-lg">{{ $movement->product->name }}</td>

                            <td class="px-8 py-6 text-lg">
                                <span class="px-3 py-1 rounded-full text-white 
                                    {{ $movement->type == 'IN' ? 'bg-green-500' : 'bg-red-500' }}">
                                    {{ $movement->type }}
                                </span>
                            </td>

                            <td class="px-8 py-6 text-lg">{{ $movement->quantity }}</td>
                            <!-- <td class="px-8 py-6 text-lg">{{ $movement->description ?? '-' }}</td> -->
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-12 text-center text-metallic-mid text-lg">
                                No stock movements available.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($movements->hasPages())
            <div class="mt-8 flex justify-center">
                <div class="bg-steel-700/50 rounded-lg p-4">
                    {{ $movements->links() }}
                </div>
            </div>
        @endif
    </div>

</div>
@endsection
