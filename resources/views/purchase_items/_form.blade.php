<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label for="purchase_id" class="block text-metallic-light font-semibold mb-2">Purchase</label>
        <select name="purchase_id" id="purchase_id" class="w-full bg-steel-800 border border-steel-600 text-metallic-light rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-yellow-500">
            @foreach($purchases as $purchase)
                <option value="{{ $purchase->id }}" {{ old('purchase_id', $purchaseItem->purchase_id ?? '') == $purchase->id ? 'selected' : '' }}>
                   {{ $purchase->product->name ?? 'N/A' }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="product_id" class="block text-metallic-light font-semibold mb-2">Product</label>
        <select name="product_id" id="product_id" class="w-full bg-steel-800 border border-steel-600 text-metallic-light rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-yellow-500">
            @foreach($products as $product)
                <option value="{{ $product->id }}" {{ old('product_id', $purchaseItem->product_id ?? '') == $product->id ? 'selected' : '' }}>
                    {{ $product->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="quantity" class="block text-metallic-light font-semibold mb-2">Quantity</label>
        <input type="number" name="quantity" id="quantity" class="w-full bg-steel-800 border border-steel-600 text-metallic-light rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-yellow-500" value="{{ old('quantity', $purchase_item->quantity ?? '') }}" min="1">
    </div>

    <div>
        <label for="cost_price" class="block text-metallic-light font-semibold mb-2">Cost Price</label>
        <input type="number" step="0.01" name="cost_price" id="cost_price" class="w-full bg-steel-800 border border-steel-600 text-metallic-light rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-yellow-500" value="{{ old('cost_price', $purchase_item->cost_price ?? '') }}">
    </div>
</div>

<div class="mt-8">
    <button type="submit" class="metallic-btn px-6 py-3 rounded-lg text-metallic-light hover:text-white transition-colors duration-300">
        SAVE PURCHASE ITEM
    </button>
</div>
