@extends('layouts.admin')

@section('title', 'Transactions - ' . $user->prenom . ' ' . $user->nom)

@section('admin-content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.nkap.users.show', $user->id) }}" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition-colors">
                <i class="fas fa-arrow-left text-gray-600"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Transactions</h1>
                <p class="text-gray-500 mt-1">{{ $user->prenom }} {{ $user->nom }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <div class="bg-emerald-100 text-emerald-700 px-4 py-2 rounded-xl font-medium">
                <i class="fas fa-wallet mr-2"></i>Solde: {{ number_format($user->solde) }} FCFA
            </div>
        </div>
    </div>

    <!-- Tableau -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Référence</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Destinataire</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Montant</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Frais</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Statut</th>
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
                                <span class="font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $transaction->type)) }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-mono text-sm text-gray-600">{{ $transaction->reference ?? 'N/A' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-gray-700 max-w-xs truncate">{{ $transaction->description ?? '-' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @if($transaction->destinataire)
                            <a href="{{ route('admin.nkap.users.show', $transaction->destinataire->id) }}" class="text-emerald-600 hover:underline">
                                {{ $transaction->destinataire->prenom }} {{ $transaction->destinataire->nom }}
                            </a>
                            @else
                            <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="font-semibold @if(in_array($transaction->type, ['recharge', 'transfert_recu', 'gain_tontine', 'bonus_parrainage'])) text-emerald-600 @else text-red-600 @endif">
                                {{ in_array($transaction->type, ['recharge', 'transfert_recu', 'gain_tontine', 'bonus_parrainage']) ? '+' : '-' }}{{ number_format($transaction->montant) }} FCFA
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($transaction->frais)
                            <span class="text-gray-600">{{ number_format($transaction->frais) }} FCFA</span>
                            @else
                            <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($transaction->statut == 'complete')
                            <span class="inline-flex items-center bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-sm font-medium">
                                <i class="fas fa-check-circle mr-1"></i>Complète
                            </span>
                            @elseif($transaction->statut == 'en_attente')
                            <span class="inline-flex items-center bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-medium">
                                <i class="fas fa-clock mr-1"></i>En attente
                            </span>
                            @else
                            <span class="inline-flex items-center bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-medium">
                                <i class="fas fa-times-circle mr-1"></i>Échouée
                            </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-3 text-gray-500">
                                <i class="fas fa-exchange-alt text-5xl text-gray-300"></i>
                                <p class="text-lg font-medium">Aucune transaction</p>
                                <p class="text-sm">Cet utilisateur n'a pas encore effectué de transactions</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($transactions->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $transactions->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
