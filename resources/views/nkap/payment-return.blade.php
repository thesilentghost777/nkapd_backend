<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retour Paiement - NKAP DEY</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 500px;
            width: 100%;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .icon {
            width: 80px;
            height: 80px;
            background: #667eea;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .icon svg {
            width: 40px;
            height: 40px;
            fill: white;
        }
        h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
        }
        p {
            color: #666;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .token {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 10px;
            font-family: monospace;
            font-size: 14px;
            word-break: break-all;
            margin-bottom: 30px;
            color: #333;
        }
        .btn {
            background: #667eea;
            color: white;
            padding: 15px 40px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #5568d3;
        }
        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #667eea;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">
            <svg viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
        </div>
        
        <h1>Paiement en cours</h1>
        
        <p>{{ $message }}</p>
        
        @if($token)
        <div class="token">
            Référence: {{ $token }}
        </div>
        @endif
        
        <div class="spinner"></div>
        
        <p style="font-size: 14px; color: #999;">
            Vous serez redirigé automatiquement...
        </p>
        
        <button onclick="closeWindow()" class="btn">
            Fermer
        </button>
    </div>

    <script>
        function closeWindow() {
            // Tentative de fermeture pour WebView mobile
            if (window.ReactNativeWebView) {
                window.ReactNativeWebView.postMessage(JSON.stringify({
                    action: 'close',
                    token: '{{ $token }}'
                }));
            }
            
            // Tentative de fermeture pour WebView Flutter
            if (window.flutter_inappwebview) {
                window.flutter_inappwebview.callHandler('close', {
                    token: '{{ $token }}'
                });
            }
            
            // Pour navigateur standard - ferme l'onglet/fenêtre
            window.close();
            
            // Si window.close() ne fonctionne pas (certains navigateurs bloquent)
            // Rediriger vers une page vide ou une URL about:blank
            setTimeout(() => {
                window.location.href = 'about:blank';
            }, 500);
        }
        
        // Tentative de fermeture automatique après 2 secondes
        setTimeout(() => {
            document.querySelector('.spinner').style.display = 'none';
            
            // Auto-fermeture après affichage du message
            setTimeout(() => {
                closeWindow();
            }, 1000);
        }, 2000);
    </script>
</body>
</html>