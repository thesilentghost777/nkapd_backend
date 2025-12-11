<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'NKAPD Admin') - {{ config('app.name', 'NKAPD') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional Styles -->
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-indigo-900 via-indigo-800 to-indigo-900 text-white fixed h-full overflow-y-auto shadow-2xl z-20">
            <!-- Logo -->
            <div class="p-6 border-b border-indigo-700">
                <h1 class="text-2xl font-bold tracking-wider">NKAPD Admin</h1>
                <p class="text-indigo-300 text-sm mt-1">Administration</p>
            </div>

            <!-- Navigation Menu -->
            <nav class="p-4 space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.nkap.dashboard') ? 'bg-indigo-700 shadow-lg' : 'hover:bg-indigo-800' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="font-medium">Tableau de bord</span>
                </a>

                <!-- Utilisateurs -->
                <a href="{{ route('admin.nkap.users.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.nkap.users.*') ? 'bg-indigo-700 shadow-lg' : 'hover:bg-indigo-800' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span class="font-medium">Utilisateurs</span>
                </a>

                <!-- Tontines -->
                <a href="{{ route('admin.nkap.tontines.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.nkap.tontines.*') ? 'bg-indigo-700 shadow-lg' : 'hover:bg-indigo-800' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="font-medium">Tontines</span>
                </a>

                <!-- Transactions -->
                <a href="{{ route('admin.nkap.transactions.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.nkap.transactions.*') ? 'bg-indigo-700 shadow-lg' : 'hover:bg-indigo-800' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-medium">Transactions</span>
                </a>

                <!-- Produits -->
                <a href="{{ route('admin.nkap.produits.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.nkap.produits.*') ? 'bg-indigo-700 shadow-lg' : 'hover:bg-indigo-800' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span class="font-medium">Produits</span>
                </a>

                <!-- Conversations -->
<a href="{{ route('admin.nkap.conversations.index') }}" 
   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.nkap.conversations.*') ? 'bg-indigo-700 shadow-lg' : 'hover:bg-indigo-800' }}">
    <!-- Icone Chat -->
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.77 9.77 0 01-4-.8L3 20l1.23-3.7A7.94 7.94 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
    </svg>
    <span class="font-medium">Conversations</span>
</a>

<!-- Rencontres -->
<a href="{{ route('admin.nkap.rencontres.index') }}" 
   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.nkap.rencontres.*') ? 'bg-indigo-700 shadow-lg' : 'hover:bg-indigo-800' }}">
    <!-- Icone Utilisateurs -->
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M17 20h5v-2a4 4 0 00-5-4m-6 6H2v-2a4 4 0 015-4m5-6a4 4 0 11-8 0 4 4 0 018 0zm6 0a4 4 0 11-8 0 4 4 0 018 0z" />
    </svg>
    <span class="font-medium">Rencontres</span>
</a>


                <!-- Divider -->
                <div class="pt-4 pb-2">
                    <div class="border-t border-indigo-700"></div>
                </div>

                <!-- Configurations -->
                <a href="{{ route('admin.nkap.configurations.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.nkap.configurations.*') ? 'bg-indigo-700 shadow-lg' : 'hover:bg-indigo-800' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="font-medium">Configurations</span>
                </a>
            </nav>

            <!-- User Info -->
            <div class="absolute bottom-0 w-64 p-4 border-t border-indigo-700 bg-indigo-900">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center">
                        <span class="text-sm font-bold">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-indigo-300 truncate">{{ auth()->user()->email ?? '' }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 ml-64">
            <!-- Top Navigation Bar -->
            <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-10">
                <div class="flex items-center justify-between px-8 py-4">
                    <!-- Page Title -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">@yield('page-title', 'NKAPD Admin')</h2>
                        @hasSection('page-subtitle')
                            <p class="text-sm text-gray-600 mt-1">@yield('page-subtitle')</p>
                        @endif
                    </div>

                    <!-- Right Side Actions -->
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <button class="relative p-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>

                        <!-- User Menu -->
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                                Retour au site
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="px-4 py-2 text-sm text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors">
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-8">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="text-green-800 font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="text-red-800 font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
                        <div class="flex">
                            <svg class="w-5 h-5 text-red-500 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <p class="text-red-800 font-medium mb-2">Erreurs de validation :</p>
                                <ul class="list-disc list-inside text-red-700 text-sm space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Main Content Section -->
                @yield('admin-content')
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 px-8 py-6 mt-12">
                <div class="flex items-center justify-between text-sm text-gray-600">
                    <p>&copy; {{ date('Y') }} NKAPD. Tous droits réservés.</p>
                    <p>Version 1.0.0</p>
                </div>
            </footer>
        </div>
    </div>

    <!-- Additional Scripts -->
    @stack('scripts')
</body>
</html>