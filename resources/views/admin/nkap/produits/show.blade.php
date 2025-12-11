@extends('layouts.admin')

@section('title', 'Détails Produit - ' . $produit->titre)

@section('admin-content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.nkap.produits.index') }}" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition-colors">
                <i class="fas fa-arrow-left text-gray-600"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $produit->titre }}</h1>
                <p class="text-gray-500 mt-1">{{ ucfirst($produit->categorie ?? 'Non catégorisé') }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            @if($produit->statut == 'actif')
            <span class="bg-emerald-100 text-emerald-700 px-4 py-2 rounded-xl font-medium">
                <i class="fas fa-check-circle mr-2"></i>Actif
            </span>
            @elseif($produit->statut == 'vendu')
            <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-xl font-medium">
                <i class="fas fa-shopping-cart mr-2"></i>Vendu
            </span>
            @elseif($produit->statut == 'refuse')
            <span class="bg-red-100 text-red-700 px-4 py-2 rounded-xl font-medium">
                <i class="fas fa-times-circle mr-2"></i>Refusé
            </span>
            @else
            <span class="bg-gray-100 text-gray-700 px-4 py-2 rounded-xl font-medium">
                <i class="fas fa-pause-circle mr-2"></i>Inactif
            </span>
            @endif
        </div>
    </div>

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-xl flex items-center gap-3">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Image et Détails -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Image -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="aspect-video bg-gray-100">
                    @if($produit->image_url)
                    <img src="{{ asset('storage/' . $produit->image_url) }}" alt="{{ $produit->titre }}" class="w-full h-full object-contain">
                    @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <i class="fas fa-image text-8xl"></i>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Informations -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900">Informations du Produit</h2>
                </div>
                <div class="p-6">
                    <div class="grid md:grid-cols-2 gap-4 mb-6">
                        <div class="p-4 bg-emerald-50 rounded-xl">
                            <p class="text-sm text-emerald-600 mb-1">Prix</p>
                            <p class="text-2xl font-bold text-emerald-700">{{ number_format($produit->prix) }} FCFA</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <p class="text-sm text-gray-500 mb-1">Catégorie</p>
                            <p class="text-xl font-bold text-gray-900">{{ ucfirst($produit->categorie ?? 'Non définie') }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <p class="text-sm text-gray-500 mb-1">Date de publication</p>
                            <p class="font-semibold text-gray-900">{{ $produit->created_at->format('d/m/Y à H:i') }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <p class="text-sm text-gray-500 mb-1">Dernière modification</p>
                            <p class="font-semibold text-gray-900">{{ $produit->updated_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    </div>
                    @if($produit->description)
                    <div class="p-4 bg-gray-50 rounded-xl">
                        <p class="text-sm text-gray-500 mb-2">Description</p>
                        <p class="text-gray-900 whitespace-pre-line">{{ $produit->description }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Vendeur -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-100 bg-emerald-50">
                    <h3 class="font-semibold text-emerald-800">
                        <i class="fas fa-store mr-2"></i>Vendeur
                    </h3>
                </div>
                <div class="p-4">
                    @if($produit->vendeur)
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-emerald-400 to-green-500 rounded-xl flex items-center justify-center text-white font-bold text-xl">
                            {{ strtoupper(substr($produit->vendeur->prenom, 0, 1)) }}{{ strtoupper(substr($produit->vendeur->nom, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $produit->vendeur->prenom }} {{ $produit->vendeur->nom }}</p>
                            <p class="text-sm text-gray-500">{{ $produit->vendeur->email }}</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.nkap.users.show', $produit->vendeur->id) }}" class="w-full bg-emerald-100 hover:bg-emerald-200 text-emerald-700 px-4 py-2 rounded-xl font-medium text-center block transition-colors">
                        <i class="fas fa-user mr-2"></i>Voir le profil
                    </a>
                    @else
                    <p class="text-gray-400 text-center py-4">Vendeur non disponible</p>
                    @endif
                </div>
            </div>

            <!-- Modifier le statut -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Modifier le statut</h3>
                </div>
                <div class="p-4 space-y-2">
                    <form action="{{ route('admin.nkap.produits.update-statut', $produit->id) }}" method="POST" class="space-y-2">
                        @csrf
                        @method('POST')
                        <button type="submit" name="statut" value="actif" class="w-full {{ $produit->statut == 'actif' ? 'bg-emerald-500 text-white' : 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200' }} px-4 py-3 rounded-xl font-medium transition-colors flex items-center justify-center gap-2">
                            <i class="fas fa-check-circle"></i>Activer
                        </button>
                        <button type="submit" name="statut" value="inactif" class="w-full {{ $produit->statut == 'inactif' ? 'bg-gray-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} px-4 py-3 rounded-xl font-medium transition-colors flex items-center justify-center gap-2">
                            <i class="fas fa-pause-circle"></i>Désactiver
                        </button>
                        <button type="submit" name="statut" value="vendu" class="w-full {{ $produit->statut == 'vendu' ? 'bg-blue-500 text-white' : 'bg-blue-100 text-blue-700 hover:bg-blue-200' }} px-4 py-3 rounded-xl font-medium transition-colors flex items-center justify-center gap-2">
                            <i class="fas fa-shopping-cart"></i>Marquer vendu
                        </button>
                        <button type="submit" name="statut" value="refuse" class="w-full {{ $produit->statut == 'refuse' ? 'bg-red-500 text-white' : 'bg-red-100 text-red-700 hover:bg-red-200' }} px-4 py-3 rounded-xl font-medium transition-colors flex items-center justify-center gap-2">
                            <i class="fas fa-times-circle"></i>Refuser
                        </button>
                    </form>
                </div>
            </div>

            <!-- Supprimer -->
            <div class="bg-red-50 border border-red-200 rounded-2xl p-4">
                <h3 class="font-semibold text-red-800 mb-3">
                    <i class="fas fa-exclamation-triangle mr-2"></i>Zone Dangereuse
                </h3>
                <form action="{{ route('admin.nkap.produits.destroy', $produit->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-3 rounded-xl font-medium transition-colors flex items-center justify-center gap-2" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ? Cette action est irréversible.')">
                        <i class="fas fa-trash"></i>Supprimer le produit
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
