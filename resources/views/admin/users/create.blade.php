@extends('layouts.app')
@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-3xl font-bold mb-8 metallic-text font-orbitron tracking-tight">ADD NEW USER</h2>
            
            <div class="bg-steel-800/50 backdrop-blur-sm p-8 rounded-xl border border-steel-700 shadow-metallic">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    @include('admin.users._form')
                </form>
            </div>
        </div>
    </div>
@endsection
