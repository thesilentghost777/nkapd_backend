<?php

namespace App\Http\Controllers\Api\Nkap;

use App\Http\Controllers\Controller;
use App\Services\Nkap\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct(private TransactionService $service) {}

    /**
     * Page de retour après paiement (return_url)
     * Redirige vers l'app mobile ou affiche un message
     */
    public function paymentReturn(Request $request)
    {
        $token = $request->query('token');
        
        Log::info('Payment Return', [
            'token' => $token,
            'query' => $request->query()
        ]);

        // Retourner une page HTML simple pour l'app mobile
        return view('nkap.payment-return', [
            'token' => $token,
            'message' => 'Votre paiement est en cours de traitement. Vous pouvez fermer cette page.',
        ]);
    }

    /**
     * Webhook de paiement (payin - recharges)
     */
    public function paymentWebhook(Request $request)
    {
        try {
            $webhookData = $request->all();
            
            Log::info('Payment Webhook Received', $webhookData);

            $result = $this->service->handlePaymentWebhook($webhookData);

            return response()->json([
                'success' => $result,
                'message' => $result ? 'Webhook traité' : 'Erreur de traitement'
            ]);

        } catch (\Exception $e) {
            Log::error('Payment Webhook Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur interne'
            ], 500);
        }
    }

    /**
     * Webhook de retrait (payout)
     */
    public function payoutWebhook(Request $request)
    {
        try {
            $webhookData = $request->all();
            
            Log::info('Payout Webhook Received', $webhookData);

            $result = $this->service->handleWithdrawalWebhook($webhookData);

            return response()->json([
                'success' => $result,
                'message' => $result ? 'Webhook traité' : 'Erreur de traitement'
            ]);

        } catch (\Exception $e) {
            Log::error('Payout Webhook Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur interne'
            ], 500);
        }
    }

    /**
     * Vérifier le statut d'un paiement/retrait
     */
    public function checkStatus(Request $request)
    {
        $token = $request->input('token');

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token manquant'
            ], 400);
        }

        try {
            $tracking = \App\Models\NkapPaymentTracking::where('token_pay', $token)->first();

            if (!$tracking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaction introuvable'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'statut' => $tracking->statut,
                    'type' => $tracking->type,
                    'montant' => $tracking->montant,
                    'frais' => $tracking->frais,
                    'completed_at' => $tracking->completed_at,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la vérification'
            ], 500);
        }
    }
}