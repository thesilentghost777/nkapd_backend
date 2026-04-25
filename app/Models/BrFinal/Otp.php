<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code de connexion</title>
</head>
<body style="margin:0;padding:0;background:#f5f4f0;font-family:'DM Sans',Arial,sans-serif">
    <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 16px">
        <tr>
            <td align="center">
                <table width="100%" style="max-width:480px;background:white;border-radius:20px;overflow:hidden;box-shadow:0 2px 16px rgba(0,0,0,0.06)">

                    {{-- Header --}}
                    <tr>
                        <td style="background:#c2601a;padding:32px;text-align:center">
                            <div style="width:52px;height:52px;background:rgba(255,255,255,0.2);border-radius:14px;display:inline-flex;align-items:center;justify-content:center;margin-bottom:12px">
                                <span style="color:white;font-size:26px;font-weight:800">B</span>
                            </div>
                            <p style="color:white;font-size:20px;font-weight:700;margin:0;font-family:Syne,Arial,sans-serif">Business Room</p>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding:36px 32px">
                            <p style="font-size:16px;color:#1a1a1a;margin:0 0 8px 0">
                                Bonjour <strong>{{ $user->prenom }}</strong>,
                            </p>
                            <p style="font-size:14px;color:#666;margin:0 0 28px 0;line-height:1.6">
                                Voici votre code de connexion à Business Room. Ce code est valable <strong>10 minutes</strong>.
                            </p>

                            {{-- Code OTP --}}
                            <div style="background:#fef0e6;border:2px dashed #c2601a;border-radius:16px;padding:24px;text-align:center;margin-bottom:28px">
                                <p style="font-size:11px;color:#9a4510;margin:0 0 10px 0;text-transform:uppercase;letter-spacing:1px;font-weight:600">Votre code</p>
                                <p style="font-size:40px;font-weight:800;color:#c2601a;letter-spacing:10px;margin:0;font-family:Syne,Arial,sans-serif">{{ $code }}</p>
                            </div>

                            <p style="font-size:13px;color:#999;margin:0;line-height:1.6">
                                Si vous n'avez pas demandé ce code, ignorez cet email. Votre compte reste sécurisé.
                            </p>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background:#fafaf8;padding:20px 32px;border-top:1px solid #efede8;text-align:center">
                            <p style="font-size:12px;color:#aaa;margin:0">
                                © {{ date('Y') }} Business Room · Ce message est confidentiel
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>