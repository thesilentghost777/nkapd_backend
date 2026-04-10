@extends('br-final.layouts.app')
@section('title', 'Mon espace')
@section('content')
<div class="p-6 lg:p-8 max-w-5xl mx-auto">

    {{-- Header --}}
    <div class="mb-6 flex flex-wrap items-start justify-between gap-4">
        <div>
            <p class="text-sm text-gray-400">Bonjour,</p>
            <h1 class="text-2xl font-semibold text-gray-900">{{ $user->prenom }} 👋</h1>
        </div>
        @if(!$stats['adhesion_payee'])
            <form action="{{ route('br.membre.adhesion') }}" method="POST">
                @csrf
                <button type="submit" class="px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-sm rounded-lg font-medium transition">
                    💳 Payer l'adhésion (10 000 FCFA)
                </button>
            </form>
        @else
            <span class="px-3 py-1.5 bg-green-50 border border-green-200 text-green-700 text-sm rounded-full font-medium">✓ Membre actif</span>
        @endif
    </div>

    {{-- Alerte adhésion --}}
    @if(!$stats['adhesion_payee'])
        <div class="mb-6 p-4 bg-amber-50 border-l-4 border-amber-500 rounded-lg text-sm text-amber-800">
            <strong>Adhésion requise</strong> — Payez vos 10 000 FCFA pour accéder aux prêts.
        </div>
    @endif

    {{-- Notifications --}}
    @if($notifications->count())
        <div class="mb-6 space-y-2">
            @foreach($notifications as $notif)
                @php $colors = ['success'=>'border-green-500 bg-green-50 text-green-800','danger'=>'border-red-500 bg-red-50 text-red-800','default'=>'border-amber-500 bg-amber-50 text-amber-800'][$notif->type ?? 'default']; @endphp
                <div class="p-4 border-l-4 rounded-lg text-sm {{ $colors }}">
                    <p class="font-medium">{{ $notif->titre }}</p>
                    <p class="mt-0.5 opacity-80">{{ $notif->contenu }}</p>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
        @foreach([
            ['label'=>'Épargne totale','value'=>number_format($stats['total_epargne'],0,',',' '),'unit'=>'FCFA','color'=>'text-gray-900'],
            ['label'=>'Tontines actives','value'=>$stats['tontines_actives'],'unit'=>'en cours','color'=>'text-amber-600'],
            ['label'=>'Filleuls actifs','value'=>$stats['filleuls'],'unit'=>'membres','color'=>'text-green-600'],
            ['label'=>'Plafond prêt','value'=>number_format($stats['plafond_pret'],0,',',' '),'unit'=>'FCFA max','color'=>'text-blue-600'],
        ] as $s)
            <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
                <p class="text-xs text-gray-400 mb-1">{{ $s['label'] }}</p>
                <p class="text-xl font-semibold {{ $s['color'] }}">{{ $s['value'] }}</p>
                <p class="text-xs text-gray-400 mt-0.5">{{ $s['unit'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- 3 colonnes --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- Tontines --}}
        <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-gray-900">💰 Mes tontines</h2>
                <a href="{{ route('br.membre.tontine.index') }}" class="text-xs text-amber-600 hover:underline">Voir tout →</a>
            </div>
            @forelse($user->tontinesActives as $t)
                <div class="bg-gray-50 rounded-lg p-3 mb-3">
                    <div class="flex justify-between text-xs text-gray-400 mb-1">
                        <span class="text-amber-600 font-medium capitalize">{{ $t->type }}</span>
                        <span>{{ $t->nb_cotisations }}/{{ $t->nb_cotisations_total }}</span>
                    </div>
                    <p class="font-semibold text-gray-900 mb-2">{{ number_format($t->total_cotise,0,',',' ') }} <span class="text-xs font-normal text-gray-400">FCFA</span></p>
                    <div class="h-1 bg-gray-200 rounded-full"><div class="h-1 bg-amber-500 rounded-full" style="width:{{ $t->progression }}%"></div></div>
                </div>
            @empty
                <p class="text-sm text-gray-400 text-center py-4">Aucune tontine active</p>
            @endforelse
            <a href="{{ route('br.membre.tontine.index') }}" class="block text-center text-sm text-amber-600 border border-amber-200 rounded-lg py-2 mt-1 hover:bg-amber-50 transition">+ Créer une tontine</a>
        </div>

        {{-- Prêt --}}
        <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-gray-900">💳 Prêt</h2>
                <a href="{{ route('br.membre.pret.index') }}" class="text-xs text-amber-600 hover:underline">Détails →</a>
            </div>
            @if($stats['pret_en_cours'])
                @php $pret = $stats['pret_en_cours']; @endphp
                <div class="text-center py-2">
                    <p class="text-xs text-gray-400 mb-1">Montant accordé</p>
                    <p class="text-3xl font-semibold text-gray-900">{{ number_format($pret->montant_accorde,0,',',' ') }}</p>
                    <p class="text-xs text-gray-400 mb-3">FCFA</p>
                    <div class="p-3 rounded-lg {{ $pret->statut==='en_retard' ? 'bg-red-50 text-red-700' : 'bg-green-50 text-green-700' }} text-xs mb-3">
                        Reste à payer : {{ number_format($pret->reste_a_payer,0,',',' ') }} FCFA
                    </div>
                    <a href="{{ route('br.membre.pret.index') }}" class="block w-full py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-sm rounded-lg transition font-medium">Rembourser</a>
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-4xl mb-2">🏦</p>
                    <p class="text-sm text-gray-400 mb-4">Aucun prêt en cours</p>
                    <a href="{{ route('br.membre.pret.index') }}" class="inline-block px-6 py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-sm rounded-lg font-medium transition">Demander un prêt</a>
                </div>
            @endif
        </div>

        {{-- Parrainage --}}
        <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm">
            <h2 class="font-semibold text-gray-900 mb-4">🤝 Mon parrainage</h2>
            
            {{-- Lien de parrainage avec bouton de copie --}}
            <div class="bg-gray-50 rounded-lg p-3 mb-4">
                <p class="text-xs text-gray-400 mb-2">Lien de parrainage</p>
                <div class="flex items-center gap-2">
                    <code id="sponsorLink" class="flex-1 text-xs text-amber-600 font-mono break-all bg-white p-2 rounded border border-gray-200">
                        {{ route('br.register', ['parrain' => $user->telephone]) }}
                    </code>
                    <button onclick="copySponsorLink()" class="px-3 py-2 bg-amber-600 hover:bg-amber-700 text-white text-xs rounded-lg transition font-medium whitespace-nowrap">
                        📋 Copier
                    </button>
                </div>
                <p id="copyFeedback" class="text-xs text-green-600 mt-2 hidden">✓ Lien copié dans le presse-papier !</p>
            </div>

            {{-- Code de parrainage à copier --}}
            <div class="bg-gray-50 rounded-lg p-3 mb-4">
                <p class="text-xs text-gray-400 mb-2">Code de parrainage (à partager)</p>
                <div class="flex items-center gap-2">
                    <code id="sponsorCode" class="flex-1 text-sm font-bold text-amber-600 bg-white p-2 rounded border border-gray-200 text-center">
                        {{ $user->code_parrainage ?? $user->telephone }}
                    </code>
                    <button onclick="copySponsorCode()" class="px-3 py-2 bg-amber-600 hover:bg-amber-700 text-white text-xs rounded-lg transition font-medium whitespace-nowrap">
                        📋 Copier
                    </button>
                </div>
                <p id="copyCodeFeedback" class="text-xs text-green-600 mt-2 hidden">✓ Code copié dans le presse-papier !</p>
            </div>

            <div class="flex justify-between text-sm py-1.5 border-b border-gray-100">
                <span class="text-gray-400">Filleuls actifs</span>
                <span class="font-semibold">{{ $stats['filleuls'] }}</span>
            </div>
            <div class="flex justify-between text-sm py-1.5">
                <span class="text-gray-400">Plafond actuel</span>
                <span class="text-amber-600 font-semibold">{{ number_format($stats['plafond_pret'],0,',',' ') }} FCFA</span>
            </div>
            <a href="{{ route('br.membre.profil') }}" class="block text-center text-xs text-gray-500 border border-gray-200 rounded-lg py-2 mt-4 hover:border-amber-200 hover:bg-amber-50 transition">Voir mon profil complet</a>
        </div>

    </div>
</div>

{{-- Script de copie --}}
<script>
function copySponsorLink() {
    const linkElement = document.getElementById('sponsorLink');
    const linkText = linkElement.textContent || linkElement.innerText;
    
    navigator.clipboard.writeText(linkText).then(function() {
        const feedback = document.getElementById('copyFeedback');
        feedback.classList.remove('hidden');
        setTimeout(function() {
            feedback.classList.add('hidden');
        }, 2000);
    }).catch(function(err) {
        console.error('Erreur de copie: ', err);
        alert('Impossible de copier le lien');
    });
}

function copySponsorCode() {
    const codeElement = document.getElementById('sponsorCode');
    const codeText = codeElement.textContent || codeElement.innerText;
    
    navigator.clipboard.writeText(codeText).then(function() {
        const feedback = document.getElementById('copyCodeFeedback');
        feedback.classList.remove('hidden');
        setTimeout(function() {
            feedback.classList.add('hidden');
        }, 2000);
    }).catch(function(err) {
        console.error('Erreur de copie: ', err);
        alert('Impossible de copier le code');
    });
}
</script>
@endsection