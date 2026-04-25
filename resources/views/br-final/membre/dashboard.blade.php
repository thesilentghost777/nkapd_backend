@extends('br-final.layouts.app')

@section('title', 'Dashboard')

@push('styles')
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --brand: #E8521A;
    --brand-light: #FEF0E8;
    --brand-dark: #C0401A;
    --bg: #F7F5F1;
    --card: #FFFFFF;
    --dark: #181716;
    --mid: #6B6560;
    --light: #B8B2AA;
    --green: #2D7A22;
    --green-bg: #EDF7EB;
    --red: #C0302A;
    --red-bg: #FCEAEA;
    --shadow: 0 2px 16px rgba(0,0,0,0.07);
    --radius: 18px;
    --radius-sm: 12px;
  }

  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--bg);
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: flex-start;
  }

  .phone {
    width: 100%;
    max-width: 430px;
    min-height: 100vh;
    background: var(--bg);
    position: relative;
    padding-bottom: 90px;
    overflow-x: hidden;
  }

  /* ─── HEADER ─── */
  .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px 16px;
    background: #fff;
    border-bottom: 1px solid #F0EDE8;
    position: sticky;
    top: 0;
    z-index: 100;
  }

  .logo-row {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: linear-gradient(135deg, #2d2d2d 0%, #555 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 15px;
    font-weight: 700;
    flex-shrink: 0;
  }

  .brand-name {
    font-family: 'Syne', sans-serif;
    font-size: 16px;
    font-weight: 700;
    color: var(--brand);
    letter-spacing: -0.2px;
  }

  .bell {
    width: 38px; height: 38px;
    border-radius: 50%;
    background: var(--bg);
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
  }

  .bell-dot {
    width: 7px;height: 7px;
    background: var(--brand);
    border-radius: 50%;
    position: absolute;
    top: 7px; right: 7px;
    border: 1.5px solid #fff;
  }

  /* ─── CONTENT ─── */
  .content { padding: 24px 20px 0; }

  .greeting-sub { font-size: 13px; color: var(--light); font-weight: 400; }
  .greeting-name {
    font-family: 'Syne', sans-serif;
    font-size: 28px;
    font-weight: 800;
    color: var(--dark);
    margin-top: 2px;
    letter-spacing: -0.5px;
  }

  /* ─── ALERT ─── */
  .alert-adhesion {
    margin-top: 20px;
    background: #fff;
    border-radius: var(--radius);
    border-left: 4px solid var(--brand);
    padding: 16px 18px;
    display: flex;
    align-items: flex-start;
    gap: 12px;
    box-shadow: var(--shadow);
  }

  .alert-icon {
    width: 36px; height: 36px;
    background: var(--brand-light);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .alert-body { flex: 1; }
  .alert-title {
    font-size: 13px;
    font-weight: 600;
    color: var(--brand);
    margin-bottom: 3px;
  }
  .alert-text { font-size: 12px; color: var(--mid); line-height: 1.5; }

  .btn-pay {
    display: inline-block;
    margin-top: 12px;
    background: var(--brand);
    color: #fff;
    border: none;
    border-radius: 30px;
    padding: 9px 20px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    transition: background 0.2s;
  }
  .btn-pay:hover { background: var(--brand-dark); }

  /* ─── ÉPARGNE CARD ─── */
  .epargne-card {
    margin-top: 20px;
    background: #fff;
    border-radius: var(--radius);
    padding: 20px 22px;
    box-shadow: var(--shadow);
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .epargne-label {
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.8px;
    color: var(--light);
    text-transform: uppercase;
    margin-bottom: 6px;
  }

  .epargne-value {
    font-family: 'Syne', sans-serif;
    font-size: 30px;
    font-weight: 800;
    color: var(--dark);
    letter-spacing: -1px;
  }

  .epargne-unit {
    font-size: 13px;
    font-weight: 500;
    color: var(--mid);
    margin-left: 4px;
  }

  .wallet-icon {
    width: 52px; height: 52px;
    background: var(--brand-light);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  /* ─── MINI STATS ─── */
  .mini-stats {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    margin-top: 14px;
  }

  .mini-card {
    background: #fff;
    border-radius: var(--radius-sm);
    padding: 16px;
    box-shadow: var(--shadow);
  }

  .mini-icon {
    width: 36px; height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 10px;
    font-size: 18px;
  }

  .mini-label {
    font-size: 10px;
    font-weight: 600;
    color: var(--light);
    text-transform: uppercase;
    letter-spacing: 0.7px;
    margin-bottom: 4px;
  }

  .mini-value {
    font-family: 'Syne', sans-serif;
    font-size: 22px;
    font-weight: 800;
    color: var(--dark);
    letter-spacing: -0.5px;
  }

  .mini-unit {
    font-size: 10px;
    color: var(--light);
    margin-left: 2px;
    font-weight: 400;
  }

  /* ─── SECTION TITLE ─── */
  .section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 26px 0 14px;
  }

  .section-title {
    font-family: 'Syne', sans-serif;
    font-size: 17px;
    font-weight: 700;
    color: var(--dark);
  }

  .section-link {
    font-size: 12px;
    color: var(--brand);
    text-decoration: none;
    font-weight: 500;
    background: var(--brand-light);
    padding: 5px 12px;
    border-radius: 20px;
  }

  /* ─── TONTINE CARD ─── */
  .tontine-card {
    background: #fff;
    border-radius: var(--radius);
    padding: 18px;
    box-shadow: var(--shadow);
    display: flex;
    align-items: center;
    gap: 14px;
  }

  .tontine-thumb {
    width: 48px; height: 48px;
    border-radius: 14px;
    background: linear-gradient(135deg, #1a1a2e, #16213e);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
  }

  .tontine-info { flex: 1; }
  .tontine-name {
    font-size: 15px;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 3px;
  }
  .tontine-sub {
    font-size: 12px;
    color: var(--light);
  }

  .tontine-pct {
    font-family: 'Syne', sans-serif;
    font-size: 18px;
    font-weight: 700;
    color: var(--brand);
  }

  .progress-wrap {
    margin-top: 10px;
    height: 5px;
    background: #F0EDE8;
    border-radius: 10px;
    overflow: hidden;
  }

  .progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--brand-dark), var(--brand));
    border-radius: 10px;
    transition: width 0.5s ease;
  }

  /* ─── PRÊT CARD ─── */
  .pret-card {
    background: #fff;
    border-radius: var(--radius);
    padding: 18px;
    box-shadow: var(--shadow);
  }

  .pret-row {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .pret-check {
    width: 40px; height: 40px;
    border-radius: 50%;
    background: var(--green-bg);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .pret-info { flex: 1; }
  .pret-name { font-size: 15px; font-weight: 600; color: var(--dark); }
  .pret-echo { font-size: 12px; color: var(--light); margin-top: 2px; }
  .pret-amount {
    font-family: 'Syne', sans-serif;
    font-size: 16px;
    font-weight: 700;
    color: var(--dark);
    white-space: nowrap;
  }
  .pret-unit { font-size: 11px; color: var(--light); font-weight: 400; }

  .pret-details-link {
    display: block;
    text-align: center;
    margin-top: 14px;
    padding-top: 14px;
    border-top: 1px solid #F0EDE8;
    font-size: 13px;
    color: var(--brand);
    text-decoration: none;
    font-weight: 500;
  }

  /* ─── PARRAINAGE ─── */
  .parrain-card {
    background: var(--dark);
    border-radius: var(--radius);
    padding: 20px;
    box-shadow: var(--shadow);
  }

  .parrain-title {
    font-family: 'Syne', sans-serif;
    font-size: 16px;
    font-weight: 700;
    color: #fff;
    margin-bottom: 6px;
  }

  .parrain-text {
    font-size: 12px;
    color: #9E9890;
    line-height: 1.5;
    margin-bottom: 16px;
  }

  .parrain-message {
    background: rgba(255,255,255,0.05);
    border-radius: 10px;
    padding: 12px;
    margin-bottom: 16px;
    font-size: 12px;
    color: #B8B2AA;
    line-height: 1.6;
  }

  .parrain-message p {
    margin-bottom: 8px;
  }

  .parrain-message p:last-child {
    margin-bottom: 0;
  }

  .ref-row {
    background: #2A2622;
    border-radius: 12px;
    padding: 10px 14px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
  }

  .ref-link {
    font-size: 12px;
    color: #9E9890;
    font-family: monospace;
    flex: 1;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    user-select: all;
    cursor: pointer;
  }

  .copy-btn {
    width: 36px; height: 36px;
    background: var(--brand);
    border: none;
    border-radius: 10px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: background 0.2s;
    position: relative;
  }
  .copy-btn:hover { background: var(--brand-dark); }
  
  .copy-btn.copied {
    background: #2D7A22;
  }

  .share-buttons {
    display: flex;
    gap: 10px;
    margin-top: 12px;
  }

  .share-btn {
    flex: 1;
    background: #2A2622;
    border: none;
    border-radius: 10px;
    padding: 10px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    color: #B8B2AA;
    font-size: 12px;
    font-weight: 500;
    transition: all 0.2s;
    font-family: 'DM Sans', sans-serif;
  }

  .share-btn:hover {
    background: #3A3632;
    color: #fff;
  }

  .share-btn svg {
    width: 16px;
    height: 16px;
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

  /* ─── BOTTOM NAV ─── */
  .bottom-nav {
    position: fixed;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100%;
    max-width: 430px;
    background: #fff;
    border-top: 1px solid #F0EDE8;
    display: flex;
    padding: 10px 0 20px;
    z-index: 200;
  }

  .nav-item {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    cursor: pointer;
    text-decoration: none;
  }

  .nav-icon { font-size: 20px; line-height: 1; }
  .nav-label { font-size: 10px; font-weight: 500; color: var(--light); }
  .nav-item.active .nav-label { color: var(--brand); }
  .nav-item.active .nav-icon { filter: none; }

  /* animations */
  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  .content > * {
    animation: fadeUp 0.35s ease both;
  }
  .content > *:nth-child(1) { animation-delay: 0.05s; }
  .content > *:nth-child(2) { animation-delay: 0.10s; }
  .content > *:nth-child(3) { animation-delay: 0.15s; }
  .content > *:nth-child(4) { animation-delay: 0.20s; }
  .content > *:nth-child(5) { animation-delay: 0.25s; }
  .content > *:nth-child(6) { animation-delay: 0.30s; }
  .content > *:nth-child(7) { animation-delay: 0.35s; }

  @media (max-width: 430px) {
    .ref-link {
      font-size: 10px;
    }
  }
</style>
@endpush

@section('content')
<div class="phone">

  
  <!-- CONTENT -->
  <div class="content">

    <!-- Greeting -->
    <div>
      <p class="greeting-sub">Bonjour,</p>
      <h1>{{ $user->prenom }}</h1>
    </div>

  {{-- Alerte frais d'adhésion (visible seulement si non payé) --}}
@if(!$stats['adhesion_payee'])
  <div class="alert-adhesion">
    <div class="alert-icon">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#E8521A" stroke-width="2.5" stroke-linecap="round">
        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
      </svg>
    </div>
    <div class="alert-body">
      <p class="alert-title">Frais d'Adhésion</p>
      <p class="alert-text">Régularisez votre frais d'adhésion de <strong>10 000 FCFA</strong> pour débloquer tous les avantages.</p>

      <form action="{{ route('br.membre.adhesion') }}" method="POST" id="adhesion-alert-form">
        @csrf
        <button type="submit" class="btn-pay" id="adhesion-alert-btn">
          <span id="alert-btn-text">Payer maintenant</span>
          <span id="alert-btn-spinner" style="display:none; align-items:center; justify-content:center;">
            <svg width="14" height="14" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg" class="spinning">
              <circle cx="9" cy="9" r="7" fill="none" stroke="currentColor" stroke-width="2.5" stroke-dasharray="30" stroke-dashoffset="10" stroke-linecap="round"/>
            </svg>
          </span>
        </button>
      </form>

    </div>
  </div>
@endif

<style>
  @keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
  }
  .spinning {
    animation: spin 0.8s linear infinite;
  }
  #adhesion-alert-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    cursor: pointer;
  }
</style>

<script>
  document.getElementById('adhesion-alert-form').addEventListener('submit', function() {
    const btn = document.getElementById('adhesion-alert-btn');
    const text = document.getElementById('alert-btn-text');
    const spinner = document.getElementById('alert-btn-spinner');

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

    {{-- Épargne totale --}}
    <div class="epargne-card">
      <div>
        <p class="epargne-label">Total Épargne</p>
        <h1>{{ number_format($stats['total_epargne'], 0, ',', ' ') }}<span class="epargne-unit">FCFA</span></h1>
      </div>
      <div class="wallet-icon">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#E8521A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="2" y="5" width="20" height="14" rx="3"/>
          <path d="M16 12h.01"/>
          <path d="M2 10h20"/>
        </svg>
      </div>
    </div>

    {{-- Mini stats --}}
    <div class="mini-stats">
      <div class="mini-card">
        <div class="mini-icon" style="background:#EEF4FF;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#3B82F6" stroke-width="2" stroke-linecap="round">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
          </svg>
        </div>
        <p class="mini-label">Tontines Actives</p>
        <h1>{{ str_pad($stats['tontines_actives'], 2, '0', STR_PAD_LEFT) }}</h1>
      </div>
      <div class="mini-card">
        <div class="mini-icon" style="background:#FEF0E8;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#E8521A" stroke-width="2" stroke-linecap="round">
            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
            <polyline points="17 6 23 6 23 12"/>
          </svg>
        </div>
        <p class="mini-label">Limite de Prêt</p>
        <h1>
          @php
            $plafond = $stats['plafond_pret'];
            if ($plafond >= 1000000) {
                echo rtrim(rtrim(number_format($plafond / 1000000, 1, ',', ''), '0'), ',') . 'M';
            } else {
                echo number_format($plafond, 0, ',', ' ') . ' FCFA';
            }
          @endphp
        </h1>
      </div>
    </div>

    {{-- Mes Tontines --}}
    @if($user->tontinesActives->isNotEmpty())
      <div>
        <div class="section-header">
          <h2 class="section-title">Mes Tontines</h2>
          <a href="#" class="section-link">+ Créer</a>
        </div>
        @foreach($user->tontinesActives as $tontine)
          <div class="tontine-card" style="margin-bottom:12px;">
            <div class="tontine-thumb">🏠</div>
            <div class="tontine-info">
              <p class="tontine-name">{{ $tontine->nom ?? 'Tontine' }}</p>
              <p class="tontine-sub">Prochain tour : {{ optional($tontine->prochain_tour)->format('d M') ?? 'À venir' }}</p>
              <div class="progress-wrap" style="margin-top:8px">
                <div class="progress-fill" style="width:{{ $tontine->pourcentage_progression ?? 0 }}%"></div>
              </div>
            </div>
            <div>
              <p class="tontine-pct">{{ $tontine->pourcentage_progression ?? 0 }}%</p>
            </div>
          </div>
        @endforeach
      </div>
    @endif

    {{-- Prêts en cours --}}
    @if($stats['pret_en_cours'])
      <div>
        <div class="section-header">
          <h2 class="section-title">Prêt en cours</h2>
        </div>
        <div class="pret-card">
          <div class="pret-row">
            <div class="pret-check">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7A22" stroke-width="2.5" stroke-linecap="round">
                <polyline points="20 6 9 17 4 12"/>
              </svg>
            </div>
            <div class="pret-info">
              <p class="pret-name">{{ $stats['pret_en_cours']->motif ?? 'Crédit' }}</p>
              <p class="pret-echo">
                Échéance : {{ optional($stats['pret_en_cours']->date_echeance)->format('d M') }}
              </p>
            </div>
            <div style="text-align:right">
              <p class="pret-amount">
                {{ number_format($stats['pret_en_cours']->montant_restant ?? 0, 0, ',', ' ') }}
                <span class="pret-unit">FCFA</span>
              </p>
            </div>
          </div>
          <a href="#" class="pret-details-link">Voir les détails →</a>
        </div>
      </div>
    @endif

    {{-- Parrainage --}}
    @php
      $lienParrainage = route('br.register', ['parrain' => $user->telephone]);
      $messageParrainage = "Rejoins Business Room et bénéficie d'un financement jusqu'à 5 millions de FCFA et d'un accompagnement personnalisé pour réaliser tous tes projets. Inscris-toi via ce lien : " . $lienParrainage;
      $messageWhatsApp = urlencode($messageParrainage);
    @endphp
    <div>
      <div class="section-header">
        <h2 class="section-title">Mon Parrainage</h2>
      </div>
     
      <div class="parrain-card">
        <p class="parrain-title">Invitez vos partenaires</p>
        
        <p class="parrain-text">
          Vous avez <strong>{{ $stats['filleuls'] ?? 0 }}</strong> filleul(s) actif(s).
          Invitez vos partenaires et gagnez des bonus sur chaque adhésion validée.
        </p>
        
        <div class="parrain-message">
          <p>Rejoins Business Room et bénéficie d'un financement jusqu'à 5 millions de FCFA 
          et d'un accompagnement personnalisé pour réaliser tous tes projets.</p>
          <p>Inscris-toi via ce lien :</p>
        </div>
        
        {{-- Le bouton copier copie l'intégralité du message de parrainage (texte + lien) --}}
        <div class="ref-row">
          <span class="ref-link">{{ $lienParrainage }}</span>
          <button class="copy-btn" onclick="copyFullMessage('{{ addslashes($messageParrainage) }}')" aria-label="Copier le message et le lien">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round">
              <rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
            </svg>
          </button>
        </div>

        <div class="share-buttons">
          {{-- Partage natif (Web Share API) — fonctionne sur Android, iOS et PC modern --}}
          <button class="share-btn" onclick="shareNatif('{{ addslashes($messageParrainage) }}', '{{ $lienParrainage }}')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/>
              <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>
            </svg>
            Partager
          </button>
        </div>
      </div>
    </div>

    <div style="height:10px"></div>
  </div>

  {{-- Pied de page --}}
  <footer class="app-footer">
    <p class="footer-owner">Propriété du CFPAM GROUP</p>
    <p class="footer-dev">Développé par <a href="https://tfs237.com" target="_blank" rel="noopener noreferrer">TFS237</a></p>
  </footer>

  {{-- Navigation inférieure --}}
  <nav class="bottom-nav">
    <a href="#" class="nav-item active">
      <span class="nav-icon">⊞</span>
      <span class="nav-label" style="color:var(--brand)">Dashboard</span>
    </a>
    <a href="{{ route('br.membre.tontine.index') }}" class="nav-item">
      <span class="nav-icon">👥</span>
      <span class="nav-label">Tontines</span>
    </a>
    <a href="{{ route('br.membre.pret.index') }}" class="nav-item">
      <span class="nav-icon">🏦</span>
      <span class="nav-label">Prêts</span>
    </a>
    <a href="{{ route('br.membre.business.index') }}" class="nav-item">
      <span class="nav-icon">🛒</span>
      <span class="nav-label">Marché</span>
    </a>
    <a href="{{ route('br.membre.cashbook.index') }}" class="nav-item">
      <span class="nav-icon">📒</span>
      <span class="nav-label">Cashbook</span>
    </a>
    <a href="{{ route('br.membre.assistance.index') }}" class="nav-item">
      <span class="nav-icon">❓</span>
      <span class="nav-label">Assistance</span>
    </a>
  </nav>

</div>
@endsection

@push('scripts')
<script>
  /**
   * Copie l'intégralité du message de parrainage (texte + lien) dans le presse-papiers.
   */
  function copyFullMessage(message) {
    if (navigator.clipboard && navigator.clipboard.writeText) {
      navigator.clipboard.writeText(message).then(() => {
        showCopyFeedback();
      }).catch(() => {
        fallbackCopy(message);
      });
    } else {
      fallbackCopy(message);
    }
  }

  function fallbackCopy(text) {
    const textArea = document.createElement('textarea');
    textArea.value = text;
    Object.assign(textArea.style, {
      position: 'fixed', top: '0', left: '0',
      width: '2em', height: '2em',
      padding: '0', border: 'none', outline: 'none',
      boxShadow: 'none', background: 'transparent', opacity: '0'
    });
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    try {
      const ok = document.execCommand('copy');
      if (ok) showCopyFeedback();
    } catch (err) {
      alert('Impossible de copier. Veuillez copier le message manuellement.');
    }
    document.body.removeChild(textArea);
  }

  function showCopyFeedback() {
    const btn = document.querySelector('.copy-btn');
    const original = btn.innerHTML;
    btn.classList.add('copied');
    btn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>';
    setTimeout(() => {
      btn.classList.remove('copied');
      btn.innerHTML = original;
    }, 2000);
  }

  /**
   * Partage natif via l'API Web Share (Android, iOS, PC).
   * Si le navigateur ne supporte pas l'API, repli sur la copie dans le presse-papiers.
   */
  function shareNatif(message, url) {
    if (navigator.share) {
      navigator.share({
        title: 'Business Room – Rejoins-nous !',
        text: message,
        url: url
      }).catch((err) => {
        // L'utilisateur a annulé ou une erreur est survenue — on ne fait rien
        if (err.name !== 'AbortError') {
          console.error('Erreur de partage :', err);
        }
      });
    } else {
      // Repli : copier le message dans le presse-papiers
      copyFullMessage(message);
      alert('Lien et message copiés ! Collez-les dans l\'application de votre choix.');
    }
  }
</script>
@endpush