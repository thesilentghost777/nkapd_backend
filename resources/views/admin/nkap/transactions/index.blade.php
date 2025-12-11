@extends('layouts.admin')

@section('title', 'Transactions NKAP')

@section('admin-content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Transactions</h1>
            <p class="text-gray-500 mt-1">Historique de toutes les transactions de la plateforme</p>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <div class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl p-5 text-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-exchange-alt"></i>
                </div>
                <div>
                    <p class="text-emerald-100 text-sm">Total</p>
                    <p class="text-2xl font-bold">{{ number_format($stats['total']) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-green-500 to-teal-600 rounded-2xl p-5 text-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-coins"></i>
                </div>
                <div>
                    <p class="text-green-100 text-sm">Montant Total</p>
                    <p class="text-xl font-bold">{{ number_format($stats['total_montant']) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl p-5 text-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-arrow-down"></i>
                </div>
                <div>
                    <p class="text-blue-100 text-sm">Recharges</p>
                    <p class="text-xl font-bold">{{ number_format($stats['recharges']) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-red-500 to-pink-600 rounded-2xl p-5 text-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-arrow-up"></i>
                </div>
                <div>
                    <p class="text-red-100 text-sm">Retraits</p>
                    <p class="text-xl font-bold">{{ number_format($stats['retraits']) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl p-5 text-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-percent"></i>
                </div>
                <div>
                    <p class="text-amber-100 text-sm">Frais Collectés</p>
                    <p class="text-xl font-bold">{{ number_format($stats['frais_collectes']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <form action="{{ route('admin.nkap.transactions.index') }}" method="GET" class="grid md:grid-cols-6 gap-4">
            <div class="md:col-span-2">
                <div class="relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Rechercher par référence, nom..."
                        class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    >
                </div>
            </div>
            <div>
                <select name="type" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">Tous les types</option>
                    @foreach($types as $type)
                    <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $type)) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="statut" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">Tous les statuts</option>
                    <option value="complete" {{ request('statut') == 'complete' ? 'selected' : '' }}>Complète</option>
                    <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                    <option value="echouee" {{ request('statut') == 'echouee' ? 'selected' : '' }}>Échouée</option>
                </select>
            </div>
            <div>
                <input 
                    type="date" 
                    name="date_debut" 
                    value="{{ request('date_debut') }}"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    placeholder="Date début"
                >
            </div>
            <div>
                <input 
                    type="date" 
                    name="date_fin" 
                    value="{{ request('date_fin') }}"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    placeholder="Date fin"
                >
            </div>
            <div class="md:col-span-6 flex gap-3">
                <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-2 rounded-xl font-medium transition-colors">
                    <i class="fas fa-filter mr-2"></i>Filtrer
                </button>
                <a href="{{ route('admin.nkap.transactions.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-xl font-medium transition-colors">
                    <i class="fas fa-times mr-2"></i>Réinitialiser
                </a>
            </div>
        </form>
    </div>

    <!-- Tableau -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Utilisateur</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Référence</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Montant</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Frais</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transactions as $transaction)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-900">{{ $transaction->created_at->format('d/m/Y') }}</p>
                            <p class="text-sm text-gray-500">{{ $transaction->created_at->format('H:i') }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @if($transaction->user)
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-green-500 rounded-lg flex items-center justify-center text-white font-bold">
                                    {{ strtoupper(substr($transaction->user->prenom ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <a href="{{ route('admin.nkap.users.show', $transaction->user->id) }}" class="font-medium text-gray-900 hover:text-emerald-600">
                                        {{ $transaction->user->prenom }} {{ $transaction->user->nom }}
                                    </a>
                                </div>
                            </div>
                            @else
                            <span class="text-gray-400">N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center
                                    @if(in_array($transaction->type, ['recharge', 'transfert_recu', 'gain_tontine', 'bonus_parrainage'])) bg-emerald-100 text-emerald-600
                                    @else bg-red-100 text-red-600 @endif">
                                    @if($transaction->type == 'recharge')
                                        <i class="fas fa-plus"></i>
                                    @elseif($transaction->type == 'retrait')
                                        <i class="fas fa-minus"></i>
                                    @elseif(str_contains($transaction->type, 'transfert'))
                                        <i class="fas fa-exchange-alt"></i>
                                    @elseif(str_contains($transaction->type, 'tontine'))
                                        <i class="fas fa-piggy-bank"></i>
                                    @else
                                        <i class="fas fa-circle"></i>
                                    @endif
                                </div>
                                <span class="text-sm font-medium text-gray-700">{{ ucfirst(str_replace('_', ' ', $transaction->type)) }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-mono text-sm text-gray-600">{{ Str::limit($transaction->reference ?? 'N/A', 15) }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="font-semibold @if(in_array($transaction->type, ['recharge', 'transfert_recu', 'gain_tontine', 'bonus_parrainage'])) text-emerald-600 @else text-red-600 @endif">
                                {{ number_format($transaction->montant) }} FCFA
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($transaction->frais)
                            <span class="text-gray-600">{{ number_format($transaction->frais) }}</span>
                            @else
                            <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($transaction->statut == 'complete')
                            <span class="inline-flex items-center bg-emerald-100 text-emerald-700 px-2 py-1 rounded-full text-xs font-medium">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1"></span>Complète
                            </span>
                            @elseif($transaction->statut == 'en_attente')
                            <span class="inline-flex items-center bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-medium">
                                <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full mr-1"></span>En attente
                            </span>
                            @else
                            <span class="inline-flex items-center bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-medium">
                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1"></span>Échouée
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end">
                                <a href="{{ route('admin.nkap.transactions.show', $transaction->id) }}" class="w-9 h-9 bg-emerald-100 hover:bg-emerald-200 text-emerald-600 rounded-lg flex items-center justify-center transition-colors" title="Détails">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-3 text-gray-500">
                                <i class="fas fa-exchange-alt text-5xl text-gray-300"></i>
                                <p class="text-lg font-medium">Aucune transaction trouvée</p>
                                <p class="text-sm">Modifiez vos critères de recherche</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($transactions->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $transactions->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
