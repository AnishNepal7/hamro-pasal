@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Stock Movement Report</h2>

    <div class="metallic-card p-6 mb-6">
        <form action="{{ route('stock-movements.report.download') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Report Range</label>
                <select name="type" id="type" class="w-full p-2 rounded bg-steel-700 text-white">
                    <option value="full">Full History</option>
                    <option value="daily">Daily</option>
                    <option value="monthly">Monthly</option>
                    <option value="yearly">Yearly</option>
                    <option value="range">Custom Range</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">From</label>
                <input type="date" name="from" id="from" class="w-full p-2 rounded bg-steel-700 text-white">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">To</label>
                <input type="date" name="to" id="to" class="w-full p-2 rounded bg-steel-700 text-white">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Product (optional)</label>
                <select name="product_id" class="w-full p-2 rounded bg-steel-700 text-white">
                    <option value="">All Products</option>
                    @foreach($products as $prod)
                        <option value="{{ $prod->id }}">{{ $prod->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Movement Type</label>
                <select name="mov_type" class="w-full p-2 rounded bg-steel-700 text-white">
                    <option value="ALL">All</option>
                    <option value="IN">IN</option>
                    <option value="OUT">OUT</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Rows per PDF page</label>
                <input type="number" name="page_size" value="40" min="10" max="200" class="w-full p-2 rounded bg-steel-700 text-white">
            </div>

            <div class="md:col-span-3 lg:col-span-1 flex items-end space-x-2">
                <button type="submit" class="bg-metallic-gold px-4 py-2 rounded font-bold">Download PDF</button>
                <a href="{{ route('stock-movements.index') }}" class="bg-steel-700 px-4 py-2 rounded">Back</a>
            </div>
        </form>
    </div>

    <p class="text-sm text-metallic-mid">Tip: choose "Custom Range" to enter dates in the From / To fields.</p>
</div>

<script>
    // Show/hide date inputs depending on type
    const typeSelect = document.getElementById('type');
    const fromInput = document.getElementById('from');
    const toInput = document.getElementById('to');

    function toggleDateInputs() {
        if (typeSelect.value === 'range') {
            fromInput.disabled = false;
            toInput.disabled = false;
        } else {
            fromInput.disabled = true;
            toInput.disabled = true;
            fromInput.value = '';
            toInput.value = '';
        }
    }

    typeSelect.addEventListener('change', toggleDateInputs);
    toggleDateInputs();
</script>
@endsection
