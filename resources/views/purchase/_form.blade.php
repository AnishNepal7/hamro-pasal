<div class="grid grid-cols-1 gap-6">
    <!-- Supplier -->
    <div>
        <label for="supplier_id" class="block text-metallic-mid font-bold mb-3 text-lg">Supplier:</label>
        <select name="supplier_id" id="supplier_id"
            class="metallic-input shadow-lg border rounded-lg w-full py-4 px-4 text-lg bg-slate-800" required>
            <option value="">-- Select Supplier --</option>
            @foreach($suppliers as $supplier)
            <option value="{{ $supplier->id }}" {{ old('supplier_id', $purchase->supplier_id ?? '') == $supplier->id ? 'selected' : '' }}>
                {{ $supplier->name }}
            </option>
            @endforeach
        </select>
        @error('supplier_id')
        <p class="text-red-400 text-sm mt-2 flex items-center">
            <span class="mr-2">⚠️</span>{{ $message }}
        </p>
        @enderror
    </div>

    <!-- Product and Quantity Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="name" class="block text-metallic-mid font-bold mb-3 text-lg">Product:</label>

            <input type="text"
                name="name"
                id="name"
                value="{{ old('name', $purchase->name ?? '') }}"
                class="metallic-input shadow-lg appearance-none border rounded-lg w-full py-4 px-4 text-lg"
                placeholder="Enter product name..."
                required>

            @error('name')
            <p class="text-red-400 text-sm mt-2 flex items-center">
                <span class="mr-2">⚠️</span>{{ $message }}
            </p>
            @enderror
        </div>


        <div>
            <label for="quantity" class="block text-metallic-mid font-bold mb-3 text-lg">Quantity:</label>
            <input type="number" name="quantity" id="quantity"
                value="{{ old('quantity', $purchase->quantity ?? '') }}"
                class="metallic-input shadow-lg appearance-none border rounded-lg w-full py-4 px-4 text-lg"
                placeholder="0" required>
            @error('quantity')
            <p class="text-red-400 text-sm mt-2 flex items-center">
                <span class="mr-2">⚠️</span>{{ $message }}
            </p>
            @enderror
        </div>
    </div>

    <!-- Purchase Price and Date -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="purchase_price" class="block text-metallic-mid font-bold mb-3 text-lg">Purchase Price (Rs.):</label>
            <input type="number" name="purchase_price" id="purchase_price"
                value="{{ old('purchase_price', $purchase->purchase_price ?? '') }}"
                class="metallic-input shadow-lg appearance-none border rounded-lg w-full py-4 px-4 text-lg"
                step="0.01" placeholder="0.00" required>
            @error('purchase_price')
            <p class="text-red-400 text-sm mt-2 flex items-center">
                <span class="mr-2">⚠️</span>{{ $message }}
            </p>
            @enderror
        </div>

        <div>
            <label for="purchase_date" class="block text-metallic-mid font-bold mb-3 text-lg">Purchase Date:</label>
            <input type="date" name="purchase_date" id="purchase_date"
                value="{{ old('purchase_date', $purchase->purchase_date ?? now()->format('Y-m-d')) }}"
                class="metallic-input shadow-lg appearance-none border rounded-lg w-full py-4 px-4 text-lg" required>
            @error('purchase_date')
            <p class="text-red-400 text-sm mt-2 flex items-center">
                <span class="mr-2">⚠️</span>{{ $message }}
            </p>
            @enderror
        </div>
    </div>
</div>

<!-- Submit & Cancel -->
<div class="flex items-center justify-between pt-8">
    <button type="submit"
        class="metallic-btn metallic-btn-success px-8 py-4 text-lg font-bold rounded-lg text-white transition-all duration-300">
        💾 SAVE PURCHASE
    </button>
    <a href="{{ route('purchase.index') }}"
        class="text-metallic-mid hover:text-metallic-gold transition-colors duration-300 text-lg font-semibold">
        Cancel
    </a>
</div>