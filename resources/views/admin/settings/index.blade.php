@extends('layouts.app')
@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-4xl font-bold metallic-text-gold font-orbitron">SYSTEM SETTINGS</h2>
            <div class="flex items-center space-x-2">
                <span class="text-metallic-mid">⚙️</span>
                <span class="text-metallic-mid text-lg">Configuration Panel</span>
            </div>
        </div>
        
        @include('partials.alerts')

        <div class="metallic-card p-8 rounded-xl">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-8">
                    <div class="flex items-center mb-4">
                        <span class="text-2xl mr-3">🎯</span>
                        <h3 class="text-2xl font-bold metallic-text text-metallic-mid">Anomaly Detection Settings</h3>
                    </div>
                    
                    <div class="bg-steel-700/30 p-6 rounded-lg border border-steel-600">
                        <label for="anomaly_threshold" class="block text-metallic-mid font-bold mb-3 text-lg">
                            Anomaly Threshold (Z-Score)
                        </label>
                        <input type="number" step="0.1" name="anomaly_threshold" id="anomaly_threshold" 
                               value="{{ old('anomaly_threshold', $settings->get('anomaly_threshold', 2.0)) }}" 
                               class="metallic-input shadow-lg appearance-none border rounded-lg w-full md:w-1/3 py-4 px-4 text-lg">
                        <p class="text-metallic-dark text-sm mt-3 flex items-center">
                            <span class="mr-2">💡</span>
                            A higher number makes anomaly detection less sensitive. Default is 2.0.
                        </p>
                        @error('anomaly_threshold') 
                            <p class="text-red-400 text-sm mt-2 flex items-center">
                                <span class="mr-2">⚠️</span>{{ $message }}
                            </p> 
                        @enderror
                    </div>
                </div>

                <hr class="my-8 border-steel-600">

                <!-- Placeholder for future settings -->
                <div class="mb-8">
                    <div class="flex items-center mb-4">
                        <span class="text-2xl mr-3">🔮</span>
                        <h3 class="text-2xl font-bold text-metallic-mid">Future Settings</h3>
                    </div>
                    
                    <div class="bg-steel-700/20 p-6 rounded-lg border border-steel-600 border-dashed">
                        <p class="text-metallic-dark text-lg flex items-center">
                            <span class="mr-2">🚀</span>
                            Additional configuration options will be added here as the system evolves.
                        </p>
                    </div>
                </div>

                <div class="flex justify-between items-center pt-6">
                    <button type="submit" class="metallic-btn metallic-btn-success px-8 py-4 text-lg font-bold rounded-lg text-white transition-all duration-300">
                        💾 SAVE SETTINGS
                    </button>
                    <p class="text-metallic-dark text-sm">
                        Changes will take effect immediately
                    </p>
                </div>
            </form>
        </div>
    </div>
@endsection
