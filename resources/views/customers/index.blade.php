@extends('layouts.app')
@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold metallic-text-gold font-orbitron">CUSTOMERS</h2>
        <a href="{{ route('customers.create') }}" class="metallic-btn px-6 py-3 rounded-lg text-metallic-light hover:text-white transition-colors duration-300">
            + ADD CUSTOMER
        </a>
    </div>

    <div class="metallic-card p-8 rounded-xl overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-metallic-light border-b border-steel-600">
                    <th class="py-3 px-4">#</th>
                    <th class="py-3 px-4">Name</th>
                    <th class="py-3 px-4">Contact</th>
                    <th class="py-3 px-4">Email</th>
                    <!-- <th class="py-3 px-4">Address</th> -->
                    <th class="py-3 px-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr class="border-b border-steel-700 text-metallic-mid hover:bg-steel-700/40">
                        <td class="py-3 px-4">{{ $loop->iteration }}</td>
                        <td class="py-3 px-4">{{ $customer->name }}</td>
                        <td class="py-3 px-4">{{ $customer->contact }}</td>
                        <td class="py-3 px-4">{{ $customer->email }}</td>
                        <!-- <td class="py-3 px-4">{{ $customer->address }}</td> -->
                        <td class="py-3 px-4 flex gap-3">
                            <a href="{{ route('customers.edit', $customer) }}" class="text-yellow-400 hover:text-yellow-300">Edit</a>
                            <form action="{{ route('customers.destroy', $customer) }}" method="POST" onsubmit="return confirm('Delete this customer?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-400">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-6 text-center text-metallic-mid">No customers found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $customers->links() }}
    </div>
</div>
@endsection
