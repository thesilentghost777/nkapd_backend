<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title>Business Room – Inscription</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --brand: #E8521A;
    --brand-dark: #C0401A;
    --brand-light: #FEF0E8;
    --bg: #F7F5F1;
    --dark: #181716;
    --mid: #6B6560;
    --light: #B8B2AA;
    --border: #E8E4DC;
    --input-bg: #F3F1ED;
    --radius: 18px;
    --radius-sm: 12px;
  }

  body {
    font-family: 'DM Sans', sans-serif;
    background: #0F0D0C;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: flex-start;
  }

  .phone {
    width: 100%;
    max-width: 430px;
    min-height: 100vh;
    overflow-x: hidden;
    position: relative;
  }

  /* ─── HERO ─── */
  .hero {
    background: linear-gradient(170deg, #FDF0E8 0%, #F9E8D8 60%, #F2D8C0 100%);
    padding: 40px 28px 36px;
    text-align: center;
    position: relative;
    overflow: hidden;
  }

  .hero::before {
    content: '';
    position: absolute;
    width: 300px; height: 300px;
    background: radial-gradient(circle, rgba(232,82,26,0.12) 0%, transparent 70%);
    top: -80px; right: -60px;
    border-radius: 50%;
    pointer-events: none;
  }

  .hero-brand {
    font-family: 'Syne', sans-serif;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2.5px;
    color: var(--brand);
    text-transform: uppercase;
    margin-bottom: 20px;
    display: block;
  }

  .hero-title {
    font-family: 'Syne', sans-serif;
    font-size: 38px;
    font-weight: 800;
    color: var(--dark);
    line-height: 1.12;
    letter-spacing: -1.5px;
    margin-bottom: 14px;
  }

  .hero-sub {
    font-size: 14px;
    color: var(--mid);
    line-height: 1.55;
    max-width: 280px;
    margin: 0 auto;
  }

  /* ─── FORM CONTAINER ─── */
  .form-wrap {
    background: #fff;
    margin: 0;
    padding: 28px 24px 40px;
    min-height: calc(100vh - 260px);
    border-radius: 28px 28px 0 0;
    margin-top: -20px;
    position: relative;
    z-index: 2;
  }

  /* ─── FIELDS ─── */
  .field-group { margin-bottom: 18px; }

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

  .label-optional {
    font-size: 10px;
    color: var(--light);
    font-weight: 400;
    text-transform: none;
    letter-spacing: 0;
  }

  .input-row {
    position: relative;
    display: flex;
    align-items: center;
  }

  .input-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--light);
    pointer-events: none;
    display: flex;
  }

  input[type="text"],
  input[type="email"],
  input[type="tel"],
  input[type="password"] {
    width: 100%;
    background: var(--input-bg);
    border: 1.5px solid transparent;
    border-radius: var(--radius-sm);
    padding: 13px 14px 13px 42px;
    font-size: 14px;
    font-family: 'DM Sans', sans-serif;
    color: var(--dark);
    outline: none;
    transition: border-color 0.2s, background 0.2s;
  }

  input::placeholder { color: var(--light); }

  input:focus {
    border-color: var(--brand);
    background: #fff;
    box-shadow: 0 0 0 4px rgba(232,82,26,0.08);
  }

  .row-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    margin-bottom: 18px;
  }

  /* password toggle */
  .pass-toggle {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: var(--light);
    display: flex;
    padding: 4px;
  }

  /* ─── CHECKBOX ─── */
  .checkbox-row {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin: 20px 0 26px;
  }

  .checkbox-row input[type="checkbox"] {
    width: 18px; height: 18px;
    flex-shrink: 0;
    accent-color: var(--brand);
    cursor: pointer;
    margin-top: 1px;
    padding: 0;
    border-radius: 4px;
  }

  .checkbox-text {
    font-size: 12px;
    color: var(--mid);
    line-height: 1.5;
  }

  .checkbox-text a { color: var(--brand); text-decoration: none; font-weight: 500; }

  /* ─── SUBMIT ─── */
  .btn-submit {
    width: 100%;
    background: var(--brand);
    color: #fff;
    border: none;
    border-radius: 16px;
    padding: 16px;
    font-size: 15px;
    font-weight: 700;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: background 0.2s, transform 0.1s, opacity 0.2s;
    box-shadow: 0 4px 20px rgba(232,82,26,0.35);
    position: relative;
    overflow: hidden;
  }

  .btn-submit:hover:not(:disabled) { background: var(--brand-dark); transform: translateY(-1px); }
  .btn-submit:active:not(:disabled) { transform: translateY(0); }
  .btn-submit:disabled { opacity: 0.75; cursor: not-allowed; }

  /* ─── SPINNER ─── */
  .btn-label { display: flex; align-items: center; gap: 10px; transition: opacity 0.2s; }
  .btn-label.hidden { opacity: 0; }

  .spinner-wrap {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.2s;
    pointer-events: none;
  }
  .spinner-wrap.visible { opacity: 1; }

  .spinner {
    width: 22px;
    height: 22px;
    border: 2.5px solid rgba(255,255,255,0.35);
    border-top-color: #fff;
    border-radius: 50%;
    animation: spin 0.7s linear infinite;
  }

  @keyframes spin {
    to { transform: rotate(360deg); }
  }

  /* ─── SECTION DIVIDER ─── */
  .divider {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 22px;
  }
  .divider-line { flex: 1; height: 1px; background: var(--border); }
  .divider-text { font-size: 11px; color: var(--light); white-space: nowrap; }

  /* ─── OAUTH ─── */
  .oauth-row {
    display: flex;
    gap: 10px;
    margin-bottom: 24px;
  }

  .oauth-btn {
    flex: 1;
    background: var(--input-bg);
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    padding: 12px 8px;
    font-size: 13px;
    font-weight: 500;
    font-family: 'DM Sans', sans-serif;
    color: var(--dark);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    transition: background 0.15s, border-color 0.15s;
  }

  .oauth-btn:hover { background: #ECEAE6; border-color: var(--mid); }

  /* ─── SIGN IN LINK ─── */
  .signin-row {
    text-align: center;
    margin-top: 22px;
    font-size: 13px;
    color: var(--light);
  }

  .signin-row a { color: var(--brand); font-weight: 600; text-decoration: none; }

  /* ─── ALERT ERRORS ─── */
  .alert-error {
    background: #FFF0EE;
    border: 1.5px solid rgba(232,82,26,0.25);
    border-radius: var(--radius-sm);
    padding: 12px 14px;
    margin-bottom: 20px;
    font-size: 13px;
    color: var(--brand-dark);
    line-height: 1.5;
  }
  .alert-error ul { margin: 4px 0 0 16px; }
  .alert-error li { margin-bottom: 2px; }

  /* ─── ANIMATIONS ─── */
  .form-wrap > * {
    animation: slideUp 0.3s ease both;
  }
  @keyframes slideUp {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
  }

  /* ─── CODE PARRAIN AUTO-FILLED ─── */
  input[name="code_parrain"][readonly] {
    cursor: not-allowed;
    opacity: 0.85;
  }
</style>
</head>
<body>
<div class="phone">

  <!-- HERO -->
  <div class="hero">
    <span class="hero-brand">Business Room</span>
    <h1 class="title-tontine">Rejoignez<br>l'élite<br>entrepreneuriale.</h1>
    <p class="hero-sub">Accédez à des opportunités d'investissement exclusives et un réseau de mentors certifiés.</p>
  </div>

  <!-- FORM -->
  <div class="form-wrap">

    {{-- Affichage des erreurs de validation --}}
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

    <!-- OAuth -->
    <div class="oauth-row">
      <button type="button" class="oauth-btn">
        <svg width="17" height="17" viewBox="0 0 48 48"><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.18 1.48-4.97 2.31-8.16 2.31-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/></svg>
        Google
      </button>
      <button type="button" class="oauth-btn" style="background:#1a1a1a;border-color:#1a1a1a;color:#fff;">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="white"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/></svg>
        Apple
      </button>
    </div>

    <div class="divider">
      <div class="divider-line"></div>
      <span class="divider-text">ou créez votre compte</span>
      <div class="divider-line"></div>
    </div>

    <!-- FORM POST -->
    <form id="registerForm" method="POST" action="{{ route('br.register') }}" novalidate>
      @csrf

      <!-- Row: Prénom / Nom -->
      <div class="row-2">
        <div class="field-group" style="margin-bottom:0">
          <div class="field-label"><span class="label-text">Prénom</span></div>
          <div class="input-row">
            <span class="input-icon">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </span>
            <input type="text" name="prenom" placeholder="Alex" value="{{ old('prenom') }}" required>
          </div>
        </div>
        <div class="field-group" style="margin-bottom:0">
          <div class="field-label"><span class="label-text">Nom</span></div>
          <div class="input-row">
            <span class="input-icon">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </span>
            <input type="text" name="nom" placeholder="Rivers" value="{{ old('nom') }}" required>
          </div>
        </div>
      </div>

      <!-- Email -->
      <div class="field-group" style="margin-top:18px">
        <div class="field-label">
          <span class="label-text">Email</span>
          <span class="label-optional">Optionnel</span>
        </div>
        <div class="input-row">
          <span class="input-icon">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          </span>
          <input type="email" name="email" placeholder="alex@businessroom.com" value="{{ old('email') }}">
        </div>
      </div>

      <!-- Téléphone -->
      <div class="field-group">
        <div class="field-label"><span class="label-text">Téléphone</span></div>
        <div class="input-row">
          <span class="input-icon">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
          </span>
          <input type="tel" name="telephone" placeholder="+237 6 00 00 00 00" value="{{ old('telephone') }}" required>
        </div>
      </div>

      <!-- WhatsApp -->
      <div class="field-group">
        <div class="field-label">
          <span class="label-text">WhatsApp</span>
          <span class="label-optional">Optionnel</span>
        </div>
        <div class="input-row">
          <span class="input-icon">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
          </span>
          <input type="tel" name="whatsapp" placeholder="Identique au téléphone ?" value="{{ old('whatsapp') }}">
        </div>
      </div>

      <!-- Code Parrain -->
      <div class="field-group">
        <div class="field-label">
          <span class="label-text">Code d'invitation</span>
          <span class="label-optional" id="parrainBadge" style="display:none;color:#E8521A;font-weight:600;">✓ Pré-rempli</span>
        </div>
        <div class="input-row">
          <span class="input-icon">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#E8521A" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
          </span>
          <input type="text" id="codeParrainInput" name="code_parrain" placeholder="code d'invitation" value="{{ old('code_parrain') }}" style="border-color:rgba(232,82,26,0.3);background:#FEF9F6;">
        </div>
      </div>

      <!-- Mot de passe -->
      <div class="field-group">
        <div class="field-label"><span class="label-text">Mot de passe</span></div>
        <div class="input-row">
          <span class="input-icon">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          </span>
          <input type="password" id="pwd" name="password" placeholder="••••••••••••" style="padding-right:44px" required>
          <button class="pass-toggle" onclick="togglePwd('pwd','eye-icon')" type="button">
            <svg id="eye-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
        </div>
      </div>

      <!-- Confirmation mot de passe -->
      <div class="field-group">
        <div class="field-label"><span class="label-text">Confirmer le mot de passe</span></div>
        <div class="input-row">
          <span class="input-icon">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          </span>
          <input type="password" id="pwd2" name="password_confirmation" placeholder="••••••••••••" style="padding-right:44px" required>
          <button class="pass-toggle" onclick="togglePwd('pwd2','eye-icon2')" type="button">
            <svg id="eye-icon2" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
        </div>
      </div>

      <!-- Checkbox -->
      <div class="checkbox-row">
        <input type="checkbox" id="terms" name="terms" required>
        <label for="terms" class="checkbox-text">
          J'accepte les <a href="#">Conditions d'Utilisation</a> et la <a href="#">Politique de Confidentialité</a>.
        </label>
      </div>

      <!-- Submit -->
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

    <!-- Login -->
    <div class="signin-row">
      Déjà membre ? <a href="{{ route('br.login') }}">Se connecter</a>
    </div>

  </div>
</div>

<script>
  // ─── AUTO-FILL CODE PARRAIN depuis ?parrain= dans l'URL ───
  (function () {
    const params = new URLSearchParams(window.location.search);
    const parrain = params.get('parrain');
    const input = document.getElementById('codeParrainInput');
    const badge = document.getElementById('parrainBadge');

    // On ne pré-remplit que si le champ n'a pas déjà une valeur
    // (old() de Laravel a la priorité en cas de re-soumission avec erreurs)
    if (parrain && input && !input.value.trim()) {
      input.value = parrain;
      input.readOnly = true; // empêche la modification accidentelle
      input.style.borderColor = 'rgba(232,82,26,0.6)';
      input.style.background = '#FEF0E8';
      if (badge) badge.style.display = 'inline';
    }
  })();

  // ─── TOGGLE MOT DE PASSE ───
  function togglePwd(inputId, iconId) {
    const pwd = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (pwd.type === 'password') {
      pwd.type = 'text';
      icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
    } else {
      pwd.type = 'password';
      icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    }
  }

  // ─── SPINNER AU SUBMIT ───
  document.getElementById('registerForm').addEventListener('submit', function () {
    const btn     = document.getElementById('submitBtn');
    const label   = document.getElementById('btnLabel');
    const spinner = document.getElementById('spinnerWrap');
    btn.disabled = true;
    label.classList.add('hidden');
    spinner.classList.add('visible');
  });
</script>
</body>
</html>