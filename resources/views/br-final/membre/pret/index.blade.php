@extends('br-final.layouts.app')
@section('title', 'Mes Prêts')
@section('content')
<div class="p-4">

<a href="{{ route('br.membre.dashboard') }}" 
   style="font-size:13px;color:#888;display:inline-block;margin-bottom:10px;padding-top:8px">
   ← Retour
</a>
    <div class="mb-5 pt-2">
        <h1 style="font-family:Syne,sans-serif;font-size:24px;font-weight:700">Prêts</h1>
        <p style="font-size:13px;color:#888;margin-top:2px">Gérez vos demandes de prêts</p>
    </div>

    {{-- Éligibilité --}}
    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;margin-bottom:16px">
        <div class="card" style="padding:12px">
            <p style="font-size:10px;color:#888;margin-bottom:4px">Filleuls actifs</p>
            <p style="font-family:Syne,sans-serif;font-size:20px;font-weight:700">{{ $user->nb_filleuls_actifs }}</p>
            <p style="font-size:10px;color:{{ $user->nb_filleuls_actifs>=1?'#2d7a22':'#c0302a' }};margin-top:2px">{{ $user->nb_filleuls_actifs>=1?'✓ Ok':'✗ Min 1' }}</p>
        </div>
        <div class="card" style="padding:12px">
            <p style="font-size:10px;color:#888;margin-bottom:4px">Plafond</p>
            <p style="font-family:Syne,sans-serif;font-size:16px;font-weight:700;color:#c2601a">{{ number_format($user->plafond_pret,0,',',' ') }}</p>
            <p style="font-size:10px;color:#aaa;margin-top:2px">FCFA</p>
        </div>
        <div class="card" style="padding:12px">
            <p style="font-size:10px;color:#888;margin-bottom:4px">Adhésion</p>
            <p style="font-family:Syne,sans-serif;font-size:20px;font-weight:700;color:{{ $user->estMembre()?'#2d7a22':'#c0302a' }}">{{ $user->estMembre()?'✓':'✗' }}</p>
            <p style="font-size:10px;color:#aaa;margin-top:2px">{{ $user->estMembre()?'Payée':'Requise' }}</p>
        </div>
    </div>

    @if($pretActif)
    <div class="card p-4 mb-3">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px">
            <h2 style="font-family:Syne,sans-serif;font-size:16px;font-weight:700">Prêt en cours</h2>
            @php
                $sc=['en_cours'=>'badge-green','en_retard'=>'badge-red','en_attente'=>'badge-yellow'][$pretActif->statut]??'badge-yellow';
            @endphp
            <span class="{{ $sc }}">{{ ucfirst(str_replace('_',' ',$pretActif->statut)) }}</span>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:12px">
            <div style="background:#f5f4f0;border-radius:10px;padding:10px">
                <p style="font-size:10px;color:#888;margin-bottom:3px">Montant accordé</p>
                <p style="font-size:14px;font-weight:600">{{ number_format($pretActif->montant_accorde??$pretActif->montant_demande,0,',',' ') }} FCFA</p>
            </div>
            <div style="background:#f5f4f0;border-radius:10px;padding:10px">
                <p style="font-size:10px;color:#888;margin-bottom:3px">Total dû</p>
                <p style="font-size:14px;font-weight:600;color:#c2601a">{{ number_format($pretActif->montant_total_du,0,',',' ') }} FCFA</p>
            </div>
            <div style="background:#f5f4f0;border-radius:10px;padding:10px">
                <p style="font-size:10px;color:#888;margin-bottom:3px">Reste à payer</p>
                <p style="font-size:14px;font-weight:600">{{ number_format($pretActif->reste_a_payer,0,',',' ') }} FCFA</p>
            </div>
            <div style="background:#f5f4f0;border-radius:10px;padding:10px">
                <p style="font-size:10px;color:#888;margin-bottom:3px">Échéance</p>
                <p style="font-size:14px;font-weight:600">{{ $pretActif->date_echeance?\Carbon\Carbon::parse($pretActif->date_echeance)->format('d/m/Y'):'—' }}</p>
            </div>
        </div>

        @if($pretActif->penalites > 0)
            <div class="alert-error mb-3">⚠ Pénalités de retard : {{ number_format($pretActif->penalites,0,',',' ') }} FCFA</div>
        @endif

        @if(in_array($pretActif->statut,['en_cours','en_retard']))
            <form action="{{ route('br.membre.pret.rembourser', $pretActif) }}" method="POST">
                @csrf
                <input type="number" name="montant" min="1000" max="{{ $pretActif->reste_a_payer }}" placeholder="Montant à rembourser" required class="input" style="margin-bottom:10px">
                <button type="submit" class="btn-primary" style="width:100%">Payer maintenant</button>
            </form>
        @endif
    </div>

    @else
        @if($user->estMembre() && $user->nb_filleuls_actifs >= 1)
        <div class="card p-4 mb-3">
            <h2 style="font-family:Syne,sans-serif;font-size:16px;font-weight:700;margin-bottom:10px">Faire une demande</h2>
            <div style="background:#fef0e6;border-radius:10px;padding:10px;font-size:13px;color:#9a4510;margin-bottom:12px">
                💡 Plafond : <strong>{{ number_format($user->plafond_pret,0,',',' ') }} FCFA</strong> · {{ $user->nb_filleuls_actifs }} filleul(s) · 10% d'intérêt
            </div>
            <form action="{{ route('br.membre.pret.demander') }}" method="POST">
                @csrf
                <input type="number" name="montant" min="10000" max="{{ $user->plafond_pret }}" step="1000" placeholder="Montant souhaité (ex: 50 000)" required class="input" style="margin-bottom:10px">
                <button type="submit" class="btn-primary" style="width:100%">Envoyer la demande</button>
            </form>
        </div>
        @else
        <div class="card p-4 mb-3" style="text-align:center;padding:32px 16px">
            <p style="font-size:36px;margin-bottom:8px">🔒</p>
            <p style="font-family:Syne,sans-serif;font-size:16px;font-weight:700;margin-bottom:6px">Non éligible aux prêts</p>
            <p style="font-size:13px;color:#888">{{ !$user->estMembre()?'Payez votre adhésion pour devenir éligible.':'Parrainez au moins 1 membre actif pour débloquer les prêts.' }}</p>
        </div>
        @endif
    @endif

    @if($historique->count())
    <div class="card p-4">
        <h2 style="font-family:Syne,sans-serif;font-size:16px;font-weight:700;margin-bottom:12px">Historique des prêts</h2>
        @foreach($historique as $p)
        <div style="padding:12px 0;border-bottom:0.5px solid #e5e3dc;display:flex;justify-content:space-between;align-items:center">
            <div>
                <p style="font-size:14px;font-weight:600">{{ number_format($p->montant_accorde??$p->montant_demande,0,',',' ') }} FCFA</p>
                <p style="font-size:12px;color:#888;margin-top:2px">{{ $p->created_at->format('d/m/Y') }}</p>
                @if($p->motif_refus)<p style="font-size:11px;color:#c0302a;margin-top:2px">{{ $p->motif_refus }}</p>@endif
            </div>
            <span class="{{ $p->statut==='rembourse'?'badge-green':'badge-red' }}">{{ $p->statut }}</span>
        </div>
        @endforeach
    </div>
    @endif

</div>
@endsection