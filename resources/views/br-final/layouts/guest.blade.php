<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Business Room')</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #f8f7f4;
            color: #1a1a1a;
            min-height: 100vh;
        }

        h1, h2, h3 {
            font-family: 'Syne', sans-serif;
        }

        /* Container principal */
        .guest-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .guest-box {
            width: 100%;
            max-width: 460px;
            margin: 0 auto;
        }

        /* Cartes */
        .card {
            background: white;
            border-radius: 24px;
            padding: 28px 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            border: 1px solid #e8e6e1;
        }

        /* Bouton principal */
        .btn-primary {
            background: #c2601a;
            color: white;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            border: none;
            border-radius: 14px;
            padding: 12px 20px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
            width: 100%;
            text-align: center;
            display: inline-block;
        }

        .btn-primary:hover {
            background: #a04e12;
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(194, 96, 26, 0.2);
        }

        /* Champs de formulaire */
        .input {
            width: 100%;
            background: #f5f4f0;
            border: 1px solid #e8e6e1;
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 13px;
            color: #1a1a1a;
            transition: all 0.2s ease;
            font-family: 'DM Sans', sans-serif;
        }

        .input:focus {
            outline: none;
            border-color: #c2601a;
            background: white;
            box-shadow: 0 0 0 3px rgba(194, 96, 26, 0.08);
        }

        .input::placeholder {
            color: #aaa;
        }

        /* Labels */
        .label {
            display: block;
            font-size: 12px;
            color: #666;
            margin-bottom: 6px;
            font-weight: 500;
        }

        /* Messages d'alerte */
        .alert-error {
            background: #fef2f0;
            border: 1px solid #f0c4bc;
            border-radius: 12px;
            padding: 12px 14px;
            color: #c0392b;
            font-size: 12px;
            margin-bottom: 16px;
        }

        .alert-success {
            background: #eef5ea;
            border: 1px solid #c8e0b5;
            border-radius: 12px;
            padding: 12px 14px;
            color: #2d7a22;
            font-size: 12px;
            margin-bottom: 16px;
        }

        /* Logo */
        .logo-wrapper {
            width: 64px;
            height: 64px;
            background: #c2601a;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px auto;
        }

        .logo-text {
            color: white;
            font-size: 30px;
            font-weight: 800;
            font-family: 'Syne', sans-serif;
        }

        /* Titre de page */
        .page-title {
            font-family: 'Syne', sans-serif;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 6px;
            text-align: center;
            color: #1a1a1a;
        }

        .page-subtitle {
            font-size: 13px;
            color: #888;
            text-align: center;
            margin-top: 4px;
        }

        /* Séparateur */
        .separator {
            border-top: 1px solid #e8e6e1;
            margin-top: 22px;
            padding-top: 18px;
        }

        /* Lien */
        .link {
            color: #c2601a;
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.2s;
        }

        .link:hover {
            opacity: 0.8;
            text-decoration: underline;
        }

        /* Checkbox */
        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 22px;
        }

        .checkbox-wrapper input {
            width: 16px;
            height: 16px;
            margin: 0;
            accent-color: #c2601a;
        }

        .checkbox-wrapper label {
            font-size: 12px;
            color: #888;
        }

        /* Grid pour 2 colonnes */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 18px;
        }

        /* Champ de formulaire groupé */
        .form-group {
            margin-bottom: 18px;
        }

        /* Note aide */
        .help-text {
            font-size: 10px;
            color: #aaa;
            margin-top: 5px;
        }

        /* Badge optionnel */
        .optional-badge {
            color: #aaa;
            font-weight: normal;
            font-size: 11px;
        }

        /* Message d'erreur de validation */
        .error-message {
            color: #dc3545;
            font-size: 11px;
            margin-top: 6px;
        }
    </style>
</head>
<body>
<div class="guest-container">
    <div class="guest-box">
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @yield('content')
    </div>
</div>
</body>
</html>