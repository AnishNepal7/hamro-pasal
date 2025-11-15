<div class="grid grid-cols-1 gap-6">
    <div>
        <label class="block text-metallic-mid font-bold mb-3 text-lg">Product:</label>
        <select name="product_id" class="metallic-input shadow-lg border rounded-lg w-full py-4 px-4 text-lg bg-slate-800" required>
            <option value="">-- Select Product --</option>
            @foreach($products as $product)
                <option value="{{ $product->id }}" @selected(old('product_id', $stockMovement->product_id ?? '') == $product->id)>
                    {{ $product->name }}
                </option>
            @endforeach
        </select>
        @error('product_id') <p class="text-red-400 text-sm mt-2">⚠️ {{ $message }}</p> @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-metallic-mid font-bold mb-3 text-lg">Type:</label>
            <select name="type" class="metallic-input shadow-lg border rounded-lg w-full py-4 px-4 text-lg bg-slate-800" required>
                <option value="">-- Select Type --</option>
                <option value="IN" @selected(old('type', $stockMovement->type ?? '') == 'IN')>IN (Stock In)</option>
                <option value="OUT" @selected(old('type', $stockMovement->type ?? '') == 'OUT')>OUT (Stock Out)</option>
            </select>
            @error('type') <p class="text-red-400 text-sm mt-2">⚠️ {{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-metallic-mid font-bold mb-3 text-lg">Quantity:</label>
            <input type="number" name="quantity" value="{{ old('quantity', $stockMovement->quantity ?? '') }}"
                   class="metallic-input shadow-lg border rounded-lg w-full py-4 px-4 text-lg"
                   placeholder="Enter quantity..." required>
            @error('quantity') <p class="text-red-400 text-sm mt-2">⚠️ {{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label class="block text-metallic-mid font-bold mb-3 text-lg">Description:</label>
        <input type="text" name="description" value="{{ old('description', $stockMovement->description ?? '') }}"
               class="metallic-input shadow-lg border rounded-lg w-full py-4 px-4 text-lg"
               placeholder="Enter description...">
        @error('description') <p class="text-red-400 text-sm mt-2">⚠️ {{ $message }}</p> @enderror
    </div>
</div>

<div class="flex items-center justify-between pt-8">
    <button type="submit" class="metallic-btn metallic-btn-success px-8 py-4 text-lg font-bold rounded-lg text-white">
        💾 SAVE MOVEMENT
    </button>
    <a href="{{ route('stock_movements.index') }}" class="text-metallic-mid hover:text-metallic-gold text-lg font-semibold">
        Cancel
    </a>
</div>
