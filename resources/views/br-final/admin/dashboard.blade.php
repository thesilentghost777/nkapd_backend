@extends('br-final.layouts.admin')
@section('title', 'Dashboard Admin')
@section('content')
<div class="p-6 lg:p-8">
    <div class="mb-8">
        <h1 class="text-3xl font-800 text-white" style="font-family:Syne,sans-serif">Dashboard</h1>
        <p class="text-gray-600 text-sm mt-1">Vue d'ensemble — {{ now()->format('d F Y') }}</p>
    </div>

    <!-- KPIs -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        @php
            $kpis = [
                ['label'=>'Membres total','value'=>number_format($stats['total_membres']),'sub'=>$stats['en_attente'].' en attente','color'=>'text-white'],
                ['label'=>'Membres actifs','value'=>number_format($stats['membres_actifs']),'sub'=>'statut membre','color'=>'text-green-400'],
                ['label'=>'Tontines actives','value'=>number_format($stats['total_tontines']),'sub'=>number_format($stats['volume_tontines'],0,',',' ').' FCFA','color'=>'text-orange-400'],
                ['label'=>'Prêts en cours','value'=>number_format($stats['prets_en_cours']),'sub'=>number_format($stats['volume_prets'],0,',',' ').' FCFA','color'=>'text-blue-400'],
                ['label'=>'Prêts en attente','value'=>number_format($stats['prets_en_attente']),'sub'=>'à traiter','color'=>'text-yellow-400'],
                ['label'=>'Retraits pending','value'=>number_format($stats['retraits_pending']),'sub'=>'à valider','color'=>'text-purple-400'],
                ['label'=>'Assistances','value'=>number_format($stats['assistances_pending']),'sub'=>'en attente','color'=>'text-red-400'],
                ['label'=>'Revenus adhésion','value'=>number_format($stats['revenus_adhesion'],0,',',' ').' FCFA','sub'=>'total perçu','color'=>'text-green-400'],
            ];
        @endphp
        @foreach($kpis as $kpi)
            <div class="stat-card p-5">
                <p class="text-gray-600 text-xs mb-2">{{ $kpi['label'] }}</p>
                <p class="{{ $kpi['color'] }} text-xl font-bold" style="font-family:Syne,sans-serif">{{ $kpi['value'] }}</p>
                <p class="text-gray-700 text-xs mt-1">{{ $kpi['sub'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Derniers membres -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-white font-bold" style="font-family:Syne,sans-serif">Derniers membres</h2>
                <a href="{{ route('br.admin.membres') }}" class="text-red-400 text-xs hover:underline">Voir tout →</a>
            </div>
            <div class="space-y-3">
                @foreach($derniersMembers as $m)
                    <div class="flex items-center justify-between py-2">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-red-500/20 flex items-center justify-center text-red-400 text-xs font-bold">{{ substr($m->prenom, 0, 1) }}</div>
                            <div>
                                <p class="text-white text-sm font-medium">{{ $m->nom_complet }}</p>
                                <p class="text-gray-600 text-xs">{{ $m->telephone }}</p>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded-full text-xs {{ $m->statut === 'membre' ? 'bg-green-500/15 text-green-400' : 'bg-yellow-500/15 text-yellow-400' }}">{{ $m->statut }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Dernières transactions -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-white font-bold" style="font-family:Syne,sans-serif">Dernières transactions</h2>
                <a href="{{ route('br.admin.transactions') }}" class="text-red-400 text-xs hover:underline">Voir tout →</a>
            </div>
            <div class="space-y-3">
                @foreach($dernieresTx as $tx)
                    <div class="flex items-center justify-between py-2 border-b border-gray-800 last:border-0">
                        <div>
                            <p class="text-white text-sm">{{ $tx->user->nom_complet ?? '—' }}</p>
                            <p class="text-gray-600 text-xs capitalize">{{ str_replace('_', ' ', $tx->type) }}</p>
                        </div>
                        <p class="text-green-400 font-bold text-sm">{{ number_format($tx->montant, 0, ',', ' ') }} FCFA</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Alertes -->
    @if($stats['prets_en_attente'] > 0 || $stats['retraits_pending'] > 0 || $stats['assistances_pending'] > 0)
        <div class="mt-6 card p-6">
            <h2 class="text-white font-bold mb-4" style="font-family:Syne,sans-serif">⚡ Actions requises</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @if($stats['prets_en_attente'] > 0)
                    <a href="{{ route('br.admin.prets', ['statut'=>'en_attente']) }}" class="flex items-center gap-4 bg-yellow-500/10 border border-yellow-500/20 rounded-2xl p-4 hover:border-yellow-500/40 transition">
                        <span class="text-2xl">💳</span>
                        <div>
                            <p class="text-yellow-400 font-bold">{{ $stats['prets_en_attente'] }} prêts</p>
                            <p class="text-gray-500 text-xs">en attente de validation</p>
                        </div>
                    </a>
                @endif
                @if($stats['retraits_pending'] > 0)
                    <a href="{{ route('br.admin.tontine.retraits') }}" class="flex items-center gap-4 bg-purple-500/10 border border-purple-500/20 rounded-2xl p-4 hover:border-purple-500/40 transition">
                        <span class="text-2xl">💸</span>
                        <div>
                            <p class="text-purple-400 font-bold">{{ $stats['retraits_pending'] }} retraits</p>
                            <p class="text-gray-500 text-xs">à traiter</p>
                        </div>
                    </a>
                @endif
                @if($stats['assistances_pending'] > 0)
                    <a href="{{ route('br.admin.assistances', ['statut'=>'en_attente']) }}" class="flex items-center gap-4 bg-red-500/10 border border-red-500/20 rounded-2xl p-4 hover:border-red-500/40 transition">
                        <span class="text-2xl">🛟</span>
                        <div>
                            <p class="text-red-400 font-bold">{{ $stats['assistances_pending'] }} demandes</p>
                            <p class="text-gray-500 text-xs">d'assistance en attente</p>
                        </div>
                    </a>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection