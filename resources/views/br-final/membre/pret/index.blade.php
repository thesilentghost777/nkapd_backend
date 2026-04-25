@extends('br-final.layouts.app')
@section('title', 'Mes Prêts')

@push('styles')
<style>
    :root {
        --orange:       #F07C2A;
        --orange-light: #FEF0E6;
        --orange-dark:  #C95E14;
        --green:        #2D7A22;
        --red:          #C0302A;
        --bg:           #F4F3EF;
        --card:         #FFFFFF;
        --text:         #1A1A1A;
        --muted:        #888888;
        --border:       #EDECE8;
        --icon-bg:      #F5F4F0;
        --radius-lg:    18px;
        --radius-md:    12px;
        --radius-sm:    8px;
        --shadow:       0 2px 12px rgba(0,0,0,.06);
        --shadow-card:  0 1px 4px rgba(0,0,0,.04), 0 4px 16px rgba(0,0,0,.06);
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        background: var(--bg);
        font-family: 'DM Sans', 'Helvetica Neue', sans-serif;
        color: var(--text);
        -webkit-font-smoothing: antialiased;
    }

    /* ── Page wrapper ── */
    .page {
        max-width: 430px;
        margin: 0 auto;
        min-height: 100svh;
        padding: 0 0 90px;
        position: relative;
        background: var(--bg);
    }

    /* ── Top bar ── */
    .topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 20px 12px;
        background: var(--card);
        border-bottom: 1px solid var(--border);
        position: sticky;
        top: 0;
        z-index: 50;
    }
    .topbar-logo {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .topbar-avatar {
        width: 38px; height: 38px;
        border-radius: 50%;
        background: #2d2d2d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        color: #fff;
        font-weight: 700;
        overflow: hidden;
    }
    .topbar-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .topbar-title {
        font-family: 'Syne', sans-serif;
        font-size: 16px;
        font-weight: 700;
        letter-spacing: -.2px;
    }
    .topbar-bell {
        width: 38px; height: 38px;
        border-radius: 50%;
        background: var(--icon-bg);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        border: none;
        transition: background .15s;
    }
    .topbar-bell:hover { background: var(--border); }

    /* ── Inner padding ── */
    .inner { padding: 0 16px; }

    /* ── Section header ── */
    .section-header {
        padding: 22px 0 14px;
    }
    .section-header .back-link {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        color: var(--muted);
        text-decoration: none;
        margin-bottom: 12px;
        transition: color .15s;
    }
    .section-header .back-link:hover { color: var(--text); }
    .section-header h1 {
        font-family: 'Syne', sans-serif;
        font-size: 22px;
        font-weight: 800;
        letter-spacing: -.4px;
        line-height: 1.1;
    }
    .section-header p {
        font-size: 13px;
        color: var(--muted);
        margin-top: 4px;
        font-weight: 400;
    }

    /* ── Cards ── */
    .card {
        background: var(--card);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card);
        border: 1px solid var(--border);
    }

    /* ── Stat row: full-width statut + 2-col grid below ── */
    .stat-full {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 18px;
        background: var(--card);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card);
        border: 1px solid var(--border);
        margin-bottom: 10px;
    }
    .stat-full-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .stat-icon {
        width: 42px; height: 42px;
        border-radius: 12px;
        background: var(--icon-bg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }
    .stat-label {
        font-size: 11px;
        color: var(--muted);
        margin-bottom: 3px;
        font-weight: 500;
        letter-spacing: .2px;
    }
    .stat-value {
        font-family: 'Syne', sans-serif;
        font-size: 17px;
        font-weight: 700;
        line-height: 1.2;
    }
    .stat-dot {
        width: 9px; height: 9px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .stat-dot.red { background: var(--red); }
    .stat-dot.green { background: var(--green); }

    .stat-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-bottom: 20px;
    }
    .stat-cell {
        background: var(--card);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card);
        border: 1px solid var(--border);
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    /* ── Info banner ── */
    .info-banner {
        background: var(--orange-light);
        border-radius: var(--radius-md);
        padding: 14px 16px;
        font-size: 12px;
        color: #9A4510;
        line-height: 1.75;
        margin-bottom: 16px;
        border: 1px solid #F2D4BC;
    }
    .info-banner strong { color: #7A3308; }

    /* ── Restricted access block ── */
    .restricted {
        background: var(--card);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card);
        border: 1px solid var(--border);
        padding: 36px 22px 28px;
        text-align: center;
        margin-bottom: 20px;
    }
    .lock-wrap {
        width: 72px; height: 72px;
        border-radius: 50%;
        background: var(--icon-bg);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 28px;
    }
    .restricted h3 {
        font-family: 'Syne', sans-serif;
        font-size: 17px;
        font-weight: 700;
        margin-bottom: 8px;
    }
    .restricted p {
        font-size: 13px;
        color: var(--muted);
        line-height: 1.6;
        margin-bottom: 20px;
    }
    .badge-outlined {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: 1.5px solid var(--orange);
        border-radius: 20px;
        padding: 7px 16px;
        font-size: 12px;
        font-weight: 600;
        color: var(--orange);
        margin-bottom: 20px;
        letter-spacing: .4px;
    }

    /* ── Loan active detail grid ── */
    .loan-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        margin-bottom: 14px;
    }
    .loan-cell {
        background: var(--icon-bg);
        border-radius: var(--radius-sm);
        padding: 10px 12px;
    }
    .loan-cell-label {
        font-size: 10px;
        color: var(--muted);
        margin-bottom: 4px;
        font-weight: 500;
    }
    .loan-cell-value {
        font-size: 14px;
        font-weight: 600;
        line-height: 1.3;
    }

    /* ── Alerts ── */
    .alert {
        border-radius: var(--radius-sm);
        padding: 10px 14px;
        font-size: 12px;
        font-weight: 500;
        margin-bottom: 12px;
        line-height: 1.5;
    }
    .alert-warn { background: #FFFBE6; color: #8A6D00; border: 1px solid #F0DC80; }
    .alert-err  { background: #FFF0EF; color: #C0302A; border: 1px solid #F5BDB9; }
    .alert-ok   { background: #E8F5E9; color: #2D7A22; border: 1px solid #B2DDB5; }

    /* ── Buttons ── */
    .btn {
        display: block;
        width: 100%;
        text-align: center;
        padding: 14px;
        border-radius: 50px;
        font-size: 15px;
        font-weight: 700;
        letter-spacing: -.1px;
        border: none;
        cursor: pointer;
        transition: opacity .15s, transform .1s;
    }
    .btn:active { opacity: .85; transform: scale(.98); }
    .btn-orange {
        background: var(--orange);
        color: #fff;
    }
    .btn-orange:hover { background: var(--orange-dark); }

    /* ── Input ── */
    .field {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid var(--border);
        border-radius: var(--radius-md);
        font-size: 14px;
        background: var(--icon-bg);
        color: var(--text);
        outline: none;
        transition: border-color .2s;
        font-family: inherit;
    }
    .field:focus { border-color: var(--orange); background: #fff; }
    .field-label {
        display: block;
        font-size: 11px;
        font-weight: 600;
        color: var(--muted);
        margin-bottom: 6px;
        letter-spacing: .3px;
    }

    /* ── Simulation box ── */
    .sim-box {
        background: var(--orange-light);
        border: 1px solid #F2D4BC;
        border-radius: var(--radius-md);
        padding: 14px 16px;
        margin-bottom: 16px;
        display: none;
    }
    .sim-box.visible { display: block; }
    .sim-box-title {
        font-weight: 700;
        font-size: 13px;
        color: #9A4510;
        margin-bottom: 12px;
    }
    .sim-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }
    .sim-item-label { font-size: 10px; color: var(--muted); margin-bottom: 3px; }
    .sim-item-value { font-size: 13px; font-weight: 700; }

    /* ── Statut badges ── */
    .badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    .badge-green { background: #E8F5E9; color: var(--green); }
    .badge-red   { background: #FFF0EF; color: var(--red); }
    .badge-amber { background: #FFFBE6; color: #8A6D00; }

    /* ── Historique ── */
    .hist-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 0;
        border-bottom: 1px solid var(--border);
    }
    .hist-row:last-child { border-bottom: none; }

    /* ── Footer ── */
    .ssl-note {
        text-align: center;
        font-size: 11px;
        color: #bbb;
        margin-top: 24px;
        padding-bottom: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }

    /* ── Bottom nav ── */
    .bottom-nav {
        position: fixed;
        bottom: 0; left: 0; right: 0;
        height: 72px;
        background: var(--card);
        border-top: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-around;
        z-index: 100;
        box-shadow: 0 -4px 24px rgba(0,0,0,.06);
    }
    .nav-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        text-decoration: none;
        flex: 1;
        padding: 8px 0;
        transition: opacity .15s;
    }
    .nav-item svg { width: 22px; height: 22px; }
    .nav-item span {
        font-size: 10px;
        font-weight: 500;
        color: var(--muted);
    }
    .nav-item.active span { color: var(--orange); }
    .nav-item.active svg path,
    .nav-item.active svg rect,
    .nav-item.active svg circle { stroke: var(--orange); }
    .nav-item svg path, .nav-item svg rect, .nav-item svg circle {
        stroke: var(--muted);
        stroke-width: 1.8;
        fill: none;
        stroke-linecap: round;
        stroke-linejoin: round;
    }


     /* ─── FOOTER ─── */
  .app-footer {
    text-align: center;
    padding: 20px 20px 10px;
    border-top: 1px solid #EDE9E4;
    margin-top: 10px;
  }

  .footer-owner {
    font-size: 11px;
    font-weight: 600;
    color: var(--light);
    letter-spacing: 0.5px;
    text-transform: uppercase;
    margin-bottom: 4px;
  }

  .footer-dev {
    font-size: 11px;
    color: var(--light);
  }

  .footer-dev a {
    color: var(--brand);
    text-decoration: none;
    font-weight: 600;
  }

  .footer-dev a:hover {
    text-decoration: underline;
  }

  
    /* card section title */
    .card-section-title {
        font-family: 'Syne', sans-serif;
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 14px;
    }

    /* frais note */
    .frais-note {
        background: var(--icon-bg);
        border-radius: var(--radius-sm);
        padding: 9px 13px;
        font-size: 12px;
        color: #666;
        margin-bottom: 10px;
    }

    .mb-10 { margin-bottom: 10px; }
    .mb-16 { margin-bottom: 16px; }
    .mb-20 { margin-bottom: 20px; }
    .p-card { padding: 20px; }
    .form-row2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px; }
</style>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
@endpush

@section('content')
<div class="page">

    
    <div class="inner">

        {{-- ===== SECTION HEADER ===== --}}
        <div class="section-header">
            <a href="{{ route('br.membre.dashboard') }}" class="back-link">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                Retour
            </a>
            <h2 style="font-size: 32px;">TABLEAU DE BORD</h2>
            <p>Gestion des Prêts</p>
        </div>

        {{-- ===== STAT : STATUT ADHÉSION (full width) ===== --}}
        <div class="stat-full mb-10">
            <div class="stat-full-left">
                <div class="stat-icon">🛡️</div>
                <div>
                    <p class="stat-label">Statut Adhésion</p>
                    <p class="stat-value" style="color:{{ $user->estMembre() ? 'var(--green)' : 'var(--orange)' }}">
                        {{ $user->estMembre() ? 'Membre' : 'Non Membre' }}
                    </p>
                </div>
            </div>
            <div class="stat-dot {{ $user->estMembre() ? 'green' : 'red' }}"></div>
        </div>

        {{-- ===== STATS GRID : Parrainages + Plafond ===== --}}
        <div class="stat-grid">
            <div class="stat-cell">
                <div class="stat-icon">👥</div>
                <div>
                    <p class="stat-label">Parrainages Actifs</p>
                    <p class="stat-value">{{ str_pad($user->nb_filleuls_actifs, 2, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>
            <div class="stat-cell">
                <div class="stat-icon">💳</div>
                <div>
                    <p class="stat-label">Plafond Prêt</p>
                    <p class="stat-value" style="font-size:14px;color:var(--orange)">
                        {{ number_format($user->plafond_pret, 0, ',', ' ') }} FCFA
                    </p>
                </div>
            </div>
        </div>

        {{-- ===== ÉLIGIBILITÉ ===== --}}
        @if($user->estMembre() && $user->nb_filleuls_actifs >= 1)

            {{-- Info taux --}}
            <div class="info-banner mb-16">
                <strong>💡 Comment ça marche</strong><br>
                • <strong>Frais de dossier :</strong> 3% déduits au déblocage<br>
                • <strong>Pénalité active :</strong> 0,1%/jour + 2%/mois tant que le crédit est ouvert<br>
                • <strong>Après l'échéance :</strong> pénalité monte à <strong>1%/jour</strong> (+ 2%/mois inchangé)
            </div>

            {{-- ===== PRÊT ACTIF ===== --}}
            @if($pretActif)
            <div class="card p-card mb-20">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
                    <h2 class="card-section-title" style="margin:0">Prêt en cours</h2>
                    @php
                        $badgeClass = ['en_cours'=>'badge-green','en_retard'=>'badge-red','en_attente'=>'badge-amber','approuve'=>'badge-amber'][$pretActif->statut] ?? 'badge-amber';
                    @endphp
                    <span class="badge {{ $badgeClass }}">{{ ucfirst(str_replace('_', ' ', $pretActif->statut)) }}</span>
                </div>

                <div class="loan-grid">
                    <div class="loan-cell">
                        <p class="loan-cell-label">Montant accordé</p>
                        <p class="loan-cell-value">{{ number_format($pretActif->montant_accorde ?? $pretActif->montant_demande, 0, ',', ' ') }} FCFA</p>
                    </div>
                    <div class="loan-cell">
                        <p class="loan-cell-label">Montant net reçu</p>
                        <p class="loan-cell-value" style="color:var(--green)">
                            @if($pretActif->montant_net_verse)
                                {{ number_format($pretActif->montant_net_verse, 0, ',', ' ') }} FCFA
                            @else
                                <span style="color:#ccc">—</span>
                            @endif
                        </p>
                    </div>
                    <div class="loan-cell">
                        <p class="loan-cell-label">Total dû (capital + intérêt)</p>
                        <p class="loan-cell-value" style="color:var(--orange)">{{ number_format($pretActif->montant_total_du ?? 0, 0, ',', ' ') }} FCFA</p>
                    </div>
                    <div class="loan-cell">
                        <p class="loan-cell-label">Reste à payer</p>
                        <p class="loan-cell-value">{{ number_format($pretActif->reste_a_payer, 0, ',', ' ') }} FCFA</p>
                    </div>
                    <div class="loan-cell">
                        <p class="loan-cell-label">Durée choisie</p>
                        <p class="loan-cell-value">{{ $pretActif->duree_valeur }} {{ $pretActif->duree_unite }}</p>
                    </div>
                    <div class="loan-cell">
                        <p class="loan-cell-label">Échéance</p>
                        <p class="loan-cell-value">{{ $pretActif->date_echeance ? \Carbon\Carbon::parse($pretActif->date_echeance)->format('d/m/Y') : '—' }}</p>
                    </div>
                </div>

                @if($pretActif->frais_dossier > 0)
                <div class="frais-note mb-10">
                    📎 Frais de dossier prélevés : <strong>{{ number_format($pretActif->frais_dossier, 0, ',', ' ') }} FCFA</strong> (3%)
                </div>
                @endif

                @if($pretActif->penalites > 0)
                <div class="alert alert-err">
                    ⚠ Pénalités de retard : <strong>{{ number_format($pretActif->penalites, 0, ',', ' ') }} FCFA</strong>
                    @if($pretActif->en_retard)
                        · <span style="font-weight:700">Taux actuel : 1%/jour</span>
                    @endif
                </div>
                @endif

                @if(in_array($pretActif->statut, ['en_cours', 'en_retard']))
                <form action="{{ route('br.membre.pret.rembourser', $pretActif) }}" method="POST">
                    @csrf
                    <div class="mb-10">
                        <label class="field-label">Montant à rembourser (FCFA)</label>
                        <input type="number" name="montant" min="1000" max="{{ $pretActif->reste_a_payer }}"
                               placeholder="ex : 25 000" required class="field">
                    </div>
                    <button type="submit" class="btn btn-orange">💳 Payer maintenant</button>
                </form>

                @elseif($pretActif->statut === 'en_attente')
                <div class="alert alert-warn" style="text-align:center">
                    ⏳ Votre demande est en cours d'examen par l'administration.
                </div>
                @elseif($pretActif->statut === 'approuve')
                <div class="alert alert-ok" style="text-align:center">
                    ✅ Prêt approuvé — le virement sera effectué sous peu.
                </div>
                @endif
            </div>

            @else
            {{-- ===== FORMULAIRE DEMANDE ===== --}}
            <div class="card p-card mb-20">
                <h2 class="card-section-title">Faire une demande de prêt</h2>

                <form action="{{ route('br.membre.pret.demander') }}" method="POST" id="pretForm">
                    @csrf

                    <div class="mb-16">
                        <label class="field-label">
                            Montant souhaité (max : {{ number_format($user->plafond_pret, 0, ',', ' ') }} FCFA)
                        </label>
                        <input type="number" name="montant" id="montantInput"
                               min="10000" max="{{ $user->plafond_pret }}" step="1000"
                               placeholder="ex : 50 000" required
                               class="field" oninput="calculerSimulation()">
                    </div>

                    <div class="form-row2">
                        <div>
                            <label class="field-label">Durée</label>
                            <input type="number" name="duree_valeur" id="dureeValeur"
                                   min="1" max="365" placeholder="ex : 30" required
                                   class="field" oninput="calculerSimulation()">
                        </div>
                        <div>
                            <label class="field-label">Unité</label>
                            <select name="duree_unite" id="dureeUnite" class="field" onchange="calculerSimulation()">
                                <option value="jours">Jours</option>
                                <option value="mois">Mois</option>
                            </select>
                        </div>
                    </div>

                    <div id="simulation" class="sim-box">
                        <p class="sim-box-title">📊 Simulation de remboursement</p>
                        <div class="sim-grid">
                            <div>
                                <p class="sim-item-label">Capital + intérêt (10%) + assurance (6,5%)</p>
                                <p id="simTotal" class="sim-item-value" style="color:var(--orange)"></p>
                            </div>
                            <div>
                                <p class="sim-item-label">Frais de dossier (3%)</p>
                                <p id="simFrais" class="sim-item-value" style="color:#666"></p>
                            </div>
                            <div>
                                <p class="sim-item-label">Montant net que vous recevez</p>
                                <p id="simNet" class="sim-item-value" style="color:var(--green)"></p>
                            </div>
                            <div>
                                <p class="sim-item-label">Échéance estimée</p>
                                <p id="simEcheance" class="sim-item-value" style="color:#555"></p>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-orange">Envoyer la demande →</button>
                </form>
            </div>
            @endif

        @else
        {{-- ===== NON ÉLIGIBLE ===== --}}
        <div class="restricted">
            <div class="lock-wrap">🔒</div>
            <h3>Accès restreint aux prêts</h3>
            <p>Vous n'êtes pas encore éligible pour soumettre une demande de prêt dans le Business Room.</p>
            <div class="badge-outlined">
                🛡 ADHÉSION ANNUELLE REQUISE
            </div>
           

            <form action="{{ route('br.membre.adhesion') }}" method="POST" style="width:100%" id="adhesion-form">
    @csrf
    <button type="submit" class="btn btn-orange" id="adhesion-btn">
        <span id="btn-text">Payer l'adhésion pour devenir éligible</span>
        <span id="btn-spinner" style="display:none; align-items:center; justify-content:center;">
            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg" class="spinning">
                <circle cx="9" cy="9" r="7" fill="none" stroke="currentColor" stroke-width="2.5" stroke-dasharray="30" stroke-dashoffset="10" stroke-linecap="round"/>
            </svg>
        </span>
    </button>
</form>

<style>
    #adhesion-btn {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .spinning {
        animation: spin 0.8s linear infinite;
    }
</style>

<script>
    document.getElementById('adhesion-form').addEventListener('submit', function() {
        const btn = document.getElementById('adhesion-btn');
        const text = document.getElementById('btn-text');
        const spinner = document.getElementById('btn-spinner');

        btn.disabled = true;
        text.style.display = 'none';
        spinner.style.display = 'flex';

        // Stopper automatiquement après 10s
        setTimeout(function() {
            btn.disabled = false;
            text.style.display = 'inline';
            spinner.style.display = 'none';
        }, 10000);
    });
</script>

        </div>
        @endif

        {{-- ===== HISTORIQUE ===== --}}
        @if($user->estMembre() && $user->nb_filleuls_actifs >= 1 && $historique->count())
        <div class="card p-card mb-20">
            <h2 class="card-section-title">Historique des prêts</h2>
            @foreach($historique as $p)
            <div class="hist-row">
                <div>
                    <p style="font-size:14px;font-weight:600">{{ number_format($p->montant_accorde ?? $p->montant_demande, 0, ',', ' ') }} FCFA</p>
                    <p style="font-size:12px;color:var(--muted);margin-top:3px">
                        {{ $p->created_at->format('d/m/Y') }}
                        @if($p->duree_valeur) · {{ $p->duree_valeur }} {{ $p->duree_unite }} @endif
                    </p>
                    @if($p->motif_refus)
                        <p style="font-size:11px;color:var(--red);margin-top:2px">{{ $p->motif_refus }}</p>
                    @endif
                </div>
                <span class="badge {{ $p->statut === 'rembourse' ? 'badge-green' : 'badge-red' }}">{{ $p->statut }}</span>
            </div>
            @endforeach
        </div>
        @endif

        {{-- SSL --}}
        <div class="ssl-note">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#bbb" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            Transaction sécurisée par cryptage SSL
        </div>

    </div>{{-- /inner --}}

     {{-- Pied de page --}}
  <footer class="app-footer">
    <p class="footer-owner">Propriété du CFPAM GROUP</p>
    <p class="footer-dev">Développé par <a href="https://tfs237.com" target="_blank" rel="noopener noreferrer">TFS237</a></p>
  </footer>


   

</div>

<script>
function fmt(n) {
    return new Intl.NumberFormat('fr-FR').format(Math.round(n)) + ' FCFA';
}

function calculerSimulation() {
    const montant = parseFloat(document.getElementById('montantInput').value) || 0;
    const duree   = parseInt(document.getElementById('dureeValeur').value)    || 0;
    const unite   = document.getElementById('dureeUnite').value;
    const sim     = document.getElementById('simulation');

    if (montant < 10000 || duree < 1) { sim.classList.remove('visible'); return; }

    const interet   = montant * 0.10;
    const assurance = montant * 0.065;
    const total     = montant + interet + assurance;
    const frais     = montant * 0.03;
    const netRecu   = montant - frais;

    const today = new Date();
    let echeance = new Date(today);
    if (unite === 'mois') echeance.setMonth(echeance.getMonth() + duree);
    else                  echeance.setDate(echeance.getDate() + duree);
    const echeanceStr = echeance.toLocaleDateString('fr-FR', { day:'2-digit', month:'2-digit', year:'numeric' });

    document.getElementById('simTotal').textContent    = fmt(total);
    document.getElementById('simFrais').textContent    = fmt(frais);
    document.getElementById('simNet').textContent      = fmt(netRecu);
    document.getElementById('simEcheance').textContent = echeanceStr;
    sim.classList.add('visible');
}


</script>
@endsection