@extends('layouts.admin')

@section('title', 'Détails Transaction')

@section('admin-content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.nkap.transactions.index') }}" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition-colors">
                <i class="fas fa-arrow-left text-gray-600"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Détails de la Transaction</h1>
                <p class="text-gray-500 mt-1">Référence: {{ $transaction->reference ?? 'N/A' }}</p>
            </div>
        </div>
        <div>
            @if($transaction->statut == 'complete')
            <span class="inline-flex items-center bg-emerald-100 text-emerald-700 px-4 py-2 rounded-xl text-sm font-medium">
                <i class="fas fa-check-circle mr-2"></i>Transaction Complète
            </span>
            @elseif($transaction->statut == 'en_attente')
            <span class="inline-flex items-center bg-yellow-100 text-yellow-700 px-4 py-2 rounded-xl text-sm font-medium">
                <i class="fas fa-clock mr-2"></i>En Attente
            </span>
            @else
            <span class="inline-flex items-center bg-red-100 text-red-700 px-4 py-2 rounded-xl text-sm font-medium">
                <i class="fas fa-times-circle mr-2"></i>Échouée
            </span>
            @endif
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Détails principaux -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Montant -->
            <div class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl p-8 text-white text-center">
                <p class="text-emerald-100 mb-2">Montant de la transaction</p>
                <p class="text-5xl font-bold">{{ number_format($transaction->montant) }} <span class="text-2xl">FCFA</span></p>
                @if($transaction->frais)
                <p class="text-emerald-200 mt-4">
                    <i class="fas fa-info-circle mr-1"></i>
                    Frais: {{ number_format($transaction->frais) }} FCFA
                </p>
                @endif
            </div>

            <!-- Informations -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900">Informations de la Transaction</h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <p class="text-sm text-gray-500 mb-1">Type</p>
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
                                <span class="font-semibold text-gray-900">{{ ucfirst(str_replace('_', ' ', $transaction->type)) }}</span>
                            </div>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <p class="text-sm text-gray-500 mb-1">Référence</p>
                            <p class="font-mono font-semibold text-gray-900">{{ $transaction->reference ?? 'N/A' }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <p class="text-sm text-gray-500 mb-1">Date de création</p>
                            <p class="font-semibold text-gray-900">{{ $transaction->created_at->format('d/m/Y à H:i:s') }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <p class="text-sm text-gray-500 mb-1">Statut</p>
                            <p class="font-semibold @if($transaction->statut == 'complete') text-emerald-600 @elseif($transaction->statut == 'en_attente') text-yellow-600 @else text-red-600 @endif">
                                {{ ucfirst(str_replace('_', ' ', $transaction->statut)) }}
                            </p>
                        </div>
                    </div>
                    @if($transaction->description)
                    <div class="p-4 bg-gray-50 rounded-xl">
                        <p class="text-sm text-gray-500 mb-1">Description</p>
                        <p class="text-gray-900">{{ $transaction->description }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Émetteur -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-100 bg-emerald-50">
                    <h3 class="font-semibold text-emerald-800">
                        <i class="fas fa-user mr-2"></i>Émetteur
                    </h3>
                </div>
                <div class="p-4">
                    @if($transaction->user)
                    <div class="flex items-center gap-3">
                        <div class="w-14 h-14 bg-gradient-to-br from-emerald-400 to-green-500 rounded-xl flex items-center justify-center text-white font-bold text-xl">
                            {{ strtoupper(substr($transaction->user->prenom, 0, 1)) }}{{ strtoupper(substr($transaction->user->nom, 0, 1)) }}
                        </div>
                        <div>
                            <a href="{{ route('admin.nkap.users.show', $transaction->user->id) }}" class="font-semibold text-gray-900 hover:text-emerald-600">
                                {{ $transaction->user->prenom }} {{ $transaction->user->nom }}
                            </a>
                            <p class="text-sm text-gray-500">{{ $transaction->user->email }}</p>
                            <p class="text-sm text-gray-500">{{ $transaction->user->telephone }}</p>
                        </div>
                    </div>
                    @else
                    <p class="text-gray-400 text-center py-4">Utilisateur non disponible</p>
                    @endif
                </div>
            </div>

            <!-- Destinataire -->
            @if($transaction->destinataire)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-100 bg-blue-50">
                    <h3 class="font-semibold text-blue-800">
                        <i class="fas fa-user-check mr-2"></i>Destinataire
                    </h3>
                </div>
                <div class="p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-xl flex items-center justify-center text-white font-bold text-xl">
                            {{ strtoupper(substr($transaction->destinataire->prenom, 0, 1)) }}{{ strtoupper(substr($transaction->destinataire->nom, 0, 1)) }}
                        </div>
                        <div>
                            <a href="{{ route('admin.nkap.users.show', $transaction->destinataire->id) }}" class="font-semibold text-gray-900 hover:text-blue-600">
                                {{ $transaction->destinataire->prenom }} {{ $transaction->destinataire->nom }}
                            </a>
                            <p class="text-sm text-gray-500">{{ $transaction->destinataire->email }}</p>
                            <p class="text-sm text-gray-500">{{ $transaction->destinataire->telephone }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Résumé -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Résumé</h3>
                </div>
                <div class="p-4 space-y-3">
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600">Montant brut</span>
                        <span class="font-semibold text-gray-900">{{ number_format($transaction->montant) }} FCFA</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600">Frais</span>
                        <span class="font-semibold text-gray-900">{{ number_format($transaction->frais ?? 0) }} FCFA</span>
                    </div>
                    <div class="border-t border-gray-100 pt-3 flex justify-between items-center">
                        <span class="font-semibold text-gray-900">Montant net</span>
                        <span class="font-bold text-emerald-600 text-lg">{{ number_format($transaction->montant - ($transaction->frais ?? 0)) }} FCFA</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
                <div class="space-y-3">
                    @if($transaction->user)
                    <a href="{{ route('admin.nkap.users.transactions', $transaction->user->id) }}" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-3 rounded-xl font-medium transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-history"></i>
                        Historique utilisateur
                    </a>
                    @endif
                    <a href="{{ route('admin.nkap.transactions.index') }}" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-3 rounded-xl font-medium transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-list"></i>
                        Toutes les transactions
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
