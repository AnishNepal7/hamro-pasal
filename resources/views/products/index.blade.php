@extends('layouts.app')
@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-4xl font-bold metallic-text-gold font-orbitron">PRODUCTS</h2>
            <a href="{{ route('products.create') }}" class="metallic-btn px-8 py-4 text-lg font-bold rounded-lg text-metallic-light hover:text-white transition-colors duration-300">
                + ADD NEW PRODUCT
            </a>
        </div>

        @if (session('success'))
            <div class="alert-success p-4 rounded-lg mb-6 flex items-center">
                <span class="text-2xl mr-3">✅</span>
                <span class="text-green-100 text-lg">{{ session('success') }}</span>
            </div>
        @endif

        <div class="metallic-card p-8 rounded-xl">
            <div class="overflow-x-auto">
                <table class="metallic-table min-w-full rounded-lg overflow-hidden">
                    <thead>
                        <tr>
                            <th class="px-8 py-4 text-left text-lg font-bold">Product name</th>
                            <th class="px-8 py-4 text-center text-lg font-bold">Quantity(stock)</th>
                            <th class="px-8 py-4 text-center text-lg font-bold">Supplier</th>
                            <th class="px-8 py-4 text-center text-lg font-bold">Category</th>
                            <th class="px-8 py-4 text-center text-lg font-bold">selling Price</th>
                            <th class="px-8 py-4 text-center text-lg font-bold">Purchase Price</th>
                            <th class="px-8 py-4 text-center text-lg font-bold">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr class="hover:bg-steel-700/30 transition-colors duration-200">
                                <td class="px-8 py-6 text-lg">
                                    <div>
                                        <div class="font-semibold">{{ $product->name }}</div>
                                        @if($product->quantity < 10)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-900/50 text-red-300 mt-1">
                                                ⚠️ Low Stock
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <span class="text-lg font-mono {{ $product->quantity < 10 ? 'text-red-400' : 'text-metallic-mid' }}">
                                        {{ $product->quantity }}
                                    </span>
                                </td>
                                 <td class="px-8 py-6 text-center">
                                    <span class="text-lg font-mono }}">
                                        {{ $product->supplier->name }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <span class="text-lg font-mono }}">
                                        {{ $product->category->name }}
                                    </span>
                                </td>
                               
                                <td class="px-8 py-6 text-center">
                                    <span class="text-lg font-mono text-metallic-gold">
                                        Rs. {{ number_format($product->selling_price, 2) }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <span class="text-lg font-mono text-metallic-gold">
                                        Rs. {{ number_format($product->purchase_price, 2) }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <div class="flex justify-center space-x-4">
                                        <a href="{{ route('products.edit', $product) }}" 
                                           class="text-metallic-gold hover:text-yellow-300 transition-colors duration-200 font-semibold">
                                            ✏️ Edit
                                        </a>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this product?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-400 hover:text-red-300 transition-colors duration-200 font-semibold">
                                                🗑️ Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-12 text-center text-metallic-mid text-lg">
                                    No products found. <a href="{{ route('products.create') }}" class="text-metallic-gold hover:text-yellow-300">Create one now</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
            {{-- Pagination --}}
            @if ($products->hasPages())
                <div class="mt-8 flex justify-center">
                    <div class="bg-steel-700/50 rounded-lg p-4">
                        {{ $products->links() }}
                    </div>
                </div>  
            @endif
                    
        </div>
    </div>
@endsection
