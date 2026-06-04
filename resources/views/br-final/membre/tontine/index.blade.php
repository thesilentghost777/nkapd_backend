@extends('br-final.layouts.app')
@section('title', 'Mes Tontines')
@section('content')

<style>
:root {
    --dark:         #1B4332;
    --mid:          #2D6A4F;
    --gold:         #D4A017;
    --gold-light:   #e8c76a;
    --gold-bg:      #fdf8ec;
    --gold-border:  #f0d878;
    --green:        #2D6A4F;
    --green-light:  #f0f7f4;
    --green-border: #a8d5be;
    --red:          #dc2626;
    --red-light:    #fef2f2;
    --red-border:   #fecaca;
    --ink:          #0d2b1e;
    --ink-2:        #2d4a3a;
    --ink-3:        #4a7c62;
    --ink-4:        #8ab5a0;
    --border:       #d6ede4;
    --bg:           #f0f7f4;
    --white:        #ffffff;
    --radius-sm:    10px;
    --radius-md:    16px;
    --radius-lg:    22px;
    --shadow-card:  0 4px 24px rgba(27,67,50,.09);
    --shadow-gold:  0 4px 18px rgba(212,160,23,.25);
}

.page { max-width: 440px; margin: 0 auto; padding: 0 16px 100px; }

.back-link {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 13px; color: var(--ink-3); text-decoration: none;
    padding: 14px 0 4px; font-weight: 500;
    transition: color .18s;
}
.back-link:hover { color: var(--dark); }

.page-header { padding: 10px 0 22px; }
.page-header h2 {
    font-family: 'Playfair Display', serif;
    font-size: 26px; font-weight: 700; color: var(--dark);
    letter-spacing: -.3px; margin-bottom: 4px;
}
.page-header p { font-size: 13px; color: var(--ink-3); margin: 0; }

.alert { border-radius: var(--radius-md); padding: 12px 16px; font-size: 13px; margin-bottom: 12px; font-weight: 500; display: flex; align-items: center; gap: 8px; }
.alert-success { background: var(--green-light); color: var(--green); border: 1px solid var(--green-border); }
.alert-error   { background: var(--red-light);   color: var(--red);   border: 1px solid var(--red-border); }

/* ── Card ── */
.card {
    background: var(--white);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-card);
    padding: 22px;
    margin-bottom: 16px;
    border: 1px solid var(--border);
}

/* ── Tags ── */
.tag {
    display: inline-flex; align-items: center;
    padding: 4px 12px; border-radius: 20px;
    font-size: 11px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .6px;
    background: var(--dark); color: var(--gold-light);
}
.tag-gray {
    background: var(--bg); color: var(--ink-3);
}

/* ── Tontine active header ── */
.tontine-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; }

/* ── Amount big ── */
.amount-big .label { font-size: 11px; color: var(--ink-3); margin-bottom: 4px; font-weight: 500; letter-spacing: .3px; text-transform: uppercase; }
.amount-big .value-row { display: flex; align-items: baseline; gap: 6px; }
.amount-big .value {
    font-family: 'Playfair Display', serif;
    font-size: 34px; font-weight: 700; color: var(--dark); line-height: 1;
}
.amount-big .currency { font-size: 13px; font-weight: 600; color: var(--ink-3); }
.amount-big .sub { font-size: 12px; color: var(--ink-4); margin-top: 4px; }
.amount-big .rcv {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 13px; color: var(--ink-3); margin-top: 8px;
    background: var(--gold-bg); border: 1px solid var(--gold-border);
    padding: 6px 12px; border-radius: 8px;
}
.amount-big .rcv strong { color: var(--dark); font-weight: 700; }

/* ── Progress ── */
.progress-wrap { margin: 18px 0; }
.progress-meta { display: flex; justify-content: space-between; font-size: 12px; color: var(--ink-3); margin-bottom: 8px; }
.progress-meta strong { color: var(--dark); font-weight: 700; }
.progress-track { height: 8px; background: var(--bg); border-radius: 99px; overflow: hidden; border: 1px solid var(--border); }
.progress-fill  {
    height: 100%;
    background: linear-gradient(90deg, var(--dark) 0%, var(--mid) 60%, var(--gold) 100%);
    border-radius: 99px; transition: width .7s cubic-bezier(.4,0,.2,1);
}

/* ── Info grid ── */
.info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 18px; }
.info-cell { background: var(--bg); border-radius: var(--radius-sm); padding: 14px; border: 1px solid var(--border); }
.info-cell .cl { font-size: 11px; color: var(--ink-3); margin-bottom: 5px; font-weight: 500; text-transform: uppercase; letter-spacing: .3px; }
.info-cell .cv { font-size: 15px; font-weight: 700; color: var(--dark); }
.info-cell .cv.green { color: var(--mid); }

/* ── Buttons ── */
.btn-primary {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%; padding: 15px;
    background: var(--dark); color: var(--gold-light);
    font-size: 14px; font-weight: 600; border: none;
    border-radius: var(--radius-md); cursor: pointer; text-decoration: none;
    box-shadow: 0 4px 14px rgba(27,67,50,.3);
    transition: background .2s, box-shadow .2s, transform .1s;
    font-family: 'Outfit', sans-serif; letter-spacing: .2px;
}
.btn-primary:hover  { background: #142e23; box-shadow: 0 6px 22px rgba(27,67,50,.4); }
.btn-primary:active { transform: scale(.98); }

.btn-whatsapp {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%; padding: 15px; background: #25D366; color: #fff;
    font-size: 14px; font-weight: 600; border-radius: var(--radius-md); text-decoration: none;
    box-shadow: 0 4px 14px rgba(37,211,102,.25); transition: background .2s;
    font-family: 'Outfit', sans-serif;
}
.btn-whatsapp:hover { background: #1da851; }

/* ── Status banners ── */
.status-banner {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    padding: 13px; border-radius: var(--radius-md); font-size: 13px; font-weight: 500;
}
.status-banner.pending {
    background: var(--gold-bg); color: #7a5c00;
    border: 1px solid var(--gold-border);
}
.status-banner.done {
    background: var(--green-light); color: var(--green);
    border: 1px solid var(--green-border);
}

/* ── Section titles ── */
.section-title {
    font-family: 'Playfair Display', serif;
    font-size: 18px; font-weight: 700; color: var(--dark); margin-bottom: 4px;
}
.section-sub { font-size: 12px; color: var(--ink-3); margin-bottom: 18px; }

/* ── Form ── */
.field-label { display: block; font-size: 12px; font-weight: 600; color: var(--ink-2); margin-bottom: 7px; letter-spacing: .2px; }
.input {
    width: 100%; padding: 13px 14px;
    border: 1.5px solid var(--border); border-radius: var(--radius-sm);
    font-size: 15px; color: var(--ink); background: var(--white);
    outline: none; transition: border-color .2s, box-shadow .2s;
    margin-bottom: 12px; font-family: 'Outfit', sans-serif;
}
.input:focus { border-color: var(--mid); box-shadow: 0 0 0 3px rgba(45,106,79,.12); }

/* ── Type selector ── */
.type-selector { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 16px; }
.type-option { position: relative; cursor: pointer; }
.type-option input { position: absolute; opacity: 0; pointer-events: none; }
.type-card {
    border: 2px solid var(--border); border-radius: var(--radius-md);
    padding: 14px; transition: border-color .2s, background .2s;
}
.type-option input:checked + .type-card {
    border-color: var(--dark); background: var(--bg);
}
.type-badge {
    display: inline-block; background: var(--dark); color: var(--gold-light);
    font-size: 11px; font-weight: 700; padding: 3px 9px; border-radius: 6px; margin-bottom: 7px;
}
.type-option input:not(:checked) + .type-card .type-badge { background: var(--ink-4); color: #fff; }
.type-name { font-size: 14px; font-weight: 700; color: var(--dark); }
.type-desc { font-size: 11px; color: var(--ink-3); margin-top: 3px; }

/* ── Recap bloc ── */
.recap-bloc {
    display: none;
    background: var(--bg); border: 1px solid var(--border);
    border-radius: var(--radius-md); padding: 18px; margin-bottom: 14px;
    position: relative; overflow: hidden;
}
.recap-bloc::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
    background: linear-gradient(90deg, var(--dark), var(--mid), var(--gold));
}
.recap-title {
    font-size: 11px; font-weight: 700; color: var(--mid);
    text-transform: uppercase; letter-spacing: .6px; margin-bottom: 14px;
}
.recap-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px; margin-bottom: 16px; }
.recap-cell { background: var(--white); border-radius: var(--radius-sm); padding: 11px; border: 1px solid var(--border); }
.rc-label { font-size: 10px; color: var(--ink-3); margin-bottom: 4px; font-weight: 500; }
.rc-value { font-size: 13px; font-weight: 700; color: var(--dark); }
.rc-value.gold { color: var(--gold); }

/* ── Errors ── */
.error-list p { font-size: 12px; color: var(--red); margin-bottom: 3px; }

/* ── History ── */
.history-row {
    padding: 14px 0; border-bottom: 1px solid var(--border);
    display: flex; justify-content: space-between; align-items: flex-start;
}
.history-row:last-child { border-bottom: none; }
.hr-name { font-size: 14px; font-weight: 600; color: var(--dark); text-transform: capitalize; }
.hr-meta { font-size: 11px; color: var(--ink-3); margin-top: 3px; }
.hr-amount { font-size: 14px; font-weight: 700; color: var(--dark); text-align: right; }
.hr-total  { font-size: 11px; color: var(--ink-4); text-align: right; }

/* ── Ghost ── */
.btn-ghost {
    background: none; border: none; cursor: pointer; font-size: 13px;
    color: var(--ink-3); text-decoration: underline; padding: 8px;
    font-family: 'Outfit', sans-serif; transition: color .18s;
}
.btn-ghost:hover { color: var(--red); }

/* ── Footer ── */
.app-footer {
    text-align: center; padding: 24px 20px 10px;
    border-top: 1px solid var(--border); margin-top: 12px;
}
.footer-owner {
    font-size: 11px; font-weight: 600; color: var(--ink-4);
    letter-spacing: .6px; text-transform: uppercase; margin-bottom: 4px;
}
.footer-dev { font-size: 11px; color: var(--ink-4); }
.footer-dev a { color: var(--mid); text-decoration: none; font-weight: 600; }
.footer-dev a:hover { text-decoration: underline; }
</style>

<div class="page">

    <a href="{{ route('br.membre.dashboard') }}" class="back-link">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
        Retour
    </a>

    <div class="page-header">
        <h2>Mes Tontines</h2>
        <p>Gérez vos épargnes automatiques</p>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-error">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- Tontines actives --}}
    @foreach([$journaliereActive, $hebdoActive] as $t)
        @if($t)
        <div class="card">
            <div class="tontine-header">
                <span class="tag">{{ $t->type }}</span>
                <span class="tag tag-gray" style="text-transform:capitalize">{{ str_replace('_',' ',$t->statut) }}</span>
            </div>

            <div class="amount-big">
                <p class="label">Cotisé jusqu'ici</p>
                <div class="value-row">
                    <span class="value">{{ number_format($t->total_cotise,0,',',' ') }}</span>
                    <span class="currency">FCFA</span>
                </div>
                <p class="sub">Total à cotiser : {{ number_format($t->montant_reel_a_atteindre,0,',',' ') }} FCFA</p>
                <div class="rcv">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Vous recevrez : <strong>{{ number_format($t->objectif,0,',',' ') }} FCFA</strong>
                </div>
            </div>

            <div class="progress-wrap">
                <div class="progress-meta">
                    <span>{{ $t->nb_cotisations }} / {{ $t->nb_cotisations_total }} cotisations</span>
                    <strong>{{ $t->progression }}%</strong>
                </div>
                <div class="progress-track">
                    <div class="progress-fill" style="width:{{ min($t->progression,100) }}%"></div>
                </div>
            </div>

            <div class="info-grid">
                <div class="info-cell">
                    <p class="cl">Je cotise / {{ $t->type==='journaliere' ? 'jour' : 'semaine' }}</p>
                    <p class="cv">{{ number_format($t->montant_cotisation,0,',',' ') }} <span style="font-size:11px;font-weight:400;color:var(--ink-3)">FCFA</span></p>
                </div>
                <div class="info-cell">
                    <p class="cl">Je reçois à la fin</p>
                    <p class="cv green">{{ number_format($t->objectif,0,',',' ') }} <span style="font-size:11px;font-weight:400;color:var(--ink-3)">FCFA</span></p>
                </div>
            </div>

            @if($t->statut === 'active')
                @if($t->progression < 100)
                    <form action="{{ route('br.membre.tontine.cotiser', $t) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-primary">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
                            Cotiser maintenant
                        </button>
                    </form>
                @else
                    <a href="https://wa.me/{{ config('brfinal.whatsapp_admin') }}?text={{ urlencode('Bonjour, j\'ai atteint mon objectif de tontine '.$t->type.' (ID #'.$t->id.'). Je souhaite recevoir mes '.number_format($t->objectif,0,',',' ').' FCFA.') }}"
                       target="_blank" class="btn-whatsapp">
                        <svg width="17" height="17" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        Demander mon retrait
                    </a>
                @endif
            @elseif($t->statut === 'retrait_demande')
                <div class="status-banner pending">⏳ Retrait en attente de validation</div>
            @elseif($t->statut === 'retrait_valide')
                <div class="status-banner done">✅ Retrait validé — fonds reçus</div>
            @endif
        </div>
        @endif
    @endforeach

    {{-- Créer une tontine --}}
    @if(!$journaliereActive || !$hebdoActive)
    <div class="card">
        <p class="section-title">+ Nouvelle tontine</p>
        <p class="section-sub">Définissez votre objectif, nous calculons le reste.</p>

        <form action="{{ route('br.membre.tontine.creer') }}" method="POST">
            @csrf

            <label class="field-label">Type de tontine</label>
            <div class="type-selector">
                @if(!$journaliereActive)
                <label class="type-option">
                    <input type="radio" name="type" value="journaliere" checked>
                    <div class="type-card">
                        <div class="type-badge">J</div>
                        <p class="type-name">Journalière</p>
                        <p class="type-desc">Cotisation quotidienne</p>
                    </div>
                </label>
                @endif
                @if(!$hebdoActive)
                <label class="type-option">
                    <input type="radio" name="type" value="hebdomadaire" {{ $journaliereActive ? 'checked' : '' }}>
                    <div class="type-card">
                        <div class="type-badge">H</div>
                        <p class="type-name">Hebdomadaire</p>
                        <p class="type-desc">Cotisation par semaine</p>
                    </div>
                </label>
                @endif
            </div>

            <label class="field-label" for="tontine-objectif">Objectif souhaité (FCFA)</label>
            <input type="number" name="objectif" id="tontine-objectif" min="1200" step="1"
                   placeholder="Ex : 1 000 000" required class="input" value="{{ old('objectif') }}">

            <div class="recap-bloc" id="calcul-bloc">
                <p class="recap-title">📊 Récapitulatif automatique</p>
                <div class="recap-grid">
                    <div class="recap-cell">
                        <p class="rc-label">Vous recevez</p>
                        <p class="rc-value" id="recap-objectif">—</p>
                    </div>
                    <div class="recap-cell">
                        <p class="rc-label">À cotiser <span id="recap-taux" style="color:var(--gold)"></span></p>
                        <p class="rc-value gold" id="recap-reel">—</p>
                    </div>
                    <div class="recap-cell">
                        <p class="rc-label">Nb cotisations</p>
                        <p class="rc-value" id="recap-nb">—</p>
                    </div>
                </div>
                <label class="field-label">Cotisation par <span id="periode-label">jour</span> (FCFA)</label>
                <input type="number" name="montant_cotisation" id="montant-cotisation"
                       min="1200" step="1200" placeholder="Ex : 100 000" required class="input">
                <p style="font-size:11px;color:var(--ink-4);margin-top:-8px" id="multiple-hint">Multiple de 1 200 FCFA</p>
            </div>

            @if($errors->any())
                <div class="error-list" style="margin-bottom:10px">
                    @foreach($errors->all() as $error)
                        <p>• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <button type="submit" id="btn-creer" disabled class="btn-primary" style="margin-top:14px;opacity:.4;cursor:not-allowed">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Créer la tontine
            </button>
        </form>
    </div>
    @endif

    {{-- Historique --}}
    @if($historique->count())
    <div class="card">
        <p class="section-title" style="margin-bottom:14px">Historique</p>
        @foreach($historique as $t)
        <div class="history-row">
            <div>
                <p class="hr-name">{{ $t->type }}</p>
                <p class="hr-meta">{{ \Carbon\Carbon::parse($t->date_debut)->format('d/m/Y') }} · {{ str_replace('_',' ',$t->statut) }}</p>
            </div>
            <div>
                <p class="hr-amount">{{ number_format($t->total_cotise,0,',',' ') }} FCFA</p>
                <p class="hr-total">/ {{ number_format($t->objectif,0,',',' ') }} FCFA</p>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    @if(auth('brfinal')->user()->tontines()->whereIn('statut',['active','complete'])->count() > 1)
    <div style="text-align:center;margin-top:6px">
        <form action="{{ route('br.membre.tontine.retirer-tout') }}" method="POST"
              onsubmit="return confirm('Confirmer le retrait de toutes vos tontines ?')">
            @csrf
            <button type="submit" class="btn-ghost">Demander le retrait de toutes mes tontines</button>
        </form>
    </div>
    @endif

    <footer class="app-footer">
        <p class="footer-owner">Propriété du CFPAM GROUP</p>
        <p class="footer-dev">Développé par <a href="https://tfs237.com" target="_blank" rel="noopener noreferrer">TFS237</a></p>
    </footer>

</div>

@push('scripts')
<script>
(function(){
    const typeInputs    = document.querySelectorAll('input[name="type"]');
    const objectifInput = document.getElementById('tontine-objectif');
    const montantInput  = document.getElementById('montant-cotisation');
    const calculBloc    = document.getElementById('calcul-bloc');
    const btnCreer      = document.getElementById('btn-creer');
    const recapObjectif = document.getElementById('recap-objectif');
    const recapReel     = document.getElementById('recap-reel');
    const recapTaux     = document.getElementById('recap-taux');
    const recapNb       = document.getElementById('recap-nb');
    const periodeLabel  = document.getElementById('periode-label');
    const multipleHint  = document.getElementById('multiple-hint');

    function fmt(n){ return new Intl.NumberFormat('fr-FR').format(Math.round(n))+' FCFA'; }
    function getType(){ return document.querySelector('input[name="type"]:checked')?.value||'journaliere'; }
    function getStep(){ return getType()==='journaliere'?1200:6100; }
    function getTaux(){ return getType()==='journaliere'?0.20:0.10; }

    function updateType(){
        const step=getStep(),taux=getTaux()*100;
        periodeLabel.textContent=getType()==='journaliere'?'jour':'semaine';
        multipleHint.textContent='Multiple de '+step.toLocaleString('fr-FR')+' FCFA';
        if(montantInput){montantInput.step=step;montantInput.min=step;}
        recapTaux.textContent='(+'+taux+'%)';
        if(montantInput?.value&&parseInt(montantInput.value)%step!==0)montantInput.value='';
        recalcul();
    }
    function recalcul(){
        const objectif=parseFloat(objectifInput.value);
        const montant=parseFloat(montantInput?.value);
        const taux=getTaux();const step=getStep();
        if(!objectif||objectif<1200){calculBloc.style.display='none';setBtn(false);return;}
        const montantReel=(objectif*(1+taux))/2;
        calculBloc.style.display='block';
        recapObjectif.textContent=fmt(objectif);
        recapReel.textContent=fmt(montantReel);
        if(montant&&montant>=step&&montant%step===0){
            const nb=Math.ceil(montantReel/montant);
            recapNb.textContent=nb+' '+(getType()==='journaliere'?'jour(s)':'semaine(s)');
            setBtn(true);
        }else{recapNb.textContent='—';setBtn(false);}
    }
    function setBtn(on){
        btnCreer.disabled=!on;
        btnCreer.style.opacity=on?'1':'.4';
        btnCreer.style.cursor=on?'pointer':'not-allowed';
    }
    typeInputs.forEach(r=>r.addEventListener('change',updateType));
    objectifInput.addEventListener('input',recalcul);
    montantInput?.addEventListener('input',recalcul);
    updateType();
})();
</script>
@endpush
@endsection