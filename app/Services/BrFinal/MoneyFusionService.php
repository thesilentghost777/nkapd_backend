<?php

namespace App\Services\BrFinal;

use App\Models\BrFinal\Payment;
use App\Models\BrFinal\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MoneyFusionService
{
    protected string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.moneyfusion.api_url', env('MONEYFUSION_API_URL'));
    }

    public function initierPaiement(array $data): array
    {
        $paymentData = [
            'totalPrice' => (int) $data['montant'],
            'article' => [[$data['description'] ?? 'Paiement' => (int) $data['montant']]],
            'personal_Info' => [[
                'type' => $data['type'],
                'reference' => $data['reference'],
                'user_id' => $data['user_id'],
            ]],
            'numeroSend' => $data['telephone'],
            'nomclient' => $data['nom_client'],
            'return_url' => $data['return_url'] ?? config('app.url') . '/br/paiement/callback',
            'webhook_url' => config('app.url') . '/br/webhook/moneyfusion',
        ];

        try {
            $response = Http::post($this->apiUrl, $paymentData);
            $result = $response->json();

            if ($result && isset($result['statut']) && $result['statut'] === true) {
                return [
                    'success' => true,
                    'token' => $result['token'],
                    'url' => $result['url'],
                    'message' => $result['message'] ?? 'Paiement initié',
                ];
            }

            Log::error('MoneyFusion BRFINAL: Erreur', ['response' => $result]);
            return ['success' => false, 'message' => $result['message'] ?? 'Erreur paiement'];
        } catch (\Exception $e) {
            Log::error('MoneyFusion BRFINAL: Exception', ['error' => $e->getMessage()]);
            return ['success' => false, 'message' => 'Service de paiement indisponible'];
        }
    }

    public function verifierStatut(string $token): array
    {
        try {
            $response = Http::get("https://www.pay.moneyfusion.net/paiementNotif/{$token}");
            $result = $response->json();

            if ($result && isset($result['statut']) && $result['statut'] === true) {
                return ['success' => true, 'data' => $result['data'], 'statut_paiement' => $result['data']['statut'] ?? 'pending'];
            }
            return ['success' => false, 'message' => 'Impossible de récupérer le statut'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Erreur de vérification'];
        }
    }

    public function traiterWebhook(array $data): bool
    {
        $token = $data['tokenPay'] ?? null;
        $event = $data['event'] ?? null;

        if (!$token) {
            Log::warning('BRFINAL Webhook: token manquant', $data);
            return false;
        }

        $payment = Payment::where('token_paiement', $token)->first();
        if (!$payment) {
            Log::warning('BRFINAL Webhook: payment introuvable', ['token' => $token]);
            return false;
        }

        $nouveauStatut = match ($event) {
            'payin.session.completed' => 'paid',
            'payin.session.cancelled' => 'failure',
            'payin.session.pending' => 'pending',
            default => null,
        };

        if (!$nouveauStatut || $payment->statut === $nouveauStatut || $payment->statut === 'paid') {
            return true;
        }

        $payment->update([
            'statut' => $nouveauStatut,
            'moyen_paiement' => $data['moyen'] ?? $payment->moyen_paiement,
            'numero_transaction' => $data['numeroTransaction'] ?? null,
            'frais' => $data['frais'] ?? 0,
            'webhook_data' => $data,
        ]);

        if ($nouveauStatut === 'paid') {
            $this->finaliserPaiement($payment);
        }

        return true;
    }

    protected function finaliserPaiement(Payment $payment): void
    {
        $payable = $payment->payable;
        if (!$payable) return;

        switch ($payment->type) {
            case 'adhesion':
                $user = $payment->user;
                if ($user) {
                    $user->update(['adhesion_payee' => true, 'statut' => 'membre']);
                    // Activer le parrainage
                    $referral = \App\Models\BrFinal\Referral::where('filleul_id', $user->id)->first();
                    if ($referral) $referral->update(['statut' => 'actif']);
                }
                break;

            case 'tontine':
                if ($payable instanceof \App\Models\BrFinal\Contribution) {
                    $payable->update(['statut' => 'paid']);
                    $tontine = $payable->tontine;
                    if ($tontine) {
                        $tontine->increment('total_cotise', $payable->montant);
                        $tontine->increment('nb_cotisations_faites');
                        if ($tontine->estComplete()) {
                            $tontine->update(['statut' => 'complete']);
                        }
                    }
                }
                break;

            case 'remboursement':
                if ($payable instanceof \App\Models\BrFinal\LoanRepayment) {
                    $payable->update(['statut' => 'paid']);
                    $loan = $payable->loan;
                    if ($loan) {
                        $loan->increment('montant_rembourse', $payable->montant);
                        if ($loan->montant_rembourse >= $loan->montant_total_du) {
                            $loan->update(['statut' => 'rembourse']);
                        }
                    }
                }
                break;
        }

        Notification::envoyer(
            $payment->user_id,
            'Paiement confirmé',
            "Votre paiement de " . number_format($payment->montant, 0, ',', ' ') . " FCFA a été confirmé.",
            'success'
        );
    }
}
