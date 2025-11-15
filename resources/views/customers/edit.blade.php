@extends('layouts.app')
@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold metallic-text-gold font-orbitron">EDIT CUSTOMER</h2>
        <a href="{{ route('customers.index') }}" class="metallic-btn px-6 py-3 rounded-lg text-metallic-light hover:text-white transition-colors duration-300">
            ← BACK TO CUSTOMERS
        </a>
    </div>

    <div class="metallic-card p-8 rounded-xl">
        <form action="{{ route('customers.update', $customer) }}" method="POST">
            @csrf
            @method('PUT')
            @include('customers._form', ['customer' => $customer])
        </form>
    </div>
</div>
@endsection
