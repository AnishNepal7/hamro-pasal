@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold metallic-text font-orbitron tracking-tight">
                USER MANAGEMENT
            </h1>
            <p class="text-metallic-mid mt-2">
                Manage system users and their access permissions
            </p>
        </div>
        <a href="{{ route('admin.users.create') }}" 
           class="metallic-btn px-6 py-3 text-lg font-bold rounded-lg text-metallic-light hover:text-white transition-all duration-300">
            <span class="mr-2">➕</span> Add New User
        </a>
    </div>

    <!-- Users Table -->
    <div class="metallic-card backdrop-blur-sm rounded-xl border border-steel-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-steel-800/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-metallic-mid font-bold uppercase tracking-wider">
                            User Details
                        </th>
                        <th class="px-6 py-4 text-left text-metallic-mid font-bold uppercase tracking-wider">
                            Role
                        </th>
                        <th class="px-6 py-4 text-left text-metallic-mid font-bold uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-4 text-right text-metallic-mid font-bold uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-steel-700">
                    @forelse($users as $user)
                        <tr class="hover:bg-steel-800/30 transition-colors duration-300">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-metallic-light to-metallic-dark flex items-center justify-center">
                                            <span class="text-steel-900 font-bold text-lg">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-metallic-light font-medium">{{ $user->name }}</div>
                                        <div class="text-steel-100 text-sm">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->roles->isNotEmpty())
                                    @foreach($user->roles as $role)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-metallic-gold/20 text-metallic-gold border border-metallic-gold/30">
                                            {{ ucfirst($role->name) }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-steel-600/20 text-steel-300 border border-steel-600/30">
                                        No Role
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($user->email_verified_at)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-600/20 text-green-400 border border-green-600/30">
                                        ✓ Verified
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-600/20 text-yellow-400 border border-yellow-600/30">
                                        ⏳ Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium space-x-2">
                                <a href="{{ route('admin.users.edit', $user) }}" 
                                   class="text-metallic-gold hover:text-yellow-200 transition-colors duration-300">
                                    Edit
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}" 
                                      method="POST" 
                                      class="inline-block"
                                      onsubmit="return confirm('Are you sure you want to delete this user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-400 hover:text-red-300 transition-colors duration-300">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-steel-300">
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
