<?php

namespace App\Services\Nkap;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MoneyFusionService
{
    /**
     * Code pays pour le Cameroun
     */
    private const CAMEROON_COUNTRY_CODE = 'cm';

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
     * Initier un retrait via MoneyFusion (Cameroun uniquement)
     */
    public function initiateWithdrawal(
        string $phone,
        float $amount,
        string $withdrawMode
    ): array {
        $logContext = [
            'method' => 'initiateWithdrawal',
            'phone_original' => $phone,
            'amount' => $amount,
            'withdraw_mode' => $withdrawMode,
        ];

        try {
            Log::info('MoneyFusion Withdrawal - Starting withdrawal process', $logContext);

            // Formater le numéro avec le préfixe camerounais (ajoute 237 si absent)
            $formattedPhone = $this->formatCameroonPhone($phone);
            
            Log::info('MoneyFusion Withdrawal - Phone number formatted', array_merge($logContext, [
                'phone_formatted' => $formattedPhone,
                'prefix_added' => ($phone !== $formattedPhone)
            ]));

            $withdrawalData = [
                'countryCode' => self::CAMEROON_COUNTRY_CODE,
                'phone' => $formattedPhone,
                'amount' => $amount,
                'withdraw_mode' => $withdrawMode,
                'webhook_url' => config('services.moneyfusion.payout_webhook_url'),
            ];

            Log::info('MoneyFusion Withdrawal - Request payload prepared', array_merge($logContext, [
                'payload' => $withdrawalData,
                'api_url' => config('services.moneyfusion.payout_url'),
                'api_key_configured' => !empty(config('services.moneyfusion.payout_api_key')),
            ]));

            $response = Http::timeout(30)
                ->withHeaders([
                    'moneyfusion-private-key' => config('services.moneyfusion.payout_api_key'),
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->post(config('services.moneyfusion.payout_url'), $withdrawalData);

            Log::info('MoneyFusion Withdrawal - Response received', array_merge($logContext, [
                'status_code' => $response->status(),
                'response_body' => $response->body(),
                'response_headers' => $response->headers(),
            ]));

            if (!$response->successful()) {
                Log::error('MoneyFusion Withdrawal - Request failed', array_merge($logContext, [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'headers' => $response->headers(),
                    'phone_formatted' => $formattedPhone,
                ]));
                
                throw new \Exception('Erreur lors de l\'initialisation du retrait');
            }

            $data = $response->json();

            Log::info('MoneyFusion Withdrawal - Response parsed', array_merge($logContext, [
                'response_data' => $data,
                'has_statut' => isset($data['statut']),
                'statut_value' => $data['statut'] ?? null,
                'has_token' => isset($data['tokenPay']),
            ]));

            if (!isset($data['statut']) || !$data['statut']) {
                Log::error('MoneyFusion Withdrawal - Invalid status in response', array_merge($logContext, [
                    'response_data' => $data,
                    'error_message' => $data['message'] ?? 'No message provided'
                ]));
                
                throw new \Exception($data['message'] ?? 'Erreur inconnue');
            }

            Log::info('MoneyFusion Withdrawal - Withdrawal initiated successfully', array_merge($logContext, [
                'token' => $data['tokenPay'] ?? 'N/A',
                'message' => $data['message'] ?? 'N/A',
            ]));

            return [
                'success' => true,
                'token' => $data['tokenPay'],
                'message' => $data['message'] ?? 'Retrait soumis avec succès'
            ];

        } catch (\Exception $e) {
            Log::error('MoneyFusion Withdrawal - Exception caught', array_merge($logContext, [
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]));

            throw new \Exception('Impossible d\'initier le retrait: ' . $e->getMessage());
        }
    }

    /**
     * Formate un numéro de téléphone camerounais en ajoutant le préfixe 237 si nécessaire
     */
    private function formatCameroonPhone(string $phone): string
    {
        // Nettoyer le numéro (enlever espaces, tirets, etc.)
        $cleaned = preg_replace('/[^0-9]/', '', $phone);
        
        // Si le numéro commence déjà par 237, le retourner tel quel
        if (str_starts_with($cleaned, '237')) {
            return $cleaned;
        }
        
        // Si le numéro commence par +237, enlever le + et retourner
        if (str_starts_with($phone, '+237')) {
            return preg_replace('/[^0-9]/', '', $phone);
        }
        
        // Sinon, ajouter 237 devant
        return '237' . $cleaned;
    }
}