<section class="space-y-6">
    <div class="p-4 bg-red-600/10 border border-red-500/30 rounded-lg">
        <p class="text-sm text-red-300">
            Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
        </p>
    </div>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg"
    >
        DELETE ACCOUNT
    </button>

    <!-- Delete Account Modal -->
    <div
        x-data="{ show: false }"
        x-on:open-modal.window="$event.detail == 'confirm-user-deletion' ? show = true : null"
        x-on:close-modal.window="$event.detail == 'confirm-user-deletion' ? show = false : null"
        x-on:keydown.escape.window="show = false"
        x-show="show"
        class="fixed inset-0 z-50 overflow-y-auto"
        x-cloak
    >
        <!-- Modal Overlay -->
        <div
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black bg-opacity-75 backdrop-blur-sm"
            x-on:click="show = false"
        ></div>

        <!-- Modal Content -->
        <div class="flex items-center justify-center min-h-screen px-4 py-8">
            <div
                x-show="show"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95"
                class="bg-steel-800 rounded-xl shadow-2xl max-w-md w-full border border-red-500/30"
                x-on:click.stop
            >
                <div class="p-6">
                    <!-- Modal Header -->
                    <div class="flex items-center mb-4">
                        <div class="text-red-400 text-3xl mr-3">⚠️</div>
                        <h3 class="text-xl font-bold text-red-300">
                            Delete Account
                        </h3>
                    </div>

                    <!-- Modal Body -->
                    <div class="mb-6">
                        <p class="text-steel-100 mb-4">
                            Are you sure you want to delete your account? This action cannot be undone.
                        </p>
                        <p class="text-steel-100 mb-4">
                            All of your data, including your profile information, will be permanently removed from our servers.
                        </p>

                        <!-- Password Confirmation Form -->
                        <form method="post" action="{{ route('profile.destroy') }}" class="space-y-4">
                            @csrf
                            @method('delete')

                            <div>
                                <label for="password" class="block text-sm font-bold text-metallic-light mb-2">
                                    CONFIRM PASSWORD
                                </label>
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    class="w-full px-4 py-3 bg-steel-900 border border-steel-600 rounded-lg text-metallic-light placeholder-steel-400 focus:border-red-500 focus:ring-2 focus:ring-red-500/20 focus:outline-none transition-all duration-300"
                                    placeholder="Enter your password to confirm"
                                    required
                                >
                                @error('password', 'userDeletion')
                                    <p class="mt-2 text-sm text-red-400 flex items-center">
                                        <span class="mr-1">⚠️</span>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Modal Footer -->
                            <div class="flex items-center justify-end space-x-4 pt-4">
                                <button
                                    type="button"
                                    x-on:click="show = false"
                                    class="px-4 py-2 text-steel-300 hover:text-white bg-steel-700 hover:bg-steel-600 rounded-lg transition-colors duration-300"
                                >
                                    Cancel
                                </button>
                                <button
                                    type="submit"
                                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg transition-colors duration-300"
                                >
                                    Delete Account
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
[x-cloak] {
    display: none !important;
}
</style>
