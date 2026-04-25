@extends('br-final.layouts.app')
@section('title', 'Cahier de caisse')
@section('content')

<style>
/* ── Design System ──────────────────────────────── */
:root {
    --orange:       #F4521E;
    --orange-light: #FFF0EB;
    --green:        #22A45D;
    --green-light:  #E6F7EE;
    --red:          #E53935;
    --red-light:    #FDECEA;
    --ink:          #111111;
    --ink-2:        #444444;
    --ink-3:        #888888;
    --ink-4:        #BBBBBB;
    --border:       #EBEBEB;
    --bg:           #F6F5F2;
    --white:        #FFFFFF;
    --radius-sm:    10px;
    --radius-md:    16px;
    --radius-lg:    22px;
    --shadow-card:  0 4px 24px rgba(0,0,0,.07);
}
.page { max-width: 430px; margin: 0 auto; padding: 0 16px 100px; }

/* Back */
.back-link {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 13px; color: var(--ink-3); text-decoration: none;
    padding: 12px 0 4px;
}
.back-link:hover { color: var(--orange); }

/* Top bar */
.top-bar {
    display: flex; justify-content: space-between; align-items: flex-start;
    padding: 12px 0 20px; flex-wrap: wrap; gap: 10px;
}
.top-bar h1 { font-family: 'Syne', sans-serif; font-size: 26px; font-weight: 800; letter-spacing: -.5px; }
.top-bar .month { font-size: 13px; color: var(--orange); font-weight: 600; margin-top: 3px; }
.top-bar-actions { display: flex; gap: 8px; align-items: center; }

/* Buttons */
.btn-primary {
    display: inline-flex; align-items: center; justify-content: center; gap: 6px;
    padding: 11px 18px; background: var(--orange); color: #fff;
    font-size: 13px; font-weight: 600; border: none;
    border-radius: var(--radius-md); cursor: pointer; text-decoration: none;
    box-shadow: 0 4px 14px rgba(244,82,30,.3);
    transition: background .2s, box-shadow .2s, transform .1s;
    font-family: inherit;
}
.btn-primary:hover  { background: #e03e0a; }
.btn-primary:active { transform: scale(.98); }

.btn-secondary {
    display: inline-flex; align-items: center; justify-content: center; gap: 6px;
    padding: 11px 18px; background: var(--white); color: var(--ink-2);
    font-size: 13px; font-weight: 500; border: 1.5px solid var(--border);
    border-radius: var(--radius-md); cursor: pointer; text-decoration: none;
    transition: border-color .2s; font-family: inherit;
}
.btn-secondary:hover { border-color: var(--ink-3); }

/* Card */
.card {
    background: var(--white);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-card);
    padding: 20px;
    margin-bottom: 14px;
    border: 1px solid rgba(0,0,0,.04);
}

/* KPI grid */
.kpi-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; margin-bottom: 16px; }
.kpi-cell { background: var(--white); border-radius: var(--radius-lg); box-shadow: var(--shadow-card); padding: 16px; border: 1px solid rgba(0,0,0,.04); }
.kpi-cell .kpi-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 10px; }
.kpi-cell .kpi-icon.green-bg { background: var(--green-light); }
.kpi-cell .kpi-icon.red-bg   { background: var(--red-light); }
.kpi-cell .kpi-label { font-size: 11px; color: var(--ink-3); margin-bottom: 4px; }
.kpi-cell .kpi-value { font-family: 'Syne', sans-serif; font-size: 20px; font-weight: 800; line-height: 1; }
.kpi-cell .kpi-value.green { color: var(--green); }
.kpi-cell .kpi-value.red   { color: var(--red); }
.kpi-cell .kpi-currency { font-size: 10px; color: var(--ink-4); margin-top: 3px; }

/* Solde Net card (orange fill) */
.solde-card {
    background: var(--orange);
    border-radius: var(--radius-lg);
    padding: 20px; margin-bottom: 14px;
    position: relative; overflow: hidden;
}
.solde-card::before {
    content: ''; position: absolute; top: -30px; right: -30px;
    width: 120px; height: 120px;
    background: rgba(255,255,255,.1); border-radius: 50%;
}
.solde-card::after {
    content: ''; position: absolute; bottom: -40px; right: 20px;
    width: 90px; height: 90px;
    background: rgba(255,255,255,.06); border-radius: 50%;
}
.solde-card .sc-badge {
    display: inline-flex; align-items: center; gap: 4px;
    background: rgba(255,255,255,.2); color: #fff;
    font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 20px;
    margin-bottom: 10px;
}
.solde-card .sc-label { font-size: 13px; color: rgba(255,255,255,.8); margin-bottom: 4px; }
.solde-card .sc-value { font-family: 'Syne', sans-serif; font-size: 34px; font-weight: 800; color: #fff; }
.solde-card .sc-currency { font-size: 16px; font-weight: 600; color: rgba(255,255,255,.8); margin-left: 4px; }

/* Section header */
.section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; }
.section-title { font-family: 'Syne', sans-serif; font-size: 17px; font-weight: 700; }
.section-link { font-size: 13px; color: var(--orange); font-weight: 500; text-decoration: none; }

/* Form */
.field-label { display: block; font-size: 12px; font-weight: 600; color: var(--ink-2); margin-bottom: 7px; }
.input {
    width: 100%; padding: 13px 14px;
    border: 1.5px solid var(--border); border-radius: var(--radius-sm);
    font-size: 15px; color: var(--ink); background: var(--white);
    outline: none; transition: border-color .2s; margin-bottom: 12px; font-family: inherit;
}
.input:focus { border-color: var(--orange); }

/* Toggle type (Entrée / Sortie) */
.type-toggle { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 12px; }
.type-toggle label { position: relative; cursor: pointer; }
.type-toggle input { position: absolute; opacity: 0; pointer-events: none; }
.toggle-btn {
    display: flex; align-items: center; justify-content: center; gap: 6px;
    padding: 12px; border-radius: var(--radius-sm); font-size: 14px; font-weight: 600;
    border: 2px solid var(--border); transition: all .2s; background: var(--white);
    color: var(--ink-3);
}
.type-toggle .entree input:checked + .toggle-btn { background: var(--green-light); border-color: var(--green); color: var(--green); }
.type-toggle .sortie input:checked + .toggle-btn { background: var(--red-light);   border-color: var(--red);   color: var(--red); }

/* Category select */
select.input { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23888' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 36px; }

/* Submit full */
.btn-submit {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%; padding: 15px;
    background: var(--orange); color: #fff; font-size: 15px; font-weight: 600;
    border: none; border-radius: var(--radius-md); cursor: pointer;
    box-shadow: 0 4px 14px rgba(244,82,30,.3);
    transition: background .2s, transform .1s; font-family: inherit;
}
.btn-submit:hover  { background: #e03e0a; }
.btn-submit:active { transform: scale(.98); }

/* Transaction rows */
.tx-table { width: 100%; border-collapse: collapse; }
.tx-header th { font-size: 11px; font-weight: 700; color: var(--ink-3); text-align: left; padding: 0 0 10px; text-transform: uppercase; letter-spacing: .4px; }
.tx-row td { padding: 12px 0; border-top: 1px solid var(--border); vertical-align: middle; }
.tx-row:first-child td { border-top: none; }

.tx-dot { width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.tx-dot.in  { background: var(--green-light); }
.tx-dot.out { background: var(--red-light); }
.tx-dot svg { width: 14px; height: 14px; }

.tx-name { font-size: 14px; font-weight: 600; color: var(--ink); }
.tx-meta { font-size: 11px; color: var(--ink-3); margin-top: 2px; }
.tx-cat  { display: inline-block; background: var(--bg); border-radius: 6px; padding: 2px 7px; font-size: 10px; font-weight: 600; color: var(--ink-3); }
.tx-amount { font-size: 14px; font-weight: 700; white-space: nowrap; padding-left: 12px; }
.tx-amount.in  { color: var(--green); }
.tx-amount.out { color: var(--red); }

.empty-state { text-align: center; padding: 28px 0; color: var(--ink-4); font-size: 13px; }

/* Previous cashbooks */
.cb-chips { display: flex; flex-wrap: wrap; gap: 8px; }
.cb-chip {
    padding: 8px 14px; border: 1.5px solid var(--border);
    border-radius: 20px; font-size: 13px; color: var(--ink-2); text-decoration: none;
    transition: border-color .2s, color .2s;
}
.cb-chip:hover { border-color: var(--orange); color: var(--orange); }
</style>

<div class="page">

    <a href="{{ route('br.membre.dashboard') }}" class="back-link">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
        Retour
    </a>

    <div class="top-bar">
        <div>
            <h2 style="font-size: 32px;">Cahier de caisse</h2>
            <p class="month">{{ $current->libelle_mois }}</p>
        </div>
        <div class="top-bar-actions">
            @if(!$current->valide)
            <form action="{{ route('br.membre.cashbook.valider', $current) }}" method="POST"
                  onsubmit="return confirm('Valider définitivement ce cahier ?')" style="margin:0">
                @csrf
                <button type="submit" class="btn-secondary">✓ Valider</button>
            </form>
            @endif
            <a href="{{ route('br.membre.cashbook.pdf', $current) }}" class="btn-primary">⬇ PDF</a>
        </div>
    </div>

    {{-- KPI Row: Entrées + Sorties --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:14px">
        <div class="kpi-cell">
            <div class="kpi-icon green-bg">
                <svg width="16" height="16" fill="none" stroke="#22A45D" stroke-width="2.5" viewBox="0 0 24 24"><path d="M23 6l-9.5 9.5-5-5L1 18"/><path d="M17 6h6v6"/></svg>
            </div>
            <p class="kpi-label">Entrées</p>
            <p class="kpi-value green">{{ number_format($current->total_entrees??0,0,',',' ') }}</p>
            <p class="kpi-currency">FCFA</p>
        </div>
        <div class="kpi-cell">
            <div class="kpi-icon red-bg">
                <svg width="16" height="16" fill="none" stroke="#E53935" stroke-width="2.5" viewBox="0 0 24 24"><path d="M23 18l-9.5-9.5-5 5L1 6"/><path d="M17 18h6v-6"/></svg>
            </div>
            <p class="kpi-label">Sorties</p>
            <p class="kpi-value red">{{ number_format($current->total_sorties??0,0,',',' ') }}</p>
            <p class="kpi-currency">FCFA</p>
        </div>
    </div>

    {{-- Solde Net (orange card) --}}
    <div class="solde-card">
        @php $solde = $current->solde ?? 0; @endphp
        @if($current->valide)
            <div class="sc-badge">✓ Validé</div>
        @elseif($solde >= 0)
            <div class="sc-badge">↑ +{{ number_format(abs($solde),0,',',' ') }}</div>
        @else
            <div class="sc-badge" style="background:rgba(0,0,0,.2)">↓ Déficit</div>
        @endif
        <p class="sc-label">Solde net</p>
        <div>
            <span class="sc-value">{{ number_format($solde,0,',',' ') }}</span>
            <span class="sc-currency">FCFA</span>
        </div>
    </div>

    {{-- Ajouter une ligne --}}
    @if(!$current->valide)
    <div class="card">
        <div class="section-header"><p class="section-title">Ajouter une ligne</p></div>

        <form action="{{ route('br.membre.cashbook.store') }}" method="POST">
            @csrf
            <input type="hidden" name="date" value="{{ date('Y-m-d') }}">

            <label class="field-label">Libellé</label>
            <input type="text" name="libelle" required placeholder="ex: Vente de stock" class="input">

            <label class="field-label">Type</label>
            <div class="type-toggle" style="margin-bottom:12px">
                <label class="entree">
                    <input type="radio" name="type" value="entree" checked>
                    <div class="toggle-btn">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
                        Entrée
                    </div>
                </label>
                <label class="sortie">
                    <input type="radio" name="type" value="sortie">
                    <div class="toggle-btn">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
                        Sortie
                    </div>
                </label>
            </div>

            <label class="field-label">Montant (FCFA)</label>
            <input type="number" name="montant" min="1" required placeholder="0" class="input">

            <label class="field-label">Catégorie</label>
            <input type="text" name="categorie" placeholder="Ex: Vente, Achat..." class="input">

            <button type="submit" class="btn-submit">
                Enregistrer l'opération
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </button>
        </form>
    </div>
    @endif

    {{-- Transactions --}}
    <div class="card">
        <div class="section-header">
            <p class="section-title">Transactions du mois</p>
        </div>
        @forelse($entries as $e)
        <div style="display:flex;align-items:center;gap:12px;padding:11px 0;border-top:1px solid var(--border)">
            <div class="tx-dot {{ $e->type==='entree'?'in':'out' }}">
                @if($e->type==='entree')
                    <svg fill="none" stroke="#22A45D" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
                @else
                    <svg fill="none" stroke="#E53935" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
                @endif
            </div>
            <div style="flex:1;min-width:0">
                <p class="tx-name" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $e->libelle }}</p>
                <p class="tx-meta">
                    {{ \Carbon\Carbon::parse($e->date)->format('d/m') }}
                    @if($e->categorie) · <span class="tx-cat">{{ $e->categorie }}</span>@endif
                </p>
            </div>
            <p class="tx-amount {{ $e->type==='entree'?'in':'out' }}">
                {{ $e->type==='entree'?'+':'-' }}{{ number_format($e->montant,0,',',' ') }}
            </p>
        </div>
        @empty
            <p class="empty-state">Aucune transaction ce mois</p>
        @endforelse
    </div>

    {{-- Cahiers précédents --}}
    @if($cashbooks->count() > 1)
    <div class="card">
        <p class="section-title" style="margin-bottom:12px">Cahiers précédents</p>
        <div class="cb-chips">
            @foreach($cashbooks as $cb)
                @if($cb->id !== $current->id)
                <a href="{{ route('br.membre.cashbook.show', $cb) }}" class="cb-chip">
                    {{ $cb->libelle_mois }}{{ $cb->valide?' ✓':'' }}
                </a>
                @endif
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection