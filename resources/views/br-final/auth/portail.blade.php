<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CFPAM COOPCA · Ensemble, rêvons plus grand</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(160deg, #fff5f0 0%, #fde8da 40%, #faf0e6 100%);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
            margin: 0;
        }
        .spin-loader {
            width: 16px; height: 16px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.75s linear infinite;
            display: inline-block;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        .btn-transition { transition: all 0.2s cubic-bezier(0.2, 0.9, 0.4, 1); }
    </style>
</head>
<body>

<div style="max-width: 480px; margin: 0 auto; padding: 0 0 48px;">

    {{-- Logo --}}
    <div style="padding: 28px 24px 0; color: #E8541A; font-size: 13px; font-weight: 800; letter-spacing: 0.12em;">
        BUSINESS ROOM
    </div>

    {{-- Hero --}}
    <div style="padding: 32px 24px 28px;">
        <h1 style="font-size: 42px; font-weight: 900; line-height: 1.08; color: #1a1a1a; margin: 0 0 16px;">
            Ensemble,<br>
            <span style="color: #E8541A;">rêvons<br>plus grand.</span>
        </h1>
        <p style="font-size: 15px; color: #6b6b6b; line-height: 1.6; margin: 0;">
            La coopérative d'appui multiforme<br>qui transforme votre vie.
        </p>
    </div>

    {{-- Stats --}}
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; padding: 0 24px 28px;">
        <div style="background: white; border-radius: 18px; padding: 20px 14px; text-align: center;">
            <div style="font-size: 28px; font-weight: 900; color: #E8541A;">5 000+</div>
            <div style="font-size: 10px; font-weight: 600; letter-spacing: 0.08em; color: #888; text-transform: uppercase; margin-top: 4px;">Adhérents</div>
        </div>
        <div style="background: white; border-radius: 18px; padding: 20px 14px; text-align: center;">
            <div style="font-size: 28px; font-weight: 900; color: #16a34a;">100%</div>
            <div style="font-size: 10px; font-weight: 600; letter-spacing: 0.08em; color: #888; text-transform: uppercase; margin-top: 4px;">Satisfaction</div>
        </div>
        <div style="background: white; border-radius: 18px; padding: 20px 14px; text-align: center; grid-column: 1 / -1;">
            <div style="font-size: 28px; font-weight: 900; color: #1d6fba;">5M+ FCFA</div>
            <div style="font-size: 10px; font-weight: 600; letter-spacing: 0.08em; color: #888; text-transform: uppercase; margin-top: 4px;">Projets financés</div>
        </div>
    </div>

    {{-- CTA Banner --}}
    <div style="margin: 0 24px 32px; background: #E8541A; border-radius: 24px; padding: 32px 24px; text-align: center;">
        <h2 style="color: white; font-size: 22px; font-weight: 800; margin: 0 0 18px;">
            Rejoignez Notre Coopérative
        </h2>
        <a href="{{ route('br.register') }}"
           id="ctaDiscoverBtn"
           class="btn-transition"
           style="display: inline-flex; align-items: center; gap: 8px; background: white; color: #E8541A; font-weight: 800; font-size: 13px; letter-spacing: 0.08em; text-transform: uppercase; border-radius: 50px; padding: 14px 28px; text-decoration: none;">
            <span id="ctaDiscoverText">Découvrir</span>
            <span id="ctaDiscoverLoader" class="spin-loader" style="display:none; border-top-color: #E8541A; border-color: rgba(232,84,26,0.2);"></span>
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

    {{-- Avantages --}}
    <div style="padding: 0 24px;">
        <h2 style="font-size: 24px; font-weight: 800; color: #1a1a1a; margin: 0 0 4px;">Nos avantages</h2>
        <p style="font-size: 13px; color: #888; margin: 0 0 18px;">Pourquoi choisir CFPAM COOP-CA ?</p>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 32px;">

            <div style="background: white; border-radius: 18px; padding: 18px 14px;">
                <div style="font-size: 26px; margin-bottom: 8px;">💰</div>
                <h3 style="font-size: 13px; font-weight: 700; color: #1a1a1a; margin: 0 0 6px;">Prêt flexible</h3>
                <p style="font-size: 11px; color: #777; line-height: 1.5; margin: 0 0 8px;">Formules NKD & NKH à votre rythme, sans pression.</p>
                <span style="display:inline-block; background:#fff4ef; color:#E8541A; font-size:10px; font-weight:700; border-radius:50px; padding:4px 10px;">NKD</span>
                <span style="display:inline-block; background:#fff4ef; color:#E8541A; font-size:10px; font-weight:700; border-radius:50px; padding:4px 10px; margin-left:4px;">NKH</span>
            </div>

            <div style="background: white; border-radius: 18px; padding: 18px 14px;">
                <div style="font-size: 26px; margin-bottom: 8px;">⚡</div>
                <h3 style="font-size: 13px; font-weight: 700; color: #1a1a1a; margin: 0 0 6px;">Financement rapide</h3>
                <p style="font-size: 11px; color: #777; line-height: 1.5; margin: 0 0 8px;">Demande 100% digitale. Fonds débloqués dès votre score.</p>
                <span style="display:inline-block; background:#f0fdf4; color:#16a34a; font-size:10px; font-weight:700; border-radius:50px; padding:4px 10px;">75% financé</span>
            </div>

            <div style="background: white; border-radius: 18px; padding: 18px 14px;">
                <div style="font-size: 26px; margin-bottom: 8px;">📊</div>
                <h3 style="font-size: 13px; font-weight: 700; color: #1a1a1a; margin: 0 0 6px;">Journal de caisse</h3>
                <p style="font-size: 11px; color: #777; line-height: 1.5; margin: 0;">Suivi en temps réel de vos flux financiers.</p>
            </div>

            <div style="background: white; border-radius: 18px; padding: 18px 14px;">
                <div style="font-size: 26px; margin-bottom: 8px;">🏪</div>
                <h3 style="font-size: 13px; font-weight: 700; color: #1a1a1a; margin: 0 0 6px;">Vitrine Business</h3>
                <p style="font-size: 11px; color: #777; line-height: 1.5; margin: 0;">Publiez vos offres dans tout le réseau BUSINESS ROOM.</p>
            </div>

            <div style="background: white; border-radius: 18px; padding: 18px 14px; grid-column: 1 / -1;">
                <div style="font-size: 26px; margin-bottom: 8px;">🎯</div>
                <h3 style="font-size: 13px; font-weight: 700; color: #1a1a1a; margin: 0 0 6px;">Invitation & Score</h3>
                <p style="font-size: 11px; color: #777; line-height: 1.5; margin: 0;">Invitez vos proches, gagnez des points et déverrouillez des avantages exclusifs dans tout le réseau.</p>
            </div>

        </div>
    </div>

    {{-- Adhésion --}}
    <div style="margin: 0 24px 32px; background: white; border-radius: 24px; padding: 32px 20px;">
        <h3 style="text-align: center; font-size: 22px; font-weight: 800; color: #1a1a1a; margin: 0 0 24px;">Prêt à démarrer ?</h3>

        <a href="{{ route('br.register') }}"
           id="registerBtn"
           class="btn-transition"
           style="display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; background: #E8541A; color: white; font-size: 13px; font-weight: 800; letter-spacing: 0.08em; text-transform: uppercase; border-radius: 50px; padding: 17px; text-decoration: none; margin-bottom: 12px;">
            <span id="registerText">+ Adhérer maintenant</span>
            <span id="registerLoader" class="spin-loader" style="display:none;"></span>
        </a>

        <a href="{{ route('br.login') }}"
           id="loginBtn"
           class="btn-transition"
           style="display: flex; align-items: center; justify-content: center; width: 100%; background: transparent; color: #1a1a1a; font-size: 13px; font-weight: 600; border: 1.5px solid #e2e2e2; border-radius: 50px; padding: 15px; text-decoration: none;">
            <span id="loginText">Se connecter</span>
            <span id="loginLoader" class="spin-loader" style="display:none; border-top-color: #E8541A; border-color: rgba(232,84,26,0.2);"></span>
        </a>

        <p style="text-align: center; font-size: 11px; color: #aaa; margin: 16px 0 0;">
            Rejoindre la coopérative · J'ai déjà un compte
        </p>
    </div>

    {{-- Footer --}}
    <footer style="text-align: center; padding: 0 24px; font-size: 11px; color: #aaa;">
        © 2026 Business Room Final · Tous droits réservés
    </footer>

</div>

<script>
(function() {
    "use strict";
    function setupLoader(btnId, loaderId, textId) {
        const btn = document.getElementById(btnId);
        if (!btn) return;
        btn.addEventListener('click', function() {
            const loader = document.getElementById(loaderId);
            const text = document.getElementById(textId);
            if (loader) loader.style.display = 'inline-block';
            if (text) text.style.opacity = '0.7';
            btn.style.pointerEvents = 'none';
            btn.style.opacity = '0.8';
        });
    }
    setupLoader('ctaDiscoverBtn', 'ctaDiscoverLoader', 'ctaDiscoverText');
    setupLoader('registerBtn', 'registerLoader', 'registerText');
    setupLoader('loginBtn', 'loginLoader', 'loginText');
})();
</script>

</body>
</html>