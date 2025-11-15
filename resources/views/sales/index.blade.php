@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-4xl font-bold metallic-text-gold font-orbitron">
            MANAGE SALES
        </h2>

        <a href="{{ route('sales.create') }}"
            class="metallic-btn px-8 py-4 text-lg font-bold rounded-lg text-metallic-light hover:text-white transition-colors duration-300">
            + ADD NEW SALE
        </a>
    </div>

    {{-- Alert --}}
    @include('partials.alerts')

    {{-- ================= FILTER + DOWNLOAD REPORT ================= --}}
    <div class="metallic-card p-8 rounded-xl mb-8">
        <h2 class="text-xl font-bold mb-4 text-metallic-mid">Download Sales Report</h2>

        <form action="{{ route('sales.downloadReport') }}" method="GET"
            class="grid grid-cols-1 md:grid-cols-5 gap-6 items-end">

            <div>
                <label class="block mb-1 text-metallic-mid font-semibold">Report Type</label>
                <select name="type" id="type"
                    class="rounded px-3 py-2 bg-steel-700 text-white w-full">
                    <option value="all">All Sales</option>
                    <option value="daily">Daily</option>
                    <option value="monthly">Monthly</option>
                    <option value="yearly">Yearly</option>
                    <option value="custom">Custom Range</option>
                    <option value="customer">By Customer</option>
                    <option value="product">By Product</option>
                </select>
            </div>

            {{-- DATE FROM --}}
            <div>
                <label class="block mb-1 text-metallic-mid font-semibold">From Date</label>
                <input type="date" name="from_date"
                    class="rounded px-3 py-2 bg-steel-700 text-white w-full">
            </div>

            {{-- DATE TO --}}
            <div>
                <label class="block mb-1 text-metallic-mid font-semibold">To Date</label>
                <input type="date" name="to_date"
                    class="rounded px-3 py-2 bg-steel-700 text-white w-full">
            </div>

            {{-- CUSTOMER NAME --}}
            <div>
                <label class="block mb-1 text-metallic-mid font-semibold">Customer</label>
                <input type="text" name="customer_name"
                    placeholder="Enter Customer Name"
                    class="rounded px-3 py-2 bg-steel-700 text-white w-full">
            </div>

            {{-- PRODUCT NAME --}}
            <div>
                <label class="block mb-1 text-metallic-mid font-semibold">Product</label>
                <input type="text" name="product_name"
                    placeholder="Enter Product Name"
                    class="rounded px-3 py-2 bg-steel-700 text-white w-full">
            </div>

            <button type="submit"
                class="bg-metallic-gold text-black px-6 py-3 rounded hover:bg-yellow-400 transition-colors font-bold col-span-1 md:col-span-5">
                ⬇ Download PDF Report
            </button>

        </form>
    </div>

    {{-- ================== SALES TABLE ================== --}}
    <div class="metallic-card p-8 rounded-xl">
        <div class="overflow-x-auto">
            <table class="metallic-table min-w-full rounded-lg overflow-hidden">
                <thead>
                    <tr>
                        <th class="px-8 py-4 text-left text-lg font-bold">#</th>
                        <th class="px-8 py-4 text-left text-lg font-bold">Date</th>
                        <th class="px-8 py-4 text-left text-lg font-bold">Customer</th>
                        <th class="px-8 py-4 text-left text-lg font-bold">Products</th>
                        <th class="px-8 py-4 text-left text-lg font-bold">Total</th>
                        <th class="px-8 py-4 text-left text-lg font-bold">Invoice</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($sales as $sale)
                        <tr class="hover:bg-steel-700/30 transition-colors duration-200">

                            <td class="px-8 py-6 text-lg">{{ $loop->iteration }}</td>

                            <td class="px-8 py-6 text-lg">
                                {{ \Carbon\Carbon::parse($sale->sale_date)->format('d M Y') }}
                            </td>

                            <td class="px-8 py-6 text-lg">{{ $sale->customer->name ?? 'Walk-in' }}</td>

                            <td class="px-8 py-6 text-lg">
                                @foreach ($sale->saleItems as $item)
                                    <div>{{ $item->product->name }} × {{ $item->quantity }}</div>
                                @endforeach
                            </td>

                            <td class="px-8 py-6 text-lg text-metallic-gold font-bold">
                                Rs. {{ number_format($sale->final_amount, 2) }}
                            </td>

                            {{-- ==== INVOICE BUTTON ==== --}}
                            <td class="px-8 py-6">
                                <a href="{{ route('sales.invoice', $sale->id) }}"
                                    class="px-5 py-2 rounded bg-metallic-gold text-black font-bold hover:bg-yellow-400">
                                    🧾 Invoice
                                </a>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="8"
                                class="px-8 py-12 text-center text-metallic-mid text-lg">
                                No sales found.
                                <a href="{{ route('sales.create') }}"
                                    class="text-metallic-gold hover:text-yellow-300">
                                    Create one now
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($sales->hasPages())
            <div class="mt-8 flex justify-center">
                <div class="bg-steel-700/50 rounded-lg p-4">
                    {{ $sales->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

@endsection
