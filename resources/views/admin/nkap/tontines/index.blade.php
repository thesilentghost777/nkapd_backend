@extends('layouts.admin')

@section('title', 'Tontines NKAP')

@section('admin-content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Tontines</h1>
            <p class="text-gray-500 mt-1">Gérez toutes les tontines de la plateforme</p>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl p-5 text-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-piggy-bank"></i>
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
                    <i class="fas fa-play-circle"></i>
                </div>
                <div>
                    <p class="text-blue-100 text-sm">En cours</p>
                    <p class="text-2xl font-bold">{{ number_format($stats['en_cours']) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-gray-500 to-gray-600 rounded-2xl p-5 text-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <p class="text-gray-200 text-sm">Fermées</p>
                    <p class="text-2xl font-bold">{{ number_format($stats['fermees']) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl p-5 text-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-coins"></i>
                </div>
                <div>
                    <p class="text-amber-100 text-sm">Montant Total</p>
                    <p class="text-xl font-bold">{{ number_format($stats['montant_total']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <form action="{{ route('admin.nkap.tontines.index') }}" method="GET" class="grid md:grid-cols-4 gap-4">
            <div class="md:col-span-2">
                <div class="relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Rechercher par nom ou code..."
                        class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    >
                </div>
            </div>
            <div>
                <select name="statut" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">Tous les statuts</option>
                    <option value="en_cours" {{ request('statut') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                    <option value="fermee" {{ request('statut') == 'fermee' ? 'selected' : '' }}>Fermée</option>
                    <option value="annulee" {{ request('statut') == 'annulee' ? 'selected' : '' }}>Annulée</option>
                </select>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-2 rounded-xl font-medium transition-colors">
                    <i class="fas fa-filter mr-2"></i>Filtrer
                </button>
                <a href="{{ route('admin.nkap.tontines.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl font-medium transition-colors">
                    <i class="fas fa-times"></i>
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

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl flex items-center gap-3">
        <i class="fas fa-exclamation-circle"></i>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    <!-- Grille des tontines -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($tontines as $tontine)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition-shadow">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="font-bold text-lg text-gray-900">{{ $tontine->nom }}</h3>
                        <p class="text-gray-500 text-sm font-mono">{{ $tontine->code }}</p>
                    </div>
                    @if($tontine->statut == 'en_cours')
                    <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-medium">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full inline-block mr-1"></span>En cours
                    </span>
                    @elseif($tontine->statut == 'fermee')
                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">
                        <span class="w-1.5 h-1.5 bg-gray-500 rounded-full inline-block mr-1"></span>Fermée
                    </span>
                    @else
                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-medium">
                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full inline-block mr-1"></span>Annulée
                    </span>
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div class="bg-gray-50 rounded-xl p-3 text-center">
                        <p class="text-gray-500 text-xs">Cotisation</p>
                        <p class="font-bold text-gray-900">{{ number_format($tontine->cotisation ?? 0) }}</p>
                        <p class="text-gray-400 text-xs">FCFA</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3 text-center">
                        <p class="text-gray-500 text-xs">Membres</p>
                        <p class="font-bold text-gray-900">{{ $tontine->membres_count }}</p>
                        <p class="text-gray-400 text-xs">participants</p>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-500">Montant total</span>
                        <span class="font-semibold text-gray-900">{{ number_format($tontine->montant_total) }} FCFA</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-gradient-to-r from-emerald-400 to-green-500 h-2 rounded-full" style="width: {{ min(100, ($tontine->montant_collecte ?? 0) / max(1, $tontine->montant_total) * 100) }}%"></div>
                    </div>
                </div>

                @if($tontine->createur)
                <div class="flex items-center gap-2 mb-4 text-sm text-gray-600">
                    <i class="fas fa-user"></i>
                    <span>Créé par</span>
                    <a href="{{ route('admin.nkap.users.show', $tontine->createur->id) }}" class="text-emerald-600 hover:underline font-medium">
                        {{ $tontine->createur->prenom }} {{ $tontine->createur->nom }}
                    </a>
                </div>
                @endif

                <div class="flex gap-2">
                    <a href="{{ route('admin.nkap.tontines.show', $tontine->id) }}" class="flex-1 bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-xl font-medium text-center transition-colors text-sm">
                        <i class="fas fa-eye mr-1"></i>Détails
                    </a>
                    @if($tontine->statut == 'en_cours')
                    <form action="{{ route('admin.nkap.tontines.update-statut', $tontine->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="statut" value="fermee">
                        <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl transition-colors" title="Fermer">
                            <i class="fas fa-lock"></i>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="md:col-span-2 lg:col-span-3 bg-white rounded-2xl border border-gray-100 p-12 text-center">
            <div class="flex flex-col items-center gap-3 text-gray-500">
                <i class="fas fa-piggy-bank text-5xl text-gray-300"></i>
                <p class="text-lg font-medium">Aucune tontine trouvée</p>
                <p class="text-sm">Modifiez vos critères de recherche</p>
            </div>
        </div>
        @endforelse
    </div>

    @if($tontines->hasPages())
    <div class="flex justify-center">
        {{ $tontines->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
