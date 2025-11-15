<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div>
            <label for="update_password_current_password" class="block text-sm font-bold text-metallic-light mb-2">
                CURRENT PASSWORD
            </label>
            <input 
                id="update_password_current_password" 
                name="current_password" 
                type="password" 
                class="w-full px-4 py-3 bg-steel-900 border border-steel-600 rounded-lg text-metallic-light placeholder-steel-400 focus:border-metallic-gold focus:ring-2 focus:ring-metallic-gold/20 focus:outline-none transition-all duration-300" 
                autocomplete="current-password"
                placeholder="Enter your current password"
            >
            @error('current_password', 'updatePassword')
                <p class="mt-2 text-sm text-red-400 flex items-center">
                    <span class="mr-1">⚠️</span>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- New Password -->
        <div>
            <label for="update_password_password" class="block text-sm font-bold text-metallic-light mb-2">
                NEW PASSWORD
            </label>
            <input 
                id="update_password_password" 
                name="password" 
                type="password" 
                class="w-full px-4 py-3 bg-steel-900 border border-steel-600 rounded-lg text-metallic-light placeholder-steel-400 focus:border-metallic-gold focus:ring-2 focus:ring-metallic-gold/20 focus:outline-none transition-all duration-300" 
                autocomplete="new-password"
                placeholder="Enter new password"
            >
            @error('password', 'updatePassword')
                <p class="mt-2 text-sm text-red-400 flex items-center">
                    <span class="mr-1">⚠️</span>
                    {{ $message }}
                </p>
            @enderror
            <div class="mt-2 text-xs text-steel-300">
                <p>Password requirements:</p>
                <ul class="list-disc list-inside mt-1 space-y-1">
                    <li>At least 8 characters long</li>
                    <li>Contains uppercase and lowercase letters</li>
                    <li>Contains at least one number</li>
                </ul>
            </div>
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-bold text-metallic-light mb-2">
                CONFIRM NEW PASSWORD
            </label>
            <input 
                id="update_password_password_confirmation" 
                name="password_confirmation" 
                type="password" 
                class="w-full px-4 py-3 bg-steel-900 border border-steel-600 rounded-lg text-metallic-light placeholder-steel-400 focus:border-metallic-gold focus:ring-2 focus:ring-metallic-gold/20 focus:outline-none transition-all duration-300" 
                autocomplete="new-password"
                placeholder="Confirm your new password"
            >
            @error('password_confirmation', 'updatePassword')
                <p class="mt-2 text-sm text-red-400 flex items-center">
                    <span class="mr-1">⚠️</span>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Save Button -->
        <div class="flex items-center justify-between pt-4">
            <button type="submit" class="metallic-btn px-6 py-3 text-sm font-bold rounded-lg text-metallic-light hover:text-white transition-colors duration-300">
                UPDATE PASSWORD
            </button>

            @if (session('status') === 'password-updated')
                <p class="text-sm text-green-400 flex items-center">
                    <span class="mr-1">✅</span>
                    Password updated successfully
                </p>
            @endif
        </div>
    </form>
</section>
