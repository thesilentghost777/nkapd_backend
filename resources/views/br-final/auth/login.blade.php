{{-- ============================================================
     resources/views/br-final/auth/login.blade.php
     ============================================================ --}}
@extends('br-final.layouts.guest')
@section('title', 'Connexion')
@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500;600&display=swap');

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --brand:       #C2601A;
  --brand-dark:  #A04D12;
  --brand-light: #FEF0E8;
  --bg:          #F5F3EF;
  --dark:        #1A1A1A;
  --mid:         #666;
  --light:       #BBB;
  --border:      #E8E4DE;
  --input-bg:    #FAFAF8;
  --radius:      18px;
  --radius-sm:   14px;
  --shadow-brand: 0 4px 18px rgba(194,96,26,0.28);
}

body, html {
  font-family: 'DM Sans', sans-serif;
  background: var(--bg);
  min-height: 100vh;
}

/* ── LAYOUT ── */
.auth-wrap {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 32px 16px 48px;
  background: var(--bg);
  position: relative;
  overflow: hidden;
}

.auth-wrap::before {
  content: '';
  position: fixed;
  top: -100px; right: -100px;
  width: 380px; height: 380px;
  background: radial-gradient(circle, rgba(194,96,26,0.11) 0%, transparent 70%);
  border-radius: 50%;
  pointer-events: none;
}
.auth-wrap::after {
  content: '';
  position: fixed;
  bottom: -80px; left: -80px;
  width: 280px; height: 280px;
  background: radial-gradient(circle, rgba(194,96,26,0.07) 0%, transparent 70%);
  border-radius: 50%;
  pointer-events: none;
}

.auth-inner {
  width: 100%;
  max-width: 420px;
  position: relative;
  z-index: 1;
}

/* ── BRAND HEADER ── */
.auth-brand {
  text-align: center;
  margin-bottom: 24px;
}

.auth-back {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 12px;
  color: #AAA;
  text-decoration: none;
  margin-bottom: 20px;
  letter-spacing: 0.3px;
  transition: color 0.2s;
}
.auth-back:hover { color: var(--brand); }

.auth-logo {
  width: 60px; height: 60px;
  background: linear-gradient(135deg, #E07020 0%, #C2601A 100%);
  border-radius: 16px;
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 14px;
  box-shadow: var(--shadow-brand);
}
.auth-logo svg { width: 28px; height: 28px; fill: white; }

.auth-brand-name {
  font-family: 'Syne', sans-serif;
  font-size: 28px;
  font-weight: 800;
  color: var(--dark);
  letter-spacing: -1px;
  line-height: 1.05;
}
.auth-brand-sub {
  font-size: 10px;
  letter-spacing: 2.5px;
  color: #B0A898;
  text-transform: uppercase;
  margin-top: 4px;
  display: block;
}

/* ── CARD ── */
.auth-card {
  background: white;
  border-radius: 26px;
  padding: 32px 28px 28px;
  box-shadow: 0 4px 28px rgba(0,0,0,0.07), 0 1px 3px rgba(0,0,0,0.04);
  border: 1px solid var(--border);
}

.auth-card-title {
  font-family: 'Syne', sans-serif;
  font-size: 21px;
  font-weight: 700;
  color: var(--dark);
  margin-bottom: 4px;
}
.auth-card-desc {
  font-size: 13px;
  color: #999;
  margin-bottom: 26px;
  line-height: 1.5;
}

/* ── ALERTS ── */
.alert {
  border-radius: 12px;
  padding: 11px 15px;
  font-size: 13px;
  text-align: center;
  margin-bottom: 18px;
  line-height: 1.45;
}
.alert-error   { background: #FCE8E8; color: #C0302A; }
.alert-success { background: #E8F5E9; color: #2E7D32; }

/* ── FIELDS ── */
.field { margin-bottom: 18px; }
.field-label {
  display: block;
  font-size: 11px;
  font-weight: 600;
  color: var(--mid);
  letter-spacing: 0.5px;
  text-transform: uppercase;
  margin-bottom: 7px;
}
.field-wrap { position: relative; }

.field-icon {
  position: absolute;
  left: 14px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--light);
  display: flex;
  align-items: center;
  pointer-events: none;
}

.field-input {
  width: 100%;
  background: var(--input-bg);
  border: 1.5px solid var(--border);
  border-radius: var(--radius-sm);
  padding: 13px 16px 13px 42px;
  font-size: 14px;
  font-family: 'DM Sans', sans-serif;
  color: var(--dark);
  outline: none;
  transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
  -webkit-appearance: none;
}
.field-input::placeholder { color: #C5C0BA; }
.field-input:focus {
  border-color: var(--brand);
  background: white;
  box-shadow: 0 0 0 3px rgba(194,96,26,0.10);
}

.field-error { font-size: 12px; color: #E74C3C; margin-top: 5px; }

/* Password toggle */
.pwd-toggle {
  position: absolute;
  right: 13px;
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
  accent-color: var(--brand);
  cursor: pointer;
  flex-shrink: 0;
}
.remember-text { font-size: 13px; color: #999; }

.btn-forgot {
  font-size: 13px;
  font-weight: 600;
  color: var(--brand);
  background: none;
  border: none;
  cursor: pointer;
  font-family: 'DM Sans', sans-serif;
  padding: 0;
  transition: text-decoration 0.15s;
}
.btn-forgot:hover { text-decoration: underline; }

/* ── SUBMIT BUTTON ── */
.btn-submit {
  width: 100%;
  background: linear-gradient(135deg, #E07020 0%, #C2601A 100%);
  color: white;
  border: none;
  border-radius: var(--radius-sm);
  padding: 15px;
  font-size: 15px;
  font-weight: 700;
  font-family: 'Syne', sans-serif;
  cursor: pointer;
  letter-spacing: 0.3px;
  box-shadow: var(--shadow-brand);
  transition: opacity 0.2s, transform 0.15s, box-shadow 0.2s;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  -webkit-appearance: none;
}
.btn-submit:hover:not(:disabled) {
  opacity: 0.91;
  transform: translateY(-1px);
  box-shadow: 0 8px 22px rgba(194,96,26,0.34);
}
.btn-submit:active:not(:disabled) { transform: translateY(0); }
.btn-submit:disabled {
  opacity: 0.68;
  cursor: not-allowed;
  transform: none;
}

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
  border-top: 1px solid #EFEDE8;
  text-align: center;
  font-size: 13px;
  color: #999;
}
.auth-footer a {
  color: var(--brand);
  font-weight: 700;
  text-decoration: none;
  margin-left: 4px;
}
.auth-footer a:hover { text-decoration: underline; }

/* ── BADGES ── */
.auth-badges {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 20px;
  margin-top: 20px;
  flex-wrap: wrap;
}
.auth-badge {
  display: flex;
  align-items: center;
  gap: 5px;
  font-size: 10px;
  color: #BBB;
  letter-spacing: 0.8px;
  text-transform: uppercase;
}

/* ── MODAL OVERLAY ── */
.modal-overlay {
  display: none;
  position: fixed;
  inset: 0;
  z-index: 9999;
  background: rgba(0,0,0,0.42);
  align-items: center;
  justify-content: center;
  padding: 20px;
  backdrop-filter: blur(4px);
  -webkit-backdrop-filter: blur(4px);
}
.modal-overlay.open { display: flex; }

.modal-box {
  background: white;
  border-radius: 22px;
  padding: 30px 26px;
  width: 100%;
  max-width: 350px;
  box-shadow: 0 20px 60px rgba(0,0,0,0.16);
  animation: modalIn 0.22s ease;
}
@keyframes modalIn {
  from { opacity: 0; transform: scale(0.94) translateY(10px); }
  to   { opacity: 1; transform: scale(1) translateY(0); }
}

.modal-wa-icon {
  width: 50px; height: 50px;
  background: #25D366;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 14px;
  box-shadow: 0 4px 14px rgba(37,211,102,0.28);
}
.modal-title {
  font-family: 'Syne', sans-serif;
  font-size: 18px;
  font-weight: 700;
  color: var(--dark);
  text-align: center;
  margin-bottom: 6px;
}
.modal-desc {
  font-size: 13px;
  color: #999;
  text-align: center;
  line-height: 1.5;
  margin-bottom: 22px;
}
.modal-label {
  display: block;
  font-size: 11px;
  font-weight: 600;
  color: var(--mid);
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-bottom: 8px;
}

.phone-row {
  display: flex;
  align-items: center;
  background: var(--input-bg);
  border: 1.5px solid var(--border);
  border-radius: var(--radius-sm);
  overflow: hidden;
  margin-bottom: 18px;
  transition: border-color 0.2s, box-shadow 0.2s;
}
.phone-row:focus-within {
  border-color: #25D366;
  box-shadow: 0 0 0 3px rgba(37,211,102,0.11);
}
.phone-prefix {
  padding: 13px 12px 13px 14px;
  font-size: 13px;
  font-weight: 600;
  color: #555;
  border-right: 1px solid var(--border);
  white-space: nowrap;
  background: transparent;
  flex-shrink: 0;
}
.phone-input {
  flex: 1;
  border: none;
  outline: none;
  background: transparent;
  padding: 13px 13px;
  font-size: 14px;
  font-family: 'DM Sans', sans-serif;
  color: var(--dark);
  -webkit-appearance: none;
}
.phone-input::placeholder { color: #C5C0BA; }

.modal-preview {
  background: #F0FDF4;
  border: 1px solid #BBF7D0;
  border-radius: 11px;
  padding: 11px 13px;
  font-size: 12px;
  color: #166534;
  line-height: 1.55;
  margin-bottom: 18px;
  display: none;
}
.modal-preview.visible { display: block; }

.btn-wa {
  width: 100%;
  background: linear-gradient(135deg, #2ECC71 0%, #25D366 100%);
  color: white;
  border: none;
  border-radius: var(--radius-sm);
  padding: 13px;
  font-size: 14px;
  font-weight: 700;
  font-family: 'Syne', sans-serif;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  box-shadow: 0 4px 14px rgba(37,211,102,0.26);
  transition: opacity 0.2s, transform 0.15s;
  text-decoration: none;
}
.btn-wa:hover { opacity: 0.91; transform: translateY(-1px); }
.btn-wa:not([href*="wa.me"]) { opacity: 0.5; pointer-events: none; }

.btn-cancel {
  width: 100%;
  background: none;
  border: none;
  color: #BBB;
  font-size: 13px;
  margin-top: 11px;
  cursor: pointer;
  font-family: 'DM Sans', sans-serif;
  transition: color 0.2s;
}
.btn-cancel:hover { color: #888; }

/* ── RESPONSIVE ── */
@media (max-width: 480px) {
  .auth-card { padding: 26px 20px 22px; border-radius: 22px; }
  .auth-brand-name { font-size: 24px; }
  .auth-logo { width: 52px; height: 52px; }
}
@media (min-width: 768px) {
  .auth-wrap { padding: 48px 24px 64px; }
  .auth-inner { max-width: 440px; }
  .auth-card { padding: 38px 34px 32px; }
}
</style>

<div class="auth-wrap">
  <div class="auth-inner">

    {{-- Brand --}}
    <div class="auth-brand">
      <a href="{{ route('br.portail') }}" class="auth-back">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
        Retour au portail
      </a>

      <div class="auth-logo">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path d="M20 7H4C2.9 7 2 7.9 2 9v11c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V9c0-1.1-.9-2-2-2z"/>
          <path d="M16 7V5c0-1.1-.9-2-2-2h-4c-1.1 0-2 .9-2 2v2" fill="rgba(255,255,255,0.4)"/>
          <rect x="10" y="11" width="4" height="2" rx="1" fill="rgba(255,255,255,0.9)"/>
        </svg>
      </div>

      <div class="auth-brand-name">BUSINESS ROOM</div>
      <span class="auth-brand-sub">Espace membres</span>
    </div>

    {{-- Card --}}
    <div class="auth-card">
      <h2 class="auth-card-title">Bon retour 👋</h2>
      <p class="auth-card-desc">Connectez-vous pour accéder à votre espace.</p>

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
          <label class="field-label">Numéro de téléphone</label>
          <div class="field-wrap">
            <span class="field-icon">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81 19.79 19.79 0 01.5 1.18 2 2 0 012.18.5h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 8.37a16 16 0 006.72 6.72l1.23-1.23a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/>
              </svg>
            </span>
            <input type="text" name="telephone" class="field-input"
                   value="{{ old('telephone') }}"
                   placeholder="+237 6 00 00 00 00" required
                   inputmode="tel" autocomplete="tel">
          </div>
          @error('telephone')<p class="field-error">{{ $message }}</p>@enderror
        </div>

        {{-- Mot de passe --}}
        <div class="field">
          <label class="field-label">Mot de passe</label>
          <div class="field-wrap">
            <span class="field-icon">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0110 0v4"/>
              </svg>
            </span>
            <input type="password" name="password" id="pwdInput"
                   class="field-input" style="padding-right: 44px;"
                   placeholder="••••••••" required
                   autocomplete="current-password">
            <button type="button" class="pwd-toggle" onclick="togglePwd()" aria-label="Afficher / masquer le mot de passe">
              <svg id="eyeIcon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>
              </svg>
            </button>
          </div>
          @error('password')<p class="field-error">{{ $message }}</p>@enderror
        </div>

        {{-- Se souvenir / Oublié --}}
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
      </form>

      <div class="auth-footer">
        Nouveau sur Business Room ?<a href="{{ route('br.register') }}">Créer un compte</a>
      </div>
    </div>

    {{-- Badges --}}
    <div class="auth-badges">
      <div class="auth-badge">
        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        Secure 256-bit
      </div>
      <div class="auth-badge">
        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        Verified Member
      </div>
    </div>
  </div>
</div>

{{-- ===== MODAL : MOT DE PASSE OUBLIÉ VIA WHATSAPP ===== --}}
<div class="modal-overlay" id="forgotModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
  <div class="modal-box">

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

/* ── Modal Mot de passe oublié ── */
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
  link.removeAttribute('style');
}

function updateWaPreview(val) {
  const digits = val.replace(/\D/g, '');
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
    link.style.opacity       = '1';
    link.style.pointerEvents = 'auto';
  } else {
    preview.classList.remove('visible');
    link.href = '#';
    link.style.opacity       = '';
    link.style.pointerEvents = '';
  }
}

/* Fermer en cliquant l'overlay ou Escape */
document.getElementById('forgotModal').addEventListener('click', function (e) {
  if (e.target === this) closeForgotModal();
});
document.addEventListener('keydown', function (e) {
  if (e.key === 'Escape') closeForgotModal();
});
</script>

@endsection