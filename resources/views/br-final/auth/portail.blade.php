<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CFPAM COOPCA - Ensemble, rêvons plus grand</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">

<div class="min-h-screen">

    {{-- Hero Section --}}
    <div class="text-center py-16 px-4">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
            Ensemble, <span class="text-amber-600">Rêvons plus grand..</span>
        </h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
            La coopérative d'appui multiforme qui transforme votre vie.
        </p>
    </div>

    {{-- Stats Banner --}}
    <div class="max-w-6xl mx-auto px-4 mb-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-2xl p-6 text-center">
                <p class="text-3xl md:text-4xl font-bold text-amber-700">5000+</p>
                <p class="text-gray-600 font-medium mt-1">Adhérents</p>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-6 text-center">
                <p class="text-3xl md:text-4xl font-bold text-green-700">100%</p>
                <p class="text-gray-600 font-medium mt-1">Satisfaction</p>
            </div>
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 text-center">
                <p class="text-3xl md:text-4xl font-bold text-blue-700">5M+</p>
                <p class="text-gray-600 font-medium mt-1">Projets financés</p>
            </div>
        </div>
    </div>

    {{-- CTA Section --}}
    <div class="max-w-4xl mx-auto px-4 mb-16">
        <div class="bg-gradient-to-r from-amber-600 to-amber-700 rounded-2xl p-8 md:p-12 text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">Rejoindre Notre Coopérative</h2>
            <a href="{{ route('br.register') }}" class="inline-block px-8 py-3 bg-white text-amber-700 font-semibold rounded-lg hover:bg-gray-100 transition shadow-lg">
                Découvrir →
            </a>
        </div>
    </div>

    {{-- Avantages Section --}}
    <div class="max-w-6xl mx-auto px-4 mb-16">
        <h2 class="text-2xl md:text-3xl font-bold text-center text-gray-900 mb-4">Nos avantages</h2>
        <p class="text-center text-gray-500 mb-10">Pourquoi choisir CFPAM COOP-CA ?</p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- Prêt flexible --}}
            <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm hover:shadow-md transition">
                <div class="text-4xl mb-3">💰</div>
                <h3 class="font-semibold text-lg text-gray-900 mb-2">Prêt et accompagnement flexibles</h3>
                <p class="text-gray-600 text-sm mb-3">Deux formules NKD & NKH adaptées à votre capacité. Épargnez à votre rythme, sans pression.</p>
                <div class="flex gap-2">
                    <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs rounded-full font-medium">NKD</span>
                    <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs rounded-full font-medium">NKH</span>
                </div>
            </div>

            {{-- Financement accéléré --}}
            <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm hover:shadow-md transition">
                <div class="text-4xl mb-3">⚡</div>
                <h3 class="font-semibold text-lg text-gray-900 mb-2">Financement accéléré</h3>
                <p class="text-gray-600 text-sm mb-3">Accédez à des fonds pour vos projets dès que votre score est atteint. Demande 100% digitale.</p>
                <div class="inline-block px-3 py-1 bg-green-100 text-green-700 text-xs rounded-full font-medium">75% financé</div>
            </div>

            {{-- Journal de caisse --}}
            <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm hover:shadow-md transition">
                <div class="text-4xl mb-3">📊</div>
                <h3 class="font-semibold text-lg text-gray-900 mb-2">Journal de caisse</h3>
                <p class="text-gray-600 text-sm">Gérez vos entrées et sorties d'argent en temps réel.</p>
            </div>

            {{-- Vitrine Business --}}
            <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm hover:shadow-md transition">
                <div class="text-4xl mb-3">🏪</div>
                <h3 class="font-semibold text-lg text-gray-900 mb-2">Vitrine Business</h3>
                <p class="text-gray-600 text-sm">Publiez vos offres, touchez le réseau BUSINESS ROOM.</p>
            </div>

            {{-- Invitation & Score --}}
            <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm hover:shadow-md transition lg:col-span-2">
                <div class="text-4xl mb-3">🎯</div>
                <h3 class="font-semibold text-lg text-gray-900 mb-2">Invitation & Score</h3>
                <p class="text-gray-600 text-sm">Invitez vos proches, gagnez des points et déverrouillez des avantages exclusifs.</p>
            </div>
        </div>
    </div>

    {{-- Adhésion rapide --}}
    <div class="text-center mb-16">
        <a href="{{ route('br.register') }}" class="inline-block px-8 py-3 bg-amber-600 text-white font-semibold rounded-lg hover:bg-amber-700 transition">
            + Adhérer maintenant
        </a>
    </div>

    {{-- Prêt à démarrer --}}
    <div class="max-w-3xl mx-auto px-4 mb-16">
        <h2 class="text-2xl font-bold text-center text-gray-900 mb-6">Prêt à démarrer ?</h2>
        <p class="text-center text-gray-500 mb-8">Choisissez votre espace d'accès</p>

        <div class="bg-white border border-gray-200 rounded-xl p-8 max-w-md mx-auto">
            <h3 class="text-xl font-semibold text-gray-900 mb-4 text-center">Adhérents</h3>
            <div class="space-y-3">
                <a href="{{ route('br.register') }}" class="block w-full py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-center rounded-lg font-medium transition">
                    Créer un compte
                </a>
                <a href="{{ route('br.login') }}" class="block w-full py-2.5 border border-gray-300 hover:border-amber-400 text-gray-700 text-center rounded-lg font-medium transition">
                    Se connecter
                </a>
            </div>
            <p class="text-xs text-gray-400 text-center mt-4">Rejoindre la coopérative / J'ai déjà un compte</p>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="text-center py-8 border-t border-gray-200 bg-white">
        <p class="text-sm text-gray-400">© 2026 Business Room Final · Tous droits réservés</p>
    </footer>

</div>

</body>
</html>