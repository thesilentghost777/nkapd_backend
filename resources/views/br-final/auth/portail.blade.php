<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Room — Portail</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family:'DM Sans',sans-serif; background:#0d0d0f; color:#e5e5e7; min-height:100vh; }
        h1,h2,h3 { font-family:'Syne',sans-serif; }
        .mesh { position:fixed; inset:0; background:radial-gradient(ellipse at 30% 60%, rgba(249,115,22,.1) 0%, transparent 55%), radial-gradient(ellipse at 70% 30%, rgba(234,88,12,.06) 0%, transparent 50%); pointer-events:none; }
        .btn-primary { background:linear-gradient(135deg,#f97316,#ea580c); color:#fff; font-family:'Syne',sans-serif; font-weight:700; transition:all .2s; }
        .btn-primary:hover { transform:translateY(-2px); box-shadow:0 16px 40px rgba(249,115,22,.4); }
        .btn-ghost { border:1px solid rgba(255,255,255,.1); color:#e5e5e7; transition:all .2s; }
        .btn-ghost:hover { border-color:#f97316; color:#f97316; }
        .feature { background:rgba(22,22,24,.6); border:1px solid rgba(255,255,255,.06); border-radius:16px; }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-12px)} }
        .float { animation:float 6s ease-in-out infinite; }
    </style>
</head>
<body>
<div class="mesh"></div>
<div class="relative min-h-screen flex flex-col">
    <!-- Header -->
    <header class="p-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl btn-primary flex items-center justify-center text-white font-bold text-xl">B</div>
            <span style="font-family:Syne,sans-serif;font-weight:800" class="text-white text-xl">Business Room</span>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('br.login') }}" class="btn-ghost px-4 py-2 rounded-xl text-sm">Connexion</a>
            <a href="{{ route('br.register') }}" class="btn-primary px-4 py-2 rounded-xl text-sm">Rejoindre →</a>
        </div>
    </header>

    <!-- Hero -->
    <div class="flex-1 flex flex-col lg:flex-row items-center justify-center gap-16 px-6 py-16 max-w-6xl mx-auto w-full">
        <div class="flex-1 text-center lg:text-left">
            <span class="inline-block px-3 py-1 rounded-full text-xs font-medium bg-orange-500/15 text-orange-400 border border-orange-500/25 mb-6">🔥 Communauté Financière</span>
            <h1 class="text-5xl lg:text-7xl font-800 text-white leading-none mb-6" style="font-family:Syne,sans-serif">
                Épargnez.<br>
                <span class="text-transparent bg-clip-text" style="background:linear-gradient(90deg,#f97316,#fbbf24)">Empruntez.</span><br>
                Prospérez.
            </h1>
            <p class="text-gray-400 text-lg mb-10 max-w-lg">Rejoignez une communauté de confiance pour gérer vos tontines, obtenir des prêts et développer votre business.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                <a href="{{ route('br.register') }}" class="btn-primary px-8 py-4 rounded-2xl text-lg">Créer mon compte →</a>
                <a href="{{ route('br.login') }}" class="btn-ghost px-8 py-4 rounded-2xl text-lg">J'ai déjà un compte</a>
            </div>
        </div>

        <div class="flex-1 float">
            <div class="bg-gray-900 border border-gray-800 rounded-3xl p-6 max-w-sm mx-auto shadow-2xl">
                <div class="flex items-center justify-between mb-6">
                    <p class="text-xs text-gray-500 font-medium uppercase tracking-widest">Mon espace</p>
                    <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                </div>
                <div class="space-y-3 mb-6">
                    <div class="bg-gray-800 rounded-2xl p-4 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-orange-500/20 flex items-center justify-center text-orange-400 text-xl">💰</div>
                        <div>
                            <p class="text-xs text-gray-500">Épargne tontine</p>
                            <p class="text-white font-bold" style="font-family:Syne,sans-serif">120 000 FCFA</p>
                        </div>
                    </div>
                    <div class="bg-gray-800 rounded-2xl p-4 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-green-500/20 flex items-center justify-center text-green-400 text-xl">📈</div>
                        <div>
                            <p class="text-xs text-gray-500">Filleuls actifs</p>
                            <p class="text-white font-bold" style="font-family:Syne,sans-serif">3 filleuls</p>
                        </div>
                    </div>
                    <div class="bg-gray-800 rounded-2xl p-4 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-blue-500/20 flex items-center justify-center text-blue-400 text-xl">💳</div>
                        <div>
                            <p class="text-xs text-gray-500">Plafond prêt</p>
                            <p class="text-white font-bold" style="font-family:Syne,sans-serif">150 000 FCFA</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-orange-600 to-orange-500 rounded-2xl p-4">
                    <p class="text-white text-sm font-medium">Cotisation du jour</p>
                    <p class="text-white/70 text-xs">Tontine journalière · 500 FCFA</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Features -->
    <div class="px-6 py-16 max-w-6xl mx-auto w-full">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="feature p-6">
                <div class="text-3xl mb-4">🤝</div>
                <h3 class="text-white font-bold mb-2" style="font-family:Syne,sans-serif">Tontines digitales</h3>
                <p class="text-gray-500 text-sm">Tontines journalières et hebdomadaires avec suivi en temps réel de votre épargne.</p>
            </div>
            <div class="feature p-6">
                <div class="text-3xl mb-4">💸</div>
                <h3 class="text-white font-bold mb-2" style="font-family:Syne,sans-serif">Prêts solidaires</h3>
                <p class="text-gray-500 text-sm">Obtenez des prêts basés sur votre réseau de filleuls, jusqu'à 50 000 FCFA par filleul.</p>
            </div>
            <div class="feature p-6">
                <div class="text-3xl mb-4">🏪</div>
                <h3 class="text-white font-bold mb-2" style="font-family:Syne,sans-serif">Marketplace business</h3>
                <p class="text-gray-500 text-sm">Publiez et découvrez des produits et services au sein de la communauté.</p>
            </div>
        </div>
    </div>
</div>
</body>
</html>