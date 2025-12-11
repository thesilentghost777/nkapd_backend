@extends('layouts.admin')

@section('title', 'Produits NKAP')

@section('admin-content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Produits</h1>
            <p class="text-gray-500 mt-1">Gérez les produits du marketplace NKAP</p>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl p-5 text-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-box"></i>
                </div>
                <div>
                    <p class="text-emerald-100 text-sm">Total</p>
                    <p class="text-2xl font-bold">{{ number_format($stats['total']) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl p-5 text-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <p class="text-blue-100 text-sm">Actifs</p>
                    <p class="text-2xl font-bold">{{ number_format($stats['actifs']) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl p-5 text-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div>
                    <p class="text-amber-100 text-sm">Vendus</p>
                    <p class="text-2xl font-bold">{{ number_format($stats['vendus']) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl p-5 text-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-tags"></i>
                </div>
                <div>
                    <p class="text-purple-100 text-sm">Catégories</p>
                    <p class="text-2xl font-bold">{{ $stats['categories']->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <form action="{{ route('admin.nkap.produits.index') }}" method="GET" class="grid md:grid-cols-4 gap-4">
            <div class="md:col-span-2">
                <div class="relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Rechercher un produit..."
                        class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    >
                </div>
            </div>
            <div>
                <select name="categorie" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">Toutes les catégories</option>
                    @foreach($stats['categories'] as $categorie)
                    <option value="{{ $categorie }}" {{ request('categorie') == $categorie ? 'selected' : '' }}>
                        {{ ucfirst($categorie) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="statut" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">Tous les statuts</option>
                    <option value="actif" {{ request('statut') == 'actif' ? 'selected' : '' }}>Actif</option>
                    <option value="inactif" {{ request('statut') == 'inactif' ? 'selected' : '' }}>Inactif</option>
                    <option value="vendu" {{ request('statut') == 'vendu' ? 'selected' : '' }}>Vendu</option>
                    <option value="refuse" {{ request('statut') == 'refuse' ? 'selected' : '' }}>Refusé</option>
                </select>
            </div>
            <div class="md:col-span-4 flex gap-3">
                <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-2 rounded-xl font-medium transition-colors">
                    <i class="fas fa-filter mr-2"></i>Filtrer
                </button>
                <a href="{{ route('admin.nkap.produits.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-xl font-medium transition-colors">
                    <i class="fas fa-times mr-2"></i>Réinitialiser
                </a>
            </div>
        </form>
    </div>

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-xl flex items-center gap-3">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Grille des produits -->
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($produits as $produit)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition-shadow group">
            <div class="aspect-square bg-gray-100 relative overflow-hidden">
                @if($produit->image_url)
                <img src="{{ asset('storage/' . $produit->image_url) }}" alt="{{ $produit->titre }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                @else
                <div class="w-full h-full flex items-center justify-center text-gray-400">
                    <i class="fas fa-image text-5xl"></i>
                </div>
                @endif
                <div class="absolute top-3 right-3">
                    @if($produit->statut == 'actif')
                    <span class="bg-emerald-500 text-white px-2 py-1 rounded-lg text-xs font-medium">Actif</span>
                    @elseif($produit->statut == 'vendu')
                    <span class="bg-blue-500 text-white px-2 py-1 rounded-lg text-xs font-medium">Vendu</span>
                    @elseif($produit->statut == 'refuse')
                    <span class="bg-red-500 text-white px-2 py-1 rounded-lg text-xs font-medium">Refusé</span>
                    @else
                    <span class="bg-gray-500 text-white px-2 py-1 rounded-lg text-xs font-medium">Inactif</span>
                    @endif
                </div>
            </div>
            <div class="p-4">
                <p class="text-xs text-emerald-600 font-medium mb-1">{{ ucfirst($produit->categorie ?? 'Non catégorisé') }}</p>
                <h3 class="font-bold text-gray-900 mb-2 line-clamp-1">{{ $produit->titre }}</h3>
                <p class="text-emerald-600 font-bold text-lg mb-3">{{ number_format($produit->prix) }} FCFA</p>
                
                @if($produit->vendeur)
                <div class="flex items-center gap-2 mb-3 text-sm text-gray-600">
                    <div class="w-6 h-6 bg-gradient-to-br from-emerald-400 to-green-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                        {{ strtoupper(substr($produit->vendeur->prenom, 0, 1)) }}
                    </div>
                    <span>{{ $produit->vendeur->prenom }} {{ $produit->vendeur->nom }}</span>
                </div>
                @endif

                <div class="flex gap-2">
                    <a href="{{ route('admin.nkap.produits.show', $produit->id) }}" class="flex-1 bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-2 rounded-lg font-medium text-center transition-colors text-sm">
                        <i class="fas fa-eye mr-1"></i>Voir
                    </a>
                    <form action="{{ route('admin.nkap.produits.destroy', $produit->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-600 px-3 py-2 rounded-lg transition-colors" onclick="return confirm('Supprimer ce produit ?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="md:col-span-2 lg:col-span-4 bg-white rounded-2xl border border-gray-100 p-12 text-center">
            <div class="flex flex-col items-center gap-3 text-gray-500">
                <i class="fas fa-box-open text-5xl text-gray-300"></i>
                <p class="text-lg font-medium">Aucun produit trouvé</p>
                <p class="text-sm">Modifiez vos critères de recherche</p>
            </div>
        </div>
        @endforelse
    </div>

    @if($produits->hasPages())
    <div class="flex justify-center">
        {{ $produits->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
