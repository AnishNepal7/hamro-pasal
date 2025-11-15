<section>
    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <!-- Name Field -->
        <div>
            <label for="name" class="block text-sm font-bold text-metallic-light mb-2">
                NAME
            </label>
            <input 
                id="name" 
                name="name" 
                type="text" 
                class="w-full px-4 py-3 bg-steel-900 border border-steel-600 rounded-lg text-metallic-light placeholder-steel-400 focus:border-metallic-gold focus:ring-2 focus:ring-metallic-gold/20 focus:outline-none transition-all duration-300" 
                value="{{ old('name', $user->name) }}" 
                required 
                autofocus 
                autocomplete="name"
                placeholder="Enter your full name"
            >
            @error('name')
                <p class="mt-2 text-sm text-red-400 flex items-center">
                    <span class="mr-1">⚠️</span>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Email Field -->
        <div>
            <label for="email" class="block text-sm font-bold text-metallic-light mb-2">
                EMAIL ADDRESS
            </label>
            <input 
                id="email" 
                name="email" 
                type="email" 
                class="w-full px-4 py-3 bg-steel-900 border border-steel-600 rounded-lg text-metallic-light placeholder-steel-400 focus:border-metallic-gold focus:ring-2 focus:ring-metallic-gold/20 focus:outline-none transition-all duration-300" 
                value="{{ old('email', $user->email) }}" 
                required 
                autocomplete="username"
                placeholder="Enter your email address"
            >
            @error('email')
                <p class="mt-2 text-sm text-red-400 flex items-center">
                    <span class="mr-1">⚠️</span>
                    {{ $message }}
                </p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 p-3 bg-yellow-600/20 border border-yellow-500/30 rounded-lg">
                    <p class="text-sm text-yellow-300">
                        Your email address is unverified.
                        <button form="send-verification" class="underline text-yellow-200 hover:text-yellow-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            Click here to re-send the verification email.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-400">
                            A new verification link has been sent to your email address.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Save Button -->
        <div class="flex items-center justify-between pt-4">
            <button type="submit" class="metallic-btn px-6 py-3 text-sm font-bold rounded-lg text-metallic-light hover:text-white transition-colors duration-300">
                SAVE CHANGES
            </button>

            @if (session('status') === 'profile-updated')
                <p class="text-sm text-green-400 flex items-center">
                    <span class="mr-1">✅</span>
                    Saved successfully
                </p>
            @endif
        </div>
    </form>

    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>
    @endif
</section>
