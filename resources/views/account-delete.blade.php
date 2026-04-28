<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer mon compte – Business Room</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:        #0b0e13;
            --surface:   #111418;
            --border:    #1e2330;
            --accent:    #e8533a;
            --accent-h:  #ff6b52;
            --warn-bg:   #1a1008;
            --warn-bd:   #5c2c14;
            --text:      #eaedf3;
            --muted:     #7a8099;
            --success:   #2ecc71;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            line-height: 1.65;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 16px 80px;
        }

        /* ── Header ── */
        header {
            width: 100%;
            max-width: 540px;
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 48px;
        }

        .logo-mark {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, var(--accent), #c0392b);
            border-radius: 12px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
        }

        .logo-mark svg { width: 22px; height: 22px; }

        .brand { font-family: 'Syne', sans-serif; font-weight: 800; font-size: 1.15rem; letter-spacing: -.02em; }
        .brand span { color: var(--accent); }

        /* ── Card ── */
        .card {
            width: 100%; max-width: 540px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
        }

        .card-header {
            padding: 32px 36px 28px;
            border-bottom: 1px solid var(--border);
            position: relative;
        }

        .card-header::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 60% 80% at 10% 0%, rgba(232,83,58,.08), transparent 70%);
            pointer-events: none;
        }

        .icon-circle {
            width: 56px; height: 56px;
            background: rgba(232,83,58,.12);
            border: 1.5px solid rgba(232,83,58,.3);
            border-radius: 50%;
            display: grid; place-items: center;
            margin-bottom: 20px;
        }

        .icon-circle svg { width: 24px; height: 24px; color: var(--accent); }

        h1 {
            font-family: 'Syne', sans-serif;
            font-size: 1.55rem;
            font-weight: 800;
            letter-spacing: -.03em;
            line-height: 1.2;
            margin-bottom: 8px;
        }

        .subtitle { color: var(--muted); font-size: .92rem; }

        /* ── Warning box ── */
        .warning-box {
            margin: 28px 36px 0;
            padding: 16px 20px;
            background: var(--warn-bg);
            border: 1px solid var(--warn-bd);
            border-radius: 12px;
            display: flex;
            gap: 14px;
            align-items: flex-start;
        }

        .warning-box svg { flex-shrink: 0; margin-top: 2px; color: #e8a23a; width: 18px; height: 18px; }

        .warning-box p { font-size: .88rem; color: #c9a06a; line-height: 1.55; }

        /* ── Body ── */
        .card-body { padding: 28px 36px 32px; }

        label {
            display: block;
            font-size: .8rem;
            font-weight: 500;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 8px;
        }

        input[type="email"],
        input[type="password"],
        textarea {
            width: 100%;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-size: .95rem;
            padding: 13px 16px;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        input[type="email"]:focus,
        input[type="password"]:focus,
        textarea:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(232,83,58,.15);
        }

        textarea { resize: vertical; min-height: 90px; }

        .field { margin-bottom: 22px; }

        /* ── Checklist ── */
        .consequences {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 18px 20px;
            margin-bottom: 24px;
        }

        .consequences-title {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: .9rem;
            margin-bottom: 14px;
            color: #b0b8cc;
        }

        .consequence-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 10px;
            font-size: .875rem;
            color: var(--muted);
        }

        .consequence-item:last-child { margin-bottom: 0; }

        .dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--accent);
            flex-shrink: 0;
            margin-top: 7px;
        }

        /* ── Checkbox confirm ── */
        .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 28px;
            cursor: pointer;
        }

        .checkbox-group input[type="checkbox"] {
            width: 18px; height: 18px;
            accent-color: var(--accent);
            flex-shrink: 0;
            margin-top: 2px;
            cursor: pointer;
        }

        .checkbox-group span { font-size: .88rem; color: var(--muted); line-height: 1.5; }

        /* ── Button ── */
        .btn-delete {
            width: 100%;
            padding: 15px;
            background: var(--accent);
            color: #fff;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: .97rem;
            letter-spacing: .02em;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: background .2s, transform .1s, box-shadow .2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-delete:hover { background: var(--accent-h); box-shadow: 0 6px 24px rgba(232,83,58,.35); }
        .btn-delete:active { transform: scale(.98); }
        .btn-delete:disabled { opacity: .5; cursor: not-allowed; transform: none; box-shadow: none; }

        .btn-delete svg { width: 18px; height: 18px; }

        .cancel-link {
            display: block;
            text-align: center;
            margin-top: 18px;
            color: var(--muted);
            font-size: .88rem;
            text-decoration: none;
            transition: color .2s;
        }

        .cancel-link:hover { color: var(--text); }

        /* ── Success state ── */
        .success-state {
            display: none;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 56px 36px;
            gap: 16px;
        }

        .success-icon {
            width: 72px; height: 72px;
            background: rgba(46,204,113,.1);
            border: 2px solid rgba(46,204,113,.3);
            border-radius: 50%;
            display: grid; place-items: center;
        }

        .success-icon svg { width: 32px; height: 32px; color: var(--success); }

        .success-state h2 {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.4rem;
        }

        .success-state p { color: var(--muted); font-size: .92rem; max-width: 320px; }

        /* ── Footer ── */
        footer {
            margin-top: 40px;
            text-align: center;
            color: var(--muted);
            font-size: .8rem;
        }

        footer a { color: var(--muted); text-decoration: underline; text-underline-offset: 3px; }
        footer a:hover { color: var(--text); }

        /* ── Spinner ── */
        @keyframes spin { to { transform: rotate(360deg); } }
        .spinner { width: 18px; height: 18px; border: 2px solid rgba(255,255,255,.3); border-top-color: #fff; border-radius: 50%; animation: spin .7s linear infinite; display: none; }

        /* ── Responsive ── */
        @media (max-width: 480px) {
            .card-header, .card-body { padding-left: 24px; padding-right: 24px; }
            .warning-box { margin-left: 24px; margin-right: 24px; }
            h1 { font-size: 1.3rem; }
        }
    </style>
</head>
<body>

    <header>
        <div class="logo-mark">
            <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>
                <line x1="12" y1="12" x2="12" y2="16"/><line x1="10" y1="14" x2="14" y2="14"/>
            </svg>
        </div>
        <div class="brand">Business<span>Room</span></div>
    </header>

    <div class="card">

        {{-- ── Form view ── --}}
        <div id="formView">
            <div class="card-header">
                <div class="icon-circle">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
                    </svg>
                </div>
                <h1>Supprimer mon compte</h1>
                <p class="subtitle">Cette action est permanente et irréversible.</p>
            </div>

            <div class="warning-box">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
                <p><strong>Attention :</strong> toutes vos données seront définitivement effacées dans un délai de 30 jours. Cette opération ne peut pas être annulée.</p>
            </div>

            <div class="card-body">

                {{-- Consequences --}}
                <div class="consequences">
                    <div class="consequences-title">Ce qui sera supprimé :</div>
                    <div class="consequence-item"><div class="dot"></div><span>Votre profil et informations personnelles</span></div>
                    <div class="consequence-item"><div class="dot"></div><span>Tous vos espaces de travail et projets</span></div>
                    <div class="consequence-item"><div class="dot"></div><span>Vos messages, fichiers et historique</span></div>
                    <div class="consequence-item"><div class="dot"></div><span>Vos abonnements actifs (sans remboursement)</span></div>
                    <div class="consequence-item"><div class="dot"></div><span>Vos connexions et contacts dans l'application</span></div>
                </div>

                {{-- Form --}}
                <form id="deleteForm" method="POST" action="{{ route('account.delete') }}" novalidate>
                    @csrf
                    @method('DELETE')

                    <div class="field">
                        <label for="email">Adresse e-mail du compte</label>
                        <input type="email" id="email" name="email"
                               placeholder="votre@email.com"
                               value="{{ old('email', auth()->user()->email ?? '') }}"
                               required autocomplete="email">
                        @error('email')
                            <p style="color:var(--accent);font-size:.82rem;margin-top:6px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="password">Mot de passe actuel</label>
                        <input type="password" id="password" name="password"
                               placeholder="••••••••"
                               required autocomplete="current-password">
                        @error('password')
                            <p style="color:var(--accent);font-size:.82rem;margin-top:6px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="reason">Raison de la suppression <span style="color:var(--muted);text-transform:none;font-weight:400">(facultatif)</span></label>
                        <textarea id="reason" name="reason" placeholder="Dites-nous pourquoi vous partez…">{{ old('reason') }}</textarea>
                    </div>

                    <label class="checkbox-group" for="confirm">
                        <input type="checkbox" id="confirm" name="confirm" required>
                        <span>Je comprends que cette action est irréversible et que toutes mes données seront définitivement supprimées.</span>
                    </label>

                    @if ($errors->any() && !$errors->has('email') && !$errors->has('password'))
                        <p style="color:var(--accent);font-size:.88rem;margin-bottom:18px;">{{ $errors->first() }}</p>
                    @endif

                    <button type="submit" class="btn-delete" id="submitBtn" disabled>
                        <span id="btnText">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
                            </svg>
                            Supprimer définitivement mon compte
                        </span>
                        <div class="spinner" id="spinner"></div>
                    </button>

                    <a href="{{ url('/') }}" class="cancel-link">← Annuler et retourner à l'accueil</a>
                </form>

            </div>
        </div>

        {{-- ── Success view (shown via JS or after redirect with session) ── --}}
        @if(session('account_deleted'))
        <div class="success-state" style="display:flex;">
            <div class="success-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
            </div>
            <h2>Demande enregistrée</h2>
            <p>Votre compte sera définitivement supprimé dans <strong>30 jours</strong>. Vous recevrez un e-mail de confirmation.</p>
        </div>
        @endif

    </div>

    <footer>
        <p>© {{ date('Y') }} Business Room &nbsp;·&nbsp; <a href="{{ route('privacy') ?? '#' }}">Politique de confidentialité</a> &nbsp;·&nbsp; <a href="mailto:support@businessroom.app">Support</a></p>
    </footer>

    <script>
        const checkbox  = document.getElementById('confirm');
        const submitBtn = document.getElementById('submitBtn');
        const form      = document.getElementById('deleteForm');
        const spinner   = document.getElementById('spinner');
        const btnText   = document.getElementById('btnText');

        // Enable / disable button based on checkbox
        checkbox?.addEventListener('change', () => {
            submitBtn.disabled = !checkbox.checked;
        });

        // Show spinner on submit
        form?.addEventListener('submit', (e) => {
            if (!checkbox.checked) { e.preventDefault(); return; }
            submitBtn.disabled = true;
            btnText.style.display = 'none';
            spinner.style.display = 'block';
        });
    </script>

</body>
</html>