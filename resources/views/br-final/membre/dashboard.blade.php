@extends('br-final.layouts.app')
@section('title', 'Dashboard')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800;900&display=swap');

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --green-dark:  #1B4332;
  --green-mid:   #2D6A4F;
  --green-light: #D8F3DC;
  --green-pale:  #F0FAF3;
  --gold:        #D4A017;
  --gold-light:  #FFF8E1;
  --white:       #FFFFFF;
  --bg:          #F2F6F3;
  --dark:        #111827;
  --mid:         #4B5563;
  --light:       #9CA3AF;
  --border:      #E5E7EB;
  --red:         #DC2626;
  --red-bg:      #FEF2F2;
  --shadow:      0 2px 16px rgba(0,0,0,0.06);
  --radius:      18px;
  --radius-sm:   12px;
}

body {
  font-family: 'Manrope', sans-serif;
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

/* ── HEADER ── */
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 18px 20px 14px;
  background: var(--white);
  border-bottom: 1px solid var(--border);
  position: sticky;
  top: 0;
  z-index: 100;
}

.header-left { display: flex; align-items: center; gap: 10px; }

.avatar {
  width: 38px; height: 38px;
  border-radius: 50%;
  background: var(--green-dark);
  display: flex; align-items: center; justify-content: center;
  color: var(--gold);
  font-size: 15px;
  font-weight: 800;
  flex-shrink: 0;
}

.header-brand { line-height: 1.15; }
.header-brand .name { font-size: 13px; font-weight: 900; color: var(--green-dark); }
.header-brand .sub  { font-size: 9px; font-weight: 700; color: var(--gold); letter-spacing: 0.1em; text-transform: uppercase; }

.bell {
  width: 36px; height: 36px;
  border-radius: 50%;
  background: var(--bg);
  border: 1.5px solid var(--border);
  cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  position: relative;
  color: var(--mid);
}
.bell-dot {
  width: 7px; height: 7px;
  background: var(--gold);
  border-radius: 50%;
  position: absolute;
  top: 6px; right: 6px;
  border: 1.5px solid var(--white);
}

/* ── CONTENT ── */
.content { padding: 22px 18px 0; }

/* ── GREETING ── */
.greeting-sub  { font-size: 12px; color: var(--light); font-weight: 500; }
.greeting-name {
  font-size: 26px;
  font-weight: 900;
  color: var(--dark);
  margin-top: 2px;
  letter-spacing: -0.4px;
}

/* ── ALERT ADHÉSION ── */
.alert-adhesion {
  margin-top: 18px;
  background: var(--white);
  border-radius: var(--radius);
  border-left: 4px solid var(--gold);
  padding: 14px 16px;
  display: flex;
  align-items: flex-start;
  gap: 12px;
  box-shadow: var(--shadow);
}
.alert-icon {
  width: 34px; height: 34px;
  background: var(--gold-light);
  border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.alert-body { flex: 1; }
.alert-title  { font-size: 12px; font-weight: 700; color: var(--gold); margin-bottom: 3px; }
.alert-text   { font-size: 11px; color: var(--mid); line-height: 1.55; }
.btn-pay {
  display: inline-flex; align-items: center; gap: 6px;
  margin-top: 10px;
  background: var(--green-dark);
  color: var(--white);
  border: none;
  border-radius: 50px;
  padding: 9px 18px;
  font-size: 12px; font-weight: 700;
  cursor: pointer;
  font-family: 'Manrope', sans-serif;
  transition: background 0.2s;
}
.btn-pay:hover { background: var(--green-mid); }

/* ── ÉPARGNE CARD ── */
.epargne-card {
  margin-top: 18px;
  background: var(--green-dark);
  border-radius: var(--radius);
  padding: 22px 20px;
  box-shadow: 0 4px 20px rgba(27,67,50,0.25);
  display: flex;
  justify-content: space-between;
  align-items: center;
  position: relative;
  overflow: hidden;
}
.epargne-card::before {
  content: '';
  position: absolute;
  top: -40px; right: -40px;
  width: 140px; height: 140px;
  border-radius: 50%;
  background: rgba(255,255,255,0.05);
}
.epargne-card::after {
  content: '';
  position: absolute;
  bottom: -20px; left: -20px;
  width: 80px; height: 80px;
  border-radius: 50%;
  background: rgba(212,160,23,0.1);
}
.epargne-label {
  font-size: 10px; font-weight: 700;
  letter-spacing: 0.1em;
  color: rgba(255,255,255,0.55);
  text-transform: uppercase;
  margin-bottom: 8px;
}
.epargne-value {
  font-size: 30px; font-weight: 900;
  color: var(--white);
  letter-spacing: -1px;
  line-height: 1;
}
.epargne-unit { font-size: 13px; font-weight: 500; color: rgba(255,255,255,0.6); margin-left: 4px; }

.wallet-icon {
  width: 50px; height: 50px;
  background: rgba(255,255,255,0.1);
  border-radius: 14px;
  border: 1px solid rgba(255,255,255,0.15);
  display: flex; align-items: center; justify-content: center;
  position: relative; z-index: 1;
}

/* ── MINI STATS ── */
.mini-stats {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 10px;
  margin-top: 12px;
}
.mini-card {
  background: var(--white);
  border-radius: var(--radius-sm);
  padding: 16px;
  box-shadow: var(--shadow);
}
.mini-icon {
  width: 34px; height: 34px;
  border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 10px;
}
.mini-label {
  font-size: 10px; font-weight: 600;
  color: var(--light);
  text-transform: uppercase;
  letter-spacing: 0.07em;
  margin-bottom: 4px;
}
.mini-value {
  font-size: 22px; font-weight: 900;
  color: var(--dark);
  letter-spacing: -0.5px;
}
.mini-unit { font-size: 10px; color: var(--light); margin-left: 2px; font-weight: 400; }

/* ── SECTION HEADER ── */
.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin: 24px 0 12px;
}
.section-title { font-size: 16px; font-weight: 900; color: var(--dark); }
.section-link {
  font-size: 11px;
  color: var(--green-mid);
  text-decoration: none;
  font-weight: 700;
  background: var(--green-pale);
  padding: 5px 12px;
  border-radius: 50px;
  border: 1px solid rgba(45,106,79,0.15);
}

/* ── TONTINE CARD ── */
.tontine-card {
  background: var(--white);
  border-radius: var(--radius);
  padding: 16px;
  box-shadow: var(--shadow);
  display: flex;
  align-items: center;
  gap: 12px;
}
.tontine-thumb {
  width: 46px; height: 46px;
  border-radius: 13px;
  background: var(--green-pale);
  border: 1px solid rgba(45,106,79,0.12);
  display: flex; align-items: center; justify-content: center;
  font-size: 20px; flex-shrink: 0;
}
.tontine-info { flex: 1; }
.tontine-name { font-size: 14px; font-weight: 700; color: var(--dark); margin-bottom: 2px; }
.tontine-sub  { font-size: 11px; color: var(--light); font-weight: 500; }
.tontine-pct  { font-size: 16px; font-weight: 900; color: var(--green-mid); }
.progress-wrap { margin-top: 8px; height: 5px; background: var(--border); border-radius: 10px; overflow: hidden; }
.progress-fill { height: 100%; background: linear-gradient(90deg, var(--green-dark), var(--green-mid)); border-radius: 10px; transition: width 0.5s ease; }

/* ── PRÊT CARD ── */
.pret-card { background: var(--white); border-radius: var(--radius); padding: 16px; box-shadow: var(--shadow); }
.pret-row  { display: flex; align-items: center; gap: 12px; }
.pret-check {
  width: 40px; height: 40px;
  border-radius: 50%;
  background: var(--green-pale);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
  border: 1px solid rgba(45,106,79,0.15);
}
.pret-info { flex: 1; }
.pret-name  { font-size: 14px; font-weight: 700; color: var(--dark); }
.pret-echo  { font-size: 11px; color: var(--light); margin-top: 2px; font-weight: 500; }
.pret-amount { font-size: 15px; font-weight: 900; color: var(--dark); white-space: nowrap; }
.pret-unit   { font-size: 10px; color: var(--light); font-weight: 400; }
.pret-details-link {
  display: block; text-align: center;
  margin-top: 12px; padding-top: 12px;
  border-top: 1px solid var(--border);
  font-size: 12px; color: var(--green-mid);
  text-decoration: none; font-weight: 700;
}

/* ── PARRAINAGE ── */
.parrain-card {
  background: var(--green-dark);
  border-radius: var(--radius);
  padding: 20px;
  box-shadow: var(--shadow);
  position: relative;
  overflow: hidden;
}
.parrain-card::before {
  content: ''; position: absolute;
  top: -50px; right: -50px;
  width: 160px; height: 160px;
  border-radius: 50%;
  background: rgba(255,255,255,0.04);
}
.parrain-title { font-size: 15px; font-weight: 900; color: var(--white); margin-bottom: 6px; }
.parrain-text  { font-size: 11px; color: rgba(255,255,255,0.55); line-height: 1.6; margin-bottom: 14px; }
.parrain-text strong { color: var(--gold); font-weight: 800; }
.parrain-message {
  background: rgba(255,255,255,0.06);
  border-radius: 10px;
  padding: 12px;
  margin-bottom: 14px;
  font-size: 11px;
  color: rgba(255,255,255,0.55);
  line-height: 1.65;
  border: 1px solid rgba(255,255,255,0.08);
}
.parrain-message p { margin-bottom: 6px; }
.parrain-message p:last-child { margin-bottom: 0; }

.ref-row {
  background: rgba(0,0,0,0.2);
  border-radius: 12px;
  padding: 10px 12px;
  display: flex; align-items: center;
  justify-content: space-between; gap: 10px;
  border: 1px solid rgba(255,255,255,0.08);
}
.ref-link {
  font-size: 11px; color: rgba(255,255,255,0.5);
  font-family: monospace; flex: 1;
  overflow: hidden; text-overflow: ellipsis;
  white-space: nowrap; user-select: all; cursor: pointer;
}
.copy-btn {
  width: 34px; height: 34px;
  background: var(--green-mid);
  border: none; border-radius: 9px;
  cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
  transition: background 0.2s;
}
.copy-btn:hover { background: var(--gold); }
.copy-btn.copied { background: #16a34a; }

.share-buttons { display: flex; gap: 10px; margin-top: 10px; }
.share-btn {
  flex: 1;
  background: rgba(255,255,255,0.07);
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: 10px; padding: 10px;
  cursor: pointer;
  display: flex; align-items: center; justify-content: center; gap: 6px;
  color: rgba(255,255,255,0.6);
  font-size: 11px; font-weight: 600;
  transition: all 0.2s;
  font-family: 'Manrope', sans-serif;
}
.share-btn:hover { background: rgba(255,255,255,0.12); color: var(--white); }
.share-btn svg { width: 15px; height: 15px; }

/* ── FOOTER ── */
.app-footer {
  text-align: center;
  padding: 20px 20px 10px;
  border-top: 1px solid var(--border);
  margin-top: 10px;
}
.footer-owner { font-size: 10px; font-weight: 700; color: var(--light); letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 3px; }
.footer-dev   { font-size: 11px; color: var(--light); }
.footer-dev a { color: var(--green-mid); text-decoration: none; font-weight: 700; }
.footer-dev a:hover { text-decoration: underline; }

/* ── BOTTOM NAV ── */
.bottom-nav {
  position: fixed; bottom: 0;
  left: 50%; transform: translateX(-50%);
  width: 100%; max-width: 430px;
  background: var(--white);
  border-top: 1px solid var(--border);
  display: flex;
  padding: 8px 0 calc(8px + env(safe-area-inset-bottom));
  z-index: 200;
}
.nav-item {
  flex: 1;
  display: flex; flex-direction: column; align-items: center; gap: 3px;
  cursor: pointer; text-decoration: none;
  color: var(--light);
  font-size: 9px; font-weight: 600;
  letter-spacing: 0.03em;
  padding: 4px 0;
  position: relative;
}
.nav-item.active { color: var(--green-dark); }
.nav-item.active::after {
  content: '';
  position: absolute; bottom: -8px;
  width: 4px; height: 4px;
  background: var(--green-dark);
  border-radius: 50%;
}
.nav-item svg { width: 21px; height: 21px; }

/* ── ANIMATIONS ── */
@keyframes fadeUp {
  from { opacity: 0; transform: translateY(14px); }
  to   { opacity: 1; transform: translateY(0); }
}
.content > * { animation: fadeUp 0.32s ease both; }
.content > *:nth-child(1) { animation-delay: 0.04s; }
.content > *:nth-child(2) { animation-delay: 0.09s; }
.content > *:nth-child(3) { animation-delay: 0.14s; }
.content > *:nth-child(4) { animation-delay: 0.19s; }
.content > *:nth-child(5) { animation-delay: 0.24s; }
.content > *:nth-child(6) { animation-delay: 0.29s; }
.content > *:nth-child(7) { animation-delay: 0.34s; }

@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
.spinning { animation: spin 0.8s linear infinite; }
</style>
@endpush

@section('content')
<div class="phone">



  <!-- ── CONTENT ── -->
  <div class="content">

    <!-- Greeting -->
    <div>
      <p class="greeting-sub">Bonjour,</p>
      <h1 class="greeting-name">{{ $user->prenom }} 👋</h1>
    </div>

    <!-- Alert adhésion -->
    @if(isset($alertAdhesion) && $alertAdhesion)
    <div class="alert-adhesion">
      <div class="alert-icon">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#D4A017" stroke-width="2.2" stroke-linecap="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
      </div>
      <div class="alert-body">
        <p class="alert-title">Adhésion en attente</p>
        <p class="alert-text">Votre cotisation d'adhésion est en attente de paiement.</p>
        <form id="adhesion-alert-form" action="{{ route('br.membre.payer.adhesion') }}" method="POST">
          @csrf
          <button id="adhesion-alert-btn" type="submit" class="btn-pay">
            <span id="alert-btn-text">Payer maintenant</span>
            <span id="alert-btn-spinner" style="display:none;">
              <svg class="spinning" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
            </span>
          </button>
        </form>
      </div>
    </div>
    @endif

    <!-- Épargne totale -->
    <div class="epargne-card">
      <div style="position:relative;z-index:1;">
        <p class="epargne-label">Total Épargne</p>
        <div>
          <span class="epargne-value">{{ number_format($stats['total_epargne'], 0, ',', ' ') }}</span>
          <span class="epargne-unit">FCFA</span>
        </div>
        <div style="display:flex;align-items:center;gap:5px;margin-top:10px;">
          <div style="width:6px;height:6px;border-radius:50%;background:var(--gold);"></div>
          <span style="font-size:10px;color:rgba(255,255,255,0.45);font-weight:600;">Solde disponible</span>
        </div>
      </div>
      <div class="wallet-icon">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#D4A017" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="2" y="5" width="20" height="14" rx="3"/>
          <path d="M16 12h.01"/><path d="M2 10h20"/>
        </svg>
      </div>
    </div>

    <!-- Mini stats -->
    <div class="mini-stats">
      <div class="mini-card">
        <div class="mini-icon" style="background:var(--green-pale);">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D6A4F" stroke-width="2" stroke-linecap="round">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
          </svg>
        </div>
        <p class="mini-label">Tontines Actives</p>
        <p class="mini-value">{{ str_pad($stats['tontines_actives'], 2, '0', STR_PAD_LEFT) }}</p>
      </div>
      <div class="mini-card">
        <div class="mini-icon" style="background:var(--gold-light);">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#D4A017" stroke-width="2" stroke-linecap="round">
            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
            <polyline points="17 6 23 6 23 12"/>
          </svg>
        </div>
        <p class="mini-label">Limite de Prêt</p>
        <p class="mini-value">
          @php
            $plafond = $stats['plafond_pret'];
            if ($plafond >= 1000000) {
                echo rtrim(rtrim(number_format($plafond / 1000000, 1, ',', ''), '0'), ',') . 'M';
            } else {
                echo number_format($plafond, 0, ',', ' ');
            }
          @endphp<span class="mini-unit">FCFA</span>
        </p>
      </div>
    </div>

    <!-- Mes Tontines -->
    @if($user->tontinesActives->isNotEmpty())
    <div>
      <div class="section-header">
        <h2 class="section-title">Mes Tontines</h2>
        <a href="#" class="section-link">+ Créer</a>
      </div>
      @foreach($user->tontinesActives as $tontine)
      <div class="tontine-card" style="margin-bottom:10px;">
        <div class="tontine-thumb">🏠</div>
        <div class="tontine-info">
          <p class="tontine-name">{{ $tontine->nom ?? 'Tontine' }}</p>
          <p class="tontine-sub">Prochain tour : {{ optional($tontine->prochain_tour)->format('d M') ?? 'À venir' }}</p>
          <div class="progress-wrap">
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

    <!-- Prêt en cours -->
    @if($stats['pret_en_cours'])
    <div>
      <div class="section-header">
        <h2 class="section-title">Prêt en cours</h2>
      </div>
      <div class="pret-card">
        <div class="pret-row">
          <div class="pret-check">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#2D6A4F" stroke-width="2.5" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
          </div>
          <div class="pret-info">
            <p class="pret-name">{{ $stats['pret_en_cours']->motif ?? 'Crédit' }}</p>
            <p class="pret-echo">Échéance : {{ optional($stats['pret_en_cours']->date_echeance)->format('d M') }}</p>
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

    <!-- Parrainage -->
    @php
      $lienParrainage     = route('br.register', ['parrain' => $user->telephone]);
      $messageParrainage  = "Rejoins Business Room et bénéficie d'un financement jusqu'à 5 millions de FCFA et d'un accompagnement personnalisé pour réaliser tous tes projets. Inscris-toi via ce lien : " . $lienParrainage;
      $messageWhatsApp    = urlencode($messageParrainage);
    @endphp
    <div>
      <div class="section-header">
        <h2 class="section-title">Mon Parrainage</h2>
      </div>

      <div class="parrain-card">
        <p class="parrain-title">Invitez vos partenaires</p>
        <p class="parrain-text">
          Vous avez <strong>{{ $stats['filleuls'] ?? 0 }} filleul(s) actif(s)</strong>.
          Invitez vos partenaires et gagnez des bonus sur chaque adhésion validée.
        </p>
        <div class="parrain-message">
          <p>Rejoins Business Room et bénéficie d'un financement jusqu'à 5 millions de FCFA et d'un accompagnement personnalisé pour réaliser tous tes projets.</p>
          <p>Inscris-toi via ce lien :</p>
        </div>
        <div class="ref-row">
          <span class="ref-link">{{ $lienParrainage }}</span>
          <button class="copy-btn" onclick="copyFullMessage('{{ addslashes($messageParrainage) }}')" aria-label="Copier le message">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round">
              <rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
            </svg>
          </button>
        </div>
        <div class="share-buttons">
          <button class="share-btn" onclick="shareNatif('{{ addslashes($messageParrainage) }}', '{{ $lienParrainage }}')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
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

  <!-- Footer -->
  <footer class="app-footer">
    <p class="footer-owner">Propriété du CFPAM GROUP</p>
    <p class="footer-dev">Développé par <a href="https://tfs237.com" target="_blank" rel="noopener noreferrer">TFS237</a></p>
  </footer>

  <!-- Bottom Nav -->
  <nav class="bottom-nav">
    <a href="{{ route('br.membre.dashboard') }}" class="nav-item active">
      <svg viewBox="0 0 24 24" fill="currentColor"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
      Dashboard
    </a>
    <a href="{{ route('br.membre.tontine.index') }}" class="nav-item">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
      Tontines
    </a>
    <a href="{{ route('br.membre.pret.index') }}" class="nav-item">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
      Prêts
    </a>
    <a href="{{ route('br.membre.business.index') }}" class="nav-item">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
      Marché
    </a>
    <a href="{{ route('br.membre.cashbook.index') }}" class="nav-item">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
      Cashbook
    </a>
    <a href="{{ route('br.membre.assistance.index') }}" class="nav-item">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
      Aide
    </a>
  </nav>

</div>
@endsection

@push('scripts')
<script>
document.getElementById('adhesion-alert-form')?.addEventListener('submit', function () {
  const btn     = document.getElementById('adhesion-alert-btn');
  const text    = document.getElementById('alert-btn-text');
  const spinner = document.getElementById('alert-btn-spinner');
  btn.disabled          = true;
  text.style.display    = 'none';
  spinner.style.display = 'flex';
  setTimeout(function () {
    btn.disabled          = false;
    text.style.display    = 'inline';
    spinner.style.display = 'none';
  }, 10000);
});

function copyFullMessage(message) {
  if (navigator.clipboard && navigator.clipboard.writeText) {
    navigator.clipboard.writeText(message).then(showCopyFeedback).catch(() => fallbackCopy(message));
  } else { fallbackCopy(message); }
}

function fallbackCopy(text) {
  const ta = document.createElement('textarea');
  ta.value = text;
  Object.assign(ta.style, { position: 'fixed', top: '0', left: '0', width: '2em', height: '2em', padding: '0', border: 'none', background: 'transparent', opacity: '0' });
  document.body.appendChild(ta);
  ta.focus(); ta.select();
  try { if (document.execCommand('copy')) showCopyFeedback(); } catch(e) {}
  document.body.removeChild(ta);
}

function showCopyFeedback() {
  const btn = document.querySelector('.copy-btn');
  const orig = btn.innerHTML;
  btn.classList.add('copied');
  btn.innerHTML = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>';
  setTimeout(() => { btn.classList.remove('copied'); btn.innerHTML = orig; }, 2000);
}

function shareNatif(message, url) {
  if (navigator.share) {
    navigator.share({ title: 'COOP-CA – Rejoins-nous !', text: message, url: url }).catch(err => {
      if (err.name !== 'AbortError') console.error(err);
    });
  } else {
    copyFullMessage(message);
    alert('Lien et message copiés ! Collez-les dans l\'application de votre choix.');
  }
}
</script>
@endpush