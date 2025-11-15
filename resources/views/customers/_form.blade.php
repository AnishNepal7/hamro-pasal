<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label for="name" class="block text-metallic-light font-semibold mb-2">Customer Name</label>
        <input type="text" name="name" id="name"
               class="w-full bg-steel-800 border border-steel-600 text-metallic-light rounded-lg p-3"
               value="{{ old('name', $customer->name ?? '') }}" required>
    </div>

    <div>
        <label for="contact" class="block text-metallic-light font-semibold mb-2">Contact</label>
        <input type="text" name="contact" id="contact"
               class="w-full bg-steel-800 border border-steel-600 text-metallic-light rounded-lg p-3"
               value="{{ old('contact', $customer->contact ?? '') }}">
    </div>

    <div>
        <label for="email" class="block text-metallic-light font-semibold mb-2">Email</label>
        <input type="email" name="email" id="email"
               class="w-full bg-steel-800 border border-steel-600 text-metallic-light rounded-lg p-3"
               value="{{ old('email', $customer->email ?? '') }}">
    </div>

    <!-- <div>
        <label for="address" class="block text-metallic-light font-semibold mb-2">Address</label>
        <input type="text" name="address" id="address"
               class="w-full bg-steel-800 border border-steel-600 text-metallic-light rounded-lg p-3"
               value="{{ old('address', $customer->address ?? '') }}">
    </div> -->
</div>

<div class="mt-8">
    <button type="submit" class="metallic-btn px-6 py-3 rounded-lg text-metallic-light hover:text-white transition-colors duration-300">
        SAVE CUSTOMER
    </button>
</div>
