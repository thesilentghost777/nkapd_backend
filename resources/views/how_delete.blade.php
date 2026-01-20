<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppression de compte - {{ config('app.name') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f5f5f5;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        .header h1 {
            color: #d32f2f;
            margin-bottom: 10px;
            font-size: 28px;
        }

        .app-info {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #2196F3;
        }

        .content-section {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .content-section h2 {
            color: #1976D2;
            margin-bottom: 15px;
            font-size: 22px;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 10px;
        }

        .content-section h3 {
            color: #424242;
            margin-top: 20px;
            margin-bottom: 10px;
            font-size: 18px;
        }

        .data-list {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin: 15px 0;
        }

        .data-list ul {
            list-style: none;
            padding-left: 0;
        }

        .data-list li {
            padding: 8px 0;
            padding-left: 25px;
            position: relative;
        }

        .data-list li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #4CAF50;
            font-weight: bold;
        }

        .data-list.retained li:before {
            content: "i";
            background: #FF9800;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-style: italic;
        }

        .warning-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }

        .warning-box strong {
            color: #856404;
        }

        .contact-box {
            background: #e8f5e9;
            border: 2px solid #4CAF50;
            padding: 25px;
            border-radius: 10px;
            margin: 25px 0;
            text-align: center;
        }

        .contact-box h3 {
            color: #2e7d32;
            margin-bottom: 15px;
        }

        .email-button {
            display: inline-block;
            background: #4CAF50;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 10px 0;
            transition: background 0.3s;
        }

        .email-button:hover {
            background: #45a049;
        }

        .email-info {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            margin-top: 15px;
            font-family: monospace;
            font-size: 14px;
        }

        .steps {
            counter-reset: step-counter;
            list-style: none;
            padding-left: 0;
        }

        .steps li {
            counter-increment: step-counter;
            padding: 15px;
            margin: 15px 0;
            background: #f9f9f9;
            border-radius: 5px;
            border-left: 4px solid #2196F3;
            position: relative;
            padding-left: 60px;
        }

        .steps li:before {
            content: counter(step-counter);
            position: absolute;
            left: 15px;
            top: 15px;
            background: #2196F3;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .timeline {
            background: #fff8e1;
            border-left: 4px solid #FFC107;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }

        .footer {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 14px;
        }

        @media (max-width: 600px) {
            .container {
                padding: 10px;
            }

            .header, .content-section {
                padding: 20px;
            }

            .header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🗑️ Suppression de compte</h1>
            <p>Procédure de suppression des données utilisateur</p>
        </div>

        <div class="app-info">
            <strong>Application concernée :</strong> {{ config('app.name') }}<br>
            <strong>Développeur :</strong> {{ config('app.name') }} Team<br>
            <strong>Dernière mise à jour :</strong> {{ date('d/m/Y') }}
        </div>

        <div class="content-section">
            <h2>📋 Comment supprimer votre compte</h2>
            <p>Nous respectons votre droit à la suppression de vos données personnelles. Suivez la procédure ci-dessous pour demander la suppression complète de votre compte.</p>

            <ol class="steps">
                <li>
                    <strong>Envoyez un email de demande</strong><br>
                    Contactez notre service client à l'adresse email indiquée ci-dessous avec l'objet "Suppression de compte".
                </li>
                <li>
                    <strong>Incluez les informations nécessaires</strong><br>
                    Indiquez l'adresse email associée à votre compte et votre identifiant utilisateur (si connu).
                </li>
                <li>
                    <strong>Confirmation de réception</strong><br>
                    Vous recevrez une confirmation de votre demande sous 48 heures ouvrées.
                </li>
                <li>
                    <strong>Suppression effective</strong><br>
                    Votre compte et vos données seront supprimés dans un délai maximum de 30 jours.
                </li>
            </ol>

            <div class="contact-box">
                <h3>📧 Contactez notre service client</h3>
                <a href="mailto:wilfrieddark2.0@gmail.com?subject=Suppression de compte - {{ config('app.name') }}&body=Bonjour,%0D%0A%0D%0AJe souhaite supprimer mon compte.%0D%0A%0D%0AEmail du compte : [Votre email]%0D%0AIdentifiant utilisateur : [Votre ID si connu]%0D%0A%0D%0AMerci." 
                   class="email-button">
                    Envoyer un email de suppression
                </a>
                <div class="email-info">
                    <strong>Email :</strong> wilfrieddark2.0@gmail.com<br>
                    <strong>Objet :</strong> Suppression de compte - {{ config('app.name') }}
                </div>
            </div>

            <div class="warning-box">
                <strong>⚠️ Attention :</strong> La suppression de votre compte est définitive et irréversible. Toutes vos données seront définitivement perdues.
            </div>
        </div>

        <div class="content-section">
            <h2>🗂️ Données qui seront supprimées</h2>
            <p>Les données suivantes seront définitivement supprimées de nos serveurs :</p>
            
            <div class="data-list">
                <ul>
                    <li>Informations de compte (email, nom d'utilisateur, mot de passe)</li>
                    <li>Données de profil utilisateur</li>
                    <li>Préférences et paramètres de l'application</li>
                    <li>Historique d'utilisation et interactions</li>
                    <li>Contenu généré par l'utilisateur</li>
                    <li>Photos et médias téléchargés</li>
                    <li>Messages et communications</li>
                    <li>Données de localisation</li>
                    <li>Données analytiques liées à votre compte</li>
                </ul>
            </div>
        </div>

        <div class="content-section">
            <h2>📦 Données conservées (si applicable)</h2>
            <p>Conformément aux obligations légales, certaines données peuvent être conservées temporairement :</p>
            
            <div class="data-list retained">
                <ul>
                    <li><strong>Données de facturation et transactions :</strong> Conservées 10 ans pour conformité fiscale et comptable</li>
                    <li><strong>Logs de sécurité anonymisés :</strong> Conservés 12 mois pour prévention de la fraude</li>
                    <li><strong>Données légales obligatoires :</strong> Conservées selon les durées légales en vigueur</li>
                    <li><strong>Données agrégées et anonymisées :</strong> Utilisées uniquement pour statistiques (non liées à votre identité)</li>
                </ul>
            </div>

            <p style="margin-top: 15px; font-size: 14px; color: #666;">
                <strong>Note :</strong> Ces données conservées ne permettent pas de vous identifier personnellement et sont traitées dans le strict respect du RGPD et des lois locales sur la protection des données.
            </p>
        </div>

        <div class="content-section">
            <h2>⏱️ Délais de suppression</h2>
            
            <div class="timeline">
                <strong>Délai de traitement :</strong>
                <ul style="margin-top: 10px; margin-left: 20px;">
                    <li><strong>Confirmation initiale :</strong> Sous 48 heures ouvrées</li>
                    <li><strong>Suppression des données actives :</strong> 7 jours maximum</li>
                    <li><strong>Suppression des sauvegardes :</strong> 30 jours maximum</li>
                    <li><strong>Purge complète des systèmes :</strong> 30 jours maximum</li>
                </ul>
            </div>

            <p style="margin-top: 15px;">
                Après la suppression, votre compte ne pourra plus être récupéré. Si vous souhaitez utiliser à nouveau nos services, vous devrez créer un nouveau compte.
            </p>
        </div>

        <div class="content-section">
            <h2>🔒 Vos droits</h2>
            <p>Conformément au RGPD et aux lois sur la protection des données, vous disposez également des droits suivants :</p>
            
            <div class="data-list">
                <ul>
                    <li><strong>Droit d'accès :</strong> Demander une copie de vos données personnelles</li>
                    <li><strong>Droit de rectification :</strong> Corriger des données inexactes</li>
                    <li><strong>Droit à la portabilité :</strong> Recevoir vos données dans un format structuré</li>
                    <li><strong>Droit d'opposition :</strong> S'opposer au traitement de vos données</li>
                    <li><strong>Droit à la limitation :</strong> Limiter le traitement de vos données</li>
                </ul>
            </div>

            <p style="margin-top: 15px;">
                Pour exercer ces droits, contactez-nous à la même adresse email : 
                <strong>wilfrieddark2.0@gmail.com</strong>
            </p>
        </div>

        <div class="content-section">
            <h2>❓ Questions fréquentes</h2>
            
            <h3>Puis-je annuler ma demande de suppression ?</h3>
            <p>Oui, tant que la suppression n'a pas été effectuée. Contactez-nous rapidement pour annuler votre demande.</p>

            <h3>Que se passe-t-il si j'ai des achats ou abonnements actifs ?</h3>
            <p>Nous vous recommandons d'annuler d'abord vos abonnements. Les achats déjà effectués ne seront pas remboursés.</p>

            <h3>Mes données seront-elles vraiment supprimées ?</h3>
            <p>Oui, toutes vos données personnelles identifiables seront définitivement supprimées, à l'exception des données que nous sommes légalement obligés de conserver.</p>

            <h3>Combien de temps faut-il pour supprimer mon compte ?</h3>
            <p>La suppression complète prend maximum 30 jours. Vous recevrez une confirmation par email une fois le processus terminé.</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.</p>
            <p style="margin-top: 10px;">
                <a href="{{ url('/') }}" style="color: #2196F3; text-decoration: none;">Retour à l'accueil</a> | 
                <a href="mailto:wilfrieddark2.0@gmail.com" style="color: #2196F3; text-decoration: none;">Contact</a>
            </p>
        </div>
    </div>
</body>
</html>