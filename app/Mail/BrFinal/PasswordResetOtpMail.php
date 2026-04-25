<?php

namespace App\Mail\BrFinal;

use App\Models\BrFinal\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $code;

    public function __construct(User $user, string $code)
    {
        $this->user = $user;
        $this->code = $code;
    }

    public function build(): static
    {
        return $this
            ->subject('Business Room — Réinitialisation de votre mot de passe')
            ->html($this->buildHtml());
    }

    private function buildHtml(): string
    {
        $prenom = e($this->user->prenom);
        $code   = e($this->code);

        return <<<HTML
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
</head>
<body style="margin:0;padding:0;background:#f5f4f0;font-family:'DM Sans',Arial,sans-serif">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f5f4f0;padding:40px 0">
        <tr>
            <td align="center">
                <table width="480" cellpadding="0" cellspacing="0"
                       style="background:white;border-radius:20px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.08)">

                    {{-- Header --}}
                    <tr>
                        <td style="background:#c2601a;padding:28px 32px;text-align:center">
                            <div style="width:52px;height:52px;background:rgba(255,255,255,0.2);border-radius:14px;display:inline-flex;align-items:center;justify-content:center;margin-bottom:12px">
                                <span style="color:white;font-size:24px;font-weight:bold;line-height:52px">B</span>
                            </div>
                            <p style="color:rgba(255,255,255,0.85);font-size:13px;margin:0">Business Room</p>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding:36px 32px">
                            <h1 style="font-size:20px;font-weight:700;color:#1a1a1a;margin:0 0 10px 0">
                                Réinitialisation du mot de passe
                            </h1>
                            <p style="font-size:14px;color:#666;margin:0 0 24px 0">
                                Bonjour <strong>{$prenom}</strong>, voici votre code OTP pour réinitialiser votre mot de passe Business Room.
                            </p>

                            {{-- Code box --}}
                            <div style="background:#fef6f0;border:2px dashed #c2601a;border-radius:16px;padding:24px;text-align:center;margin-bottom:24px">
                                <p style="font-size:11px;color:#c2601a;font-weight:600;text-transform:uppercase;letter-spacing:1px;margin:0 0 10px 0">
                                    Code de réinitialisation
                                </p>
                                <p style="font-size:38px;font-weight:800;color:#c2601a;letter-spacing:10px;margin:0;font-family:monospace">
                                    {$code}
                                </p>
                            </div>

                            <p style="font-size:13px;color:#888;margin:0 0 8px 0">
                                ⏱ Ce code est valide pendant <strong>15 minutes</strong>.
                            </p>
                            <p style="font-size:13px;color:#888;margin:0">
                                Si vous n'avez pas demandé cette réinitialisation, ignorez cet email. Votre mot de passe actuel reste inchangé.
                            </p>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background:#fafaf8;border-top:1px solid #efede8;padding:20px 32px;text-align:center">
                            <p style="font-size:12px;color:#bbb;margin:0">
                                © Business Room — Yaoundé, Cameroun
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
HTML;
    }
}