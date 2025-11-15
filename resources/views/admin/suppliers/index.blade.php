@extends('layouts.app')
@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-4xl font-bold metallic-text-gold font-orbitron">MANAGE SUPPLIERS</h2>
            <a href="{{ route('admin.suppliers.create') }}" class="metallic-btn px-8 py-4 text-lg font-bold rounded-lg text-metallic-light hover:text-white transition-colors duration-300">
                + ADD NEW SUPPLIER
            </a>
        </div>

        @include('partials.alerts')

        <div class="metallic-card p-8 rounded-xl">
            <div class="overflow-x-auto">
                <table class="metallic-table min-w-full rounded-lg overflow-hidden">
                    <thead>
                        <tr>
                            <th class="px-8 py-4 text-left text-lg font-bold"> Name</th>
                            <th class="px-8 py-4 text-left text-lg font-bold">Company</th>
                            <th class="px-8 py-4 text-left text-lg font-bold">Contact</th>
                            <th class="px-8 py-4 text-left text-lg font-bold">Email</th>
                            <th class="px-8 py-4 text-left text-lg font-bold">Address</th>
                            <th class="px-8 py-4 text-center text-lg font-bold">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($suppliers as $supplier)
                            <tr class="hover:bg-steel-700/30 transition-colors duration-200">
                                <td class="px-8 py-6 text-lg">{{ $supplier->name }}</td>
                                <td class="px-8 py-6 text-lg">{{ $supplier->company }}</td>
                                <td class="px-8 py-6 text-lg">{{ $supplier->contact }}</td>
                                <td class="px-8 py-6 text-lg">{{ $supplier->email }}</td>
                                <td class="px-8 py-6 text-lg">{{ $supplier->address }}</td>
                                <td class="px-8 py-6 text-center">
                                    <div class="flex justify-center space-x-4">
                                        <a href="{{ route('admin.suppliers.edit', $supplier) }}" 
                                           class="text-metallic-gold hover:text-yellow-300 transition-colors duration-200 font-semibold">
                                            ✏️ Edit
                                        </a>
                                        <form action="{{ route('admin.suppliers.destroy', $supplier) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-400 hover:text-red-300 transition-colors duration-200 font-semibold" 
                                                    onclick="return confirm('Are you sure you want to delete this supplier?')">
                                                🗑️ Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-8 py-12 text-center text-metallic-mid text-lg">
                                    No suppliers found. <a href="{{ route('admin.suppliers.create') }}" class="text-metallic-gold hover:text-yellow-300">Create one now</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($suppliers->hasPages())
                <div class="mt-8 flex justify-center">
                    <div class="bg-steel-700/50 rounded-lg p-4">
                        {{ $suppliers->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
