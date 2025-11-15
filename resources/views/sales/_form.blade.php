@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <h2 class="text-4xl font-bold metallic-text-gold font-orbitron mb-6">CREATE SALE</h2>

    <form action="{{ route('sales.store') }}" method="POST">
        @csrf

        <!-- Customer -->
        <div class="mb-6">
            <label for="customer_name" class="block text-metallic-mid font-bold mb-3 text-lg">Customer:</label>
            <input list="customers-list" name="customer_name" id="customer_name"
                value="{{ old('customer_name') }}"
                class="metallic-input shadow-lg border rounded-lg w-full py-4 px-4 text-lg bg-slate-800"
                placeholder="Select or type customer name">
            <datalist id="customers-list">
                @foreach($customers as $customer)
                    <option value="{{ $customer->name }}"></option>
                @endforeach
            </datalist>
            @error('customer_name')
            <p class="text-red-400 text-sm mt-2 flex items-center">
                <span class="mr-2">⚠️</span>{{ $message }}
            </p>
            @enderror
        </div>

        <!-- Sale Date -->
        <div class="mb-6">
            <label for="sale_date" class="block text-metallic-mid font-bold mb-3 text-lg">Sale Date:</label>
            <input type="date" name="sale_date" id="sale_date" value="{{ old('sale_date', now()->format('Y-m-d')) }}"
                class="metallic-input shadow-lg border rounded-lg w-full py-4 px-4 text-lg" required>
            @error('sale_date')
            <p class="text-red-400 text-sm mt-2 flex items-center">
                <span class="mr-2">⚠️</span>{{ $message }}
            </p>
            @enderror
        </div>

        <!-- Products Table -->
        <div class="metallic-card p-6 rounded-xl shadow-lg mb-6">
            <h3 class="text-xl font-bold text-metallic-mid mb-4">Products</h3>

            <div id="products-wrapper" class="space-y-4">
                <!-- Initial Product Row -->
                <div class="grid grid-cols-1 md:grid-cols-6 gap-4 product-row">
                    <div>
                        <label class="block text-metallic-mid font-semibold mb-1">Product:</label>
                        <select name="products[0][product_id]" class="product-select metallic-input shadow-lg border rounded-lg w-full py-3 px-3 text-lg bg-slate-800">
                            <option value="">-- Select Product --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" 
                                        data-price="{{ $product->selling_price }}" 
                                        data-stock="{{ $product->quantity }}">
                                    {{ $product->name }} | Stock: {{ $product->quantity }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-metallic-mid font-semibold mb-1">Quantity:</label>
                        <input type="number" name="products[0][quantity]" min="1" value="1"
                            class="product-quantity metallic-input shadow-lg border rounded-lg w-full py-3 px-3 text-lg">
                    </div>

                    <div>
                        <label class="block text-metallic-mid font-semibold mb-1">Price (Rs.):</label>
                        <input type="number" name="products[0][selling_price]" step="0.01" value="0.00"
                            class="product-price metallic-input shadow-lg border rounded-lg w-full py-3 px-3 text-lg">
                    </div>

                    <div>
                        <label class="block text-metallic-mid font-semibold mb-1">Total (Rs.):</label>
                        <input type="number" class="product-total metallic-input shadow-lg border rounded-lg w-full py-3 px-3 text-lg" value="0.00" readonly>
                    </div>

                    <div class="flex items-end space-x-2 col-span-2">
                        <button type="button" class="add-product metallic-btn metallic-btn-success px-4 py-2 rounded-lg text-white font-bold">
                            + Add
                        </button>
                        <button type="button" class="remove-product metallic-btn metallic-btn-danger px-4 py-2 rounded-lg text-white font-bold hidden">
                            &times; Remove
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Discount & Tax -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 items-end">
            <div>
                <label for="discount" class="block text-metallic-mid font-bold mb-3 text-lg">Discount (Rs.):</label>
                <input type="number" name="discount" id="discount" value="{{ old('discount', 0) }}"
                    class="metallic-input shadow-lg border rounded-lg w-full py-4 px-4 text-lg" step="0.01">
            </div>

            <div>
                <label for="tax" class="block text-metallic-mid font-bold mb-3 text-lg">Tax (Rs.):</label>
                <input type="number" name="tax" id="tax" value="{{ old('tax', 0) }}"
                    class="metallic-input shadow-lg border rounded-lg w-full py-4 px-4 text-lg" step="0.01">
            </div>

            <div>
                <label class="block text-metallic-mid font-bold mb-3 text-lg">Grand Total (Rs.):</label>
                <input type="number" name="grand_total" id="grand_total" value="0.00"
                    class="metallic-input shadow-lg border rounded-lg w-full py-4 px-4 text-lg" readonly>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="metallic-btn metallic-btn-success px-8 py-4 text-lg font-bold rounded-lg text-white transition-all duration-300">
                💾 RECORD SALE
            </button>
            <a href="{{ route('sales.index') }}" class="text-metallic-mid hover:text-metallic-gold transition-colors duration-300 text-lg font-semibold">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const productsWrapper = document.getElementById('products-wrapper');
    const grandTotalInput = document.getElementById('grand_total');

    function calculateRowTotal(row) {
        const qtyInput = row.querySelector('.product-quantity');
        const priceInput = row.querySelector('.product-price');
        const totalInput = row.querySelector('.product-total');

        const qty = parseFloat(qtyInput.value) || 0;
        const price = parseFloat(priceInput.value) || 0;

        totalInput.value = (qty * price).toFixed(2);
        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        let total = 0;
        productsWrapper.querySelectorAll('.product-row').forEach(row => {
            const rowTotal = parseFloat(row.querySelector('.product-total').value) || 0;
            total += rowTotal;
        });
        grandTotalInput.value = total.toFixed(2);
    }

    // Add / Remove product rows
    productsWrapper.addEventListener('click', function(e) {
        if(e.target.classList.contains('add-product')) {
            const row = e.target.closest('.product-row');
            const clone = row.cloneNode(true);
            const newIndex = productsWrapper.querySelectorAll('.product-row').length;

            clone.querySelectorAll('select, input').forEach(el => {
                if(el.name) el.name = el.name.replace(/\[\d+\]/, `[${newIndex}]`);
                if(el.tagName === 'INPUT') el.value = el.classList.contains('product-total') ? '0.00' : (el.type === 'number' ? '0' : '');
                else el.selectedIndex = 0;
            });

            clone.querySelector('.remove-product').classList.remove('hidden');
            productsWrapper.appendChild(clone);
        }

        if(e.target.classList.contains('remove-product')) {
            e.target.closest('.product-row').remove();
            calculateGrandTotal();
        }
    });

    // Auto-fill price and limit quantity
    productsWrapper.addEventListener('change', function(e) {
        if(e.target.classList.contains('product-select')) {
            const row = e.target.closest('.product-row');
            const selectedOption = e.target.selectedOptions[0];
            const priceInput = row.querySelector('.product-price');
            const qtyInput = row.querySelector('.product-quantity');

            const price = selectedOption.dataset.price || 0;
            const stock = selectedOption.dataset.stock || 0;

            priceInput.value = price;
            qtyInput.max = stock;
            if(qtyInput.value > stock) qtyInput.value = stock;

            calculateRowTotal(row);
        }
    });

    // Recalculate row total on quantity or price change
    productsWrapper.addEventListener('input', function(e) {
        if(e.target.classList.contains('product-quantity') || e.target.classList.contains('product-price')) {
            const row = e.target.closest('.product-row');
            const max = parseInt(e.target.max || 0);
            if(max && parseInt(e.target.value) > max) e.target.value = max;
            calculateRowTotal(row);
        }
    });

    // Initial calculation
    productsWrapper.querySelectorAll('.product-row').forEach(row => calculateRowTotal(row));
});
</script>
@endsection
