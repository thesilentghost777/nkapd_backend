<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Business Room') — BR</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { display: ['Syne','sans-serif'], body: ['DM Sans','sans-serif'] },
                    colors: {
                        brand: { 50:'#fff7ed', 100:'#ffedd5', 500:'#f97316', 600:'#ea580c', 700:'#c2410c', 900:'#7c2d12' },
                        dark: { 50:'#f8f9fa', 100:'#e9ecef', 200:'#dee2e6', 300:'#ced4da', 400:'#adb5bd', 500:'#6c757d', 600:'#495057', 700:'#343a40', 800:'#212529', 900:'#1a1d20' }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'DM Sans', sans-serif; background: #f8f9fa; color: #1a1d20; }
        h1,h2,h3,h4 { font-family: 'Syne', sans-serif; }
        .sidebar { background: #ffffff; border-right: 1px solid #dee2e6; }
        .nav-link { transition: all .2s; border-radius: 10px; color: #495057; }
        .nav-link:hover, .nav-link.active { background: rgba(249,115,22,.08); color: #f97316; }
        .nav-link.active { border-left: 3px solid #f97316; background: rgba(249,115,22,.05); }
        .card { background: #ffffff; border: 1px solid #dee2e6; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .badge-orange { background: rgba(249,115,22,.1); color: #f97316; border: 1px solid rgba(249,115,22,.2); }
        .btn-primary { background: linear-gradient(135deg,#f97316,#ea580c); color:#fff; transition: all .2s; }
        .btn-primary:hover { opacity:.9; transform:translateY(-1px); box-shadow:0 8px 20px rgba(249,115,22,.2); }
        ::-webkit-scrollbar { width:5px; } ::-webkit-scrollbar-track { background:#e9ecef; } ::-webkit-scrollbar-thumb { background:#adb5bd; border-radius:99px; }
        ::-webkit-scrollbar-thumb:hover { background:#6c757d; }
        
        /* Light mode specific styles */
        .sidebar .text-gray-400 { color: #6c757d !important; }
        .sidebar .text-gray-500 { color: #adb5bd !important; }
        .border-dark-600 { border-color: #dee2e6 !important; }
        .bg-dark-800 { background: #ffffff !important; }
        .hover\:bg-dark-700:hover { background: #f8f9fa !important; }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen">

<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="sidebar w-64 fixed inset-y-0 left-0 z-30 flex-col hidden lg:flex">
        <div class="p-6 border-b border-dark-200">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl btn-primary flex items-center justify-center font-display font-800 text-white text-lg">B</div>
                <div>
                    <p class="font-display font-700 text-dark-900 text-sm">Business Room</p>
                    <p class="text-xs text-dark-500">Espace Membre</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            <a href="{{ route('br.membre.dashboard') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 text-dark-600 text-sm {{ request()->routeIs('br.membre.dashboard') ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Tableau de bord
            </a>
            <a href="{{ route('br.membre.tontine.index') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 text-dark-600 text-sm {{ request()->routeIs('br.membre.tontine.*') ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Tontines
            </a>
            <a href="{{ route('br.membre.pret.index') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 text-dark-600 text-sm {{ request()->routeIs('br.membre.pret.*') ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Prêts
            </a>
            <a href="{{ route('br.membre.business.index') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 text-dark-600 text-sm {{ request()->routeIs('br.membre.business.*') ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                Business
            </a>
            <a href="{{ route('br.membre.cashbook.index') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 text-dark-600 text-sm {{ request()->routeIs('br.membre.cashbook.*') ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Cahier de caisse
            </a>
            <a href="{{ route('br.membre.assistance.index') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 text-dark-600 text-sm {{ request()->routeIs('br.membre.assistance.*') ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Assistance
            </a>
        </nav>

        <div class="p-4 border-t border-dark-200">
            <a href="{{ route('br.membre.profil') }}" class="flex items-center gap-3 p-2 rounded-xl hover:bg-dark-100 transition">
                <div class="w-8 h-8 rounded-full bg-brand-500 flex items-center justify-center text-white text-xs font-bold">
                    {{ substr(auth('brfinal')->user()->prenom, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-medium text-dark-900 truncate">{{ auth('brfinal')->user()->nom_complet }}</p>
                    <p class="text-xs text-dark-500 truncate">{{ auth('brfinal')->user()->telephone }}</p>
                </div>
            </a>
            <form action="{{ route('br.logout') }}" method="POST" class="mt-2">
                @csrf
                <button class="w-full text-left text-xs text-dark-500 hover:text-red-500 px-2 py-1 transition">Déconnexion →</button>
            </form>
        </div>
    </aside>

    <!-- Mobile header -->
    <header class="lg:hidden fixed top-0 inset-x-0 z-40 bg-white border-b border-dark-200 px-4 py-3 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg btn-primary flex items-center justify-center text-white font-bold">B</div>
            <span class="font-display font-700 text-dark-900">BR</span>
        </div>
        <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="text-dark-500">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
    </header>

    <!-- Mobile menu -->
    <div id="mobile-menu" class="lg:hidden hidden fixed inset-0 z-50 bg-white pt-16">
        <nav class="p-4 space-y-1">
            <a href="{{ route('br.membre.dashboard') }}" class="nav-link flex items-center gap-3 px-3 py-3 text-dark-600">🏠 Tableau de bord</a>
            <a href="{{ route('br.membre.tontine.index') }}" class="nav-link flex items-center gap-3 px-3 py-3 text-dark-600">💰 Tontines</a>
            <a href="{{ route('br.membre.pret.index') }}" class="nav-link flex items-center gap-3 px-3 py-3 text-dark-600">💳 Prêts</a>
            <a href="{{ route('br.membre.business.index') }}" class="nav-link flex items-center gap-3 px-3 py-3 text-dark-600">🏪 Business</a>
            <a href="{{ route('br.membre.cashbook.index') }}" class="nav-link flex items-center gap-3 px-3 py-3 text-dark-600">📊 Cahier de caisse</a>
            <a href="{{ route('br.membre.assistance.index') }}" class="nav-link flex items-center gap-3 px-3 py-3 text-dark-600">🛟 Assistance</a>
            <form action="{{ route('br.logout') }}" method="POST" class="pt-4">@csrf<button class="text-red-500">Déconnexion</button></form>
        </nav>
    </div>

    <!-- Main -->
    <main class="flex-1 lg:ml-64 pt-16 lg:pt-0 min-h-screen bg-dark-50">
        @if(session('success'))
            <div class="mx-6 mt-4 px-4 py-3 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm">✓ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mx-6 mt-4 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">✗ {{ session('error') }}</div>
        @endif
        @if(session('info'))
            <div class="mx-6 mt-4 px-4 py-3 rounded-xl bg-blue-50 border border-blue-200 text-blue-700 text-sm">ℹ {{ session('info') }}</div>
        @endif
        @yield('content')
    </main>
</div>

@stack('scripts')
</body>
</html>