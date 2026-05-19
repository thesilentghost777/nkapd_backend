{{-- ============================================================
     resources/views/br-final/auth/register.blade.php
     ============================================================ --}}
@extends('br-final.layouts.guest')
@section('title', 'Inscription')
@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@300;400;500;600&display=swap');

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --brand:       #E8521A;
  --brand-dark:  #C0401A;
  --brand-light: #FEF0E8;
  --bg:          #F7F5F1;
  --dark:        #181716;
  --mid:         #6B6560;
  --light:       #B8B2AA;
  --border:      #E8E4DC;
  --input-bg:    #F3F1ED;
  --radius:      18px;
  --radius-sm:   12px;
  --shadow-brand: 0 4px 20px rgba(232,82,26,0.32);
}

html, body {
  font-family: 'DM Sans', sans-serif;
  background: var(--bg);
  min-height: 100vh;
  color: var(--dark);
}

/* ── LAYOUT ── */
.reg-wrap {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: center;
}

/* ── HERO ── */
.reg-hero {
  width: 100%;
  background: linear-gradient(168deg, #FDF0E8 0%, #F9E8D8 55%, #F2D8C0 100%);
  padding: 44px 28px 48px;
  text-align: center;
  position: relative;
  overflow: hidden;
  flex-shrink: 0;
}
.reg-hero::before {
  content: '';
  position: absolute;
  width: 280px; height: 280px;
  background: radial-gradient(circle, rgba(232,82,26,0.12) 0%, transparent 70%);
  top: -70px; right: -50px;
  border-radius: 50%;
  pointer-events: none;
}
.reg-hero::after {
  content: '';
  position: absolute;
  width: 200px; height: 200px;
  background: radial-gradient(circle, rgba(232,82,26,0.07) 0%, transparent 70%);
  bottom: -40px; left: -40px;
  border-radius: 50%;
  pointer-events: none;
}

.reg-hero-label {
  display: inline-block;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 2.5px;
  color: var(--brand);
  text-transform: uppercase;
  margin-bottom: 18px;
}
.reg-hero-title {
  font-family: 'Syne', sans-serif;
  font-size: 36px;
  font-weight: 800;
  color: var(--dark);
  line-height: 1.1;
  letter-spacing: -1.5px;
  margin-bottom: 12px;
}
.reg-hero-sub {
  font-size: 14px;
  color: var(--mid);
  line-height: 1.55;
  max-width: 290px;
  margin: 0 auto;
}

/* ── FORM PANEL ── */
.reg-form-panel {
  width: 100%;
  max-width: 520px;
  background: white;
  border-radius: 26px 26px 0 0;
  margin-top: -22px;
  padding: 30px 24px 48px;
  position: relative;
  z-index: 2;
  flex: 1;
}

/* ── ALERTS ── */
.alert-error {
  background: #FFF0EE;
  border: 1.5px solid rgba(232,82,26,0.22);
  border-radius: var(--radius-sm);
  padding: 13px 15px;
  margin-bottom: 22px;
  font-size: 13px;
  color: var(--brand-dark);
  line-height: 1.5;
}
.alert-error ul { margin: 5px 0 0 16px; }
.alert-error li { margin-bottom: 3px; }

/* ── FIELDS ── */
.field  { margin-bottom: 16px; }
.field-label {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 7px;
}
.label-text {
  font-size: 11px;
  font-weight: 600;
  color: var(--mid);
  text-transform: uppercase;
  letter-spacing: 0.7px;
}
.label-opt {
  font-size: 10px;
  color: var(--light);
  font-weight: 400;
  letter-spacing: 0;
  text-transform: none;
}
.label-filled {
  font-size: 10px;
  font-weight: 600;
  color: var(--brand);
  letter-spacing: 0;
  text-transform: none;
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
  display: flex;
  align-items: center;
}

.field-input {
  width: 100%;
  background: var(--input-bg);
  border: 1.5px solid transparent;
  border-radius: var(--radius-sm);
  padding: 13px 14px 13px 40px;
  font-size: 14px;
  font-family: 'DM Sans', sans-serif;
  color: var(--dark);
  outline: none;
  -webkit-appearance: none;
  transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
}
.field-input::placeholder { color: var(--light); }
.field-input:focus {
  border-color: var(--brand);
  background: white;
  box-shadow: 0 0 0 4px rgba(232,82,26,0.08);
}
.field-input[readonly] {
  cursor: not-allowed;
  opacity: 0.82;
}

/* Parrain field accent */
.field-input.parrain-accent {
  border-color: rgba(232,82,26,0.30);
  background: #FEF9F6;
}
.field-input.parrain-accent:focus {
  border-color: var(--brand);
  box-shadow: 0 0 0 4px rgba(232,82,26,0.08);
}

/* Password toggle */
.pwd-toggle {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  cursor: pointer;
  color: var(--light);
  padding: 4px;
  display: flex;
  align-items: center;
  transition: color 0.2s;
}
.pwd-toggle:hover { color: var(--brand); }

/* ── GRID 2 COL ── */
.row-2 {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px;
  margin-bottom: 16px;
}
.row-2 .field { margin-bottom: 0; }

/* ── CHECKBOX ── */
.check-row {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  margin: 18px 0 24px;
}
.check-row input[type="checkbox"] {
  width: 17px; height: 17px;
  flex-shrink: 0;
  accent-color: var(--brand);
  cursor: pointer;
  margin-top: 2px;
  -webkit-appearance: none;
  appearance: auto;
}
.check-text {
  font-size: 12px;
  color: var(--mid);
  line-height: 1.55;
}
.check-text a {
  color: var(--brand);
  text-decoration: none;
  font-weight: 500;
}

/* ── SUBMIT ── */
.btn-submit {
  width: 100%;
  background: var(--brand);
  color: white;
  border: none;
  border-radius: 16px;
  padding: 16px;
  font-size: 15px;
  font-weight: 700;
  font-family: 'DM Sans', sans-serif;
  cursor: pointer;
  letter-spacing: 0.4px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  box-shadow: var(--shadow-brand);
  transition: background 0.2s, transform 0.1s, opacity 0.2s;
  -webkit-appearance: none;
  position: relative;
  overflow: hidden;
}
.btn-submit:hover:not(:disabled) { background: var(--brand-dark); transform: translateY(-1px); }
.btn-submit:active:not(:disabled) { transform: translateY(0); }
.btn-submit:disabled { opacity: 0.72; cursor: not-allowed; }

/* Spinner */
@keyframes spin { to { transform: rotate(360deg); } }
.spinner {
  width: 19px; height: 19px;
  border: 2.5px solid rgba(255,255,255,0.3);
  border-top-color: white;
  border-radius: 50%;
  animation: spin 0.68s linear infinite;
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

/* ── SIGN IN ── */
.signin-row {
  text-align: center;
  margin-top: 20px;
  font-size: 13px;
  color: var(--light);
}
.signin-row a {
  color: var(--brand);
  font-weight: 600;
  text-decoration: none;
  margin-left: 3px;
}
.signin-row a:hover { text-decoration: underline; }

/* ── DIVIDER ── */
.divider {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 20px;
}
.divider-line { flex: 1; height: 1px; background: var(--border); }
.divider-text { font-size: 11px; color: var(--light); white-space: nowrap; letter-spacing: 0.4px; }

/* ── RESPONSIVE ── */
@media (max-width: 420px) {
  .reg-hero { padding: 36px 20px 44px; }
  .reg-hero-title { font-size: 30px; }
  .reg-form-panel { padding: 26px 18px 44px; border-radius: 22px 22px 0 0; }
  .row-2 { grid-template-columns: 1fr; }
}
@media (min-width: 768px) {
  .reg-hero { padding: 56px 40px 60px; }
  .reg-hero-title { font-size: 44px; }
  .reg-form-panel { padding: 36px 36px 56px; max-width: 540px; border-radius: 28px 28px 0 0; }
}
@media (min-width: 1024px) {
  .reg-wrap {
    flex-direction: row;
    min-height: 100vh;
    align-items: stretch;
  }
  .reg-hero {
    width: 42%;
    flex-shrink: 0;
    border-radius: 0;
    padding: 0 48px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: center;
    text-align: left;
  }
  .reg-hero-sub { max-width: 320px; margin: 0; }
  .reg-form-panel {
    flex: 1;
    margin-top: 0;
    border-radius: 0;
    max-width: none;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 48px 56px;
    overflow-y: auto;
  }
}
</style>

<div class="reg-wrap">

  {{-- ── HERO ── --}}
  <div class="reg-hero">
    <span class="reg-hero-label">Business Room</span>
    <h1 class="reg-hero-title">Rejoignez<br>l'élite<br>entrepreneuriale.</h1>
    <p class="reg-hero-sub">Accédez à des opportunités d'investissement exclusives et un réseau de mentors certifiés.</p>
  </div>

  {{-- ── FORM PANEL ── --}}
  <div class="reg-form-panel">

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
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#E8521A" stroke-width="2" stroke-linecap="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
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
          <button type="button" class="pwd-toggle" onclick="togglePwdField('pwd1','eye1')" aria-label="Afficher / masquer">
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
          <button type="button" class="pwd-toggle" onclick="togglePwdField('pwd2','eye2')" aria-label="Afficher / masquer">
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
          J'accepte les <a href="#">Conditions d'utilisation</a> et la <a href="#">Politique de confidentialité</a> de Business Room.
        </label>
      </div>

      {{-- Bouton --}}
      <button type="submit" class="btn-submit" id="submitBtn">
        <span class="btn-label" id="btnLabel">
          Rejoindre maintenant
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </span>
        <span class="spinner-wrap" id="spinnerWrap">
          <span class="spinner"></span>
        </span>
      </button>
    </form>

    <div class="signin-row">
      Déjà membre ?<a href="{{ route('br.login') }}">Se connecter</a>
    </div>
  </div>
</div>

<script>
/* ── Auto-fill code parrain depuis ?parrain= dans l'URL ── */
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
function togglePwdField(inputId, iconId) {
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