{{-- ============================================================
     resources/views/br-final/auth/register.blade.php
     Restyled — COOP-CA · même charte que la page portail
     ============================================================ --}}
@extends('br-final.layouts.guest')
@section('title', 'Inscription · COOP-CA')
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
  --shadow-card:  0 2px 16px rgba(0,0,0,0.07);
}

html, body {
  font-family: 'Manrope', sans-serif;
  background: var(--bg);
  min-height: 100vh;
  color: var(--dark);
  -webkit-font-smoothing: antialiased;
}

/* ══════════════════════════════
   LAYOUT WRAPPER
══════════════════════════════ */
.reg-wrap {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: center;
}

/* ══════════════════════════════
   HERO HEADER
══════════════════════════════ */
.reg-hero {
  width: 100%;
  background: var(--green-dark);
  padding: 0 20px 0;
  position: relative;
  overflow: hidden;
  flex-shrink: 0;
}

/* Cercles décoratifs */
.reg-hero::before {
  content: '';
  position: absolute;
  width: 260px; height: 260px;
  border-radius: 50%;
  background: rgba(255,255,255,0.04);
  top: -80px; right: -60px;
  pointer-events: none;
}
.reg-hero::after {
  content: '';
  position: absolute;
  width: 160px; height: 160px;
  border-radius: 50%;
  background: rgba(212,160,23,0.1);
  bottom: 0; left: -40px;
  pointer-events: none;
}

.hero-inner {
  position: relative; z-index: 1;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 28px 0 36px;
}

.hero-left { flex: 1; }

/* Logo / nav-back */
.hero-back {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  color: rgba(255,255,255,0.6);
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
  display: flex; align-items: center; justify-content: center;
  border: 1px solid rgba(255,255,255,0.15);
}
.logo-name { font-size: 15px; font-weight: 900; color: white; letter-spacing: 0.02em; }
.logo-sub  { font-size: 9px; font-weight: 700; color: var(--gold); letter-spacing: 0.14em; text-transform: uppercase; }

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
  letter-spacing: -0.5px;
  margin-bottom: 10px;
}
.hero-title em { font-style: normal; color: var(--gold); }

.hero-sub {
  font-size: 12px;
  color: rgba(255,255,255,0.6);
  line-height: 1.65;
  max-width: 260px;
}

/* Stats mini dans le hero */
.hero-stats {
  display: flex;
  gap: 16px;
  margin-top: 22px;
}
.hero-stat {
  text-align: center;
}
.hero-stat .val {
  font-size: 16px;
  font-weight: 900;
  color: var(--gold);
}
.hero-stat .lbl {
  font-size: 9px;
  font-weight: 600;
  color: rgba(255,255,255,0.5);
  text-transform: uppercase;
  letter-spacing: 0.08em;
}
.hero-stat-sep { width: 1px; background: rgba(255,255,255,0.12); align-self: stretch; }

/* Illustration déco */
.hero-deco {
  position: absolute;
  right: 16px; bottom: 0;
  opacity: 0.1;
}

/* ══════════════════════════════
   FORM PANEL
══════════════════════════════ */
.reg-form-panel {
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
  margin: 0 auto 24px;
}

/* ── DIVIDER ── */
.divider {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 22px;
}
.divider-line { flex: 1; height: 1px; background: var(--border); }
.divider-text {
  font-size: 11px;
  font-weight: 700;
  color: var(--light);
  white-space: nowrap;
  letter-spacing: 0.04em;
  text-transform: uppercase;
}

/* ── ALERT ── */
.alert-error {
  background: #FEF2F2;
  border: 1.5px solid rgba(220,38,38,0.2);
  border-radius: var(--radius-sm);
  padding: 13px 15px;
  margin-bottom: 20px;
  font-size: 12px;
  color: #991B1B;
  line-height: 1.55;
}
.alert-error strong { font-weight: 800; }
.alert-error ul { margin: 6px 0 0 16px; }
.alert-error li { margin-bottom: 3px; }

/* ── FIELDS ── */
.field { margin-bottom: 14px; }

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
.label-opt {
  font-size: 10px;
  color: var(--light);
  font-weight: 500;
  text-transform: none;
  letter-spacing: 0;
}
.label-filled {
  font-size: 10px;
  font-weight: 700;
  color: var(--green-mid);
  text-transform: none;
  letter-spacing: 0;
  display: none;
}
.label-filled.show { display: inline; }

.field-wrap { position: relative; }

.field-icon {
  position: absolute;
  left: 13px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--light);
  pointer-events: none;
  display: flex; align-items: center;
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
.field-input:focus + .field-icon,
.field-wrap:focus-within .field-icon { color: var(--green-mid); }

.field-input[readonly] { cursor: not-allowed; opacity: 0.82; }

/* Code parrain accent doré */
.field-input.parrain-accent {
  border-color: rgba(212,160,23,0.35);
  background: var(--gold-light);
}
.field-input.parrain-accent:focus {
  border-color: var(--gold);
  box-shadow: 0 0 0 4px rgba(212,160,23,0.12);
}

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

/* ── GRILLE 2 COL ── */
.row-2 {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px;
  margin-bottom: 14px;
}
.row-2 .field { margin-bottom: 0; }

/* ── CHECKBOX ── */
.check-row {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  margin: 18px 0 22px;
  padding: 14px;
  background: var(--green-pale);
  border-radius: var(--radius-sm);
  border: 1px solid rgba(45,106,79,0.12);
}
.check-row input[type="checkbox"] {
  width: 17px; height: 17px;
  flex-shrink: 0;
  accent-color: var(--green-dark);
  cursor: pointer;
  margin-top: 2px;
}
.check-text {
  font-size: 12px;
  color: var(--mid);
  line-height: 1.6;
}
.check-text a {
  color: var(--green-mid);
  text-decoration: none;
  font-weight: 700;
}
.check-text a:hover { text-decoration: underline; }

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
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  box-shadow: var(--shadow-green);
  transition: background 0.2s, transform 0.15s, opacity 0.2s;
  position: relative;
  overflow: hidden;
}
.btn-submit:hover:not(:disabled) { background: var(--green-mid); transform: translateY(-1px); }
.btn-submit:active:not(:disabled) { transform: translateY(0); }
.btn-submit:disabled { opacity: 0.7; cursor: not-allowed; }

/* Spinner */
@keyframes spin { to { transform: rotate(360deg); } }
.spinner {
  width: 18px; height: 18px;
  border: 2.5px solid rgba(255,255,255,0.3);
  border-top-color: white;
  border-radius: 50%;
  animation: spin 0.65s linear infinite;
  flex-shrink: 0;
}
.btn-label { display: flex; align-items: center; gap: 10px; transition: opacity 0.2s; }
.btn-label.hidden { opacity: 0; }
.spinner-wrap {
  position: absolute; inset: 0;
  display: flex; align-items: center; justify-content: center;
  opacity: 0; transition: opacity 0.2s; pointer-events: none;
}
.spinner-wrap.visible { opacity: 1; }

/* Gold badge sous le bouton */
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
.btn-assurance svg { color: var(--gold); flex-shrink: 0; }

/* ── SIGN IN ── */
.signin-row {
  text-align: center;
  margin-top: 22px;
  font-size: 13px;
  color: var(--light);
}
.signin-row a {
  color: var(--green-dark);
  font-weight: 800;
  text-decoration: none;
  margin-left: 4px;
}
.signin-row a:hover { text-decoration: underline; }

/* ── RESPONSIVE ── */
@media (max-width: 420px) {
  .hero-inner   { padding: 22px 0 30px; }
  .hero-title   { font-size: 24px; }
  .reg-form-panel { padding: 24px 16px 48px; }
  .row-2        { grid-template-columns: 1fr; }
}
@media (min-width: 1024px) {
  .reg-wrap { flex-direction: row; min-height: 100vh; align-items: stretch; }
  .reg-hero {
    width: 42%; flex-shrink: 0;
    border-radius: 0; padding: 0 48px;
    display: flex; flex-direction: column;
    align-items: flex-start; justify-content: center;
  }
  .hero-inner { flex-direction: column; align-items: flex-start; padding: 0; }
  .hero-sub { max-width: 300px; }
  .reg-form-panel {
    flex: 1; margin-top: 0;
    border-radius: 0; max-width: none;
    display: flex; flex-direction: column;
    justify-content: center;
    padding: 48px 56px;
    overflow-y: auto;
  }
  .panel-handle { display: none; }
}
</style>

<div class="reg-wrap">

  {{-- ══ HERO ══ --}}
  <div class="reg-hero">
    <div class="hero-inner">

      <div class="hero-left">
        <a href="{{ route('home') ?? '/' }}" class="hero-back">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
          Retour
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
          <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
          Nouvelle adhésion
        </div>

        <h1 class="hero-title">
          Rejoignez<br>
          <em>la coopérative</em>
        </h1>
        <p class="hero-sub">Accédez à des financements flexibles, un réseau de membres et des opportunités exclusives.</p>

        <div class="hero-stats">
          <div class="hero-stat">
            <div class="val">5 000+</div>
            <div class="lbl">Membres</div>
          </div>
          <div class="hero-stat-sep"></div>
          <div class="hero-stat">
            <div class="val">100%</div>
            <div class="lbl">Satisfaction</div>
          </div>
          <div class="hero-stat-sep"></div>
          <div class="hero-stat">
            <div class="val">5M+</div>
            <div class="lbl">FCFA financés</div>
          </div>
        </div>
      </div>

    </div>

    <!-- Décoration SVG -->
    <svg class="hero-deco" width="90" height="90" viewBox="0 0 90 90" fill="none" xmlns="http://www.w3.org/2000/svg">
      <circle cx="45" cy="45" r="40" stroke="white" stroke-width="1.5"/>
      <path d="M45 5 L45 85 M5 45 L85 45" stroke="white" stroke-width="1"/>
      <circle cx="45" cy="45" r="18" stroke="white" stroke-width="1.5"/>
    </svg>
  </div>

  {{-- ══ FORM PANEL ══ --}}
  <div class="reg-form-panel">
    <div class="panel-handle"></div>

    @if ($errors->any())
      <div class="alert-error">
        <strong>Veuillez corriger les erreurs suivantes :</strong>
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="divider">
      <div class="divider-line"></div>
      <span class="divider-text">Créez votre compte gratuitement</span>
      <div class="divider-line"></div>
    </div>

    <form id="registerForm" method="POST" action="{{ route('br.register') }}" novalidate>
      @csrf

      {{-- Prénom / Nom --}}
      <div class="row-2">
        <div class="field">
          <div class="field-label"><span class="label-text">Prénom</span></div>
          <div class="field-wrap">
            <span class="field-icon">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </span>
            <input type="text" name="prenom" class="field-input"
                   placeholder="Alex"
                   value="{{ old('prenom') }}"
                   autocomplete="given-name" required>
          </div>
        </div>

        <div class="field">
          <div class="field-label"><span class="label-text">Nom</span></div>
          <div class="field-wrap">
            <span class="field-icon">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </span>
            <input type="text" name="nom" class="field-input"
                   placeholder="Rivers"
                   value="{{ old('nom') }}"
                   autocomplete="family-name" required>
          </div>
        </div>
      </div>

      {{-- Email (optionnel) --}}
      <div class="field">
        <div class="field-label">
          <span class="label-text">Email</span>
          <span class="label-opt">Optionnel</span>
        </div>
        <div class="field-wrap">
          <span class="field-icon">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          </span>
          <input type="email" name="email" class="field-input"
                 placeholder="alex@businessroom.com"
                 value="{{ old('email') }}"
                 autocomplete="email">
        </div>
      </div>

      {{-- Téléphone --}}
      <div class="field">
        <div class="field-label"><span class="label-text">Téléphone</span></div>
        <div class="field-wrap">
          <span class="field-icon">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81 19.79 19.79 0 01.5 1.18 2 2 0 012.18.5h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L6.91 8.37a16 16 0 006.72 6.72l1.23-1.23a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
          </span>
          <input type="tel" name="telephone" class="field-input"
                 placeholder="+237 6 00 00 00 00"
                 value="{{ old('telephone') }}"
                 autocomplete="tel" required inputmode="tel">
        </div>
      </div>

      {{-- WhatsApp (optionnel) --}}
      <div class="field">
        <div class="field-label">
          <span class="label-text">WhatsApp</span>
          <span class="label-opt">Optionnel</span>
        </div>
        <div class="field-wrap">
          <span class="field-icon">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
          </span>
          <input type="tel" name="whatsapp" class="field-input"
                 placeholder="Identique au téléphone ?"
                 value="{{ old('whatsapp') }}"
                 inputmode="tel">
        </div>
      </div>

      {{-- Code d'invitation --}}
      <div class="field">
        <div class="field-label">
          <span class="label-text">Code d'invitation</span>
          <span class="label-opt" id="optLabel">Optionnel</span>
          <span class="label-filled" id="filledLabel">✓ Pré-rempli</span>
        </div>
        <div class="field-wrap">
          <span class="field-icon">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#D4A017" stroke-width="2" stroke-linecap="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
          </span>
          <input type="text" id="codeParrain" name="code_parrain" class="field-input parrain-accent"
                 placeholder="Code d'invitation"
                 value="{{ old('code_parrain') }}"
                 autocomplete="off">
        </div>
      </div>

      {{-- Mot de passe --}}
      <div class="field">
        <div class="field-label"><span class="label-text">Mot de passe</span></div>
        <div class="field-wrap">
          <span class="field-icon">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          </span>
          <input type="password" id="pwd1" name="password" class="field-input"
                 placeholder="••••••••••••"
                 style="padding-right: 44px;"
                 autocomplete="new-password" required>
          <button type="button" class="pwd-toggle" onclick="togglePwd('pwd1','eye1')" aria-label="Afficher / masquer">
            <svg id="eye1" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>
          </button>
        </div>
      </div>

      {{-- Confirmation --}}
      <div class="field">
        <div class="field-label"><span class="label-text">Confirmer le mot de passe</span></div>
        <div class="field-wrap">
          <span class="field-icon">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          </span>
          <input type="password" id="pwd2" name="password_confirmation" class="field-input"
                 placeholder="••••••••••••"
                 style="padding-right: 44px;"
                 autocomplete="new-password" required>
          <button type="button" class="pwd-toggle" onclick="togglePwd('pwd2','eye2')" aria-label="Afficher / masquer">
            <svg id="eye2" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>
          </button>
        </div>
      </div>

      {{-- CGU --}}
      <div class="check-row">
        <input type="checkbox" id="terms" name="terms" required>
        <label for="terms" class="check-text">
          J'accepte les <a href="#">Conditions d'utilisation</a> et la <a href="#">Politique de confidentialité</a> de COOP-CA Business Room.
        </label>
      </div>

      {{-- Bouton submit --}}
      <button type="submit" class="btn-submit" id="submitBtn">
        <span class="btn-label" id="btnLabel">
          Rejoindre maintenant
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </span>
        <span class="spinner-wrap" id="spinnerWrap">
          <span class="spinner"></span>
        </span>
      </button>

      <div class="btn-assurance">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        Inscription sécurisée · Données protégées
      </div>
    </form>

    <div class="signin-row">
      Déjà membre ?<a href="{{ route('br.login') }}">Se connecter →</a>
    </div>
  </div>
</div>

<script>
/* ── Auto-fill code parrain depuis ?parrain= ── */
(function () {
  const params  = new URLSearchParams(window.location.search);
  const parrain = params.get('parrain');
  const input   = document.getElementById('codeParrain');
  const optLbl  = document.getElementById('optLabel');
  const filLbl  = document.getElementById('filledLabel');
  if (parrain && input && !input.value.trim()) {
    input.value    = parrain;
    input.readOnly = true;
    optLbl.style.display = 'none';
    filLbl.classList.add('show');
  }
})();

/* ── Toggle mot de passe ── */
function togglePwd(inputId, iconId) {
  const input = document.getElementById(inputId);
  const icon  = document.getElementById(iconId);
  if (input.type === 'password') {
    input.type = 'text';
    icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
  } else {
    input.type = 'password';
    icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
  }
}

/* ── Spinner au submit ── */
document.getElementById('registerForm').addEventListener('submit', function () {
  const btn     = document.getElementById('submitBtn');
  const label   = document.getElementById('btnLabel');
  const spinner = document.getElementById('spinnerWrap');
  btn.disabled  = true;
  label.classList.add('hidden');
  spinner.classList.add('visible');
});
</script>

@endsection