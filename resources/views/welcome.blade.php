<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="NKAP - Votre plateforme de gestion financière, tontines et épargne communautaire">
    <title>NKAP - Gestion Financière & Tontines</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(34, 197, 94, 0.3); }
            50% { box-shadow: 0 0 40px rgba(34, 197, 94, 0.6); }
        }
        .float-animation { animation: float 3s ease-in-out infinite; }
        .pulse-glow { animation: pulse-glow 2s ease-in-out infinite; }
        .money-gradient { background: linear-gradient(135deg, #064e3b 0%, #059669 50%, #34d399 100%); }
        .money-text { background: linear-gradient(135deg, #059669, #34d399); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    </style>
</head>
<body class="bg-gradient-to-br from-emerald-950 via-emerald-900 to-green-900 min-h-screen font-sans antialiased">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-emerald-950/80 backdrop-blur-lg border-b border-emerald-700/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-green-500 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-coins text-white text-lg"></i>
                    </div>
                    <span class="text-2xl font-bold text-white">NKAP</span>
                </div>
                <div class="hidden md:flex items-center gap-8">
                    <a href="#fonctionnalites" class="text-emerald-200 hover:text-white transition-colors">Fonctionnalités</a>
                    <a href="#tontines" class="text-emerald-200 hover:text-white transition-colors">Tontines</a>
                    <a href="#marketplace" class="text-emerald-200 hover:text-white transition-colors">Marketplace</a>
                    <a href="#contact" class="text-emerald-200 hover:text-white transition-colors">Contact</a>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('login') }}" class="text-emerald-200 hover:text-white transition-colors font-medium">Connexion</a>
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-emerald-500 to-green-500 hover:from-emerald-600 hover:to-green-600 text-white px-6 py-2 rounded-lg font-medium transition-all shadow-lg hover:shadow-emerald-500/30">
                        S'inscrire
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-4 relative overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-20 left-10 w-72 h-72 bg-emerald-500/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-green-500/10 rounded-full blur-3xl"></div>
        </div>
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="inline-flex items-center gap-2 bg-emerald-800/50 border border-emerald-600/30 rounded-full px-4 py-2 mb-6">
                        <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                        <span class="text-emerald-300 text-sm font-medium">Plateforme sécurisée</span>
                    </div>
                    <h1 class="text-4xl md:text-6xl font-bold text-white leading-tight mb-6">
                        Gérez votre <span class="money-text">argent</span> en toute simplicité
                    </h1>
                    <p class="text-lg text-emerald-200/80 mb-8 leading-relaxed">
                        NKAP révolutionne la gestion financière communautaire. Créez des tontines, 
                        transférez de l'argent, et vendez vos produits sur notre marketplace sécurisée.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-emerald-500 to-green-500 hover:from-emerald-600 hover:to-green-600 text-white px-8 py-4 rounded-xl font-semibold text-lg transition-all shadow-xl hover:shadow-emerald-500/30 pulse-glow">
                            <i class="fas fa-rocket mr-2"></i>Commencer maintenant
                        </a>
                        <a href="#fonctionnalites" class="border-2 border-emerald-500/50 hover:border-emerald-400 text-emerald-200 hover:text-white px-8 py-4 rounded-xl font-semibold text-lg transition-all">
                            <i class="fas fa-play-circle mr-2"></i>Découvrir
                        </a>
                    </div>
                    <div class="flex items-center gap-8 mt-10">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">10K+</div>
                            <div class="text-emerald-400 text-sm">Utilisateurs</div>
                        </div>
                        <div class="w-px h-12 bg-emerald-700"></div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">500+</div>
                            <div class="text-emerald-400 text-sm">Tontines</div>
                        </div>
                        <div class="w-px h-12 bg-emerald-700"></div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">50M</div>
                            <div class="text-emerald-400 text-sm">FCFA échangés</div>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-gradient-to-br from-emerald-800/50 to-green-800/30 backdrop-blur-xl rounded-3xl border border-emerald-600/30 p-8 shadow-2xl float-animation">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <p class="text-emerald-400 text-sm">Solde total</p>
                                <p class="text-3xl font-bold text-white">2,450,000 <span class="text-lg text-emerald-300">FCFA</span></p>
                            </div>
                            <div class="w-14 h-14 bg-gradient-to-br from-emerald-400 to-green-500 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-wallet text-white text-2xl"></i>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="bg-emerald-900/50 rounded-xl p-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <i class="fas fa-arrow-up text-emerald-400"></i>
                                    <span class="text-emerald-300 text-sm">Reçu</span>
                                </div>
                                <p class="text-xl font-bold text-white">+850,000</p>
                            </div>
                            <div class="bg-emerald-900/50 rounded-xl p-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <i class="fas fa-arrow-down text-red-400"></i>
                                    <span class="text-emerald-300 text-sm">Envoyé</span>
                                </div>
                                <p class="text-xl font-bold text-white">-320,000</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between bg-emerald-900/30 rounded-lg p-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-green-500/20 rounded-full flex items-center justify-center">
                                        <i class="fas fa-users text-green-400"></i>
                                    </div>
                                    <div>
                                        <p class="text-white font-medium">Tontine Famille</p>
                                        <p class="text-emerald-400 text-xs">Il y a 2h</p>
                                    </div>
                                </div>
                                <span class="text-green-400 font-semibold">+100,000</span>
                            </div>
                            <div class="flex items-center justify-between bg-emerald-900/30 rounded-lg p-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-500/20 rounded-full flex items-center justify-center">
                                        <i class="fas fa-exchange-alt text-blue-400"></i>
                                    </div>
                                    <div>
                                        <p class="text-white font-medium">Transfert</p>
                                        <p class="text-emerald-400 text-xs">Il y a 5h</p>
                                    </div>
                                </div>
                                <span class="text-red-400 font-semibold">-50,000</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fonctionnalités -->
    <section id="fonctionnalites" class="py-20 px-4 bg-emerald-950/50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Fonctionnalités puissantes</h2>
                <p class="text-emerald-300 text-lg max-w-2xl mx-auto">Découvrez tous les outils dont vous avez besoin pour gérer vos finances</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-gradient-to-br from-emerald-800/40 to-emerald-900/40 backdrop-blur-sm rounded-2xl border border-emerald-600/20 p-6 hover:border-emerald-500/50 transition-all group">
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-400 to-green-500 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-wallet text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Portefeuille</h3>
                    <p class="text-emerald-300/80">Gérez votre solde, rechargez et effectuez des retraits en toute simplicité.</p>
                </div>
                <div class="bg-gradient-to-br from-emerald-800/40 to-emerald-900/40 backdrop-blur-sm rounded-2xl border border-emerald-600/20 p-6 hover:border-emerald-500/50 transition-all group">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-400 to-teal-500 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Tontines</h3>
                    <p class="text-emerald-300/80">Créez et rejoignez des tontines pour épargner ensemble en communauté.</p>
                </div>
                <div class="bg-gradient-to-br from-emerald-800/40 to-emerald-900/40 backdrop-blur-sm rounded-2xl border border-emerald-600/20 p-6 hover:border-emerald-500/50 transition-all group">
                    <div class="w-14 h-14 bg-gradient-to-br from-teal-400 to-cyan-500 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-exchange-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Transferts</h3>
                    <p class="text-emerald-300/80">Envoyez et recevez de l'argent instantanément entre utilisateurs.</p>
                </div>
                <div class="bg-gradient-to-br from-emerald-800/40 to-emerald-900/40 backdrop-blur-sm rounded-2xl border border-emerald-600/20 p-6 hover:border-emerald-500/50 transition-all group">
                    <div class="w-14 h-14 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-store text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Marketplace</h3>
                    <p class="text-emerald-300/80">Vendez et achetez des produits au sein de la communauté NKAP.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Tontines -->
    <section id="tontines" class="py-20 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Le pouvoir des Tontines</h2>
                    <p class="text-emerald-200/80 text-lg mb-8">
                        Les tontines sont un système d'épargne collectif traditionnel africain. 
                        Avec NKAP, digitalisez cette pratique ancestrale en toute sécurité.
                    </p>
                    <ul class="space-y-4">
                        <li class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-emerald-500/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check text-emerald-400"></i>
                            </div>
                            <span class="text-emerald-100">Créez des tontines avec vos proches</span>
                        </li>
                        <li class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-emerald-500/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check text-emerald-400"></i>
                            </div>
                            <span class="text-emerald-100">Cotisations automatiques et sécurisées</span>
                        </li>
                        <li class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-emerald-500/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check text-emerald-400"></i>
                            </div>
                            <span class="text-emerald-100">Suivi transparent de chaque membre</span>
                        </li>
                        <li class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-emerald-500/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check text-emerald-400"></i>
                            </div>
                            <span class="text-emerald-100">Gains distribués automatiquement</span>
                        </li>
                    </ul>
                </div>
                <div class="relative">
                    <div class="bg-gradient-to-br from-emerald-800/50 to-green-800/30 backdrop-blur-xl rounded-3xl border border-emerald-600/30 p-8 shadow-2xl">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-white">Tontine Solidarité</h3>
                            <span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-sm font-medium">En cours</span>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="bg-emerald-900/50 rounded-xl p-4 text-center">
                                <p class="text-emerald-400 text-sm mb-1">Cotisation</p>
                                <p class="text-2xl font-bold text-white">50,000</p>
                                <p class="text-emerald-300 text-xs">FCFA/mois</p>
                            </div>
                            <div class="bg-emerald-900/50 rounded-xl p-4 text-center">
                                <p class="text-emerald-400 text-sm mb-1">Membres</p>
                                <p class="text-2xl font-bold text-white">12</p>
                                <p class="text-emerald-300 text-xs">participants</p>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-emerald-300">Progression</span>
                                <span class="text-white font-medium">8/12 tours</span>
                            </div>
                            <div class="w-full bg-emerald-900 rounded-full h-3">
                                <div class="bg-gradient-to-r from-emerald-400 to-green-500 h-3 rounded-full" style="width: 66%"></div>
                            </div>
                        </div>
                        <div class="flex -space-x-2">
                            @for($i = 0; $i < 5; $i++)
                            <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-green-500 rounded-full border-2 border-emerald-800 flex items-center justify-center">
                                <span class="text-white text-xs font-bold">{{ chr(65 + $i) }}</span>
                            </div>
                            @endfor
                            <div class="w-10 h-10 bg-emerald-700 rounded-full border-2 border-emerald-800 flex items-center justify-center">
                                <span class="text-emerald-300 text-xs font-bold">+7</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Parrainage -->
    <section class="py-20 px-4 bg-gradient-to-r from-emerald-900 to-green-900">
        <div class="max-w-7xl mx-auto text-center">
            <div class="w-20 h-20 bg-gradient-to-br from-yellow-400 to-amber-500 rounded-3xl flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-gift text-white text-3xl"></i>
            </div>
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Programme de parrainage</h2>
            <p class="text-emerald-200/80 text-lg max-w-2xl mx-auto mb-8">
                Invitez vos amis et gagnez des bonus pour chaque filleul inscrit. Plus vous parrainez, plus vous gagnez !
            </p>
            <div class="grid md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                <div class="bg-emerald-800/40 backdrop-blur-sm rounded-2xl border border-emerald-600/20 p-6">
                    <div class="text-4xl font-bold text-emerald-400 mb-2">500</div>
                    <p class="text-emerald-200">FCFA par filleul</p>
                </div>
                <div class="bg-emerald-800/40 backdrop-blur-sm rounded-2xl border border-emerald-600/20 p-6">
                    <div class="text-4xl font-bold text-emerald-400 mb-2">∞</div>
                    <p class="text-emerald-200">Filleuls illimités</p>
                </div>
                <div class="bg-emerald-800/40 backdrop-blur-sm rounded-2xl border border-emerald-600/20 p-6">
                    <div class="text-4xl font-bold text-emerald-400 mb-2">24h</div>
                    <p class="text-emerald-200">Bonus crédité</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-emerald-950 border-t border-emerald-800/50 py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-green-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-coins text-white"></i>
                        </div>
                        <span class="text-2xl font-bold text-white">NKAP</span>
                    </div>
                    <p class="text-emerald-400/80">La plateforme de gestion financière communautaire la plus innovante.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Produits</h4>
                    <ul class="space-y-2 text-emerald-400">
                        <li><a href="#" class="hover:text-white transition-colors">Portefeuille</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Tontines</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Transferts</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Marketplace</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Support</h4>
                    <ul class="space-y-2 text-emerald-400">
                        <li><a href="#" class="hover:text-white transition-colors">Centre d'aide</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">FAQ</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Conditions</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Contact</h4>
                    <ul class="space-y-2 text-emerald-400">
                        <li><i class="fas fa-envelope mr-2"></i>contact@nkap.cm</li>
                        <li><i class="fas fa-phone mr-2"></i>+237 6XX XXX XXX</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i>Douala, Cameroun</li>
                    </ul>
                    <div class="flex gap-4 mt-4">
                        <a href="#" class="w-10 h-10 bg-emerald-800 hover:bg-emerald-700 rounded-lg flex items-center justify-center transition-colors">
                            <i class="fab fa-facebook-f text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-emerald-800 hover:bg-emerald-700 rounded-lg flex items-center justify-center transition-colors">
                            <i class="fab fa-twitter text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-emerald-800 hover:bg-emerald-700 rounded-lg flex items-center justify-center transition-colors">
                            <i class="fab fa-instagram text-white"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-emerald-800/50 pt-8 text-center text-emerald-500">
    <p>
        &copy; {{ date('Y') }} 
        Made by <a href="https://techforgesolutions237.com" target="_blank" class="text-emerald-400 hover:underline">TechForgeSolution 237</a>. Tous droits réservés.
    </p>
</div>

        </div>
    </footer>
</body>
</html>
