@php
$navItems = [
['label'=>'Dashboard','route'=>'dashboard'],
['label'=>'Inventory','sub'=>[
['label'=>'Products','route'=>'products.index'],
['label'=>'Categories','route'=>'admin.categories.index'],
['label'=>'Suppliers','route'=>'admin.suppliers.index'],
]],
['label'=>'Purchases','sub'=>[
['label'=>'Purchase Orders','route'=>'purchase.index'],

]],
['label'=>'Sales','sub'=>[
['label'=>'Sales History','route'=>'sales.index'],
['label'=>'Record Sale','route'=>'sales.create']

]],
['label'=>'Stock Movements','route'=>'stock-movements.index'],
];
@endphp
<nav x-data="{ open: false }" class="bg-gradient-to-r from-gray-900 to-gray-800 border-b border-gray-700 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                    <div class="bg-gradient-to-br from-amber-400 via-amber-500 to-amber-600 rounded-xl p-2 shadow-lg ring-1 ring-amber-300/20 transition-transform duration-300 group-hover:scale-105">
                        <svg class="h-8 w-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M2 17L12 22L22 17" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M2 12L12 17L22 12" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <span class="text-2xl font-extrabold text-gray-100 font-orbitron tracking-tighter">Hamro Pasal</span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden sm:flex sm:items-center sm:space-x-3 sm:ml-8">
                @foreach ($navItems as $item)
                @if(isset($item['sub']))
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="flex items-center space-x-2 px-5 py-3 text-lg font-bold rounded-lg transition-all duration-200
                                    text-gray-300 hover:text-amber-400 hover:bg-gray-800/60
                                    {{ collect($item['sub'])->pluck('route')->contains(fn($r) => request()->routeIs($r)) ? 'bg-gray-800/50 text-amber-400' : '' }}">
                        <span>{{ $item['label'] }}</span>
                        <svg class="w-5 h-5 transition-transform duration-300" :class="{ 'rotate-180': open }" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M6 9l4 4 4-4" stroke-linecap="round" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" @click.away="open=false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-1"
                        class="absolute mt-2 w-52 rounded-md shadow-lg bg-gray-900 border border-gray-700 z-50">
                        @foreach($item['sub'] as $sub)
                        <a href="{{ route($sub['route']) }}"
                            class="block px-5 py-3 text-lg font-bold text-gray-300 hover:bg-gray-800 hover:text-amber-400 rounded-md
                                        {{ request()->routeIs($sub['route']) ? 'bg-gray-800/80 text-amber-400' : '' }}">
                            {{ $sub['label'] }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @else
                <a href="{{ route($item['route']) }}"
                    class="px-5 py-3 text-lg font-bold rounded-lg transition-all duration-200
                            {{ request()->routeIs($item['route']) ? 'bg-amber-500/15 text-amber-400 border border-amber-500/30 shadow-sm' : 'text-gray-300 hover:bg-gray-800/60 hover:text-amber-400' }}">
                    {{ $item['label'] }}
                </a>
                @endif
                @endforeach
            </div>

            <!-- User Dropdown & Mobile Hamburger -->
            <div class="flex items-center sm:ml-4">
                <!-- User Dropdown -->
                <div class="hidden sm:flex sm:items-center" x-data="{ openUser: false }">
                    <button @click="openUser = !openUser"
                        class="flex items-center space-x-3 px-5 py-3 text-xl font-extrabold rounded-lg bg-gray-800/50 text-gray-300 hover:bg-gray-800 hover:text-amber-300 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-amber-400/50">
                        <!-- Avatar -->
                        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-amber-400 via-amber-500 to-amber-600 flex items-center justify-center text-gray-900 font-bold uppercase">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <span class="truncate max-w-[160px]">{{ Auth::user()->name }}</span>
                        <svg class="w-6 h-6 transition-transform duration-200" :class="{'rotate-180': openUser}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- User Card Dropdown -->
                    <div x-show="openUser" @click.away="openUser=false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-72 bg-gray-900/95 backdrop-blur-md border border-gray-700/60 rounded-2xl shadow-2xl z-50 overflow-hidden">

                        <!-- User Info Header -->
                        <div class="flex items-center px-5 py-4 border-b border-gray-700">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-amber-400 via-amber-500 to-amber-600 flex items-center justify-center text-gray-900 font-bold uppercase text-lg">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="ml-4">
                                <p class="text-lg font-bold text-gray-100 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-sm text-gray-400 truncate">{{ Auth::user()->email }}</p>
                            </div>
                        </div>

                        <!-- Dropdown Links -->
                        <div class="py-3">
                            <a href="{{ route('profile.edit') }}" class="flex items-center px-5 py-3 text-gray-300 hover:bg-gray-800/70 hover:text-amber-300 font-bold transition-colors rounded-lg">
                                <svg class="w-5 h-5 mr-3 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A3 3 0 017 15h10a3 3 0 012.879 2.804M12 11a4 4 0 100-8 4 4 0 000 8z" />
                                </svg>
                                Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center w-full px-5 py-3 text-red-400 hover:bg-red-900/30 hover:text-red-300 font-bold transition-colors rounded-lg">
                                    <svg class="w-5 h-5 mr-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H5a3 3 0 01-3-3V7a3 3 0 013-3h5a3 3 0 013 3v1" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>


                <!-- Mobile Hamburger -->
                <div class="-mr-2 flex sm:hidden">
                    <button @click="open=!open" class="inline-flex items-center justify-center p-2 rounded-lg text-gray-300 hover:text-amber-400 hover:bg-gray-800/60 focus:outline-none focus:ring-2 focus:ring-amber-400/50 transition-colors">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': !open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': !open, 'inline-flex': open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" x-transition class="sm:hidden bg-gray-900/95 backdrop-blur-md border-t border-gray-800/50">
        <div class="px-2 pt-2 pb-3 space-y-1">
            @foreach ($navItems as $item)
            @if(isset($item['sub']))
            <div x-data="{ expanded: false }" class="space-y-1">
                <button @click="expanded=!expanded" class="w-full flex justify-between items-center px-4 py-3 text-lg font-bold text-gray-300 rounded-lg hover:bg-gray-800/60 hover:text-amber-400 transition-colors">
                    {{ $item['label'] }}
                    <svg class="w-5 h-5 transform transition-transform duration-200" :class="{ 'rotate-90': expanded }" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                        <path d="M8 5l4 4 4-4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </svg>
                </button>
                <div x-show="expanded" class="pl-4 space-y-1" x-transition>
                    @foreach($item['sub'] as $sub)
                    <a href="{{ route($sub['route']) }}" class="block px-5 py-3 text-lg font-bold text-gray-400 rounded-lg hover:bg-gray-800/50 hover:text-amber-400 transition-colors {{ request()->routeIs($sub['route']) ? 'text-amber-400' : '' }}">{{ $sub['label'] }}</a>
                    @endforeach
                </div>
            </div>
            @else
            <a href="{{ route($item['route']) }}" class="block px-5 py-3 text-lg font-bold text-gray-300 rounded-lg hover:bg-gray-800/60 hover:text-amber-400 transition-colors {{ request()->routeIs($item['route']) ? 'bg-amber-500/15 text-amber-400' : '' }}">{{ $item['label'] }}</a>
            @endif
            @endforeach

            <div class="border-t border-gray-800/40 pt-3 mt-2">
                <a href="{{ route('profile.edit') }}" class="block px-5 py-3 text-lg font-bold text-gray-300 rounded-lg hover:bg-gray-800/60 hover:text-amber-400 transition-colors">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-5 py-3 text-lg font-bold text-red-400 rounded-lg hover:bg-red-900/30 hover:text-red-300 transition-colors">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>