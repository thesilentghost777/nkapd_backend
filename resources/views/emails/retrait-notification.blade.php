<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border: 1px solid #ddd;
        }
        .alert {
            background: #fff3cd;
            border: 1px solid #ffc107;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .details {
            background: white;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: bold;
            color: #666;
        }
        .value {
            color: #333;
        }
        .highlight {
            background: #667eea;
            color: white;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            margin: 20px 0;
            font-size: 18px;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🔔 Nouvelle Demande de Retrait</h1>
        <p>Traitement Manuel Requis</p>
    </div>

    <div class="content">
        <div class="alert">
            <strong>⚠️ Action Requise</strong><br>
            Une nouvelle demande de retrait vient d'être initiée et nécessite un traitement manuel dans les 24h.
        </div>

        <div class="details">
            <h3>📋 Informations Client</h3>
            <div class="detail-row">
                <span class="label">Nom complet:</span>
                <span class="value">{{ $user_name }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Email:</span>
                <span class="value">{{ $user_email }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Téléphone:</span>
                <span class="value">{{ $user_phone }}</span>
            </div>
        </div>

        <div class="details">
            <h3>💰 Détails de la Transaction</h3>
            <div class="detail-row">
                <span class="label">Référence:</span>
                <span class="value">{{ $reference }}</span>
            </div>
            <div class="detail-row">
                <span class="label">ID Transaction:</span>
                <span class="value">#{{ $transaction_id }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Date de demande:</span>
                <span class="value">{{ $date }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Montant demandé:</span>
                <span class="value">{{ $montant_brut }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Frais (25%):</span>
                <span class="value" style="color: #dc3545;">- {{ $frais }}</span>
            </div>
        </div>

        <div class="highlight">
            Montant à envoyer: {{ $montant_net }}
        </div>

        <div class="details">
            <h3>📱 Informations de Transfert</h3>
            <div class="detail-row">
                <span class="label">Numéro destinataire:</span>
                <span class="value">{{ $telephone_destinataire }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Nom du compte:</span>
                <span class="value" style="color: #667eea; font-weight: 600;">{{ $nom_associe }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Opérateur:</span>
                <span class="value">{{ $operateur }}</span>
            </div>
        </div>

        <div class="alert">
            <strong>📌 Instructions:</strong>
            <ol style="margin: 10px 0; padding-left: 20px;">
                <li>Effectuer le transfert de <strong>{{ $montant_net }}</strong> vers le <strong>{{ $telephone_destinataire }}</strong></li>
                <li>Vérifier que le nom du compte est bien <strong>{{ $nom_associe }}</strong></li>
                <li>Confirmer la transaction dans le système</li>
                <li>Le client sera notifié automatiquement</li>
            </ol>
        </div>
    </div>

    <div class="footer">
        <p>Ce mail a été envoyé automatiquement par le système NKAP</p>
        <p>Ne pas répondre à ce message</p>
    </div>
</body>
</html>