@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-steel-900 via-gray-900 to-steel-800 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold metallic-text font-orbitron tracking-tight">
                USER PROFILE
            </h1>
            <p class="mt-2 text-metallic-mid">
                Manage your account information and security settings
            </p>
        </div>

        <!-- Success Message -->
        @if (session('status') === 'profile-updated')
            <div class="mb-6 bg-gradient-to-r from-green-600/20 to-green-500/10 border border-green-500/30 rounded-lg p-4 backdrop-blur-sm">
                <div class="flex items-center">
                    <div class="text-green-400 text-xl mr-3">✅</div>
                    <p class="text-green-300 font-medium">Profile updated successfully!</p>
                </div>
            </div>
        @endif

        <!-- Profile Management Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
            <!-- Profile Information -->
            <div class="bg-steel-800/50 backdrop-blur-sm rounded-xl border border-steel-700 shadow-metallic p-6">
                <div class="flex items-center mb-6">
                    <div class="text-metallic-gold text-2xl mr-3">👤</div>
                    <h2 class="text-xl font-bold text-metallic-light">Profile Information</h2>
                </div>
                <p class="text-steel-100 mb-6">
                    Update your account's profile information and email address.
                </p>
                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- Update Password -->
            <div class="bg-steel-800/50 backdrop-blur-sm rounded-xl border border-steel-700 shadow-metallic p-6">
                <div class="flex items-center mb-6">
                    <div class="text-metallic-gold text-2xl mr-3">🔐</div>
                    <h2 class="text-xl font-bold text-metallic-light">Update Password</h2>
                </div>
                <p class="text-steel-100 mb-6">
                    Ensure your account is using a long, random password to stay secure.
                </p>
                @include('profile.partials.update-password-form')
            </div>

            <!-- Delete Account -->
            <div class="bg-steel-800/50 backdrop-blur-sm rounded-xl border border-red-700/50 shadow-metallic p-6">
                <div class="flex items-center mb-6">
                    <div class="text-red-400 text-2xl mr-3">⚠️</div>
                    <h2 class="text-xl font-bold text-red-300">Delete Account</h2>
                </div>
                <p class="text-steel-100 mb-6">
                    Once your account is deleted, all of its resources and data will be permanently deleted.
                </p>
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection
