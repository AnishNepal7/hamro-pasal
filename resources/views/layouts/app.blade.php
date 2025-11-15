<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Hamro-Pasal')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        metallic: {
                            light: '#eef2f3',
                            mid: '#c5d1d5',
                            dark: '#8a9ea5',
                            gold: '#d4af37',
                        },
                        steel: {
                            100: '#f0f4f5',
                            700: '#374151',
                            800: '#2d3748',
                            900: '#1a202c',
                        }
                    },
                    fontFamily: {
                        orbitron: ['Orbitron', 'sans-serif'],
                        roboto: ['Roboto', 'sans-serif'],
                    },
                    boxShadow: {
                        'metallic': '0 10px 30px -5px rgba(0, 0, 0, 0.5), inset 0 0 15px rgba(255, 255, 255, 0.3)',
                        'metallic-btn': '0 5px 15px rgba(0, 0, 0, 0.4), inset 0 0 10px rgba(255, 255, 255, 0.3)',
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #2c3e50 0%, #1a1a2e 100%);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }
        
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 10% 20%, rgba(212, 175, 55, 0.1) 0%, transparent 20%),
                radial-gradient(circle at 90% 80%, rgba(212, 175, 55, 0.1) 0%, transparent 20%);
            z-index: -1;
        }
        
        .metallic-text {
            background: linear-gradient(to bottom, #eef2f3, #8a9ea5);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        .metallic-card {
            background: linear-gradient(145deg, #3a4758, #2a3444);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 12px;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.5), inset 0 0 15px rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }
        
        .metallic-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(212, 175, 55, 0.5), transparent);
        }
        
        .metallic-btn {
            background: linear-gradient(145deg, #3a4758, #2a3444);
            border: 2px solid;
            border-image: linear-gradient(to bottom, #d4af37, #8e6d28) 1;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            color: #c5d1d5;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .metallic-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            color: white;
        }
        
        .metallic-btn::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }
        
        .metallic-btn:hover::before {
            left: 100%;
        }

        /* Quick Action Navigation Buttons */
        .metallic-btn-nav {
            background: linear-gradient(145deg, #3a4758, #2a3444);
            border: 1px solid rgba(212, 175, 55, 0.3);
            color: #eef2f3;
            padding: 0.75rem 1.25rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .metallic-btn-nav:hover {
            background: linear-gradient(145deg, #4a5768, #3a4758);
            border-color: rgba(212, 175, 55, 0.6);
            color: #d4af37;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.3);
        }

        .metallic-btn-nav:active {
            transform: translateY(0);
        }

        .quick-actions-bar {
            background: rgba(45, 55, 72, 0.6);
            border-bottom: 1px solid rgba(212, 175, 55, 0.2);
            backdrop-filter: blur(10px);
        }
        
        .metallic-input {
            background: linear-gradient(145deg, #2a3444, #3a4758);
            border: 1px solid rgba(197, 209, 213, 0.2);
            border-radius: 8px;
            padding: 12px 16px;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
        }
        
        .metallic-input:focus {
            outline: none;
            border-color: #d4af37;
            box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.2);
        }
        
        .metallic-input::placeholder {
            color: #8a9ea5;
        }
        
        .metallic-table {
            background: linear-gradient(145deg, #3a4758, #2a3444);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.5);
        }
        
        .metallic-table th {
            background: linear-gradient(145deg, #2a3444, #1a202c);
            color: #d4af37;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 16px;
            border-bottom: 1px solid rgba(212, 175, 55, 0.2);
        }
        
        .metallic-table td {
            padding: 16px;
            border-bottom: 1px solid rgba(197, 209, 213, 0.1);
            color: #c5d1d5;
        }
        
        .metallic-table tbody tr:hover {
            background: rgba(212, 175, 55, 0.1);
        }
        
        .chart-toggle-btn {
            background: linear-gradient(145deg, #2a3444, #3a4758);
            border: 1px solid rgba(197, 209, 213, 0.2);
            color: #c5d1d5;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .chart-toggle-btn.active,
        .chart-toggle-btn:hover {
            background: linear-gradient(145deg, #d4af37, #b8941f);
            border-color: #d4af37;
            color: #1a202c;
        }
        
        .alert {
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 16px;
            border-left: 4px solid;
        }
        
        .alert-success {
            background: linear-gradient(145deg, rgba(34, 197, 94, 0.1), rgba(34, 197, 94, 0.05));
            border-left-color: #22c55e;
            color: #22c55e;
        }
        
        .alert-error {
            background: linear-gradient(145deg, rgba(239, 68, 68, 0.1), rgba(239, 68, 68, 0.05));
            border-left-color: #ef4444;
            color: #ef4444;
        }
        
        .alert-warning {
            background: linear-gradient(145deg, rgba(245, 158, 11, 0.1), rgba(245, 158, 11, 0.05));
            border-left-color: #f59e0b;
            color: #f59e0b;
        }
        
        .alert-info {
            background: linear-gradient(145deg, rgba(59, 130, 246, 0.1), rgba(59, 130, 246, 0.05));
            border-left-color: #3b82f6;
            color: #3b82f6;
        }
        
        .pulse {
            animation: pulse 3s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.03); }
            100% { transform: scale(1); }
        }
        
        /* Navigation Enhancements */
        .nav-metallic {
            background: linear-gradient(135deg, #2a3444 0%, #1a202c 100%);
            border-bottom: 1px solid rgba(212, 175, 55, 0.2);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }
        
        .nav-link {
            color: #c5d1d5;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .nav-link:hover,
        .nav-link.active {
            color: #d4af37;
        }
        
        .nav-link::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: #d4af37;
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }
        
        /* Dropdown Styling */
        .dropdown-menu {
            background: linear-gradient(145deg, #3a4758, #2a3444);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }
        
        .dropdown-item {
            color: #c5d1d5;
            transition: all 0.3s ease;
        }
        
        .dropdown-item:hover {
            background: rgba(212, 175, 55, 0.1);
            color: #d4af37;
        }
        
        /* Form Enhancements */
        .form-label {
            color: #c5d1d5;
            font-weight: 500;
            margin-bottom: 8px;
            display: block;
        }
        
        .form-select {
            background: linear-gradient(145deg, #2a3444, #3a4758);
            border: 1px solid rgba(197, 209, 213, 0.2);
            border-radius: 8px;
            padding: 12px 16px;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
        }
        
        .form-select:focus {
            outline: none;
            border-color: #d4af37;
            box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.2);
        }
        
        .form-select option {
            background: #2a3444;
            color: white;
        }
        
        /* Modal Styling */
        .modal-content {
            background: linear-gradient(145deg, #3a4758, #2a3444);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 12px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.7);
        }
        
        .modal-header {
            border-bottom: 1px solid rgba(212, 175, 55, 0.2);
            color: #d4af37;
        }
        
        .modal-body {
            color: #c5d1d5;
        }
        
        .modal-footer {
            border-top: 1px solid rgba(212, 175, 55, 0.2);
        }
        
        /* Badge Styling */
        .badge-metallic {
            background: linear-gradient(145deg, #d4af37, #b8941f);
            color: #1a202c;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .badge-admin {
            background: linear-gradient(145deg, #ef4444, #dc2626);
            color: white;
        }
        
        .badge-shopkeeper {
            background: linear-gradient(145deg, #3b82f6, #2563eb);
            color: white;
        }
        
        /* Loading States */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }
        
        .spinner {
            border: 2px solid rgba(212, 175, 55, 0.2);
            border-top: 2px solid #d4af37;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>

<body class="font-roboto antialiased text-gray-100">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Quick Actions Bar -->
        @auth
        <div class="quick-actions-bar">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="py-4">
                    <div class="flex flex-wrap justify-center gap-4">
                        <!-- Products Button -->
                        <a href="{{ route('products.index') }}" class="metallic-btn-nav">
                            <span class="mr-2">📦</span>
                            Products
                        </a>
                        
                        <!-- Record Sale Button -->
                            <a href="{{ route('sales.create') }}" class="metallic-btn-nav">
                                <span class="mr-2">💰</span>
                                Record Sale
                            </a>
                                                    <!-- Forecast Button -->
                            <a href="{{ route('forecast.page') }}" class="metallic-btn-nav">
                                <span class="mr-2">🔮</span>
                                Forecast
                            </a>
                        
                        <!-- Categories Button (Role-based) -->
                        @if(auth()->user()->hasAnyRole(['admin', 'shopkeeper']))
                        <a href="{{ route('admin.categories.index') }}" class="metallic-btn-nav">
                            <span class="mr-2">🏷️</span>
                            Categories
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endauth

        <!-- Page Heading -->
        @if (isset($header))
            <header class="shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="alert alert-success">
                    <strong>Success!</strong> {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-error">
                    <strong>Error!</strong> {{ session('error') }}
                </div>
            @endif

            @if (session('warning'))
                <div class="alert alert-warning">
                    <strong>Warning!</strong> {{ session('warning') }}
                </div>
            @endif

            @if (session('info'))
                <div class="alert alert-info">
                    <strong>Info!</strong> {{ session('info') }}
                </div>
            @endif

            {{ $slot ?? '' }}
            @yield('content')
        </main>
    </div>
</body>
</html>
