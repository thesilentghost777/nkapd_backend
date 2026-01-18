<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Nkap D - Gagnez de l'argent en ramenant des membres grâce aux tontines intelligentes">
    <title>Nkap D | Tontines & Gains Intelligents</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        nkap: {
                            primary: '#059669',
                            secondary: '#10b981',
                            accent: '#34d399',
                            gold: '#fbbf24',
                            dark: '#022c22',
                            deeper: '#011a14'
                        }
                    },
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <style>
        * { font-family: 'Poppins', sans-serif; }
        
        .glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #34d399 0%, #10b981 50%, #059669 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .gradient-gold {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, #022c22 0%, #064e3b 50%, #022c22 100%);
        }
        
        .money-float {
            animation: moneyFloat 4s ease-in-out infinite;
        }
        
        @keyframes moneyFloat {
            0%, 100% { transform: translateY(0) rotate(-5deg); }
            50% { transform: translateY(-15px) rotate(5deg); }
        }
        
        .card-hover {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(16, 185, 129, 0.3);
        }
        
        .pulse-money {
            animation: pulseMoney 2s ease-in-out infinite;
        }
        
        @keyframes pulseMoney {
            0%, 100% { box-shadow: 0 0 20px rgba(16, 185, 129, 0.4); }
            50% { box-shadow: 0 0 40px rgba(16, 185, 129, 0.8); }
        }
        
        .coin-spin {
            animation: coinSpin 3s linear infinite;
        }
        
        @keyframes coinSpin {
            0% { transform: rotateY(0deg); }
            100% { transform: rotateY(360deg); }
        }
        
        .flow-line {
            background: linear-gradient(90deg, transparent, #10b981, transparent);
            height: 2px;
            animation: flowMove 2s linear infinite;
        }
        
        @keyframes flowMove {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
    </style>
</head>
<body class="bg-nkap-deeper text-white overflow-x-hidden">

    <!-- Preloader -->
    <div id="preloader" class="fixed inset-0 z-[100] flex items-center justify-center hero-gradient transition-opacity duration-500">
        <div class="text-center">
            <div class="relative w-32 h-32 mx-auto mb-6">
                <div class="absolute inset-0 border-4 border-nkap-accent/30 rounded-full"></div>
                <div class="absolute inset-0 border-4 border-t-nkap-accent rounded-full animate-spin"></div>
                <div class="absolute inset-4 flex items-center justify-center coin-spin">
                    <span class="text-4xl">💰</span>
                </div>
            </div>
            <p class="text-nkap-accent font-semibold text-xl">Nkap D</p>
        </div>
    </div>

    <!-- Navbar -->
    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <a href="#" class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-nkap-primary to-nkap-accent rounded-xl flex items-center justify-center shadow-lg pulse-money">
                        <span class="text-2xl">💰</span>
                    </div>
                    <p class="text-xl font-bold">Nkap D</p>
                </a>
                <div class="hidden md:flex items-center gap-8">
                    <a href="#accueil" class="text-white/80 hover:text-nkap-accent transition-colors">Accueil</a>
                    <a href="#tontines" class="text-white/80 hover:text-nkap-accent transition-colors">Tontines</a>
                    <a href="#espaces" class="text-white/80 hover:text-nkap-accent transition-colors">Espaces</a>
                    <a href="#faq" class="text-white/80 hover:text-nkap-accent transition-colors">FAQ</a>
                </div>
                <a href="https://play.google.com/store/apps/details?id=com.anonymous.nkapdey" target="_blank" class="bg-gradient-to-r from-nkap-primary to-nkap-accent text-white px-6 py-3 rounded-full font-semibold hover:shadow-lg hover:shadow-nkap-accent/30 transition-all">
                    Télécharger
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="accueil" class="min-h-screen hero-gradient relative flex items-center overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute top-20 right-10 w-72 h-72 bg-nkap-accent/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-10 w-96 h-96 bg-nkap-primary/10 rounded-full blur-3xl"></div>
        
        <!-- Floating money icons -->
        <div class="absolute top-1/4 left-1/4 text-4xl opacity-20 money-float" style="animation-delay: 0s;">💵</div>
        <div class="absolute top-1/3 right-1/4 text-5xl opacity-20 money-float" style="animation-delay: 1s;">💰</div>
        <div class="absolute bottom-1/3 left-1/3 text-3xl opacity-20 money-float" style="animation-delay: 2s;">🪙</div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div data-aos="fade-right">
                    <div class="inline-flex items-center gap-2 glass px-4 py-2 rounded-full mb-6">
                        <span class="w-2 h-2 bg-nkap-accent rounded-full animate-pulse"></span>
                        <span class="text-sm">Plateforme Fintech Camerounaise</span>
                    </div>
                    <h1 class="text-5xl md:text-7xl font-black mb-6 leading-tight">
                        Gagnez avec<br>
                        <span class="gradient-text">les Tontines</span>
                    </h1>
                    <p class="text-xl text-white/70 mb-8 leading-relaxed">
                        Créez des tontines, invitez des membres et multipliez vos gains! 
                        La première app camerounaise de tontines intelligentes avec marketplace intégrée.
                    </p>
                    <div class="flex flex-wrap gap-4 mb-10">
                        <a href="https://play.google.com/store/apps/details?id=com.anonymous.nkapdey" target="_blank" class="group bg-gradient-to-r from-nkap-primary to-nkap-accent text-white px-8 py-4 rounded-full font-bold text-lg hover:shadow-2xl hover:shadow-nkap-accent/40 transition-all flex items-center gap-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M3,20.5V3.5C3,2.91 3.34,2.39 3.84,2.15L13.69,12L3.84,21.85C3.34,21.6 3,21.09 3,20.5M16.81,15.12L6.05,21.34L14.54,12.85L16.81,15.12M20.16,10.81C20.5,11.08 20.75,11.5 20.75,12C20.75,12.5 20.5,12.92 20.16,13.19L17.89,14.5L15.39,12L17.89,9.5L20.16,10.81M6.05,2.66L16.81,8.88L14.54,11.15L6.05,2.66Z"/></svg>
                            Commencer à gagner
                            <span class="group-hover:translate-x-1 transition-transform">→</span>
                        </a>
                    </div>
                    <div class="flex items-center gap-8">
                        <div class="text-center">
                            <p class="text-3xl font-bold gradient-text">500</p>
                            <p class="text-white/60 text-sm">FCFA bonus parrainage</p>
                        </div>
                        <div class="w-px h-12 bg-white/20"></div>
                        <div class="text-center">
                            <p class="text-3xl font-bold gradient-text">1000+</p>
                            <p class="text-white/60 text-sm">FCFA min. tontine</p>
                        </div>
                        <div class="w-px h-12 bg-white/20"></div>
                        <div class="text-center">
                            <p class="text-3xl font-bold gradient-text">10</p>
                            <p class="text-white/60 text-sm">Tontines max/user</p>
                        </div>
                    </div>
                </div>
                <div data-aos="fade-left" class="relative">
                    <div class="money-float">
                        <div class="glass rounded-3xl p-8 relative">
                            <div class="absolute -top-6 -right-6 w-20 h-20 bg-gradient-to-br from-nkap-primary to-nkap-accent rounded-2xl flex items-center justify-center text-4xl shadow-xl pulse-money">
                                💰
                            </div>
                            <div class="space-y-6">
                                <div class="flex items-center gap-4 p-4 bg-white/5 rounded-xl">
                                    <div class="w-12 h-12 bg-nkap-accent/20 rounded-full flex items-center justify-center">
                                        <span class="text-nkap-accent text-xl">🎯</span>
                                    </div>
                                    <div>
                                        <p class="font-semibold">Créez une Tontine</p>
                                        <p class="text-white/60 text-sm">Définissez le montant et membres</p>
                                    </div>
                                </div>
                                <div class="overflow-hidden h-2 rounded-full">
                                    <div class="flow-line w-full"></div>
                                </div>
                                <div class="flex items-center gap-4 p-4 bg-white/5 rounded-xl">
                                    <div class="w-12 h-12 bg-yellow-500/20 rounded-full flex items-center justify-center">
                                        <span class="text-yellow-400 text-xl">👥</span>
                                    </div>
                                    <div>
                                        <p class="font-semibold">Invitez des membres</p>
                                        <p class="text-white/60 text-sm">Partagez le code tontine</p>
                                    </div>
                                </div>
                                <div class="overflow-hidden h-2 rounded-full">
                                    <div class="flow-line w-full"></div>
                                </div>
                                <div class="flex items-center gap-4 p-4 bg-nkap-accent/10 rounded-xl border border-nkap-accent/30">
                                    <div class="w-12 h-12 bg-nkap-accent/20 rounded-full flex items-center justify-center">
                                        <span class="text-nkap-accent text-xl">💵</span>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-nkap-accent">Récoltez vos gains!</p>
                                        <p class="text-white/60 text-sm">Tontine complète = Paiement</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How Tontines Work -->
    <section id="tontines" class="py-24 bg-gradient-to-b from-nkap-deeper to-nkap-dark">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-nkap-accent font-semibold">Comment ça marche</span>
                <h2 class="text-4xl md:text-5xl font-bold mt-3">Les Tontines Intelligentes</h2>
            </div>

            <div class="grid md:grid-cols-3 gap-8 mb-16">
                <div class="glass rounded-2xl p-8 text-center card-hover" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-20 h-20 bg-gradient-to-br from-nkap-primary to-nkap-accent rounded-full flex items-center justify-center text-4xl mx-auto mb-6">
                        1️⃣
                    </div>
                    <h3 class="text-xl font-bold mb-3">Créez votre Tontine</h3>
                    <p class="text-white/70">Définissez un nom, le montant (min 1000 FCFA) et le nombre de membres souhaités. 50% du montant est prélevé comme frais de création.</p>
                </div>

                <div class="glass rounded-2xl p-8 text-center card-hover" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-20 h-20 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-full flex items-center justify-center text-4xl mx-auto mb-6">
                        2️⃣
                    </div>
                    <h3 class="text-xl font-bold mb-3">Invitez des Membres</h3>
                    <p class="text-white/70">Partagez le code unique de votre tontine. Chaque membre qui rejoint contribue 50% du montant directement dans votre tontine.</p>
                </div>

                <div class="glass rounded-2xl p-8 text-center card-hover" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center text-4xl mx-auto mb-6">
                        3️⃣
                    </div>
                    <h3 class="text-xl font-bold mb-3">Récoltez les Gains</h3>
                    <p class="text-white/70">Une fois tous les membres réunis, fermez la tontine et recevez la totalité du montant collecté sur votre compte!</p>
                </div>
            </div>

            <!-- Example Card -->
            <div class="glass rounded-3xl p-8 max-w-3xl mx-auto" data-aos="fade-up">
                <h3 class="text-xl font-bold mb-6 text-center">📊 Exemple concret</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-white/5 rounded-xl">
                        <span>Tontine créée</span>
                        <span class="font-bold">1 200 FCFA × 5 membres</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-white/5 rounded-xl">
                        <span>Frais création (50%)</span>
                        <span class="text-red-400">-600 FCFA</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-white/5 rounded-xl">
                        <span>4 membres rejoignent (600 × 4)</span>
                        <span class="text-nkap-accent">+2 400 FCFA</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-nkap-accent/10 rounded-xl border border-nkap-accent/30">
                        <span class="font-bold">Total à la fermeture</span>
                        <span class="font-bold text-xl gradient-text">3 000 FCFA</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-24 hero-gradient">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-nkap-accent font-semibold">Fonctionnalités</span>
                <h2 class="text-4xl md:text-5xl font-bold mt-3">Plus qu'une app de Tontines</h2>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="glass rounded-2xl p-8 card-hover" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center text-3xl mb-6">
                        💳
                    </div>
                    <h3 class="text-xl font-bold mb-3">Recharge Facile</h3>
                    <p class="text-white/70">Rechargez votre compte via Mobile Money (Orange/MTN) en quelques secondes.</p>
                </div>

                <div class="glass rounded-2xl p-8 card-hover" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center text-3xl mb-6">
                        🔄
                    </div>
                    <h3 class="text-xl font-bold mb-3">Transferts P2P</h3>
                    <p class="text-white/70">Transférez de l'argent entre utilisateurs avec seulement 5% de frais.</p>
                </div>

                <div class="glass rounded-2xl p-8 card-hover" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-16 h-16 bg-gradient-to-br from-nkap-primary to-nkap-accent rounded-2xl flex items-center justify-center text-3xl mb-6">
                        👥
                    </div>
                    <h3 class="text-xl font-bold mb-3">Bonus Parrainage</h3>
                    <p class="text-white/70">Gagnez 500 FCFA pour chaque filleul qui participe à sa première tontine!</p>
                </div>

                <div class="glass rounded-2xl p-8 card-hover" data-aos="fade-up" data-aos-delay="400">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl flex items-center justify-center text-3xl mb-6">
                        💸
                    </div>
                    <h3 class="text-xl font-bold mb-3">Retraits Sécurisés</h3>
                    <p class="text-white/70">Retirez vos gains avec 25% de frais. Solde minimum de 1500 FCFA maintenu.</p>
                </div>

                <div class="glass rounded-2xl p-8 card-hover" data-aos="fade-up" data-aos-delay="500">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl flex items-center justify-center text-3xl mb-6">
                        🎰
                    </div>
                    <h3 class="text-xl font-bold mb-3">Multi-Tontines</h3>
                    <p class="text-white/70">Créez jusqu'à 10 tontines simultanément et rejoignez une infinité!</p>
                </div>

                <div class="glass rounded-2xl p-8 card-hover" data-aos="fade-up" data-aos-delay="600">
                    <div class="w-16 h-16 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-2xl flex items-center justify-center text-3xl mb-6">
                        🤖
                    </div>
                    <h3 class="text-xl font-bold mb-3">Assistant IA</h3>
                    <p class="text-white/70">Une FAQ intelligente pour vous guider dans l'utilisation de l'application.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Spaces Section -->
    <section id="espaces" class="py-24 bg-nkap-dark">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-nkap-accent font-semibold">Espaces Communautaires</span>
                <h2 class="text-4xl md:text-5xl font-bold mt-3">Connectez-vous!</h2>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="glass rounded-2xl p-8 card-hover border-2 border-transparent hover:border-pink-500/50" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-rose-600 rounded-2xl flex items-center justify-center text-3xl mb-6">
                        💕
                    </div>
                    <h3 class="text-xl font-bold mb-3">Espace Rencontre</h3>
                    <p class="text-white/70 mb-4">Trouvez l'amour! Système de matching basé sur vos préférences pour des rencontres amoureuses authentiques.</p>
                    <span class="text-pink-400 text-sm">Matching intelligent</span>
                </div>

                <div class="glass rounded-2xl p-8 card-hover border-2 border-transparent hover:border-blue-500/50" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center text-3xl mb-6">
                        🤝
                    </div>
                    <h3 class="text-xl font-bold mb-3">Partenaires Business</h3>
                    <p class="text-white/70 mb-4">Trouvez des partenaires d'affaires via un système d'annonces et de matching professionnel.</p>
                    <span class="text-blue-400 text-sm">Networking pro</span>
                </div>

                <div class="glass rounded-2xl p-8 card-hover border-2 border-transparent hover:border-nkap-accent/50" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-16 h-16 bg-gradient-to-br from-nkap-primary to-nkap-accent rounded-2xl flex items-center justify-center text-3xl mb-6">
                        🛒
                    </div>
                    <h3 class="text-xl font-bold mb-3">Espace Business</h3>
                    <p class="text-white/70 mb-4">Marketplace équitable où chaque vendeur a sa chance grâce à un affichage aléatoire des produits.</p>
                    <span class="text-nkap-accent text-sm">Visibilité égale pour tous</span>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-24 hero-gradient">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-nkap-accent font-semibold">FAQ</span>
                <h2 class="text-4xl md:text-5xl font-bold mt-3">Questions fréquentes</h2>
            </div>

            <div class="space-y-4">
                <div class="glass rounded-2xl p-6" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="text-lg font-bold mb-2">Comment créer une tontine?</h3>
                    <p class="text-white/70">Rechargez votre compte, allez dans "Créer Tontine", définissez le nom, montant (min 1000 FCFA) et nombre de membres. 50% du montant est prélevé pour la création.</p>
                </div>

                <div class="glass rounded-2xl p-6" data-aos="fade-up" data-aos-delay="200">
                    <h3 class="text-lg font-bold mb-2">Comment rejoindre une tontine?</h3>
                    <p class="text-white/70">Entrez le code tontine partagé par le créateur. Vous devez avoir au moins le montant de la tontine dans votre compte. 50% sera prélevé pour rejoindre.</p>
                </div>

                <div class="glass rounded-2xl p-6" data-aos="fade-up" data-aos-delay="300">
                    <h3 class="text-lg font-bold mb-2">Quels sont les frais?</h3>
                    <p class="text-white/70">Transferts: 5% | Retraits: 25% | Frais mensuel: 500 FCFA prélevé le 1er de chaque mois. Solde minimum après retrait: 1500 FCFA.</p>
                </div>

                <div class="glass rounded-2xl p-6" data-aos="fade-up" data-aos-delay="400">
                    <h3 class="text-lg font-bold mb-2">Comment fonctionne le parrainage?</h3>
                    <p class="text-white/70">Partagez votre code de parrainage. Quand votre filleul s'inscrit ET participe à sa première tontine, vous recevez 500 FCFA de bonus!</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-nkap-dark relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-nkap-accent/5 rounded-full blur-3xl"></div>
        </div>
        
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">Prêt à gagner?</h2>
            <p class="text-xl text-white/70 mb-10">Rejoignez Nkap D et commencez à multiplier vos revenus dès aujourd'hui!</p>
            
            <a href="https://play.google.com/store/apps/details?id=com.anonymous.nkapdey" target="_blank" class="inline-flex items-center gap-3 bg-gradient-to-r from-nkap-primary to-nkap-accent text-white px-10 py-5 rounded-full font-bold text-xl hover:shadow-2xl hover:shadow-nkap-accent/40 transition-all pulse-money">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M3,20.5V3.5C3,2.91 3.34,2.39 3.84,2.15L13.69,12L3.84,21.85C3.34,21.6 3,21.09 3,20.5M16.81,15.12L6.05,21.34L14.54,12.85L16.81,15.12M20.16,10.81C20.5,11.08 20.75,11.5 20.75,12C20.75,12.5 20.5,12.92 20.16,13.19L17.89,14.5L15.39,12L17.89,9.5L20.16,10.81M6.05,2.66L16.81,8.88L14.54,11.15L6.05,2.66Z"/></svg>
                Télécharger Nkap D
            </a>

            <div class="mt-12 flex flex-wrap justify-center gap-8">
                <a href="https://wa.me/237696087354" class="glass rounded-2xl p-6 hover:bg-nkap-accent/10 transition-colors">
                    <span class="text-2xl">📱</span>
                    <p class="font-semibold mt-2">+237 696 087 354</p>
                </a>
                <a href="mailto:tsf237@gmail.com" class="glass rounded-2xl p-6 hover:bg-nkap-accent/10 transition-colors">
                    <span class="text-2xl">✉️</span>
                    <p class="font-semibold mt-2">tsf237@gmail.com</p>
                </a>
                <a href="https://techforgesolution237.site" target="_blank" class="glass rounded-2xl p-6 hover:bg-nkap-accent/10 transition-colors">
                    <span class="text-2xl">🌐</span>
                    <p class="font-semibold mt-2">techforgesolution237.site</p>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-8 bg-nkap-deeper border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="flex items-center justify-center gap-3 mb-4">
                <div class="w-10 h-10 bg-gradient-to-br from-nkap-primary to-nkap-accent rounded-xl flex items-center justify-center">
                    <span class="text-xl">💰</span>
                </div>
                <span class="font-bold text-xl">Nkap D</span>
            </div>
            <p class="text-white/60">© 2026 Nkap D. Powered By <a href="https://techforgesolution237.site" target="_blank" class="text-nkap-accent hover:underline">TFS237</a></p>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        window.addEventListener('load', () => { 
            document.getElementById('preloader').style.opacity = '0'; 
            setTimeout(() => document.getElementById('preloader').style.display = 'none', 500); 
        });
        AOS.init({ duration: 800, once: true, offset: 100 });
        window.addEventListener('scroll', () => { 
            document.getElementById('navbar').classList.toggle('bg-nkap-dark/95', window.pageYOffset > 100); 
            document.getElementById('navbar').classList.toggle('backdrop-blur-xl', window.pageYOffset > 100); 
        });
    </script>
</body>
</html>
