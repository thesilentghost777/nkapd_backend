<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Business Room') — BR</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['Syne', 'sans-serif'],
                        body: ['DM Sans', 'sans-serif']
                    },
                    colors: {
                        brand: {
                            50:  '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2601a',
                            800: '#9a3412',
                            900: '#7c2d12',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        *, *::before, *::after { box-sizing: border-box; }

        :root {
            --brand:        #c2601a;
            --brand-light:  #f97316;
            --brand-bg:     #fff7ed;
            --surface:      #ffffff;
            --surface-2:    #f9f8f6;
            --border:       #ece9e3;
            --text-primary: #1a1a1a;
            --text-muted:   #6b7280;
            --text-faint:   #b0aaa0;
            --sidebar-w:    248px;
            --header-h:     60px;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--surface-2);
            color: var(--text-primary);
            margin: 0;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4, h5 { font-family: 'Syne', sans-serif; margin: 0; }

        /* ── Sidebar ── */
        #sidebar {
            position: fixed;
            inset-y: 0;
            left: 0;
            width: var(--sidebar-w);
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            z-index: 40;
        }

        .sidebar-logo {
            padding: 22px 20px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-logo-icon {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--brand-light), var(--brand));
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 18px;
            color: #fff;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(194, 96, 26, .3);
        }

        .sidebar-logo-text { line-height: 1.2; }
        .sidebar-logo-text strong { font-family: 'Syne', sans-serif; font-size: 13px; font-weight: 700; color: var(--text-primary); display: block; }
        .sidebar-logo-text span { font-size: 11px; color: var(--text-muted); }

        /* ── Nav links ── */
        #sidebar nav { flex: 1; padding: 12px 12px; overflow-y: auto; }

        .nav-section-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: .8px;
            text-transform: uppercase;
            color: var(--text-faint);
            padding: 16px 10px 6px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 500;
            color: var(--text-muted);
            text-decoration: none;
            transition: all .18s ease;
            margin-bottom: 2px;
            position: relative;
        }

        .nav-link:hover {
            background: var(--surface-2);
            color: var(--text-primary);
        }

        .nav-link.active {
            background: var(--brand-bg);
            color: var(--brand);
            font-weight: 600;
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 25%;
            bottom: 25%;
            width: 3px;
            background: var(--brand);
            border-radius: 0 3px 3px 0;
        }

        .nav-link svg { width: 17px; height: 17px; flex-shrink: 0; opacity: .7; transition: opacity .18s; }
        .nav-link:hover svg, .nav-link.active svg { opacity: 1; }

        .nav-link .badge {
            margin-left: auto;
            background: var(--brand-bg);
            color: var(--brand);
            font-size: 10px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 20px;
        }

        /* ── Sidebar footer ── */
        .sidebar-footer {
            padding: 12px;
            border-top: 1px solid var(--border);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 10px;
            border-radius: 12px;
            cursor: pointer;
            text-decoration: none;
            transition: background .18s;
        }

        .sidebar-user:hover { background: var(--surface-2); }

        .sidebar-avatar {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--brand-light), var(--brand));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
            color: #fff;
            flex-shrink: 0;
        }

        .sidebar-user-info { flex: 1; min-width: 0; }
        .sidebar-user-info strong { font-size: 13px; font-weight: 600; color: var(--text-primary); display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sidebar-user-info span { font-size: 11px; color: var(--text-muted); }

        .btn-logout {
            display: block;
            width: 100%;
            text-align: left;
            font-size: 12px;
            color: var(--text-faint);
            background: none;
            border: none;
            padding: 6px 10px;
            cursor: pointer;
            border-radius: 8px;
            transition: color .18s;
            margin-top: 4px;
        }
        .btn-logout:hover { color: #ef4444; }

        /* ── Mobile header ── */
        #mobile-header {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 50;
            height: var(--header-h);
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 0 18px;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .mobile-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .mobile-logo-icon {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--brand-light), var(--brand));
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 14px;
            color: #fff;
        }

        .mobile-logo-text {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 15px;
            color: var(--text-primary);
        }

        #hamburger {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-muted);
            flex-shrink: 0;
            margin-left: auto;   /* ← pousse le bouton à droite */
            padding: 0;
        }

        #hamburger:hover {
            background: var(--surface-2);
            color: var(--text-primary);
        }

        /* ── Mobile drawer ── */
        #mobile-drawer {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 60;
        }

        #mobile-drawer.open { display: block; }

        .drawer-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,.4);
            backdrop-filter: blur(2px);
        }

        .drawer-panel {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 280px;
            background: var(--surface);
            display: flex;
            flex-direction: column;
            animation: slideIn .22s ease;
        }

        @keyframes slideIn { from { transform: translateX(-100%); } to { transform: translateX(0); } }

        .drawer-header {
            padding: 18px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .drawer-close {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: var(--surface-2);
            border: none;
            font-size: 16px;
            color: var(--text-muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .drawer-nav { flex: 1; padding: 12px; overflow-y: auto; }

        /* ── Alerts ── */
        .alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 500;
            margin: 16px 24px 0;
        }

        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
        .alert-error   { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }
        .alert-info    { background: #eff6ff; border: 1px solid #bfdbfe; color: #2563eb; }

        /* ── Main content ── */
        #main-content {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
        }

        /* ── Responsive ── */
        @media (max-width: 1023px) {
            #sidebar { display: none; }
            #mobile-header { display: flex; }
            #main-content {
                margin-left: 0;
                padding-top: var(--header-h);
            }
            .alert { margin: 12px 16px 0; }
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 99px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--text-faint); }
    </style>
    @stack('styles')
</head>
<body>

<!-- ════════ SIDEBAR (desktop) ════════ -->
<aside id="sidebar">
    {{-- Logo --}}
    <div class="sidebar-logo">
        <div class="sidebar-logo-icon">B</div>
        <div class="sidebar-logo-text">
            <strong>Business Room</strong>
            <span>Espace Membre</span>
        </div>
    </div>

    {{-- Navigation --}}
    <nav>
        <p class="nav-section-label">Principal</p>

        <a href="{{ route('br.membre.dashboard') }}"
           class="nav-link {{ request()->routeIs('br.membre.dashboard') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Tableau de bord
        </a>

        <a href="{{ route('br.membre.tontine.index') }}"
           class="nav-link {{ request()->routeIs('br.membre.tontine.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Tontines
        </a>

        <a href="{{ route('br.membre.pret.index') }}"
           class="nav-link {{ request()->routeIs('br.membre.pret.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            Prêts
        </a>

        <p class="nav-section-label">Communauté</p>

        <a href="{{ route('br.membre.business.index') }}"
           class="nav-link {{ request()->routeIs('br.membre.business.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            Business Room
        </a>

        <a href="{{ route('br.membre.assistance.index') }}"
           class="nav-link {{ request()->routeIs('br.membre.assistance.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            Assistance
        </a>

        <p class="nav-section-label">Finance</p>

        <a href="{{ route('br.membre.cashbook.index') }}"
           class="nav-link {{ request()->routeIs('br.membre.cashbook.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Cahier de caisse
        </a>
    </nav>

    {{-- Footer utilisateur --}}
    <div class="sidebar-footer">
        <a href="{{ route('br.membre.profil') }}" class="sidebar-user">
            <div class="sidebar-avatar">{{ substr(auth('brfinal')->user()->prenom, 0, 1) }}</div>
            <div class="sidebar-user-info">
                <strong>{{ auth('brfinal')->user()->nom_complet }}</strong>
                <span>{{ auth('brfinal')->user()->telephone }}</span>
            </div>
            <svg width="14" height="14" fill="none" stroke="#b0aaa0" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
        <form action="{{ route('br.logout') }}" method="POST">
            @csrf
            <button class="btn-logout">→ Déconnexion</button>
        </form>
    </div>
</aside>

<!-- ════════ MOBILE HEADER ════════ -->
<header id="mobile-header">
    <div class="mobile-logo">
        <div class="mobile-logo-icon">B</div>
        <span class="mobile-logo-text">Business Room</span>
    </div>
    <button id="hamburger"
            onclick="document.getElementById('mobile-drawer').classList.add('open')"
            aria-label="Ouvrir le menu">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
</header>

<!-- ════════ MOBILE DRAWER ════════ -->
<div id="mobile-drawer">
    <div class="drawer-overlay" onclick="document.getElementById('mobile-drawer').classList.remove('open')"></div>
    <div class="drawer-panel">
        <div class="drawer-header">
            <div class="mobile-logo">
                <div class="mobile-logo-icon">B</div>
                <span class="mobile-logo-text">Business Room</span>
            </div>
            <button class="drawer-close" onclick="document.getElementById('mobile-drawer').classList.remove('open')">✕</button>
        </div>

        <nav class="drawer-nav">
            <p class="nav-section-label">Principal</p>
            <a href="{{ route('br.membre.dashboard') }}" class="nav-link {{ request()->routeIs('br.membre.dashboard') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Tableau de bord
            </a>
            <a href="{{ route('br.membre.tontine.index') }}" class="nav-link {{ request()->routeIs('br.membre.tontine.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Tontines
            </a>
            <a href="{{ route('br.membre.pret.index') }}" class="nav-link {{ request()->routeIs('br.membre.pret.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Prêts
            </a>

            <p class="nav-section-label">Communauté</p>
            <a href="{{ route('br.membre.business.index') }}" class="nav-link {{ request()->routeIs('br.membre.business.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                Business Room
            </a>
            <a href="{{ route('br.membre.assistance.index') }}" class="nav-link {{ request()->routeIs('br.membre.assistance.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Assistance
            </a>

            <p class="nav-section-label">Finance</p>
            <a href="{{ route('br.membre.cashbook.index') }}" class="nav-link {{ request()->routeIs('br.membre.cashbook.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Cahier de caisse
            </a>

            <div style="padding-top:20px; margin-top:20px; border-top:1px solid var(--border);">
                <a href="{{ route('br.membre.profil') }}" class="sidebar-user" style="margin-bottom:4px">
                    <div class="sidebar-avatar">{{ substr(auth('brfinal')->user()->prenom, 0, 1) }}</div>
                    <div class="sidebar-user-info">
                        <strong>{{ auth('brfinal')->user()->nom_complet }}</strong>
                        <span>{{ auth('brfinal')->user()->telephone }}</span>
                    </div>
                </a>
                <form action="{{ route('br.logout') }}" method="POST">
                    @csrf
                    <button class="btn-logout">→ Déconnexion</button>
                </form>
            </div>
        </nav>
    </div>
</div>

<!-- ════════ MAIN ════════ -->
<main id="main-content">

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
    @endif
    @if(session('info'))
        <div class="alert alert-info">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('info') }}
        </div>
    @endif

    @yield('content')
</main>

@stack('scripts')
</body>
</html>