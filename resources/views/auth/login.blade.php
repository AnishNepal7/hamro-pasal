<x-guest-layout>
    <form method="POST" action="{{ route('login') }}" class="mt-4 space-y-4">
        @csrf

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-300" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus
                placeholder="you@example.com"
                class="block mt-1 w-full bg-gray-800 text-gray-200 placeholder-gray-400 border-gray-700 focus:ring-amber-400 focus:border-amber-400 rounded-xl shadow-sm" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-gray-300" />
            <x-text-input id="password" type="password" name="password" required
                placeholder="Enter your password"
                class="block mt-1 w-full bg-gray-800 text-gray-200 placeholder-gray-400 border-gray-700 focus:ring-amber-400 focus:border-amber-400 rounded-xl shadow-sm" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label class="inline-flex items-center">
                <input id="remember_me" type="checkbox" name="remember"
                    class="rounded border-gray-700 text-amber-400 focus:ring-amber-400 shadow-sm">
                <span class="ml-2 text-sm text-gray-400">Remember me</span>
            </label>

            @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-amber-400 hover:text-amber-300">Forgot password?</a>
            @endif
        </div>

        <x-primary-button class="w-full py-3 bg-gradient-to-r from-amber-400 via-amber-500 to-amber-600 hover:from-amber-500 hover:via-amber-600 hover:to-amber-700 text-gray-900 font-extrabold rounded-xl shadow-lg transition-all duration-200">
            {{ __('Log in') }}
        </x-primary-button>
    </form>
</x-guest-layout>
