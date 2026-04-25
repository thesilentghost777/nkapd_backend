<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">
  <title>Profil • Style Pro</title>
  <!-- Typographie Apple-like -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600&display=swap" rel="stylesheet">
  <!-- Font Awesome pour les icônes (gardé pour la fonctionnalité) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: "Inter", -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, sans-serif;
      background: #f5f5f7; /* Fond Apple gris clair pour la WebView */
      display: flex;
      align-items: flex-start;
      justify-content: center;
      min-height: 100vh;
      padding: 16px 16px 24px;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    /* Carte Principale — Effet "Frosted Glass" doux */
    .profile-card {
      max-width: 480px;
      width: 100%;
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border-radius: 32px;
      box-shadow: 
        0 8px 32px rgba(0, 0, 0, 0.02),
        0 2px 8px rgba(0, 0, 0, 0.02),
        0 0 0 0.5px rgba(0, 0, 0, 0.03);
      padding: 24px 20px 28px;
      border: 1px solid rgba(255, 255, 255, 0.6);
      transition: box-shadow 0.2s ease;
    }

    /* En-tête avec loader inline */
    .header-section {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 28px;
    }

    h1 {
      font-size: 22px;
      font-weight: 600;
      letter-spacing: -0.02em;
      color: #1d1c1f;
      background: linear-gradient(135deg, #1d1c1f 0%, #3a3a3c 100%);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }

    /* Conteneur pour le loader à côté du titre */
    .title-loader-wrapper {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    /* Spin Loader — Style Apple SF Symbols */
    .spin-loader {
      width: 20px;
      height: 20px;
      border: 2.5px solid rgba(60, 60, 67, 0.15);
      border-top-color: #007AFF;
      border-radius: 50%;
      animation: spin 0.75s linear infinite;
      opacity: 0;
      transition: opacity 0.2s;
      pointer-events: none;
    }

    .spin-loader.visible {
      opacity: 1;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    /* Avatar — Style soft */
    .avatar-wrapper {
      display: flex;
      justify-content: center;
      margin-bottom: 24px;
    }

    .avatar {
      width: 96px;
      height: 96px;
      border-radius: 50%;
      background: #ffffff;
      box-shadow: 
        0 12px 24px -8px rgba(0, 0, 0, 0.05),
        0 2px 4px rgba(0, 0, 0, 0.02),
        inset 0 0 0 1px rgba(0, 0, 0, 0.02);
      display: flex;
      align-items: center;
      justify-content: center;
      color: #007AFF;
      font-size: 40px;
      transition: transform 0.2s ease;
      border: 3px solid rgba(255, 255, 255, 0.9);
    }

    /* Infos utilisateur */
    .user-name {
      text-align: center;
      font-size: 24px;
      font-weight: 600;
      letter-spacing: -0.02em;
      color: #1c1c1e;
      margin-bottom: 4px;
    }

    .user-title {
      text-align: center;
      font-size: 15px;
      font-weight: 400;
      color: #8e8e93;
      margin-bottom: 28px;
    }

    /* Champs de formulaire — style iOS */
    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      font-size: 13px;
      font-weight: 500;
      text-transform: uppercase;
      letter-spacing: 0.3px;
      color: #6c6c70;
      margin-bottom: 8px;
      margin-left: 4px;
    }

    .input-wrapper {
      position: relative;
      display: flex;
      align-items: center;
    }

    .input-icon {
      position: absolute;
      left: 16px;
      color: #8e8e93;
      font-size: 16px;
      width: 18px;
      text-align: center;
      pointer-events: none;
    }

    input, select {
      width: 100%;
      padding: 16px 16px 16px 48px;
      font-family: "Inter", sans-serif;
      font-size: 16px;
      font-weight: 400;
      color: #1c1c1e;
      background: rgba(255, 255, 255, 0.9);
      border: 0.5px solid rgba(60, 60, 67, 0.08);
      border-radius: 18px;
      box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
      outline: none;
      transition: all 0.2s cubic-bezier(0.2, 0.9, 0.4, 1);
      backdrop-filter: blur(5px);
      -webkit-backdrop-filter: blur(5px);
      appearance: none;
      -webkit-appearance: none;
    }

    select {
      background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="%238e8e93" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>');
      background-repeat: no-repeat;
      background-position: right 16px center;
      background-size: 16px;
    }

    input:focus, select:focus {
      border-color: #007AFF;
      box-shadow: 0 0 0 3px rgba(0, 122, 255, 0.1);
      background: #ffffff;
    }

    input::placeholder {
      color: #aeaeb2;
      font-weight: 400;
    }

    /* Bouton — style Apple doux */
    .action-button {
      width: 100%;
      padding: 16px 20px;
      margin-top: 16px;
      background: #007AFF;
      border: none;
      border-radius: 36px;
      color: white;
      font-family: "Inter", sans-serif;
      font-size: 17px;
      font-weight: 600;
      letter-spacing: -0.01em;
      box-shadow: 0 4px 12px rgba(0, 122, 255, 0.2);
      cursor: pointer;
      transition: all 0.2s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      backdrop-filter: blur(5px);
      -webkit-backdrop-filter: blur(5px);
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .action-button:hover {
      background: #005bbf;
      box-shadow: 0 6px 16px rgba(0, 122, 255, 0.25);
      transform: scale(1.01);
    }

    .action-button:active {
      transform: scale(0.99);
      background: #004a99;
      box-shadow: 0 2px 6px rgba(0, 122, 255, 0.2);
    }

    /* Loader dans le bouton (état chargement) */
    .button-spin {
      width: 18px;
      height: 18px;
      border: 2px solid rgba(255, 255, 255, 0.4);
      border-top-color: white;
      border-radius: 50%;
      animation: spin 0.8s linear infinite;
      display: inline-block;
    }

    /* Zone des crédits — discrète mais présente */
    .credits-badge {
      margin-top: 28px;
      display: flex;
      justify-content: center;
      font-size: 12px;
      color: #8e8e93;
      letter-spacing: 0.2px;
    }

    .credits-badge i {
      margin: 0 4px;
      font-size: 10px;
      color: #c6c6c8;
    }

    /* Responsive fine tuning */
    @media (max-width: 400px) {
      body { padding: 12px; }
      .profile-card { padding: 20px 16px; }
      h1 { font-size: 20px; }
    }
  </style>
</head>
<body>

<div class="profile-card">
  
  <!-- Header avec Spin Loader intégré (UX guidage) -->
  <div class="header-section">
    <div class="title-loader-wrapper">
      <h1>Mon Profil</h1>
      <!-- Le loader apparaît dynamiquement via JS -->
      <div class="spin-loader" id="headerLoader"></div>
    </div>
    <i class="fas fa-ellipsis" style="color: #8e8e93; opacity: 0.7; font-size: 18px;"></i>
  </div>

  <!-- Avatar & Infos (données inchangées) -->
  <div class="avatar-wrapper">
    <div class="avatar">
      <i class="fas fa-user-circle"></i>
    </div>
  </div>
  <div class="user-name">Sophie Durand</div>
  <div class="user-title">Développeuse Senior • Paris</div>

  <!-- Formulaire (mêmes champs fonctionnels) -->
  <form id="profileForm">
    <div class="form-group">
      <label>Email professionnel</label>
      <div class="input-wrapper">
        <i class="fas fa-envelope input-icon"></i>
        <input type="email" id="email" value="sophie.durand@example.com" placeholder="votre.email@domaine.com">
      </div>
    </div>

    <div class="form-group">
      <label>Téléphone</label>
      <div class="input-wrapper">
        <i class="fas fa-phone input-icon"></i>
        <input type="tel" id="phone" value="+33 6 12 34 56 78" placeholder="+33 ...">
      </div>
    </div>

    <div class="form-group">
      <label>Département</label>
      <div class="input-wrapper">
        <i class="fas fa-building input-icon"></i>
        <select id="department">
          <option>Ingénierie</option>
          <option selected>Design & Produit</option>
          <option>Marketing</option>
          <option>Ressources Humaines</option>
        </select>
      </div>
    </div>

    <!-- Bouton avec gestion de l'état de chargement -->
    <button type="button" id="saveButton" class="action-button">
      <span id="buttonText">Enregistrer les modifications</span>
      <span id="buttonLoader" class="button-spin" style="display: none;"></span>
    </button>
  </form>

  <!-- Copyright discret (identité visuelle préservée) -->
  <div class="credits-badge">
    <span>© 2026 MyCorp</span>
    <i class="fas fa-circle"></i>
    <span>v2.4.1</span>
    <i class="fas fa-circle"></i>
    <span><i class="far fa-clock"></i> 10:32</span>
  </div>
</div>

<script>
  (function() {
    "use strict";

    // Éléments UI pour les loaders
    const headerLoader = document.getElementById('headerLoader');
    const saveBtn = document.getElementById('saveButton');
    const buttonText = document.getElementById('buttonText');
    const buttonLoader = document.getElementById('buttonLoader');
    
    // Inputs (pour démo)
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');
    const deptSelect = document.getElementById('department');

    // État local
    let isSaving = false;
    let fetchTimeout = null;

    // ----- Simuler un chargement initial (guider l'utilisateur) -----
    function showInitialLoader() {
      headerLoader.classList.add('visible');
      
      // Simule une récupération de données (ex: appel API)
      setTimeout(() => {
        headerLoader.classList.remove('visible');
      }, 1200);
    }

    // ----- Gestion de la sauvegarde avec loader dans le bouton -----
    function simulateSave() {
      if (isSaving) return;

      isSaving = true;
      
      // UI : désactiver le bouton, afficher le spinner
      saveBtn.style.pointerEvents = 'none';
      saveBtn.style.opacity = '0.8';
      buttonText.style.opacity = '0.7';
      buttonLoader.style.display = 'inline-block';
      
      // Récupération des données (inchangées)
      const userData = {
        email: emailInput.value,
        phone: phoneInput.value,
        department: deptSelect.value
      };
      
      console.log('💾 Sauvegarde en cours...', userData);
      
      // Simuler un appel réseau (1.5s) avec le spinner actif
      fetchTimeout = setTimeout(() => {
        // Réactiver le bouton
        isSaving = false;
        saveBtn.style.pointerEvents = '';
        saveBtn.style.opacity = '';
        buttonText.style.opacity = '';
        buttonLoader.style.display = 'none';
        
        // Feedback visuel discret (optionnel) - changement temporaire du texte
        const originalText = buttonText.innerText;
        buttonText.innerText = '✓ Modifications enregistrées';
        setTimeout(() => {
          buttonText.innerText = originalText;
        }, 1800);
        
        console.log('✅ Profil mis à jour (simulation)');
      }, 1500);
    }

    // ----- Cleanup en cas de démontage (bonne pratique) -----
    function cleanup() {
      if (fetchTimeout) {
        clearTimeout(fetchTimeout);
      }
    }

    // ----- Attacher les événements -----
    saveBtn.addEventListener('click', simulateSave);

    // Lancer le loader d'en-tête au chargement (expérience utilisateur guidée)
    window.addEventListener('load', () => {
      showInitialLoader();
    });

    // Nettoyage (pour SPA / webview)
    window.addEventListener('beforeunload', cleanup);
    
    // Si vous souhaitez une démo plus interactive, voici un petit Easter Egg UX :
    // Quand on clique sur l'avatar, ça déclenche aussi le loader d'en-tête (démo)
    document.querySelector('.avatar').addEventListener('click', () => {
      if (!isSaving) {
        headerLoader.classList.add('visible');
        setTimeout(() => headerLoader.classList.remove('visible'), 800);
      }
    });

  })();
</script>

<!-- Note: Les informations et fonctionnalités originales sont conservées :
     - Champs email, tel, département avec leurs valeurs par défaut
     - Bouton de sauvegarde
     - Avatar et nom
     L'ajout des spinners guide l'utilisateur sans altérer les données. -->
</body>
</html>