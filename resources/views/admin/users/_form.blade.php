<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div>
        <label for="name" class="block text-metallic-light font-bold mb-2 text-sm tracking-wide">NAME:</label>
        <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}" 
               class="bg-steel-800 border-2 border-steel-700 rounded-lg w-full py-3 px-4 text-metallic-light focus:border-metallic-gold focus:outline-none transition-colors duration-300 shadow-inner" required>
        @error('name') <p class="text-red-400 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="email" class="block text-metallic-light font-bold mb-2 text-sm tracking-wide">EMAIL:</label>
        <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" 
               class="bg-steel-800 border-2 border-steel-700 rounded-lg w-full py-3 px-4 text-metallic-light focus:border-metallic-gold focus:outline-none transition-colors duration-300 shadow-inner" required>
        @error('email') <p class="text-red-400 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mb-6">
    <label for="role" class="block text-metallic-light font-bold mb-2 text-sm tracking-wide">ROLE:</label>
    <select name="role" id="role" class="bg-steel-800 border-2 border-steel-700 rounded-lg w-full py-3 px-4 text-metallic-light focus:border-metallic-gold focus:outline-none transition-colors duration-300 shadow-inner" required>
        @foreach($roles as $role)
            <option value="{{ $role->name }}" class="bg-steel-800 text-metallic-light" @isset($user) @selected($user->hasRole($role->name)) @endisset>
                {{ ucfirst($role->name) }}
            </option>
        @endforeach
    </select>
    @error('role') <p class="text-red-400 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div>
        <label for="password" class="block text-metallic-light font-bold mb-2 text-sm tracking-wide">PASSWORD:</label>
        <input type="password" name="password" id="password" 
               class="bg-steel-800 border-2 border-steel-700 rounded-lg w-full py-3 px-4 text-metallic-light focus:border-metallic-gold focus:outline-none transition-colors duration-300 shadow-inner" 
               @empty($user) required @endempty>
        @empty($user)
            <p class="text-metallic-mid text-xs mt-1">Password is required for new users.</p>
        @else
            <p class="text-metallic-mid text-xs mt-1">Leave blank to keep the current password.</p>
        @endempty
        @error('password') <p class="text-red-400 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="password_confirmation" class="block text-metallic-light font-bold mb-2 text-sm tracking-wide">CONFIRM PASSWORD:</label>
        <input type="password" name="password_confirmation" id="password_confirmation" 
               class="bg-steel-800 border-2 border-steel-700 rounded-lg w-full py-3 px-4 text-metallic-light focus:border-metallic-gold focus:outline-none transition-colors duration-300 shadow-inner">
    </div>
</div>

<div class="flex flex-col sm:flex-row gap-4 items-center justify-between pt-6 border-t border-steel-700">
    <button type="submit" class="metallic-btn px-8 py-3 text-sm font-bold rounded-lg text-metallic-light hover:text-white transition-colors duration-300 w-full sm:w-auto">
        SAVE USER
    </button>
    <a href="{{ route('admin.users.index') }}" class="text-metallic-gold hover:text-yellow-200 transition-colors duration-300 font-medium">
        Cancel
    </a>
</div>
