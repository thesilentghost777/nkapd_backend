@extends('layouts.admin')

@section('title', 'Tableau de Bord NKAP')

@section('admin-content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Tableau de Bord</h1>
            <p class="text-gray-500 mt-1">Vue d'ensemble de la plateforme NKAP</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-sm text-gray-500">Dernière mise à jour:</span>
            <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-sm font-medium">{{ now()->format('d/m/Y H:i') }}</span>
        </div>
    </div>

    <!-- Statistiques principales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
        <!-- Utilisateurs -->
        <div class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl p-6 text-white shadow-lg shadow-emerald-500/20">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <span class="bg-white/20 px-2 py-1 rounded-lg text-xs font-medium">
                    +{{ $stats['users']['nouveaux_mois'] }} ce mois
                </span>
            </div>
            <p class="text-emerald-100 text-sm">Utilisateurs</p>
            <p class="text-3xl font-bold">{{ number_format($stats['users']['total']) }}</p>
            <div class="mt-2 text-emerald-200 text-sm">
                <span class="font-medium">{{ number_format($stats['users']['actifs']) }}</span> actifs
            </div>
        </div>

        <!-- Solde Total -->
        <div class="bg-gradient-to-br from-green-500 to-teal-600 rounded-2xl p-6 text-white shadow-lg shadow-green-500/20">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-wallet text-2xl"></i>
                </div>
            </div>
            <p class="text-green-100 text-sm">Solde Total Plateforme</p>
            <p class="text-2xl font-bold">{{ number_format($stats['users']['solde_total']) }}</p>
            <div class="mt-2 text-green-200 text-sm">FCFA</div>
        </div>

        <!-- Tontines -->
        <div class="bg-gradient-to-br from-teal-500 to-cyan-600 rounded-2xl p-6 text-white shadow-lg shadow-teal-500/20">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-piggy-bank text-2xl"></i>
                </div>
                <span class="bg-white/20 px-2 py-1 rounded-lg text-xs font-medium">
                    {{ $stats['tontines']['en_cours'] }} actives
                </span>
            </div>
            <p class="text-teal-100 text-sm">Tontines</p>
            <p class="text-3xl font-bold">{{ number_format($stats['tontines']['total']) }}</p>
            <div class="mt-2 text-teal-200 text-sm">
                {{ number_format($stats['tontines']['montant_total']) }} FCFA
            </div>
        </div>

        <!-- Transactions Jour -->
        <div class="bg-gradient-to-br from-cyan-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg shadow-cyan-500/20">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-exchange-alt text-2xl"></i>
                </div>
            </div>
            <p class="text-cyan-100 text-sm">Transactions Aujourd'hui</p>
            <p class="text-3xl font-bold">{{ number_format($stats['transactions']['aujourd_hui']) }}</p>
            <div class="mt-2 text-cyan-200 text-sm">
                {{ number_format($stats['transactions']['montant_jour']) }} FCFA
            </div>
        </div>

        <!-- Frais Collectés -->
        <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl p-6 text-white shadow-lg shadow-amber-500/20">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-coins text-2xl"></i>
                </div>
            </div>
            <p class="text-amber-100 text-sm">Frais Collectés</p>
            <p class="text-2xl font-bold">{{ number_format($stats['transactions']['frais_collectes']) }}</p>
            <div class="mt-2 text-amber-200 text-sm">FCFA</div>
        </div>
    </div>

    <!-- Graphique et Activités -->
    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Graphique Transactions -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Transactions (7 derniers jours)</h2>
                <div class="flex items-center gap-4 text-sm">
                    <span class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-emerald-500 rounded-full"></span>
                        Montant
                    </span>
                    <span class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
                        Nombre
                    </span>
                </div>
            </div>
            <div class="relative h-80">
                <canvas id="transactionsChart"></canvas>
            </div>
        </div>

        <!-- Stats Rapides -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">Aperçu Rapide</h2>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-emerald-50 rounded-xl">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-box text-white"></i>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Produits</p>
                            <p class="text-lg font-bold text-gray-900">{{ $stats['produits']['total'] }}</p>
                        </div>
                    </div>
                    <span class="text-emerald-600 font-medium">{{ $stats['produits']['actifs'] }} actifs</span>
                </div>
                <div class="flex items-center justify-between p-4 bg-pink-50 rounded-xl">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-pink-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-heart text-white"></i>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Annonces</p>
                            <p class="text-lg font-bold text-gray-900">{{ $stats['annonces']['total'] }}</p>
                        </div>
                    </div>
                    <span class="text-pink-600 font-medium">{{ $stats['annonces']['actives'] }} actives</span>
                </div>
                <div class="flex items-center justify-between p-4 bg-blue-50 rounded-xl">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chart-line text-white"></i>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Total Transactions</p>
                            <p class="text-lg font-bold text-gray-900">{{ number_format($stats['transactions']['total']) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableaux -->
    <div class="grid lg:grid-cols-2 gap-6">
        <!-- Transactions Récentes -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Transactions Récentes</h2>
                    <a href="{{ route('admin.nkap.transactions.index') }}" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">
                        Voir tout <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($transactionsRecentes as $transaction)
                <div class="p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center
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
                            <div>
                                <p class="font-medium text-gray-900">{{ $transaction->user->nom ?? 'N/A' }} {{ $transaction->user->prenom ?? '' }}</p>
                                <p class="text-sm text-gray-500">{{ ucfirst(str_replace('_', ' ', $transaction->type)) }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold @if(in_array($transaction->type, ['recharge', 'transfert_recu', 'gain_tontine', 'bonus_parrainage'])) text-emerald-600 @else text-red-600 @endif">
                                {{ in_array($transaction->type, ['recharge', 'transfert_recu', 'gain_tontine', 'bonus_parrainage']) ? '+' : '-' }}{{ number_format($transaction->montant) }} FCFA
                            </p>
                            <p class="text-xs text-gray-400">{{ $transaction->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-gray-500">
                    <i class="fas fa-inbox text-4xl mb-2"></i>
                    <p>Aucune transaction récente</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Nouveaux Utilisateurs -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Nouveaux Utilisateurs</h2>
                    <a href="{{ route('admin.nkap.users.index') }}" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">
                        Voir tout <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($nouveauxUsers as $user)
                <div class="p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-green-500 rounded-xl flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($user->prenom ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ $user->prenom }} {{ $user->nom }}</p>
                                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-gray-900">{{ number_format($user->solde) }} FCFA</p>
                            <p class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-gray-500">
                    <i class="fas fa-users text-4xl mb-2"></i>
                    <p>Aucun nouvel utilisateur</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('transactionsChart').getContext('2d');
    const data = @json($transactionsParJour);
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data.map(d => d.date),
            datasets: [
                {
                    label: 'Montant (FCFA)',
                    data: data.map(d => d.montant),
                    backgroundColor: 'rgba(16, 185, 129, 0.8)',
                    borderRadius: 8,
                    yAxisID: 'y'
                },
                {
                    label: 'Nombre',
                    data: data.map(d => d.count),
                    type: 'line',
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true,
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            interaction: {
                mode: 'index',
                intersect: false
            },
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    grid: {
                        drawOnChartArea: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
});
</script>
@endsection