{{-- ============================================================
     resources/views/br-final/auth/login.blade.php
     Restyled — COOP-CA · même charte que le portail & register
     ============================================================ --}}
@extends('br-final.layouts.guest')
@section('title', 'Connexion · COOP-CA')
@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800;900&display=swap');

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --green-dark:   #1B4332;
  --green-mid:    #2D6A4F;
  --green-light:  #D8F3DC;
  --green-pale:   #F0FAF3;
  --gold:         #D4A017;
  --gold-light:   #FFF8E1;
  --white:        #FFFFFF;
  --bg:           #F4F7F4;
  --dark:         #111827;
  --mid:          #4B5563;
  --light:        #9CA3AF;
  --border:       #E5E7EB;
  --input-bg:     #F9FAF9;
  --radius:       16px;
  --radius-sm:    12px;
  --shadow-green: 0 4px 20px rgba(27,67,50,0.28);
  --shadow-card:  0 2px 24px rgba(0,0,0,0.07);
}

html, body {
  font-family: 'Manrope', sans-serif;
  background: var(--bg);
  min-height: 100vh;
  color: var(--dark);
  -webkit-font-smoothing: antialiased;
}

/* ══════════════════════════════
   LAYOUT
══════════════════════════════ */
.auth-wrap {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: center;
  position: relative;
  overflow: hidden;
}

/* ══════════════════════════════
   HERO HEADER — fond vert foncé
══════════════════════════════ */
.auth-hero {
  width: 100%;
  background: var(--green-dark);
  padding: 0 24px;
  position: relative;
  overflow: hidden;
  flex-shrink: 0;
}

/* Cercles déco */
.auth-hero::before {
  content: '';
  position: absolute;
  width: 240px; height: 240px;
  border-radius: 50%;
  background: rgba(255,255,255,0.04);
  top: -70px; right: -50px;
  pointer-events: none;
}
.auth-hero::after {
  content: '';
  position: absolute;
  width: 140px; height: 140px;
  border-radius: 50%;
  background: rgba(212,160,23,0.1);
  bottom: 0; left: -30px;
  pointer-events: none;
}

.hero-inner {
  position: relative; z-index: 1;
  padding: 28px 0 38px;
}

/* Back */
.hero-back {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  color: rgba(255,255,255,0.55);
  font-size: 12px;
  font-weight: 600;
  text-decoration: none;
  margin-bottom: 22px;
  transition: color 0.2s;
}
.hero-back:hover { color: white; }

/* Logo */
.hero-logo {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 20px;
}
.logo-icon {
  width: 38px; height: 38px;
  background: rgba(255,255,255,0.12);
  border-radius: 10px;
  border: 1px solid rgba(255,255,255,0.15);
  display: flex; align-items: center; justify-content: center;
}
.logo-name { font-size: 15px; font-weight: 900; color: white; letter-spacing: 0.02em; }
.logo-sub  { font-size: 9px;  font-weight: 700; color: var(--gold); letter-spacing: 0.14em; text-transform: uppercase; }

/* Pill label */
.hero-label {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: rgba(212,160,23,0.18);
  border: 1px solid rgba(212,160,23,0.3);
  border-radius: 50px;
  padding: 5px 12px;
  font-size: 10px;
  font-weight: 700;
  color: var(--gold);
  letter-spacing: 0.1em;
  text-transform: uppercase;
  margin-bottom: 14px;
}

.hero-title {
  font-size: 28px;
  font-weight: 900;
  color: white;
  line-height: 1.15;
  letter-spacing: -0.4px;
  margin-bottom: 10px;
}
.hero-title em { font-style: normal; color: var(--gold); }

.hero-sub {
  font-size: 12px;
  color: rgba(255,255,255,0.58);
  line-height: 1.65;
  max-width: 260px;
}

/* Badges vert dans le hero */
.hero-badges {
  display: flex;
  gap: 14px;
  margin-top: 20px;
  flex-wrap: wrap;
}
.hero-badge {
  display: flex;
  align-items: center;
  gap: 5px;
  font-size: 10px;
  font-weight: 600;
  color: rgba(255,255,255,0.45);
  letter-spacing: 0.06em;
  text-transform: uppercase;
}
.hero-badge svg { color: var(--gold); flex-shrink: 0; }

/* Déco SVG */
.hero-deco {
  position: absolute;
  right: 16px; bottom: 0;
  opacity: 0.08;
}

/* ══════════════════════════════
   CARD PANEL — fond blanc
══════════════════════════════ */
.auth-card-wrap {
  width: 100%;
  max-width: 520px;
  background: white;
  border-radius: 24px 24px 0 0;
  margin-top: -20px;
  padding: 28px 22px 52px;
  position: relative;
  z-index: 2;
  flex: 1;
  box-shadow: 0 -4px 32px rgba(0,0,0,0.06);
}

/* Tirette */
.panel-handle {
  width: 36px; height: 4px;
  background: var(--border);
  border-radius: 2px;
  margin: 0 auto 26px;
}

.card-title {
  font-size: 20px;
  font-weight: 900;
  color: var(--dark);
  margin-bottom: 4px;
}
.card-desc {
  font-size: 13px;
  color: var(--light);
  margin-bottom: 26px;
  line-height: 1.5;
}

/* ── ALERTS ── */
.alert {
  border-radius: var(--radius-sm);
  padding: 12px 15px;
  font-size: 12px;
  line-height: 1.5;
  margin-bottom: 18px;
  font-weight: 500;
}
.alert-error   { background: #FEF2F2; border: 1.5px solid rgba(220,38,38,0.2); color: #991B1B; }
.alert-success { background: var(--green-pale); border: 1.5px solid rgba(45,106,79,0.2); color: var(--green-dark); }

/* ── FIELDS ── */
.field { margin-bottom: 16px; }

.field-label {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 6px;
}
.label-text {
  font-size: 11px;
  font-weight: 700;
  color: var(--mid);
  text-transform: uppercase;
  letter-spacing: 0.7px;
}
.field-wrap { position: relative; }

.field-icon {
  position: absolute;
  left: 13px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--light);
  pointer-events: none;
  display: flex; align-items: center;
  transition: color 0.2s;
}

.field-input {
  width: 100%;
  background: var(--input-bg);
  border: 1.5px solid var(--border);
  border-radius: var(--radius-sm);
  padding: 13px 14px 13px 40px;
  font-size: 14px;
  font-family: 'Manrope', sans-serif;
  font-weight: 500;
  color: var(--dark);
  outline: none;
  -webkit-appearance: none;
  transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
}
.field-input::placeholder { color: var(--light); font-weight: 400; }
.field-input:focus {
  border-color: var(--green-mid);
  background: white;
  box-shadow: 0 0 0 4px rgba(45,106,79,0.1);
}
.field-wrap:focus-within .field-icon { color: var(--green-mid); }

.field-error { font-size: 11px; color: #DC2626; margin-top: 5px; font-weight: 600; }

/* Password toggle */
.pwd-toggle {
  position: absolute;
  right: 12px; top: 50%;
  transform: translateY(-50%);
  background: none; border: none;
  cursor: pointer;
  color: var(--light);
  padding: 4px;
  display: flex; align-items: center;
  transition: color 0.2s;
}
.pwd-toggle:hover { color: var(--green-mid); }

/* ── REMEMBER / FORGOT ── */
.row-meta {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 22px;
  flex-wrap: wrap;
  gap: 8px;
}
.remember-label {
  display: flex;
  align-items: center;
  gap: 8px;
  cursor: pointer;
}
.remember-label input[type="checkbox"] {
  width: 16px; height: 16px;
  accent-color: var(--green-dark);
  cursor: pointer;
  flex-shrink: 0;
}
.remember-text { font-size: 12px; color: var(--light); font-weight: 500; }

.btn-forgot {
  font-size: 12px;
  font-weight: 700;
  color: var(--green-mid);
  background: none; border: none;
  cursor: pointer;
  font-family: 'Manrope', sans-serif;
  padding: 0;
  transition: color 0.2s;
}
.btn-forgot:hover { color: var(--green-dark); text-decoration: underline; }

/* ── SUBMIT ── */
.btn-submit {
  width: 100%;
  background: var(--green-dark);
  color: white;
  border: none;
  border-radius: 50px;
  padding: 16px;
  font-size: 14px;
  font-weight: 800;
  font-family: 'Manrope', sans-serif;
  cursor: pointer;
  letter-spacing: 0.04em;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 9px;
  box-shadow: var(--shadow-green);
  transition: background 0.2s, transform 0.15s, opacity 0.2s;
  -webkit-appearance: none;
}
.btn-submit:hover:not(:disabled) { background: var(--green-mid); transform: translateY(-1px); }
.btn-submit:active:not(:disabled) { transform: translateY(0); }
.btn-submit:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }

/* Assurance */
.btn-assurance {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  margin-top: 12px;
  font-size: 10px;
  font-weight: 600;
  color: var(--light);
  letter-spacing: 0.04em;
}
.btn-assurance svg { color: var(--gold); }

/* ── SPINNER ── */
@keyframes spin { to { transform: rotate(360deg); } }
.spinner {
  display: inline-block;
  width: 16px; height: 16px;
  border: 2.5px solid rgba(255,255,255,0.3);
  border-top-color: white;
  border-radius: 50%;
  animation: spin 0.65s linear infinite;
  flex-shrink: 0;
}

/* ── FOOTER ── */
.auth-footer {
  margin-top: 22px;
  padding-top: 18px;
  border-top: 1px solid var(--border);
  text-align: center;
  font-size: 13px;
  color: var(--light);
}
.auth-footer a {
  color: var(--green-dark);
  font-weight: 800;
  text-decoration: none;
  margin-left: 4px;
}
.auth-footer a:hover { text-decoration: underline; }

/* ══════════════════════════════
   MODAL — MOT DE PASSE OUBLIÉ
══════════════════════════════ */
.modal-overlay {
  display: none;
  position: fixed;
  inset: 0;
  z-index: 9999;
  background: rgba(0,0,0,0.45);
  align-items: flex-end;
  justify-content: center;
  backdrop-filter: blur(4px);
  -webkit-backdrop-filter: blur(4px);
}
.modal-overlay.open { display: flex; }

.modal-box {
  background: white;
  border-radius: 24px 24px 0 0;
  padding: 10px 24px 40px;
  width: 100%;
  max-width: 520px;
  box-shadow: 0 -8px 40px rgba(0,0,0,0.14);
  animation: slideUp 0.25s cubic-bezier(0.2,0.9,0.4,1);
}
@keyframes slideUp {
  from { transform: translateY(40px); opacity: 0; }
  to   { transform: translateY(0);    opacity: 1; }
}

/* Tirette modale */
.modal-handle {
  width: 36px; height: 4px;
  background: var(--border);
  border-radius: 2px;
  margin: 0 auto 20px;
}

.modal-wa-icon {
  width: 52px; height: 52px;
  background: #25D366;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 14px;
  box-shadow: 0 4px 16px rgba(37,211,102,0.3);
}
.modal-title {
  font-size: 19px;
  font-weight: 900;
  color: var(--dark);
  text-align: center;
  margin-bottom: 6px;
}
.modal-desc {
  font-size: 12px;
  color: var(--light);
  text-align: center;
  line-height: 1.6;
  margin-bottom: 22px;
}
.modal-label {
  display: block;
  font-size: 11px;
  font-weight: 700;
  color: var(--mid);
  text-transform: uppercase;
  letter-spacing: 0.7px;
  margin-bottom: 8px;
}

.phone-row {
  display: flex;
  align-items: center;
  background: var(--input-bg);
  border: 1.5px solid var(--border);
  border-radius: var(--radius-sm);
  overflow: hidden;
  margin-bottom: 16px;
  transition: border-color 0.2s, box-shadow 0.2s;
}
.phone-row:focus-within {
  border-color: #25D366;
  box-shadow: 0 0 0 4px rgba(37,211,102,0.1);
}
.phone-prefix {
  padding: 13px 12px 13px 14px;
  font-size: 13px;
  font-weight: 700;
  color: var(--mid);
  border-right: 1px solid var(--border);
  white-space: nowrap;
  flex-shrink: 0;
}
.phone-input {
  flex: 1;
  border: none;
  outline: none;
  background: transparent;
  padding: 13px;
  font-size: 14px;
  font-family: 'Manrope', sans-serif;
  font-weight: 500;
  color: var(--dark);
  -webkit-appearance: none;
}
.phone-input::placeholder { color: var(--light); font-weight: 400; }

.modal-preview {
  background: var(--green-pale);
  border: 1px solid rgba(45,106,79,0.2);
  border-radius: var(--radius-sm);
  padding: 11px 13px;
  font-size: 12px;
  color: var(--green-dark);
  line-height: 1.6;
  margin-bottom: 16px;
  display: none;
  font-weight: 500;
}
.modal-preview.visible { display: block; }
.modal-preview strong { font-weight: 800; }

.btn-wa {
  width: 100%;
  background: #25D366;
  color: white;
  border: none;
  border-radius: 50px;
  padding: 14px;
  font-size: 14px;
  font-weight: 800;
  font-family: 'Manrope', sans-serif;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 9px;
  box-shadow: 0 4px 16px rgba(37,211,102,0.28);
  transition: opacity 0.2s, transform 0.15s;
  text-decoration: none;
}
.btn-wa:hover { opacity: 0.9; transform: translateY(-1px); }
.btn-wa[href="#"] { opacity: 0.45; pointer-events: none; }

.btn-cancel {
  width: 100%;
  background: none;
  border: none;
  color: var(--light);
  font-size: 13px;
  font-weight: 600;
  margin-top: 12px;
  cursor: pointer;
  font-family: 'Manrope', sans-serif;
  transition: color 0.2s;
  padding: 8px 0;
}
.btn-cancel:hover { color: var(--mid); }

/* ── RESPONSIVE ── */
@media (max-width: 420px) {
  .hero-inner { padding: 22px 0 30px; }
  .hero-title { font-size: 24px; }
  .auth-card-wrap { padding: 24px 16px 48px; }
}
@media (min-width: 1024px) {
  .auth-wrap { flex-direction: row; align-items: stretch; }
  .auth-hero {
    width: 42%; flex-shrink: 0;
    border-radius: 0; padding: 0 48px;
    display: flex; flex-direction: column;
    align-items: flex-start; justify-content: center;
  }
  .hero-inner { padding: 0; }
  .auth-card-wrap {
    flex: 1; margin-top: 0;
    border-radius: 0; max-width: none;
    display: flex; flex-direction: column;
    justify-content: center;
    padding: 48px 56px;
    overflow-y: auto;
  }
  .panel-handle { display: none; }
  .modal-box { border-radius: 24px; margin-bottom: 40px; }
  .modal-overlay { align-items: center; }
}
</style>

<div class="auth-wrap">

  {{-- ══ HERO ══ --}}
  <div class="auth-hero">
    <div class="hero-inner">

      <a href="{{ route('br.portail') }}" class="hero-back">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
        Retour au portail
      </a>

      <div class="hero-logo">
        <div class="logo-icon">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="8"  cy="7"  r="2.5" fill="#D4A017"/>
            <circle cx="16" cy="7"  r="2.5" fill="#D4A017"/>
            <circle cx="12" cy="5"  r="2"   fill="white"/>
            <path d="M3 17c0-3 2-5 5-5h8c3 0 5 2 5 5" stroke="white" stroke-width="1.8" stroke-linecap="round"/>
          </svg>
        </div>
        <div>
          <div class="logo-name">COOP-CA</div>
          <div class="logo-sub">Business Room</div>
        </div>
      </div>

      <div class="hero-label">
        <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        Espace membres
      </div>

      <h1 class="hero-title">
        Bon retour<br>
        <em>parmi nous.</em>
      </h1>
      <p class="hero-sub">Connectez-vous pour accéder à vos financements, votre score et votre réseau.</p>

      <div class="hero-badges">
        <div class="hero-badge">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          Connexion sécurisée
        </div>
        <div class="hero-badge">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          5 000+ membres
        </div>
      </div>
    </div>

    <svg class="hero-deco" width="90" height="90" viewBox="0 0 90 90" fill="none" xmlns="http://www.w3.org/2000/svg">
      <circle cx="45" cy="45" r="40" stroke="white" stroke-width="1.5"/>
      <path d="M45 5L45 85M5 45L85 45" stroke="white" stroke-width="1"/>
      <circle cx="45" cy="45" r="18" stroke="white" stroke-width="1.5"/>
    </svg>
  </div>

  {{-- ══ CARD PANEL ══ --}}
  <div class="auth-card-wrap">
    <div class="panel-handle"></div>

    <h2 class="card-title">Se connecter</h2>
    <p class="card-desc">Entrez vos identifiants pour accéder à votre espace.</p>

    @if(session('error'))
      <div class="alert alert-error">{{ session('error') }}</div>
    @endif
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('br.login') }}" method="POST" id="loginForm">
      @csrf

      {{-- Téléphone --}}
      <div class="field">
        <div class="field-label"><span class="label-text">Numéro de téléphone</span></div>
        <div class="field-wrap">
          <span class="field-icon">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
              <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81 19.79 19.79 0 01.5 1.18 2 2 0 012.18.5h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 8.37a16 16 0 006.72 6.72l1.23-1.23a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/>
            </svg>
          </span>
          <input type="text" name="telephone" class="field-input"
                 value="{{ old('telephone') }}"
                 placeholder="+237 6 00 00 00 00"
                 required inputmode="tel" autocomplete="tel">
        </div>
        @error('telephone')<p class="field-error">{{ $message }}</p>@enderror
      </div>

      {{-- Mot de passe --}}
      <div class="field">
        <div class="field-label"><span class="label-text">Mot de passe</span></div>
        <div class="field-wrap">
          <span class="field-icon">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
              <rect x="3" y="11" width="18" height="11" rx="2"/>
              <path d="M7 11V7a5 5 0 0110 0v4"/>
            </svg>
          </span>
          <input type="password" name="password" id="pwdInput" class="field-input"
                 style="padding-right: 44px;"
                 placeholder="••••••••"
                 required autocomplete="current-password">
          <button type="button" class="pwd-toggle" onclick="togglePwd()" aria-label="Afficher / masquer">
            <svg id="eyeIcon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>
          </button>
        </div>
        @error('password')<p class="field-error">{{ $message }}</p>@enderror
      </div>

      {{-- Remember / Forgot --}}
      <div class="row-meta">
        <label class="remember-label">
          <input type="checkbox" name="remember">
          <span class="remember-text">Se souvenir de moi</span>
        </label>
        <button type="button" class="btn-forgot" onclick="openForgotModal()">Mot de passe oublié ?</button>
      </div>

      <button type="submit" class="btn-submit" id="submitBtn">
        Se connecter
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </button>

      <div class="btn-assurance">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        Connexion chiffrée · Données protégées
      </div>
    </form>

    <div class="auth-footer">
      Pas encore membre ?<a href="{{ route('br.register') }}">Créer un compte →</a>
    </div>
  </div>
</div>

{{-- ══ MODAL : MOT DE PASSE OUBLIÉ VIA WHATSAPP ══ --}}
<div class="modal-overlay" id="forgotModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
  <div class="modal-box">
    <div class="modal-handle"></div>

    <div class="modal-wa-icon" aria-hidden="true">
      <svg width="26" height="26" viewBox="0 0 24 24" fill="white">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
      </svg>
    </div>

    <h3 class="modal-title" id="modalTitle">Mot de passe oublié ?</h3>
    <p class="modal-desc">Entrez votre numéro et nous vous enverrons un message WhatsApp pour récupérer votre accès.</p>

    <label class="modal-label" for="modalPhone">Votre numéro Business Room</label>
    <div class="phone-row">
      <span class="phone-prefix">🇨🇲 +237</span>
      <input type="tel" id="modalPhone" class="phone-input"
             placeholder="6 XX XX XX XX"
             maxlength="9"
             inputmode="numeric"
             oninput="updateWaPreview(this.value)">
    </div>

    <div class="modal-preview" id="waPreview">
      <strong>Message :</strong><br>
      <span id="waPreviewText"></span>
    </div>

    <a id="waLink" href="#" class="btn-wa" target="_blank" rel="noopener noreferrer">
      <svg width="17" height="17" viewBox="0 0 24 24" fill="white">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
      </svg>
      Envoyer sur WhatsApp
    </a>

    <button class="btn-cancel" onclick="closeForgotModal()">Annuler</button>
  </div>
</div>

<script>
/* ── Toggle mot de passe ── */
function togglePwd() {
  const input = document.getElementById('pwdInput');
  const icon  = document.getElementById('eyeIcon');
  if (input.type === 'password') {
    input.type = 'text';
    icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
  } else {
    input.type = 'password';
    icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
  }
}

/* ── Spinner au submit ── */
document.getElementById('loginForm').addEventListener('submit', function (e) {
  const btn = document.getElementById('submitBtn');
  if (btn.disabled) { e.preventDefault(); return; }
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner"></span> Connexion…';
});

/* ── Modal mot de passe oublié ── */
const WA_NUMBER = '237696087354';

function openForgotModal() {
  document.getElementById('forgotModal').classList.add('open');
  document.body.style.overflow = 'hidden';
  setTimeout(() => document.getElementById('modalPhone').focus(), 120);
}

function closeForgotModal() {
  document.getElementById('forgotModal').classList.remove('open');
  document.body.style.overflow = '';
  document.getElementById('modalPhone').value = '';
  document.getElementById('waPreview').classList.remove('visible');
  const link = document.getElementById('waLink');
  link.href = '#';
}

function updateWaPreview(val) {
  const digits  = val.replace(/\D/g, '');
  const preview = document.getElementById('waPreview');
  const text    = document.getElementById('waPreviewText');
  const link    = document.getElementById('waLink');

  if (digits.length >= 9) {
    const phone     = digits.slice(0, 9);
    const formatted = phone.replace(/(\d)(\d{2})(\d{2})(\d{2})(\d{2})/, '$1 $2 $3 $4 $5');
    const msg       = `Bonjour, j'ai oublié mon mot de passe Business Room. Mon numéro inscrit est le ${formatted}`;
    text.textContent = msg;
    preview.classList.add('visible');
    link.href = `https://wa.me/${WA_NUMBER}?text=${encodeURIComponent(msg)}`;
  } else {
    preview.classList.remove('visible');
    link.href = '#';
  }
}

/* Fermer sur overlay ou Escape */
document.getElementById('forgotModal').addEventListener('click', function (e) {
  if (e.target === this) closeForgotModal();
});
document.addEventListener('keydown', function (e) {
  if (e.key === 'Escape') closeForgotModal();
});
</script>

@endsection