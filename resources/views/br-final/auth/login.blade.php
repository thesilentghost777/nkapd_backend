@extends('br-final.layouts.guest')
@section('title', 'Connexion')
@section('content')

{{-- Firebase SDK --}}
<script src="https://www.gstatic.com/firebasejs/10.12.2/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.12.2/firebase-auth-compat.js"></script>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500;600&display=swap');

  * { box-sizing: border-box; }

  body, .br-login-wrap {
    font-family: 'DM Sans', sans-serif;
  }

  .br-login-wrap {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px 16px;
    background: #f5f3ef;
    position: relative;
    overflow: hidden;
  }

  .br-login-wrap::before {
    content: '';
    position: fixed;
    top: -120px; right: -120px;
    width: 420px; height: 420px;
    background: radial-gradient(circle, rgba(194,96,26,0.13) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
  }
  .br-login-wrap::after {
    content: '';
    position: fixed;
    bottom: -80px; left: -80px;
    width: 300px; height: 300px;
    background: radial-gradient(circle, rgba(194,96,26,0.09) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
  }

  .br-card-outer {
    width: 100%;
    max-width: 400px;
    position: relative;
    z-index: 1;
  }

  .br-brand {
    text-align: center;
    margin-bottom: 28px;
  }
  .br-back-link {
    font-size: 12px;
    color: #aaa;
    text-decoration: none;
    display: inline-block;
    margin-bottom: 20px;
    letter-spacing: 0.3px;
    transition: color 0.2s;
  }
  .br-back-link:hover { color: #c2601a; }

  .br-logo-icon {
    width: 64px; height: 64px;
    background: linear-gradient(135deg, #e07020 0%, #c2601a 100%);
    border-radius: 18px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px auto;
    box-shadow: 0 8px 24px rgba(194,96,26,0.28);
  }
  .br-logo-icon svg { width: 32px; height: 32px; fill: white; }

  .br-brand-title {
    font-family: 'Syne', sans-serif;
    font-size: 32px;
    font-weight: 800;
    color: #1a1a1a;
    line-height: 1.05;
    letter-spacing: -1px;
    margin: 0 0 6px 0;
  }
  .br-brand-sub {
    font-size: 11px;
    letter-spacing: 2.5px;
    color: #b0a898;
    text-transform: uppercase;
    margin: 0;
  }

  .br-card {
    background: white;
    border-radius: 28px;
    padding: 36px 32px 32px 32px;
    box-shadow: 0 4px 32px rgba(0,0,0,0.07), 0 1px 4px rgba(0,0,0,0.04);
    border: 1px solid #ede9e3;
  }

  .br-card-heading {
    font-family: 'Syne', sans-serif;
    font-size: 22px;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 6px 0;
  }
  .br-card-desc {
    font-size: 13px;
    color: #999;
    margin: 0 0 28px 0;
  }

  .br-alert-error {
    background: #fce8e8;
    border-radius: 12px;
    padding: 12px 16px;
    color: #c0302a;
    font-size: 13px;
    margin-bottom: 18px;
    text-align: center;
  }
  .br-alert-success {
    background: #e8f5e9;
    border-radius: 12px;
    padding: 12px 16px;
    color: #2e7d32;
    font-size: 13px;
    margin-bottom: 18px;
    text-align: center;
  }

  .br-field { margin-bottom: 20px; }
  .br-label {
    display: block;
    font-size: 12px;
    color: #666;
    margin-bottom: 8px;
    font-weight: 600;
    letter-spacing: 0.3px;
  }
  .br-input-wrap { position: relative; }
  .br-input-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #bbb;
    display: flex; align-items: center;
  }
  .br-input {
    width: 100%;
    background: #fafaf8;
    border: 1.5px solid #e8e4de;
    border-radius: 14px;
    padding: 14px 16px 14px 42px;
    font-size: 14px;
    color: #1a1a1a;
    outline: none;
    font-family: 'DM Sans', sans-serif;
    transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
  }
  .br-input::placeholder { color: #c0bbb4; }
  .br-input:focus {
    border-color: #c2601a;
    background: white;
    box-shadow: 0 0 0 3px rgba(194,96,26,0.10);
  }
  .br-input-toggle {
    position: absolute;
    right: 14px;
    top: 50%; transform: translateY(-50%);
    background: none; border: none; cursor: pointer;
    color: #bbb; padding: 0; display: flex; align-items: center;
  }
  .br-input-toggle:hover { color: #c2601a; }
  .br-error { color: #e74c3c; font-size: 12px; margin-top: 6px; }

  .br-row-remember {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 24px;
  }
  .br-remember-label {
    display: flex; align-items: center; gap: 8px; cursor: pointer;
  }
  .br-remember-label input[type="checkbox"] {
    width: 16px; height: 16px; margin: 0;
    accent-color: #c2601a; cursor: pointer;
  }
  .br-remember-text { font-size: 13px; color: #999; }

  .br-forgot-btn {
    font-size: 13px;
    color: #c2601a;
    font-weight: 600;
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
    font-family: 'DM Sans', sans-serif;
    text-decoration: none;
  }
  .br-forgot-btn:hover { text-decoration: underline; }

  .br-btn-submit {
    background: linear-gradient(135deg, #e07020 0%, #c2601a 100%);
    color: white;
    border: none;
    border-radius: 14px;
    padding: 15px;
    font-size: 15px;
    font-weight: 700;
    font-family: 'Syne', sans-serif;
    cursor: pointer;
    width: 100%;
    letter-spacing: 0.3px;
    box-shadow: 0 4px 16px rgba(194,96,26,0.30);
    transition: opacity 0.2s, transform 0.15s, box-shadow 0.2s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
  }
  .br-btn-submit:hover {
    opacity: 0.92;
    transform: translateY(-1px);
    box-shadow: 0 8px 24px rgba(194,96,26,0.35);
  }
  .br-btn-submit:active { transform: translateY(0); }
  .br-btn-submit:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
    box-shadow: 0 4px 16px rgba(194,96,26,0.30);
  }

  /* ===== SPINNER UNIVERSEL ===== */
  @keyframes spin {
    to { transform: rotate(360deg); }
  }
  .spinner {
    display: inline-block;
    width: 16px;
    height: 16px;
    border: 2.5px solid rgba(255,255,255,0.35);
    border-top-color: white;
    border-radius: 50%;
    animation: spin 0.65s linear infinite;
    flex-shrink: 0;
  }
  /* Spinner sombre pour boutons clairs (Google) */
  .spinner-dark {
    display: inline-block;
    width: 16px;
    height: 16px;
    border: 2.5px solid rgba(0,0,0,0.12);
    border-top-color: #555;
    border-radius: 50%;
    animation: spin 0.65s linear infinite;
    flex-shrink: 0;
  }

  .br-divider {
    display: flex; align-items: center; gap: 12px;
    margin: 24px 0;
  }
  .br-divider-line { flex: 1; height: 1px; background: #efede8; }
  .br-divider-text { font-size: 11px; color: #c0bab0; white-space: nowrap; letter-spacing: 1px; text-transform: uppercase; }

  .br-oauth-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin-bottom: 10px;
  }
  .br-oauth-btn {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    border-radius: 14px; padding: 13px 10px;
    font-size: 13px; font-weight: 600;
    cursor: pointer; transition: all 0.2s;
    font-family: 'DM Sans', sans-serif;
    text-decoration: none;
    min-height: 48px;
  }
  .br-oauth-btn:disabled {
    opacity: 0.65;
    cursor: not-allowed;
    transform: none !important;
  }
  .br-oauth-google {
    background: white; border: 1.5px solid #e8e4de; color: #1a1a1a;
  }
  .br-oauth-google:not(:disabled):hover { background: #fafaf8; border-color: #d0ccc6; }

  .br-oauth-apple {
    background: #1a1a1a; border: none; color: white;
  }
  .br-oauth-apple:not(:disabled):hover { background: #2d2d2d; }

  .br-footer {
    margin-top: 24px;
    padding-top: 20px;
    border-top: 1px solid #efede8;
    text-align: center;
  }
  .br-footer p { font-size: 14px; color: #999; margin: 0; }
  .br-footer a {
    color: #c2601a;
    text-decoration: none;
    font-weight: 700;
    margin-left: 4px;
  }
  .br-footer a:hover { text-decoration: underline; }

  .br-badges {
    display: flex; align-items: center; justify-content: center; gap: 20px;
    margin-top: 20px;
  }
  .br-badge {
    display: flex; align-items: center; gap: 5px;
    font-size: 10px; color: #bbb; letter-spacing: 0.8px; text-transform: uppercase;
  }

  /* ===== WHATSAPP MODAL ===== */
  .br-modal-overlay {
    display: none;
    position: fixed; inset: 0; z-index: 9999;
    background: rgba(0,0,0,0.45);
    align-items: center; justify-content: center;
    padding: 20px;
    backdrop-filter: blur(4px);
  }
  .br-modal-overlay.open { display: flex; }

  .br-modal {
    background: white;
    border-radius: 24px;
    padding: 32px 28px;
    width: 100%; max-width: 360px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.18);
    animation: modalIn 0.25s ease;
  }
  @keyframes modalIn {
    from { opacity: 0; transform: scale(0.94) translateY(12px); }
    to   { opacity: 1; transform: scale(1) translateY(0); }
  }

  .br-modal-logo {
    width: 52px; height: 52px;
    background: #25D366;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px auto;
    box-shadow: 0 4px 16px rgba(37,211,102,0.3);
  }

  .br-modal-title {
    font-family: 'Syne', sans-serif;
    font-size: 19px; font-weight: 700;
    color: #1a1a1a; text-align: center; margin: 0 0 6px 0;
  }
  .br-modal-desc {
    font-size: 13px; color: #999; text-align: center; margin: 0 0 24px 0; line-height: 1.5;
  }

  .br-modal-label {
    display: block; font-size: 12px; font-weight: 600;
    color: #666; margin-bottom: 8px; letter-spacing: 0.3px;
  }

  .br-phone-input-row {
    display: flex; align-items: center; gap: 0;
    background: #fafaf8; border: 1.5px solid #e8e4de; border-radius: 14px;
    overflow: hidden; margin-bottom: 20px;
    transition: border-color 0.2s, box-shadow 0.2s;
  }
  .br-phone-input-row:focus-within {
    border-color: #25D366;
    box-shadow: 0 0 0 3px rgba(37,211,102,0.12);
  }
  .br-phone-prefix {
    padding: 14px 12px 14px 16px;
    font-size: 14px; font-weight: 600; color: #555;
    border-right: 1px solid #e8e4de; white-space: nowrap;
    background: transparent;
  }
  .br-modal-phone-input {
    flex: 1;
    border: none; outline: none;
    background: transparent;
    padding: 14px 14px;
    font-size: 14px; color: #1a1a1a;
    font-family: 'DM Sans', sans-serif;
  }
  .br-modal-phone-input::placeholder { color: #c0bbb4; }

  .br-modal-preview {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 12px;
    padding: 12px 14px;
    font-size: 12px;
    color: #166534;
    line-height: 1.55;
    margin-bottom: 20px;
    display: none;
  }
  .br-modal-preview.visible { display: block; }

  .br-btn-whatsapp {
    width: 100%;
    background: linear-gradient(135deg, #2ecc71 0%, #25D366 100%);
    color: white;
    border: none;
    border-radius: 14px;
    padding: 14px;
    font-size: 15px;
    font-weight: 700;
    font-family: 'Syne', sans-serif;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    box-shadow: 0 4px 16px rgba(37,211,102,0.28);
    transition: opacity 0.2s, transform 0.15s;
    text-decoration: none;
  }
  .br-btn-whatsapp:hover { opacity: 0.92; transform: translateY(-1px); }
  .br-btn-whatsapp:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }

  .br-modal-cancel {
    width: 100%;
    background: none; border: none;
    color: #bbb; font-size: 13px;
    margin-top: 12px; cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    transition: color 0.2s;
  }
  .br-modal-cancel:hover { color: #888; }
</style>

<div class="br-login-wrap">
  <div class="br-card-outer">

    {{-- Brand header --}}
    <div class="br-brand">
      <a href="{{ route('br.portail') }}" class="br-back-link">← Retour au portail</a>

      <div class="br-logo-icon">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path d="M20 7H4C2.9 7 2 7.9 2 9v11c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V9c0-1.1-.9-2-2-2z"/>
          <path d="M16 7V5c0-1.1-.9-2-2-2h-4c-1.1 0-2 .9-2 2v2" fill="rgba(255,255,255,0.4)"/>
          <rect x="10" y="11" width="4" height="2" rx="1" fill="rgba(255,255,255,0.9)"/>
        </svg>
      </div>

      <h1>BUSINESS<br>ROOM</h1>
    </div>

    {{-- Main card --}}
    <div class="br-card">

      <h2 class="br-card-heading">Bon retour 👋</h2>
      <p class="br-card-desc">Connectez-vous pour accéder à votre espace.</p>

      @if(session('error'))
        <div class="br-alert-error">{{ session('error') }}</div>
      @endif
      @if(session('success'))
        <div class="br-alert-success">{{ session('success') }}</div>
      @endif

      {{-- Classic login form --}}
      <form action="{{ route('br.login') }}" method="POST" id="loginForm">
        @csrf

        {{-- Phone --}}
        <div class="br-field">
          <label class="br-label">Numéro de téléphone</label>
          <div class="br-input-wrap">
            <span class="br-input-icon">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81 19.79 19.79 0 01.5 1.18 2 2 0 012.18.5h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 8.37a16 16 0 006.72 6.72l1.23-1.23a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/>
              </svg>
            </span>
            <input type="text" name="telephone" value="{{ old('telephone') }}"
                   placeholder="+33 6 00 00 00 00" required class="br-input">
          </div>
          @error('telephone')<p class="br-error">{{ $message }}</p>@enderror
        </div>

        {{-- Password --}}
        <div class="br-field">
          <label class="br-label">Mot de passe</label>
          <div class="br-input-wrap">
            <span class="br-input-icon">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0110 0v4"/>
              </svg>
            </span>
            <input type="password" name="password" id="passwordInput"
                   placeholder="••••••••" required class="br-input">
            <button type="button" class="br-input-toggle" onclick="togglePassword()" title="Afficher/masquer">
              <svg id="eyeIcon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>
              </svg>
            </button>
          </div>
          @error('password')<p class="br-error">{{ $message }}</p>@enderror
        </div>

        {{-- Remember + Forgot --}}
        <div class="br-row-remember">
          <label class="br-remember-label">
            <input type="checkbox" name="remember">
            <span class="br-remember-text">Se souvenir de moi</span>
          </label>
          <button type="button" class="br-forgot-btn" onclick="openForgotModal()">Oublié ?</button>
        </div>

        <button type="submit" class="br-btn-submit" id="submitBtn">Se connecter →</button>
      </form>

      {{-- Divider --}}
      <div class="br-divider">
        <div class="br-divider-line"></div>
        <span class="br-divider-text">ou continuer avec</span>
        <div class="br-divider-line"></div>
      </div>

      {{-- OAuth buttons --}}
      <div class="br-oauth-grid">
        <button id="btnGoogle" type="button" class="br-oauth-btn br-oauth-google">
          <svg width="17" height="17" viewBox="0 0 48 48">
            <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
            <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
            <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
            <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.18 1.48-4.97 2.31-8.16 2.31-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
          </svg>
          Google
        </button>

        <button id="btnApple" type="button" class="br-oauth-btn br-oauth-apple">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="white">
            <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
          </svg>
          Apple
        </button>
      </div>

      {{-- Footer --}}
      <div class="br-footer">
        <p>Nouveau sur Business Room ?<a href="{{ route('br.register') }}">Créer un compte</a></p>
      </div>
    </div>

    {{-- Security badges --}}
    <div class="br-badges">
      <div class="br-badge">
        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
        </svg>
        Secure 256-bit
      </div>
      <div class="br-badge">
        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
          <polyline points="22 4 12 14.01 9 11.01"/>
        </svg>
        Verified Member
      </div>
    </div>

  </div>
</div>

{{-- ===== WHATSAPP FORGOT PASSWORD MODAL ===== --}}
<div class="br-modal-overlay" id="forgotModal">
  <div class="br-modal">

    <div class="br-modal-logo">
      <svg width="28" height="28" viewBox="0 0 24 24" fill="white">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
      </svg>
    </div>

    <h3 class="br-modal-title">Mot de passe oublié ?</h3>
    <p class="br-modal-desc">Entrez votre numéro de téléphone et nous vous enverrons un message WhatsApp pour récupérer votre accès.</p>

    <label class="br-modal-label" for="modalPhone">Votre numéro Business Room</label>
    <div class="br-phone-input-row">
      <span class="br-phone-prefix">🇨🇲 +237</span>
      <input type="tel" id="modalPhone" class="br-modal-phone-input"
             placeholder="6 XX XX XX XX" maxlength="9"
             oninput="updateWhatsAppPreview(this.value)"
             inputmode="numeric">
    </div>

    <div class="br-modal-preview" id="waPreview">
      <strong>Message qui sera envoyé :</strong><br>
      <span id="waPreviewText"></span>
    </div>

    <a id="waLink" href="#" class="br-btn-whatsapp" style="pointer-events:none;opacity:0.5;" target="_blank" rel="noopener noreferrer">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="white">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
      </svg>
      Envoyer sur WhatsApp
    </a>

    <button class="br-modal-cancel" onclick="closeForgotModal()">Annuler</button>
  </div>
</div>

{{-- ===== FIREBASE INIT & OAUTH HANDLERS ===== --}}
<script>
const firebaseConfig = {
    apiKey:            "{{ config('services.firebase.web_api_key') }}",
    authDomain:        "{{ config('services.firebase.project_id') }}.firebaseapp.com",
    projectId:         "{{ config('services.firebase.project_id') }}",
    storageBucket:     "{{ config('services.firebase.project_id') }}.appspot.com",
    messagingSenderId: "{{ config('services.firebase.messaging_sender_id') }}",
    appId:             "{{ config('services.firebase.app_id') }}",
};

firebase.initializeApp(firebaseConfig);
const auth = firebase.auth();

// =====================================================
// UTILITAIRE : Locker / Unlocker un bouton avec spinner
// =====================================================
function lockBtn(btn, spinnerClass, loadingText) {
    btn.disabled = true;
    btn._originalHTML = btn.innerHTML;
    btn.innerHTML = `<span class="${spinnerClass}"></span> ${loadingText}`;
}

function unlockBtn(btn) {
    btn.disabled = false;
    if (btn._originalHTML) {
        btn.innerHTML = btn._originalHTML;
        delete btn._originalHTML;
    }
}

// =====================================================
// Firebase : envoi du token au backend
// =====================================================
async function sendFirebaseToken(idToken, codeParrain = null) {
    const body = { idToken };
    if (codeParrain) body.code_parrain = codeParrain;

    const res = await fetch("{{ route('br.auth.firebase') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify(body),
    });
    const data = await res.json();
    if (data.redirect) {
        window.location.href = data.redirect;
    } else {
        alert(data.error ?? 'Erreur de connexion.');
    }
}

// =====================================================
// Bouton Google
// =====================================================
document.getElementById('btnGoogle').addEventListener('click', async function () {
    const btn = this;
    if (btn.disabled) return;

    lockBtn(btn, 'spinner-dark', 'Connexion...');

    const provider = new firebase.auth.GoogleAuthProvider();
    provider.setCustomParameters({ prompt: 'select_account' });

    try {
        const result = await auth.signInWithPopup(provider);
        const idToken = await result.user.getIdToken();
        await sendFirebaseToken(idToken);
        // Pas de unlockBtn ici : la page va rediriger
    } catch (e) {
        console.error(e);
        alert('Connexion Google annulée ou échouée.');
        unlockBtn(btn); // On rend le bouton disponible seulement en cas d'erreur
    }
});

// =====================================================
// Bouton Apple
// =====================================================
document.getElementById('btnApple').addEventListener('click', async function () {
    const btn = this;
    if (btn.disabled) return;

    lockBtn(btn, 'spinner', 'Connexion...');

    const provider = new firebase.auth.OAuthProvider('apple.com');
    provider.addScope('email');
    provider.addScope('name');

    try {
        const result = await auth.signInWithPopup(provider);
        const idToken = await result.user.getIdToken();
        await sendFirebaseToken(idToken);
        // Pas de unlockBtn ici : la page va rediriger
    } catch (e) {
        console.error(e);
        alert('Connexion Apple annulée ou échouée.');
        unlockBtn(btn); // On rend le bouton disponible seulement en cas d'erreur
    }
});

// =====================================================
// Formulaire classique (submit)
// =====================================================
document.getElementById('loginForm').addEventListener('submit', function (e) {
    const btn = document.getElementById('submitBtn');
    if (btn.disabled) {
        e.preventDefault();
        return false;
    }
    lockBtn(btn, 'spinner', 'Connexion...');
    // Pas de unlockBtn : la page recharge après soumission
});

// =====================================================
// Toggle mot de passe
// =====================================================
function togglePassword() {
    const input = document.getElementById('passwordInput');
    const icon  = document.getElementById('eyeIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
    } else {
        input.type = 'password';
        icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    }
}

// =====================================================
// Modal WhatsApp (mot de passe oublié)
// =====================================================
const WA_NUMBER = '237696087354';

function openForgotModal() {
    document.getElementById('forgotModal').classList.add('open');
    document.body.style.overflow = 'hidden';
    setTimeout(() => document.getElementById('modalPhone').focus(), 100);
}

function closeForgotModal() {
    document.getElementById('forgotModal').classList.remove('open');
    document.body.style.overflow = '';
    document.getElementById('modalPhone').value = '';
    document.getElementById('waPreview').classList.remove('visible');
    const waLink = document.getElementById('waLink');
    waLink.style.pointerEvents = 'none';
    waLink.style.opacity = '0.5';
}

function updateWhatsAppPreview(value) {
    const digits = value.replace(/\D/g, '');
    const preview = document.getElementById('waPreview');
    const previewText = document.getElementById('waPreviewText');
    const waLink = document.getElementById('waLink');

    if (digits.length >= 9) {
        const phone = digits.slice(0, 9);
        const formatted = phone.replace(/(\d)(\d{2})(\d{2})(\d{2})(\d{2})/, '$1 $2 $3 $4 $5');
        const msg = `Bonjour, j'ai oublié mon mot de passe Business Room. Mon numéro de téléphone utilisé pour m'inscrire c'est le ${formatted}`;
        const encoded = encodeURIComponent(msg);

        previewText.textContent = msg;
        preview.classList.add('visible');
        waLink.href = `https://wa.me/${WA_NUMBER}?text=${encoded}`;
        waLink.style.pointerEvents = 'auto';
        waLink.style.opacity = '1';
    } else {
        preview.classList.remove('visible');
        waLink.href = '#';
        waLink.style.pointerEvents = 'none';
        waLink.style.opacity = '0.5';
    }
}

document.getElementById('forgotModal').addEventListener('click', function (e) {
    if (e.target === this) closeForgotModal();
});

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeForgotModal();
});
</script>

@endsection