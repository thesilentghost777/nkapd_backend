<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Administration') — BR Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'DM Sans', sans-serif; background: #0a0a0c; color: #e5e5e7; }
        h1,h2,h3,h4 { font-family: 'Syne', sans-serif; }
        .admin-sidebar { background: #111114; border-right: 1px solid #222226; }
        .nav-link { transition: all .2s; border-radius: 8px; }
        .nav-link:hover { background: rgba(239,68,68,.08); color: #ef4444; }
        .nav-link.active { background: rgba(239,68,68,.12); color: #ef4444; border-left: 3px solid #ef4444; }
        .card { background: #111114; border: 1px solid #222226; border-radius: 14px; }
        .btn-admin { background: linear-gradient(135deg,#ef4444,#dc2626); color:#fff; transition: all .2s; }
        .btn-admin:hover { opacity:.9; box-shadow:0 8px 20px rgba(239,68,68,.3); }
        .stat-card { background: #111114; border: 1px solid #222226; border-radius: 14px; transition: all .2s; }
        .stat-card:hover { border-color: #ef4444; transform: translateY(-2px); }
        table { border-collapse: separate; border-spacing: 0; }
        thead th { background: #161618; font-family: 'Syne', sans-serif; font-size: .75rem; text-transform: uppercase; letter-spacing: .08em; color: #6b7280; }
        tbody tr { transition: background .15s; }
        tbody tr:hover { background: rgba(255,255,255,.02); }
        td, th { border-bottom: 1px solid #1e1e22; }
        ::-webkit-scrollbar { width: 4px; } ::-webkit-scrollbar-track { background: #111114; } ::-webkit-scrollbar-thumb { background: #2a2a30; border-radius:99px; }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen">
<div class="flex min-h-screen">
    <!-- Admin Sidebar -->
    <aside class="admin-sidebar w-60 fixed inset-y-0 left-0 z-30 flex-col hidden lg:flex">
        <div class="p-5 border-b border-gray-800">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg btn-admin flex items-center justify-center text-white font-bold text-sm">A</div>
                <div>
                    <p class="font-display font-700 text-white text-sm">BR Admin</p>
                    <p class="text-xs text-gray-600">Panneau de gestion</p>
                </div>
            </div>
        </div>
        <nav class="flex-1 p-3 space-y-0.5 overflow-y-auto">
            @php
                $links = [
                    ['route' => 'br.admin.dashboard', 'icon' => '⬛', 'label' => 'Dashboard'],
                    ['route' => 'br.admin.membres', 'icon' => '👥', 'label' => 'Membres'],
                    ['route' => 'br.admin.tontines', 'icon' => '💰', 'label' => 'Tontines'],
                    ['route' => 'br.admin.tontine.retraits', 'icon' => '💸', 'label' => 'Retraits'],
                    ['route' => 'br.admin.prets', 'icon' => '📋', 'label' => 'Prêts'],
                    ['route' => 'br.admin.transactions', 'icon' => '💳', 'label' => 'Transactions'],
                    ['route' => 'br.admin.assistances', 'icon' => '🛟', 'label' => 'Assistances'],
                    ['route' => 'br.admin.business', 'icon' => '🏪', 'label' => 'Business'],
                    ['route' => 'br.admin.notifications.create', 'icon' => '🔔', 'label' => 'Notifications'],
                ];
            @endphp
            @foreach($links as $link)
                <a href="{{ route($link['route']) }}" class="nav-link flex items-center gap-2.5 px-3 py-2 text-gray-400 text-sm {{ request()->routeIs($link['route']) ? 'active' : '' }}">
                    <span class="text-base">{{ $link['icon'] }}</span> {{ $link['label'] }}
                </a>
            @endforeach
        </nav>
        <div class="p-3 border-t border-gray-800">
            <form action="{{ route('br.logout') }}" method="POST">
                @csrf
                <button class="w-full text-left text-xs text-gray-600 hover:text-red-400 px-3 py-2 transition">← Déconnexion</button>
            </form>
        </div>
    </aside>

    <!-- Mobile top nav -->
    <header class="lg:hidden fixed top-0 inset-x-0 z-40 bg-gray-950 border-b border-gray-800 px-4 py-3 flex items-center justify-between">
        <span class="font-display font-700 text-white text-sm">BR Admin</span>
        <button onclick="document.getElementById('adm-menu').classList.toggle('hidden')" class="text-gray-400">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
        </button>
    </header>
    <div id="adm-menu" class="lg:hidden hidden fixed inset-0 z-50 bg-gray-950 pt-14 overflow-y-auto">
        <nav class="p-4 space-y-1">
            @foreach($links as $link)
                <a href="{{ route($link['route']) }}" class="nav-link flex items-center gap-3 px-3 py-3 text-gray-400">{{ $link['icon'] }} {{ $link['label'] }}</a>
            @endforeach
            <form action="{{ route('br.logout') }}" method="POST" class="pt-4">@csrf<button class="text-red-400 text-sm">Déconnexion</button></form>
        </nav>
    </div>

    <main class="flex-1 lg:ml-60 pt-14 lg:pt-0 min-h-screen">
        @if(session('success'))
            <div class="mx-6 mt-4 px-4 py-3 rounded-xl bg-green-900/30 border border-green-700/40 text-green-400 text-sm">✓ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mx-6 mt-4 px-4 py-3 rounded-xl bg-red-900/30 border border-red-700/40 text-red-400 text-sm">✗ {{ session('error') }}</div>
        @endif
        @yield('content')
    </main>
</div>
@stack('scripts')
</body>
</html>