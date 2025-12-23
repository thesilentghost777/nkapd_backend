<?php

namespace App\Services\Nkap;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MoneyFusionService
{
    /**
     * Initier un paiement via MoneyFusion
     */
    public function initiatePayment(
        float $montant,
        string $numeroSend,
        string $nomClient,
        array $personalInfo = [],
        array $articles = []
    ): array {
        try {
            $paymentData = [
                'totalPrice' => $montant,
                'article' => empty($articles) ? [['recharge' => $montant]] : $articles,
                'numeroSend' => $numeroSend,
                'nomclient' => $nomClient,
                'personal_Info' => $personalInfo,
                'return_url' => config('services.moneyfusion.return_url'),
                'webhook_url' => config('services.moneyfusion.webhook_url'),
            ];

            Log::info('MoneyFusion Payment Request', $paymentData);

            $response = Http::timeout(30)
                ->acceptJson()
                ->post(config('services.moneyfusion.payin_url'), $paymentData);

            if (!$response->successful()) {
                Log::error('MoneyFusion Payment Error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                
                throw new \Exception('Erreur lors de l\'initialisation du paiement');
            }

            $data = $response->json();

            if (!isset($data['statut']) || !$data['statut']) {
                throw new \Exception($data['message'] ?? 'Erreur inconnue');
            }

            return [
                'success' => true,
                'token' => $data['token'],
                'payment_url' => $data['url'],
                'message' => $data['message'] ?? 'Paiement initialisé'
            ];

        } catch (\Exception $e) {
            Log::error('MoneyFusion Payment Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw new \Exception('Impossible d\'initier le paiement: ' . $e->getMessage());
        }
    }

    /**
     * Vérifier le statut d'un paiement
     */
    public function checkPaymentStatus(string $token): array
    {
        try {
            $url = config('services.moneyfusion.status_url') . '/' . $token;
            
            $response = Http::timeout(15)
                ->acceptJson()
                ->get($url);

            if (!$response->successful()) {
                throw new \Exception('Impossible de vérifier le statut du paiement');
            }

            $data = $response->json();

            if (!isset($data['statut']) || !$data['statut']) {
                throw new \Exception('Statut de paiement invalide');
            }

            return [
                'success' => true,
                'data' => $data['data'] ?? [],
                'message' => $data['message'] ?? 'Statut récupéré'
            ];

        } catch (\Exception $e) {
            Log::error('MoneyFusion Status Check Error', [
                'token' => $token,
                'message' => $e->getMessage()
            ]);

            throw new \Exception('Erreur lors de la vérification: ' . $e->getMessage());
        }
    }

    /**
     * Initier un retrait via MoneyFusion
     */
    public function initiateWithdrawal(
        string $countryCode,
        string $phone,
        float $amount,
        string $withdrawMode
    ): array {
        try {
            $withdrawalData = [
                'countryCode' => $countryCode,
                'phone' => $phone,
                'amount' => $amount,
                'withdraw_mode' => $withdrawMode,
                'webhook_url' => config('services.moneyfusion.payout_webhook_url'),
            ];

            Log::info('MoneyFusion Withdrawal Request', $withdrawalData);

            $response = Http::timeout(30)
                ->withHeaders([
                    'moneyfusion-private-key' => config('services.moneyfusion.payout_api_key'),
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->post(config('services.moneyfusion.payout_url'), $withdrawalData);

            if (!$response->successful()) {
                Log::error('MoneyFusion Withdrawal Error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                
                throw new \Exception('Erreur lors de l\'initialisation du retrait');
            }

            $data = $response->json();

            if (!isset($data['statut']) || !$data['statut']) {
                throw new \Exception($data['message'] ?? 'Erreur inconnue');
            }

            return [
                'success' => true,
                'token' => $data['tokenPay'],
                'message' => $data['message'] ?? 'Retrait soumis avec succès'
            ];

        } catch (\Exception $e) {
            Log::error('MoneyFusion Withdrawal Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw new \Exception('Impossible d\'initier le retrait: ' . $e->getMessage());
        }
    }

    /**
     * Mapper le mode de paiement vers le withdraw_mode MoneyFusion
     */
    public function getWithdrawMode(string $methodePaiement, string $countryCode = 'cm'): string
    {
        // Mapping des méthodes de paiement vers les withdraw_mode
        $mapping = [
            'cm' => [
                'orange_money' => 'orange-money-cm',
                'mtn_money' => 'mtn-cm',
            ],
            'ci' => [
                'orange_money' => 'orange-money-ci',
                'mtn_money' => 'mtn-ci',
                'moov' => 'moov-ci',
                'wave' => 'wave-ci',
            ],
            'sn' => [
                'orange_money' => 'orange-money-senegal',
                'free_money' => 'free-money-senegal',
                'wave' => 'wave-senegal',
                'expresso' => 'expresso-senegal',
            ],
        ];

        $mode = $mapping[$countryCode][$methodePaiement] ?? null;

        if (!$mode) {
            throw new \Exception("Mode de paiement non supporté pour ce pays");
        }

        return $mode;
    }
}