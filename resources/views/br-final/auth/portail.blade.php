<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>COOP-CA · Business Room</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --green-dark:   #1B4332;
            --green-mid:    #2D6A4F;
            --green-light:  #D8F3DC;
            --green-pale:   #F0FAF3;
            --gold:         #D4A017;
            --gold-light:   #FFF8E1;
            --white:        #FFFFFF;
            --gray-50:      #F9FAFB;
            --gray-100:     #F3F4F6;
            --gray-400:     #9CA3AF;
            --gray-600:     #4B5563;
            --gray-900:     #111827;
            --radius-sm:    10px;
            --radius-md:    16px;
            --radius-lg:    24px;
            --radius-xl:    32px;
        }

        body {
            font-family: 'Manrope', sans-serif;
            background: var(--gray-50);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
            padding-bottom: 80px;
            max-width: 480px;
            margin: 0 auto;
        }

        /* ── TOP NAV ── */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 20px 16px;
            background: var(--white);
        }
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .logo-icon {
            width: 40px; height: 40px;
            background: var(--green-dark);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
        }
        .logo-icon svg { width: 24px; height: 24px; }
        .logo-text { line-height: 1.1; }
        .logo-text .name  { font-size: 14px; font-weight: 900; color: var(--green-dark); letter-spacing: 0.02em; }
        .logo-text .sub   { font-size: 10px; font-weight: 700; color: var(--gold); letter-spacing: 0.12em; text-transform: uppercase; }
        .hamburger {
            width: 40px; height: 40px;
            border-radius: 50%;
            border: 1.5px solid #E5E7EB;
            background: white;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
        }

        /* ── HERO ── */
        .hero {
            background: white;
            padding: 24px 20px 0;
            position: relative;
            overflow: hidden;
            min-height: 280px;
        }
        .hero-bg-circle {
            position: absolute;
            top: -20px; right: -30px;
            width: 220px; height: 220px;
            background: var(--green-pale);
            border-radius: 50%;
            z-index: 0;
        }
        .hero-content { position: relative; z-index: 1; width: 55%; }
        .hero h1 {
            font-size: 30px;
            font-weight: 900;
            color: var(--green-dark);
            line-height: 1.1;
            margin-bottom: 12px;
        }
        .hero h1 em { font-style: normal; color: var(--gold); }
        .hero-sub {
            font-size: 12px;
            color: var(--gray-600);
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .hero-btns { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 24px; }
        .btn-primary {
            display: inline-flex; align-items: center; gap: 6px;
            background: var(--green-dark);
            color: white;
            font-size: 11px; font-weight: 800;
            padding: 11px 16px;
            border-radius: 50px;
            text-decoration: none;
            letter-spacing: 0.02em;
            white-space: nowrap;
            transition: opacity 0.2s;
        }
        .btn-primary:active { opacity: 0.85; }
        .btn-outline {
            display: inline-flex; align-items: center; gap: 6px;
            background: white;
            color: var(--green-dark);
            border: 1.5px solid var(--green-dark);
            font-size: 11px; font-weight: 700;
            padding: 10px 16px;
            border-radius: 50px;
            text-decoration: none;
            white-space: nowrap;
            transition: opacity 0.2s;
        }

        /* Social proof strip */
        .social-strip {
            display: flex; align-items: center; gap: 10px;
            padding-bottom: 20px;
            position: relative; z-index: 1;
        }
        .avatars { display: flex; }
        .avatars span {
            width: 26px; height: 26px;
            border-radius: 50%;
            border: 2px solid white;
            background: var(--green-light);
            margin-left: -8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 10px; font-weight: 700; color: var(--green-dark);
            overflow: hidden;
        }
        .avatars span:first-child { margin-left: 0; }
        .avatars span img { width: 100%; height: 100%; object-fit: cover; }
        .social-text { font-size: 10px; color: var(--gray-600); line-height: 1.4; }
        .social-text strong { color: var(--gray-900); font-weight: 800; }

        /* Cooperer badge */
        .coop-badge {
            position: absolute;
            bottom: 20px; right: 16px;
            background: white;
            border-radius: var(--radius-md);
            padding: 10px 14px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.12);
            display: flex; align-items: center; gap: 8px;
            z-index: 2;
            max-width: 160px;
        }
        .coop-badge .check-icon {
            width: 28px; height: 28px; flex-shrink: 0;
            background: var(--green-dark);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
        }
        .coop-badge p { font-size: 10px; font-weight: 700; color: var(--green-dark); line-height: 1.3; }

        /* Hero image */
        .hero-img {
            position: absolute;
            top: 0; right: 0;
            width: 48%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }
        .hero-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top center;
        }

        /* ── STATS ── */
        .stats {
            background: white;
            margin: 12px 16px;
            border-radius: var(--radius-lg);
            padding: 20px 16px;
            display: flex;
            align-items: center;
            justify-content: space-around;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        }
        .stat-item { text-align: center; flex: 1; }
        .stat-item .icon-circle {
            width: 38px; height: 38px;
            border-radius: 50%;
            margin: 0 auto 8px;
            display: flex; align-items: center; justify-content: center;
        }
        .ic-green { background: var(--green-pale); }
        .ic-gold  { background: var(--gold-light); }
        .stat-item .val {
            font-size: 20px; font-weight: 900;
            line-height: 1;
            margin-bottom: 2px;
        }
        .val-green { color: var(--green-mid); }
        .val-gold  { color: var(--gold); }
        .val-blue  { color: #1D6FBA; }
        .stat-item .lbl { font-size: 9px; font-weight: 600; color: var(--gray-400); text-transform: uppercase; letter-spacing: 0.08em; }
        .stat-divider { width: 1px; height: 40px; background: var(--gray-100); }

        /* ── SECTION TITLE ── */
        .section-title {
            padding: 20px 20px 4px;
            font-size: 20px; font-weight: 900; color: var(--gray-900);
        }
        .section-sub {
            padding: 0 20px 16px;
            font-size: 12px; color: var(--gray-400);
        }
        .title-underline {
            width: 32px; height: 3px;
            background: var(--gold);
            border-radius: 2px;
            margin: 6px 20px 0;
        }

        /* ── AVANTAGES ── */
        .advantages {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 10px;
            padding: 0 16px 24px;
        }
        .adv-card {
            background: white;
            border-radius: var(--radius-md);
            padding: 16px 10px 14px;
            text-align: center;
        }
        .adv-icon {
            width: 44px; height: 44px;
            border-radius: 50%;
            margin: 0 auto 10px;
            display: flex; align-items: center; justify-content: center;
        }
        .adv-card h3 { font-size: 11px; font-weight: 800; color: var(--gray-900); margin-bottom: 6px; line-height: 1.3; }
        .adv-card p  { font-size: 9.5px; color: var(--gray-400); line-height: 1.5; margin-bottom: 8px; }
        .adv-bar { width: 24px; height: 2.5px; border-radius: 2px; margin: 0 auto 0; }

        /* ── CTA BANNER ── */
        .cta-banner {
            margin: 0 16px 28px;
            background: var(--green-dark);
            border-radius: var(--radius-xl);
            padding: 28px 20px 28px;
            position: relative;
            overflow: hidden;
        }
        .cta-banner::before {
            content: '';
            position: absolute;
            top: -40px; right: -40px;
            width: 150px; height: 150px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
        }
        .cta-banner::after {
            content: '';
            position: absolute;
            bottom: -30px; left: -20px;
            width: 100px; height: 100px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
        }
        .cta-inner { display: flex; align-items: center; gap: 16px; position: relative; z-index: 1; }
        .cta-left { flex: 1; }
        .cta-gold-circle {
            width: 52px; height: 52px; flex-shrink: 0;
            background: rgba(212,160,23,0.2);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
        }
        .cta-illustrations {
            position: absolute; right: 20px; top: 50%; transform: translateY(-50%);
            opacity: 0.18;
        }
        .cta-banner h2 {
            font-size: 18px; font-weight: 900; color: white;
            line-height: 1.2; margin-bottom: 6px;
        }
        .cta-banner p { font-size: 11px; color: rgba(255,255,255,0.7); line-height: 1.5; margin-bottom: 16px; }
        .btn-cta {
            display: inline-flex; align-items: center; gap: 6px;
            background: white;
            color: var(--green-dark);
            font-size: 12px; font-weight: 800;
            padding: 12px 22px;
            border-radius: 50px;
            text-decoration: none;
            letter-spacing: 0.02em;
        }
        .btn-cta svg { flex-shrink: 0; }

        /* ── BOTTOM NAV ── */
        .bottom-nav {
            position: fixed;
            bottom: 0; left: 50%;
            transform: translateX(-50%);
            width: 100%; max-width: 480px;
            background: white;
            border-top: 1px solid #F0F0F0;
            display: flex;
            padding: 8px 0 calc(8px + env(safe-area-inset-bottom));
        }
        .nav-item {
            flex: 1;
            display: flex; flex-direction: column; align-items: center;
            gap: 3px;
            text-decoration: none;
            color: var(--gray-400);
            font-size: 10px; font-weight: 600;
            padding: 4px 0;
            position: relative;
        }
        .nav-item.active { color: var(--green-dark); }
        .nav-item.active::after {
            content: '';
            position: absolute;
            bottom: -8px;
            width: 4px; height: 4px;
            background: var(--green-dark);
            border-radius: 50%;
        }
        .nav-item svg { width: 22px; height: 22px; }

        /* Spinner */
        .spin {
            width: 14px; height: 14px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            display: none;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</head>
<body>

<!-- ── TOP BAR ── -->
<header class="topbar">
    <div class="logo">
        <div class="logo-icon">
            <!-- People/coop icon -->
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="8"  cy="7"  r="2.5" fill="#D4A017"/>
                <circle cx="16" cy="7"  r="2.5" fill="#D4A017"/>
                <circle cx="12" cy="5"  r="2"   fill="white"/>
                <path d="M3 17c0-3 2-5 5-5h8c3 0 5 2 5 5" stroke="white" stroke-width="1.8" stroke-linecap="round"/>
            </svg>
        </div>
        <div class="logo-text">
            <div class="name">COOP-CA</div>
            <div class="sub">Business Room</div>
        </div>
    </div>
  
</header>

<!-- ── HERO ── -->
<section class="hero">
    <div class="hero-bg-circle"></div>

    <!-- Photo héro à droite -->
    <div class="hero-img">
        <img src="img.png" alt="Membres de la coopérative" onerror="this.style.display='none'">
    </div>

    <div class="hero-content">
        <h1>Ensemble,<br><em>révons<br>plus grand.</em></h1>
        <p class="hero-sub">La coopérative d'appui multiforme qui transforme votre vie.</p>
        <div class="hero-btns">
            <a href="{{ route('br.register') }}" id="joinBtn" class="btn-primary">
                Rejoindre la coopérative
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                <span class="spin" id="joinSpin"></span>
            </a>
            <a href="#avantages" class="btn-outline">En savoir plus</a>
        </div>

        <div class="social-strip">
            <div class="avatars">
                <span>A</span>
                <span>B</span>
                <span>C</span>
                <span>+</span>
            </div>
            <p class="social-text">Plus de <strong>5 000 membres</strong><br>nous font déjà confiance.</p>
        </div>
    </div>

    <!-- Badge flottant -->
    <div class="coop-badge">
        <div class="check-icon">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
        </div>
        <p>Coopérer<br>aujourd'hui,<br>réussir demain.</p>
    </div>
</section>

<!-- ── STATS ── -->
<div class="stats">
    <div class="stat-item">
        <div class="icon-circle ic-green">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D6A4F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <div class="val val-green">5 000+</div>
        <div class="lbl">Adhérents</div>
    </div>
    <div class="stat-divider"></div>
    <div class="stat-item">
        <div class="icon-circle ic-gold">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#D4A017" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        </div>
        <div class="val val-gold">100%</div>
        <div class="lbl">Satisfaction</div>
    </div>
    <div class="stat-divider"></div>
    <div class="stat-item">
        <div class="icon-circle" style="background:#EBF5FF;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1D6FBA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
        </div>
        <div class="val val-blue">5M+<br><span style="font-size:11px;">FCFA</span></div>
        <div class="lbl">Projets financés</div>
    </div>
</div>

<!-- ── AVANTAGES ── -->
<div id="avantages">
    <h2 class="section-title">Nos avantages</h2>
    <div class="title-underline"></div>
    <p class="section-sub">Pourquoi choisir COOP-CA ?</p>

    <div class="advantages">

        <div class="adv-card">
            <div class="adv-icon ic-green">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D6A4F" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
            </div>
            <h3>Crédit rapide</h3>
            <p>Réponse à vos demandes sous 24h.</p>
            <div class="adv-bar" style="background: var(--green-mid);"></div>
        </div>

        <div class="adv-card">
            <div class="adv-icon ic-gold">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#D4A017" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <h3>Sécurité garantie</h3>
            <p>Vos fonds sont protégés et sécurisés.</p>
            <div class="adv-bar" style="background: var(--gold);"></div>
        </div>

        <div class="adv-card">
            <div class="adv-icon ic-green">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D6A4F" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <h3>Accompa-gnement</h3>
            <p>Des conseillers dédiés à votre réussite.</p>
            <div class="adv-bar" style="background: var(--green-mid);"></div>
        </div>

    </div>
</div>

<!-- ── CTA BANNER ── -->
<div class="cta-banner">
    <div class="cta-inner">
        <div class="cta-gold-circle">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#D4A017" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <div class="cta-left">
            <h2>Prêt à<br>démarrer ?</h2>
            <p>Rejoignez une communauté de plus de 5 000 membres et construisons ensemble votre avenir.</p>
            <a href="{{ route('br.register') }}" id="ctaBtn" class="btn-cta">
                <span id="ctaText">Créer un compte</span>
                <span class="spin" id="ctaSpin" style="border-top-color:#1B4332; border-color:rgba(27,67,50,0.2);"></span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>

    <!-- Illustrations décoratives -->
    <svg class="cta-illustrations" width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect x="10" y="30" width="20" height="30" rx="2" stroke="white" stroke-width="1.5"/>
        <rect x="35" y="20" width="20" height="40" rx="2" stroke="white" stroke-width="1.5"/>
        <path d="M15 15 L40 5 L65 15" stroke="white" stroke-width="1.5"/>
        <path d="M5 60 L75 60" stroke="white" stroke-width="1.5"/>
        <path d="M55 45 L65 35 L75 40" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
    </svg>
</div>



<script>
(function () {
    "use strict";

    function spinOnClick(btnId, spinId, textId) {
        const btn = document.getElementById(btnId);
        if (!btn) return;
        btn.addEventListener('click', function () {
            const s = document.getElementById(spinId);
            const t = document.getElementById(textId);
            if (s) s.style.display = 'inline-block';
            if (t) t.style.opacity = '0.6';
            btn.style.pointerEvents = 'none';
            btn.style.opacity = '0.82';
        });
    }

    spinOnClick('joinBtn',  'joinSpin',  null);
    spinOnClick('ctaBtn',   'ctaSpin',   'ctaText');

    // Smooth scroll for "En savoir plus"
    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
        anchor.addEventListener('click', function (e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
})();
</script>

</body>
</html>