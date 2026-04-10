@extends('br-final.layouts.app')
@section('title', 'Mes Tontines')
@section('content')
<div class="p-4">

<a href="{{ route('br.membre.dashboard') }}" 
   style="font-size:13px;color:#888;display:inline-block;margin-bottom:10px;padding-top:8px">
   ← Retour
</a>
    <div class="mb-5 pt-2">
        <h1 style="font-family:Syne,sans-serif;font-size:24px;font-weight:700">Mes Tontines</h1>
        <p style="font-size:13px;color:#888;margin-top:2px">Gérez vos épargnes automatiques</p>
    </div>

    @if(session('success'))<div class="alert-success mb-4">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert-error mb-4">{{ session('error') }}</div>@endif

    {{-- Tontines actives --}}
    @foreach([$journaliereActive, $hebdoActive] as $t)
        @if($t)
        <div class="card p-4 mb-3">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px">
                <span class="tag" style="text-transform:capitalize">{{ $t->type }}</span>
                <span style="font-size:12px;color:#888;text-transform:capitalize">{{ str_replace('_',' ',$t->statut) }}</span>
            </div>

            <p style="font-size:12px;color:#888;margin-bottom:2px">Cotisé jusqu'ici</p>
            <p style="font-family:Syne,sans-serif;font-size:28px;font-weight:700;margin-bottom:2px">{{ number_format($t->total_cotise,0,',',' ') }}</p>
            <p style="font-size:12px;color:#aaa;margin-bottom:4px">FCFA / Total à cotiser : {{ number_format($t->montant_reel_a_atteindre,0,',',' ') }} FCFA</p>
            <p style="font-size:12px;color:#888">Vous recevrez : <span style="color:#2d7a22;font-weight:600">{{ number_format($t->objectif,0,',',' ') }} FCFA</span></p>

            <div style="margin:12px 0">
                <div style="display:flex;justify-content:space-between;font-size:12px;color:#888;margin-bottom:6px">
                    <span>{{ $t->nb_cotisations }} / {{ $t->nb_cotisations_total }} cotisations</span>
                    <span>{{ $t->progression }}%</span>
                </div>
                <div class="progress-bar"><div class="progress-fill" style="width:{{ min($t->progression,100) }}%"></div></div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:14px">
                <div style="background:#f5f4f0;border-radius:10px;padding:10px">
                    <p style="font-size:11px;color:#888;margin-bottom:3px">Je cotise / {{ $t->type==='journaliere' ? 'jour' : 'semaine' }}</p>
                    <p style="font-size:14px;font-weight:600">{{ number_format($t->montant_cotisation,0,',',' ') }} FCFA</p>
                </div>
                <div style="background:#f5f4f0;border-radius:10px;padding:10px">
                    <p style="font-size:11px;color:#888;margin-bottom:3px">Je reçois à la fin</p>
                    <p style="font-size:14px;font-weight:600;color:#2d7a22">{{ number_format($t->objectif,0,',',' ') }} FCFA</p>
                </div>
            </div>

            @if($t->statut === 'active')
                @if($t->progression < 100)
                    <form action="{{ route('br.membre.tontine.cotiser', $t) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-primary" style="width:100%">Cotiser maintenant</button>
                    </form>
                @else
                    <a href="https://wa.me/{{ config('brfinal.whatsapp_admin') }}?text={{ urlencode('Bonjour, j\'ai atteint mon objectif de tontine '.$t->type.' (ID #'.$t->id.'). Je souhaite recevoir mes '.number_format($t->objectif,0,',',' ').' FCFA.') }}"
                        target="_blank" style="display:flex;align-items:center;justify-content:center;gap:8px;width:100%;background:#25d366;color:#fff;border-radius:12px;padding:14px;font-size:15px;font-weight:500">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        Demander mon retrait
                    </a>
                @endif
            @elseif($t->statut === 'retrait_demande')
                <div style="text-align:center;padding:12px;border:1px solid #e6a800;border-radius:10px;color:#8a6800;font-size:13px">⏳ Retrait en attente de validation</div>
            @elseif($t->statut === 'retrait_valide')
                <div style="text-align:center;padding:12px;border:1px solid #3da832;border-radius:10px;color:#2d7a22;font-size:13px">✅ Retrait validé — fonds reçus</div>
            @endif
        </div>
        @endif
    @endforeach

    {{-- Créer une tontine --}}
    @if(!$journaliereActive || !$hebdoActive)
    <div class="card p-4 mb-3">
        <h2 style="font-family:Syne,sans-serif;font-size:16px;font-weight:700;margin-bottom:4px">+ Nouvelle tontine</h2>
        <p style="font-size:12px;color:#888;margin-bottom:16px">Définissez votre objectif, nous calculons le reste.</p>

        <form action="{{ route('br.membre.tontine.creer') }}" method="POST">
            @csrf

            <label style="font-size:12px;color:#666;display:block;margin-bottom:6px">Type de tontine</label>
            <select name="type" id="tontine-type" required class="input" style="margin-bottom:12px">
                @if(!$journaliereActive)<option value="journaliere">Journalière (+20% de commission)</option>@endif
                @if(!$hebdoActive)<option value="hebdomadaire">Hebdomadaire (+10% de commission)</option>@endif
            </select>

            <label style="font-size:12px;color:#666;display:block;margin-bottom:6px">Objectif souhaité (FCFA)</label>
            <input type="number" name="objectif" id="tontine-objectif" min="1200" step="1" placeholder="Ex: 1 000 000" required class="input" value="{{ old('objectif') }}" style="margin-bottom:12px">

            {{-- Récap calculé --}}
            <div id="calcul-bloc" style="display:none;background:#fef0e6;border-radius:12px;padding:14px;margin-bottom:12px">
                <p style="font-size:11px;color:#9a4510;margin-bottom:10px">📊 Récapitulatif automatique</p>
                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;margin-bottom:12px">
                    <div style="background:#fff;border-radius:8px;padding:8px">
                        <p style="font-size:10px;color:#888;margin-bottom:2px">Vous recevez</p>
                        <p style="font-size:13px;font-weight:600" id="recap-objectif">—</p>
                    </div>
                    <div style="background:#fff;border-radius:8px;padding:8px">
                        <p style="font-size:10px;color:#888;margin-bottom:2px">À cotiser <span id="recap-taux" style="color:#c2601a"></span></p>
                        <p style="font-size:13px;font-weight:600;color:#c2601a" id="recap-reel">—</p>
                    </div>
                    <div style="background:#fff;border-radius:8px;padding:8px">
                        <p style="font-size:10px;color:#888;margin-bottom:2px">Nb cotisations</p>
                        <p style="font-size:13px;font-weight:600" id="recap-nb">—</p>
                    </div>
                </div>
                <label style="font-size:12px;color:#666;display:block;margin-bottom:6px">Cotisation par <span id="periode-label">jour</span> (FCFA)</label>
                <input type="number" name="montant_cotisation" id="montant-cotisation" min="1200" step="1200" placeholder="Ex: 100 000" required class="input">
                <p style="font-size:11px;color:#aaa;margin-top:4px" id="multiple-hint">Multiple de 1 200 FCFA</p>
            </div>

            @if($errors->any())
                @foreach($errors->all() as $error)
                    <p style="color:#c0302a;font-size:12px;margin-bottom:4px">• {{ $error }}</p>
                @endforeach
            @endif

            <button type="submit" id="btn-creer" disabled class="btn-primary" style="width:100%;opacity:.4;cursor:not-allowed">Créer la tontine</button>
        </form>
    </div>
    @endif

    {{-- Historique --}}
    @if($historique->count())
    <div class="card p-4 mb-3">
        <h2 style="font-family:Syne,sans-serif;font-size:16px;font-weight:700;margin-bottom:12px">Historique</h2>
        @foreach($historique as $t)
        <div style="padding:12px 0;border-bottom:0.5px solid #e5e3dc;display:flex;justify-content:space-between;align-items:flex-start">
            <div>
                <p style="font-size:14px;font-weight:500;text-transform:capitalize">{{ $t->type }}</p>
                <p style="font-size:12px;color:#888;margin-top:2px">{{ \Carbon\Carbon::parse($t->date_debut)->format('d/m/Y') }} · {{ str_replace('_',' ',$t->statut) }}</p>
            </div>
            <div style="text-align:right">
                <p style="font-size:13px;font-weight:600">{{ number_format($t->total_cotise,0,',',' ') }} FCFA</p>
                <p style="font-size:11px;color:#aaa">/ {{ number_format($t->objectif,0,',',' ') }} FCFA</p>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    @if(auth('brfinal')->user()->tontines()->whereIn('statut',['active','complete'])->count() > 1)
    <div style="text-align:center;margin-top:8px">
        <form action="{{ route('br.membre.tontine.retirer-tout') }}" method="POST" onsubmit="return confirm('Confirmer le retrait de toutes vos tontines ?')">
            @csrf
            <button type="submit" style="font-size:13px;color:#888;text-decoration:underline;background:none;border:none">Demander le retrait de toutes mes tontines</button>
        </form>
    </div>
    @endif

</div>

@push('scripts')
<script>
(function(){
    const typeSelect=document.getElementById('tontine-type');
    const objectifInput=document.getElementById('tontine-objectif');
    const montantInput=document.getElementById('montant-cotisation');
    const calculBloc=document.getElementById('calcul-bloc');
    const btnCreer=document.getElementById('btn-creer');
    const recapObjectif=document.getElementById('recap-objectif');
    const recapReel=document.getElementById('recap-reel');
    const recapTaux=document.getElementById('recap-taux');
    const recapNb=document.getElementById('recap-nb');
    const periodeLabel=document.getElementById('periode-label');
    const multipleHint=document.getElementById('multiple-hint');
    function fmt(n){return new Intl.NumberFormat('fr-FR').format(Math.round(n))+' FCFA';}
    function getStep(){return typeSelect.value==='journaliere'?1200:6100;}
    function getTaux(){return typeSelect.value==='journaliere'?0.20:0.10;}
    function updateType(){
        const step=getStep(),taux=getTaux()*100;
        periodeLabel.textContent=typeSelect.value==='journaliere'?'jour':'semaine';
        multipleHint.textContent='Multiple de '+step.toLocaleString('fr-FR')+' FCFA';
        montantInput.step=step;montantInput.min=step;
        recapTaux.textContent='(+'+taux+'%)';
        if(montantInput.value&&parseInt(montantInput.value)%step!==0)montantInput.value='';
        recalcul();
    }
    function recalcul(){
        const objectif=parseFloat(objectifInput.value);
        const montant=parseFloat(montantInput.value);
        const taux=getTaux();const step=getStep();
        if(!objectif||objectif<1200){calculBloc.style.display='none';btnCreer.disabled=true;btnCreer.style.opacity='.4';return;}
        const montantReel=(objectif*(1+taux))/2;
        calculBloc.style.display='block';
        recapObjectif.textContent=fmt(objectif);
        recapReel.textContent=fmt(montantReel);
        if(montant&&montant>=step&&montant%step===0){
            const nb=Math.ceil(montantReel/montant);
            recapNb.textContent=nb+' '+(typeSelect.value==='journaliere'?'jour(s)':'semaine(s)');
            btnCreer.disabled=false;btnCreer.style.opacity='1';btnCreer.style.cursor='pointer';
        }else{
            recapNb.textContent='—';btnCreer.disabled=true;btnCreer.style.opacity='.4';btnCreer.style.cursor='not-allowed';
        }
    }
    typeSelect.addEventListener('change',updateType);
    objectifInput.addEventListener('input',recalcul);
    montantInput&&montantInput.addEventListener('input',recalcul);
    updateType();
})();
</script>
@endpush
@endsection