@extends('layouts.admin')

@section('title', 'Détails Tontine - ' . $tontine->nom)

@section('admin-content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.nkap.tontines.index') }}" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition-colors">
                <i class="fas fa-arrow-left text-gray-600"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $tontine->nom }}</h1>
                <p class="text-gray-500 mt-1 font-mono">Code: {{ $tontine->code }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            @if($tontine->statut == 'en_cours')
            <span class="bg-emerald-100 text-emerald-700 px-4 py-2 rounded-xl font-medium">
                <i class="fas fa-play-circle mr-2"></i>En cours
            </span>
            <form action="{{ route('admin.nkap.tontines.update-statut', $tontine->id) }}" method="POST" class="inline">
                @csrf
                @method('PATCH')
                <input type="hidden" name="statut" value="fermee">
                <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-xl font-medium transition-colors" onclick="return confirm('Êtes-vous sûr de vouloir fermer cette tontine ?')">
                    <i class="fas fa-lock mr-2"></i>Fermer
                </button>
            </form>
            @elseif($tontine->statut == 'fermee')
            <span class="bg-gray-100 text-gray-700 px-4 py-2 rounded-xl font-medium">
                <i class="fas fa-check-circle mr-2"></i>Fermée
            </span>
            @else
            <span class="bg-red-100 text-red-700 px-4 py-2 rounded-xl font-medium">
                <i class="fas fa-times-circle mr-2"></i>Annulée
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
        <!-- Informations principales -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Stats -->
            <div class="grid md:grid-cols-3 gap-4">
                <div class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-coins"></i>
                        </div>
                    </div>
                    <p class="text-emerald-100 text-sm">Montant Total</p>
                    <p class="text-2xl font-bold">{{ number_format($tontine->montant_total) }}</p>
                    <p class="text-emerald-200 text-sm">FCFA</p>
                </div>
                <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                    </div>
                    <p class="text-blue-100 text-sm">Cotisation</p>
                    <p class="text-2xl font-bold">{{ number_format($tontine->cotisation ?? 0) }}</p>
                    <p class="text-blue-200 text-sm">FCFA</p>
                </div>
                <div class="bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <p class="text-purple-100 text-sm">Membres</p>
                    <p class="text-2xl font-bold">{{ $tontine->membres->count() }}</p>
                    <p class="text-purple-200 text-sm">participants</p>
                </div>
            </div>

            <!-- Détails -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900">Détails de la Tontine</h2>
                </div>
                <div class="p-6">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <p class="text-sm text-gray-500 mb-1">Date de création</p>
                            <p class="font-semibold text-gray-900">{{ $tontine->created_at->format('d/m/Y à H:i') }}</p>
                        </div>
                        @if($tontine->date_debut)
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <p class="text-sm text-gray-500 mb-1">Date de début</p>
                            <p class="font-semibold text-gray-900">{{ $tontine->date_debut->format('d/m/Y') }}</p>
                        </div>
                        @endif
                        @if($tontine->date_fermeture)
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <p class="text-sm text-gray-500 mb-1">Date de fermeture</p>
                            <p class="font-semibold text-gray-900">{{ $tontine->date_fermeture->format('d/m/Y') }}</p>
                        </div>
                        @endif
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <p class="text-sm text-gray-500 mb-1">Fréquence</p>
                            <p class="font-semibold text-gray-900">{{ ucfirst($tontine->frequence ?? 'Mensuelle') }}</p>
                        </div>
                    </div>
                    @if($tontine->description)
                    <div class="mt-4 p-4 bg-gray-50 rounded-xl">
                        <p class="text-sm text-gray-500 mb-1">Description</p>
                        <p class="text-gray-900">{{ $tontine->description }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Liste des membres -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900">Membres ({{ $tontine->membres->count() }})</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Membre</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date d'adhésion</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Position</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($tontine->membres as $membre)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    @if($membre->user)
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-green-500 rounded-lg flex items-center justify-center text-white font-bold">
                                            {{ strtoupper(substr($membre->user->prenom, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $membre->user->prenom }} {{ $membre->user->nom }}</p>
                                            <p class="text-sm text-gray-500">{{ $membre->user->telephone }}</p>
                                        </div>
                                    </div>
                                    @else
                                    <span class="text-gray-400">Utilisateur supprimé</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $membre->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-sm font-medium">
                                        #{{ $membre->position ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-end">
                                        @if($membre->user)
                                        <a href="{{ route('admin.nkap.users.show', $membre->user->id) }}" class="w-8 h-8 bg-emerald-100 hover:bg-emerald-200 text-emerald-600 rounded-lg flex items-center justify-center transition-colors">
                                            <i class="fas fa-arrow-right"></i>
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                    <i class="fas fa-users text-4xl text-gray-300 mb-2"></i>
                                    <p>Aucun membre dans cette tontine</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Créateur -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-100 bg-emerald-50">
                    <h3 class="font-semibold text-emerald-800">
                        <i class="fas fa-crown mr-2"></i>Créateur
                    </h3>
                </div>
                <div class="p-4">
                    @if($tontine->createur)
                    <div class="flex items-center gap-3">
                        <div class="w-14 h-14 bg-gradient-to-br from-emerald-400 to-green-500 rounded-xl flex items-center justify-center text-white font-bold text-xl">
                            {{ strtoupper(substr($tontine->createur->prenom, 0, 1)) }}{{ strtoupper(substr($tontine->createur->nom, 0, 1)) }}
                        </div>
                        <div>
                            <a href="{{ route('admin.nkap.users.show', $tontine->createur->id) }}" class="font-semibold text-gray-900 hover:text-emerald-600">
                                {{ $tontine->createur->prenom }} {{ $tontine->createur->nom }}
                            </a>
                            <p class="text-sm text-gray-500">{{ $tontine->createur->email }}</p>
                        </div>
                    </div>
                    @else
                    <p class="text-gray-400 text-center py-4">Créateur non disponible</p>
                    @endif
                </div>
            </div>

            <!-- Progression -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Progression</h3>
                </div>
                <div class="p-4 space-y-4">
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Collecté</span>
                            <span class="font-semibold text-gray-900">{{ number_format($tontine->montant_collecte ?? 0) }} FCFA</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-3">
                            <div class="bg-gradient-to-r from-emerald-400 to-green-500 h-3 rounded-full transition-all" style="width: {{ min(100, ($tontine->montant_collecte ?? 0) / max(1, $tontine->montant_total) * 100) }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ round(($tontine->montant_collecte ?? 0) / max(1, $tontine->montant_total) * 100, 1) }}% de l'objectif</p>
                    </div>
                    <div class="pt-4 border-t border-gray-100">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tour actuel</span>
                            <span class="font-semibold text-gray-900">{{ $tontine->tour_actuel ?? 1 }} / {{ $tontine->membres->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 space-y-3">
                @if($tontine->statut == 'en_cours')
                <form action="{{ route('admin.nkap.tontines.update-statut', $tontine->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="statut" value="annulee">
                    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-3 rounded-xl font-medium transition-colors flex items-center justify-center gap-2" onclick="return confirm('Êtes-vous sûr de vouloir annuler cette tontine ?')">
                        <i class="fas fa-times-circle"></i>
                        Annuler la tontine
                    </button>
                </form>
                @endif
                <form action="{{ route('admin.nkap.tontines.destroy', $tontine->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-3 rounded-xl font-medium transition-colors flex items-center justify-center gap-2" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette tontine ? Cette action est irréversible.')">
                        <i class="fas fa-trash"></i>
                        Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
