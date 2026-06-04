<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Business Room') — BR</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;900&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['Playfair Display', 'serif'],
                        body: ['Outfit', 'sans-serif']
                    },
                    colors: {
                        forest: {
                            50:  '#f0f7f4',
                            100: '#d6ede4',
                            200: '#a8d5be',
                            400: '#52a47e',
                            500: '#2D6A4F',
                            600: '#1B4332',
                            700: '#163827',
                            800: '#102b1e',
                            900: '#0a1c13',
                        },
                        gold: {
                            300: '#e8c76a',
                            400: '#D4A017',
                            500: '#b88a13',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        *, *::before, *::after { box-sizing: border-box; }

        :root {
            --dark:         #1B4332;
            --mid:          #2D6A4F;
            --gold:         #D4A017;
            --gold-light:   #e8c76a;
            --surface:      #ffffff;
            --surface-2:    #f0f7f4;
            --border:       #d6ede4;
            --border-dark:  rgba(255,255,255,0.08);
            --text-primary: #0d2b1e;
            --text-muted:   #4a7c62;
            --text-faint:   #8ab5a0;
            --sidebar-w:    260px;
            --header-h:     64px;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--surface-2);
            color: var(--text-primary);
            margin: 0;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4, h5 { font-family: 'Playfair Display', serif; margin: 0; }

        /* ── Sidebar ── */
        #sidebar {
            position: fixed;
            inset-y: 0;
            left: 0;
            width: var(--sidebar-w);
            background: var(--dark);
            display: flex;
            flex-direction: column;
            z-index: 40;
            box-shadow: 4px 0 24px rgba(0,0,0,0.18);
        }

        /* Decorative gold line top of sidebar */
        #sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--gold), var(--gold-light), var(--gold));
        }

        .sidebar-logo {
            padding: 26px 20px 22px;
            border-bottom: 1px solid var(--border-dark);
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .sidebar-logo-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--gold-light), var(--gold));
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            font-weight: 900;
            font-size: 20px;
            color: var(--dark);
            flex-shrink: 0;
            box-shadow: 0 4px 16px rgba(212, 160, 23, .35);
        }

        .sidebar-logo-text { line-height: 1.25; }
        .sidebar-logo-text strong {
            font-family: 'Playfair Display', serif;
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            display: block;
            letter-spacing: 0.2px;
        }
        .sidebar-logo-text span {
            font-size: 11px;
            color: var(--gold-light);
            font-weight: 400;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* ── Nav links ── */
        #sidebar nav { flex: 1; padding: 10px 14px; overflow-y: auto; }

        .nav-section-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: var(--gold);
            padding: 18px 10px 6px;
            opacity: 0.7;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 500;
            color: rgba(255,255,255,0.55);
            text-decoration: none;
            transition: all .2s ease;
            margin-bottom: 2px;
            position: relative;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.07);
            color: rgba(255,255,255,0.9);
        }

        .nav-link.active {
            background: var(--mid);
            color: #fff;
            font-weight: 600;
            box-shadow: inset 0 0 0 1px rgba(212,160,23,0.25);
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 20%;
            bottom: 20%;
            width: 3px;
            background: var(--gold);
            border-radius: 0 3px 3px 0;
        }

        .nav-link svg { width: 17px; height: 17px; flex-shrink: 0; opacity: .65; transition: opacity .2s; }
        .nav-link:hover svg, .nav-link.active svg { opacity: 1; }

        .nav-link .badge {
            margin-left: auto;
            background: rgba(212,160,23,0.2);
            color: var(--gold-light);
            font-size: 10px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 20px;
            border: 1px solid rgba(212,160,23,0.3);
        }

        /* ── Sidebar footer ── */
        .sidebar-footer {
            padding: 14px;
            border-top: 1px solid var(--border-dark);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 10px 12px;
            border-radius: 12px;
            cursor: pointer;
            text-decoration: none;
            transition: background .2s;
            background: rgba(255,255,255,0.05);
        }

        .sidebar-user:hover { background: rgba(255,255,255,0.1); }

        .sidebar-avatar {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--gold-light), var(--gold));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            color: var(--dark);
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(212,160,23,.3);
        }

        .sidebar-user-info { flex: 1; min-width: 0; }
        .sidebar-user-info strong {
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .sidebar-user-info span { font-size: 11px; color: rgba(255,255,255,0.45); }

        .btn-logout {
            display: block;
            width: 100%;
            text-align: left;
            font-size: 12px;
            color: rgba(255,255,255,0.3);
            background: none;
            border: none;
            padding: 7px 12px;
            cursor: pointer;
            border-radius: 8px;
            transition: color .18s;
            margin-top: 6px;
            font-family: 'Outfit', sans-serif;
            letter-spacing: 0.2px;
        }
        .btn-logout:hover { color: #f87171; }

        /* ── Mobile header ── */
        #mobile-header {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 50;
            height: var(--header-h);
            background: var(--dark);
            border-bottom: 1px solid var(--border-dark);
            padding: 0 20px;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            box-shadow: 0 2px 16px rgba(0,0,0,0.2);
        }

        /* gold accent on mobile header too */
        #mobile-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            opacity: 0.5;
        }

        .mobile-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .mobile-logo-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--gold-light), var(--gold));
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            font-weight: 900;
            font-size: 16px;
            color: var(--dark);
        }

        .mobile-logo-text {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 15px;
            color: #fff;
        }

        #hamburger {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,0.15);
            background: rgba(255,255,255,0.07);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: rgba(255,255,255,0.7);
            flex-shrink: 0;
            margin-left: auto;
            padding: 0;
            transition: background .18s;
        }

        #hamburger:hover {
            background: rgba(255,255,255,0.14);
            color: #fff;
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
            background: rgba(0,0,0,.55);
            backdrop-filter: blur(3px);
        }

        .drawer-panel {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 290px;
            background: var(--dark);
            display: flex;
            flex-direction: column;
            animation: slideIn .24s ease;
            box-shadow: 8px 0 32px rgba(0,0,0,0.3);
        }

        .drawer-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--gold), var(--gold-light), var(--gold));
        }

        @keyframes slideIn { from { transform: translateX(-100%); } to { transform: translateX(0); } }

        .drawer-header {
            padding: 20px;
            border-bottom: 1px solid var(--border-dark);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .drawer-close {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            font-size: 15px;
            color: rgba(255,255,255,0.6);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .18s;
        }

        .drawer-close:hover { background: rgba(255,255,255,0.14); color: #fff; }

        .drawer-nav { flex: 1; padding: 12px 14px; overflow-y: auto; }

        /* ── Alerts ── */
        .alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 18px;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 500;
            margin: 18px 26px 0;
        }

        .alert-success {
            background: #f0fdf4;
            border: 1px solid #86efac;
            color: #15803d;
        }
        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
        }
        .alert-info {
            background: #f0f7f4;
            border: 1px solid var(--border);
            color: var(--mid);
        }

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
            .alert { margin: 14px 18px 0; }
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 99px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.25); }
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
            <svg width="14" height="14" fill="none" stroke="rgba(255,255,255,0.4)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
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

            <div style="padding-top:20px; margin-top:20px; border-top:1px solid rgba(255,255,255,0.08);">
                <a href="{{ route('br.membre.profil') }}" class="sidebar-user" style="margin-bottom:6px">
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