<?php

namespace App\Services\Nkap;

use App\Models\NkapUser;
use App\Models\NkapTransaction;
use App\Models\NkapConfiguration;
use App\Models\NkapPaymentTracking;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TransactionService
{
    public function __construct(
        private MoneyFusionService $moneyFusion
    ) {}

    /**
     * Recharger le compte d'un utilisateur
     */
    public function recharger(
    NkapUser $user,
    float $montant,
    string $methodePaiement,
    ?string $referenceExterne = null
): array 
{
    try {
        // Supprimer les anciennes recharges en attente pour cet utilisateur
        NkapPaymentTracking::where('user_id', $user->id)
            ->where('type', 'recharge')
            ->where('statut', 'pending')
            ->delete();

        // Supprimer aussi les transactions en attente
        NkapTransaction::where('user_id', $user->id)
            ->where('type', NkapTransaction::TYPE_RECHARGE)
            ->where('statut', 'en_attente')
            ->delete();

        // Créer un tracking de paiement
        $tracking = NkapPaymentTracking::create([
            'user_id' => $user->id,
            'type' => 'recharge',
            'montant' => $montant,
            'numero_telephone' => $user->telephone,
            'methode_paiement' => $methodePaiement,
            'statut' => 'pending',
            'token_pay' => '', // Sera mis à jour après l'appel à MoneyFusion
        ]);

        // Initier le paiement via MoneyFusion
        $paymentResult = $this->moneyFusion->initiatePayment(
            montant: $montant,
            numeroSend: $user->telephone,
            nomClient: $user->nom_complet,
            personalInfo: [
                [
                    'user_id' => $user->id,
                    'tracking_id' => $tracking->id,
                    'type' => 'recharge'
                ]
            ],
            articles: [['recharge' => $montant]]
        );

        // Mettre à jour le tracking avec le token et l'URL
        $tracking->update([
            'token_pay' => $paymentResult['token'],
            'payment_url' => $paymentResult['payment_url'],
        ]);

        // Créer une transaction en attente
        $transaction = NkapTransaction::create([
            'user_id' => $user->id,
            'type' => NkapTransaction::TYPE_RECHARGE,
            'montant' => $montant,
            'solde_avant' => $user->solde,
            'solde_apres' => $user->solde,
            'description' => "Recharge via {$methodePaiement} - En attente",
            'statut' => 'en_attente',
            'methode_paiement' => $methodePaiement,
            'reference_externe' => $paymentResult['token'],
            'metadata' => json_encode(['tracking_id' => $tracking->id]),
        ]);

        return [
            'success' => true,
            'message' => 'Paiement initialisé',
            'token' => $paymentResult['token'],
            'payment_url' => $paymentResult['payment_url'],
            'tracking_id' => $tracking->id,
            'transaction_id' => $transaction->id,
        ];
    } catch (\Exception $e) {
        Log::error('Recharge Error', [
            'user_id' => $user->id,
            'message' => $e->getMessage()
        ]);

        return [
            'success' => false,
            'message' => $e->getMessage(),
        ];
    }
}
    /**
     * Traiter le webhook de paiement (recharge)
     */
    public function handlePaymentWebhook(array $webhookData): bool
    {
        try {
            $event = $webhookData['event'] ?? '';
            $tokenPay = $webhookData['tokenPay'] ?? '';

            if (!$tokenPay) {
                Log::error('Webhook sans tokenPay', $webhookData);
                return false;
            }

            $tracking = NkapPaymentTracking::where('token_pay', $tokenPay)->first();

            if (!$tracking) {
                Log::error('Tracking non trouvé', ['token' => $tokenPay]);
                return false;
            }

            // Éviter le traitement multiple
            if ($tracking->statut === 'completed') {
                Log::info('Paiement déjà traité', ['token' => $tokenPay]);
                return true;
            }

            // Sauvegarder les données du webhook
            $tracking->webhook_data = $webhookData;
            $tracking->numero_transaction = $webhookData['numeroTransaction'] ?? null;
            $tracking->moyen = $webhookData['moyen'] ?? null;
            $tracking->save();

            if ($event === 'payin.session.completed') {
                return $this->completeRecharge($tracking, $webhookData);
            } elseif ($event === 'payin.session.cancelled') {
                return $this->cancelRecharge($tracking, $webhookData);
            }

            return true;

        } catch (\Exception $e) {
            Log::error('Webhook Processing Error', [
                'message' => $e->getMessage(),
                'data' => $webhookData
            ]);
            return false;
        }
    }

    /**
     * Compléter une recharge après paiement réussi
     */
    private function completeRecharge(NkapPaymentTracking $tracking, array $webhookData): bool
{
    return DB::transaction(function () use ($tracking, $webhookData) {
        $user = $tracking->user;
        $montant = $tracking->montant;

        // Créditer le compte utilisateur
        $soldeAvant = $user->solde;
        $user->solde += $montant;
        $user->save();

        // Créer la transaction complète
        $transaction = NkapTransaction::create([
            'user_id' => $user->id,
            'type' => NkapTransaction::TYPE_RECHARGE,
            'montant' => $montant,
            'solde_avant' => $soldeAvant,
            'solde_apres' => $user->solde,
            'description' => "Recharge via " . ($webhookData['moyen'] ?? 'Mobile Money'),
            'statut' => 'complete',
            'methode_paiement' => $tracking->methode_paiement,
            'reference_externe' => $tracking->token_pay,
            'metadata' => json_encode([
                'tracking_id' => $tracking->id,
                'numero_transaction' => $webhookData['numeroTransaction'] ?? null
            ]),
        ]);

        // Marquer le tracking comme complété
        $tracking->markAsCompleted();

        // Supprimer toutes les anciennes transactions en attente de cet utilisateur
        NkapTransaction::where('user_id', $user->id)
            ->where('type', NkapTransaction::TYPE_RECHARGE)
            ->where('statut', 'en_attente')
            ->where('id', '!=', $transaction->id) // Exclure la transaction actuelle si elle existe
            ->delete();

        // Supprimer aussi les anciens trackings en attente
        NkapPaymentTracking::where('user_id', $user->id)
            ->where('type', 'recharge')
            ->where('statut', 'pending')
            ->where('id', '!=', $tracking->id) // Exclure le tracking actuel
            ->delete();

        Log::info('Recharge completed', [
            'user_id' => $user->id,
            'montant' => $montant,
            'token' => $tracking->token_pay,
            'cleaned_pending_transactions' => true
        ]);

        return true;
    });
}

    /**
     * Annuler une recharge
     */
    private function cancelRecharge(NkapPaymentTracking $tracking, array $webhookData): bool
    {
        $tracking->markAsCancelled();

        // Marquer la transaction comme échouée
        NkapTransaction::where('reference_externe', $tracking->token_pay)
            ->where('statut', 'en_attente')
            ->update(['statut' => 'echouee']);

        Log::info('Recharge cancelled', [
            'user_id' => $tracking->user_id,
            'token' => $tracking->token_pay
        ]);

        return true;
    }

/**
 * Effectuer un retrait MANUEL (25% pour l'admin, solde min 1500F après retrait)
 * Le retrait est traité manuellement par l'équipe dans les 24h
 */
public function retirer(NkapUser $user, float $montant, string $telephone, string $operateur, string $nomAssocie): array
{
    $logContext = [
        'method' => 'retirer_manuel',
        'user_id' => $user->id,
        'user_email' => $user->email ?? 'N/A',
        'montant' => $montant,
        'telephone' => $telephone,
        'operateur' => $operateur,
        'nom_associe' => $nomAssocie,
        'solde_actuel' => $user->solde,
    ];

    Log::info('Manual Withdrawal Process - Starting withdrawal request', $logContext);

    $fraisPourcentage = NkapConfiguration::getFraisRetraitPourcentage();
    $soldeMinimum = NkapConfiguration::getSoldeMinimumApresRetrait();
    $frais = ceil($montant * ($fraisPourcentage / 100));
    $montantNet = $montant - $frais;
    $soldeApresRetrait = $user->solde - $montant;

    Log::info('Manual Withdrawal Process - Fees calculated', array_merge($logContext, [
        'frais_pourcentage' => $fraisPourcentage,
        'frais' => $frais,
        'montant_net' => $montantNet,
        'solde_minimum' => $soldeMinimum,
        'solde_apres_retrait' => $soldeApresRetrait,
    ]));
   
    // Validation du numéro de téléphone
    if (strlen($telephone) !== 9 || !is_numeric($telephone)) {
        Log::warning('Manual Withdrawal Process - Invalid phone number', array_merge($logContext, [
            'phone_length' => strlen($telephone),
            'is_numeric' => is_numeric($telephone),
        ]));

        return [
            'success' => false,
            'message' => 'Le numéro de téléphone doit contenir exactement 9 chiffres',
        ];
    }
   
    // Validation de l'opérateur
    if (!in_array($operateur, ['orange_money', 'mtn_momo'])) {
        Log::warning('Manual Withdrawal Process - Invalid operator', array_merge($logContext, [
            'allowed_operators' => ['orange_money', 'mtn_momo']
        ]));

        return [
            'success' => false,
            'message' => 'Opérateur non valide. Choisissez Orange Money ou MTN Mobile Money',
        ];
    }
   
    if ($soldeApresRetrait < $soldeMinimum) {
        $montantMaxRetrait = $user->solde - $soldeMinimum;
        
        Log::warning('Manual Withdrawal Process - Insufficient balance after minimum', array_merge($logContext, [
            'montant_max_retrait' => $montantMaxRetrait,
        ]));

        return [
            'success' => false,
            'message' => "Retrait impossible. Vous devez conserver au moins " . number_format($soldeMinimum, 0, ',', ' ') . " FCFA. Montant maximum de retrait: " . number_format($montantMaxRetrait, 0, ',', ' ') . " FCFA",
        ];
    }
   
    if ($user->solde < $montant) {
        Log::warning('Manual Withdrawal Process - Insufficient balance', $logContext);

        return [
            'success' => false,
            'message' => 'Solde insuffisant',
        ];
    }
   
    try {
        Log::info('Manual Withdrawal Process - Cleaning old pending trackings', $logContext);

        // Supprimer les anciens trackings avec token vide pour cet utilisateur
        $deletedCount = NkapPaymentTracking::where('user_id', $user->id)
            ->where('type', 'retrait')
            ->where('token_pay', '')
            ->delete();

        Log::info('Manual Withdrawal Process - Old trackings cleaned', array_merge($logContext, [
            'deleted_count' => $deletedCount
        ]));
       
        // Créer un tracking de retrait MANUEL
        $tracking = NkapPaymentTracking::create([
            'user_id' => $user->id,
            'type' => 'retrait',
            'montant' => $montantNet,
            'frais' => $frais,
            'numero_telephone' => $telephone,
            'operateur' => $operateur,
            'statut' => 'pending',
            'token_pay' => 'MANUAL_' . strtoupper(uniqid()),
        ]);

        Log::info('Manual Withdrawal Process - Tracking created', array_merge($logContext, [
            'tracking_id' => $tracking->id,
            'tracking_token' => $tracking->token_pay
        ]));
       
        // Débiter immédiatement le compte et créer la transaction
        Log::info('Manual Withdrawal Process - Starting database transaction', $logContext);

        $result = DB::transaction(function () use ($user, $montant, $montantNet, $frais, $tracking, $telephone, $operateur, $nomAssocie, $logContext) {
            $soldeAvant = $user->solde;
            $user->solde -= $montant;
            $user->save();

            Log::info('Manual Withdrawal Process - User balance updated', array_merge($logContext, [
                'solde_avant' => $soldeAvant,
                'solde_apres' => $user->solde,
                'montant_debite' => $montant
            ]));
           
            $operateurLabel = $operateur === 'orange_money' ? 'Orange Money' : 'MTN Mobile Money';
           
            $transaction = NkapTransaction::create([
                'user_id' => $user->id,
                'type' => NkapTransaction::TYPE_RETRAIT,
                'montant' => $montant,
                'solde_avant' => $soldeAvant,
                'solde_apres' => $user->solde,
                'description' => "Retrait en cours de traitement sur {$telephone} ({$nomAssocie}) via {$operateurLabel} - Frais: " . number_format($frais, 0, ',', ' ') . " FCFA",
                'statut' => 'en_attente',
                'frais' => $frais,
                'reference_externe' => $tracking->token_pay,
                'nom_associe' => $nomAssocie,
                'metadata' => json_encode([
                    'tracking_id' => $tracking->id,
                    'telephone' => $telephone,
                    'operateur' => $operateur,
                    'nom_associe' => $nomAssocie,
                    'type_traitement' => 'manuel',
                ]),
            ]);

            Log::info('Manual Withdrawal Process - Transaction created successfully', array_merge($logContext, [
                'transaction_id' => $transaction->id,
                'reference_externe' => $tracking->token_pay
            ]));
           
            return [
                'user' => $user,
                'transaction' => $transaction,
                'tracking' => $tracking,
                'operateur_label' => $operateurLabel,
            ];
        });

        // Envoyer les notifications par email
        try {
            $this->envoyerNotificationsRetrait($result['user'], $result['transaction'], $montantNet, $frais, $telephone, $nomAssocie, $result['operateur_label']);
            Log::info('Manual Withdrawal Process - Email notifications sent', $logContext);
        } catch (\Exception $e) {
            Log::error('Manual Withdrawal Process - Failed to send email notifications', array_merge($logContext, [
                'error' => $e->getMessage()
            ]));
        }
           
        return [
            'success' => true,
            'message' => "Votre demande de retrait a été enregistrée. Vous recevrez {$montantNet} FCFA sur le {$telephone} ({$nomAssocie}) via {$result['operateur_label']} dans les 24h. Pour toute urgence, contactez notre support WhatsApp.",
            'token' => $result['tracking']->token_pay,
            'tracking_id' => $result['tracking']->id,
            'montant_brut' => $montant,
            'frais' => $frais,
            'montant_net' => $montantNet,
            'nouveau_solde' => $result['user']->solde,
            'telephone' => $telephone,
            'nom_associe' => $nomAssocie,
            'operateur' => $result['operateur_label'],
            'delai_traitement' => '24h',
            'support_whatsapp' => '+237696087354',
        ];
    } catch (\Exception $e) {
        Log::error('Manual Withdrawal Process - Exception caught', array_merge($logContext, [
            'error_message' => $e->getMessage(),
            'error_file' => $e->getFile(),
            'error_line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]));
       
        return [
            'success' => false,
            'message' => 'Une erreur est survenue lors de la demande de retrait. Veuillez réessayer.',
        ];
    }
}

/**
 * Envoyer les notifications par email pour un retrait manuel
 */
private function envoyerNotificationsRetrait($user, $transaction, $montantNet, $frais, $telephone, $nomAssocie, $operateurLabel)
{
    $dgEmail = config('app.dg_notif');
    $ghostEmail = config('app.ghost_notif');
    
    $details = [
        'user_name' => $user->nom . ' ' . $user->prenom,
        'user_email' => $user->email,
        'user_phone' => $user->telephone,
        'transaction_id' => $transaction->id,
        'reference' => $transaction->reference_externe,
        'montant_brut' => number_format($transaction->montant, 0, ',', ' ') . ' FCFA',
        'frais' => number_format($frais, 0, ',', ' ') . ' FCFA',
        'montant_net' => number_format($montantNet, 0, ',', ' ') . ' FCFA',
        'telephone_destinataire' => $telephone,
        'nom_associe' => $nomAssocie,
        'operateur' => $operateurLabel,
        'date' => $transaction->created_at->format('d/m/Y à H:i'),
    ];

    // Email au DG
    if ($dgEmail) {
        Mail::send('emails.retrait-notification', $details, function ($message) use ($dgEmail, $details) {
            $message->to($dgEmail)
                    ->subject('Nouvelle demande de retrait - ' . $details['reference']);
        });
    }

    // Email au développeur
    if ($ghostEmail) {
        Mail::send('emails.retrait-notification', $details, function ($message) use ($ghostEmail, $details) {
            $message->to($ghostEmail)
                    ->subject('Nouvelle demande de retrait - ' . $details['reference']);
        });
    }
}


    /**
 * Traiter le webhook de retrait
 */


 public function handleWithdrawalWebhook(array $webhookData): bool
{
    try {
        $event = $webhookData['event'] ?? '';
        $tokenPay = $webhookData['tokenPay'] ?? '';

            if (!$tokenPay) {
                Log::error('Withdrawal webhook sans tokenPay', $webhookData);
                return false;
            }

            $tracking = NkapPaymentTracking::where('token_pay', $tokenPay)
                ->where('type', 'retrait')
                ->first();

            if (!$tracking) {
                Log::error('Tracking retrait non trouvé', ['token' => $tokenPay]);
                return false;
            }

            // Éviter le traitement multiple
            if (in_array($tracking->statut, ['completed', 'failed'])) {
                Log::info('Retrait déjà traité', ['token' => $tokenPay]);
                return true;
            }

            // Sauvegarder les données du webhook
            $tracking->webhook_data = $webhookData;
            $tracking->moyen = $webhookData['moyen'] ?? null;
            $tracking->save();

            if ($event === 'payout.session.completed') {
                return $this->completeWithdrawal($tracking, $webhookData);
            } elseif ($event === 'payout.session.cancelled') {
                return $this->cancelWithdrawal($tracking, $webhookData);
            }

            return true;

        } catch (\Exception $e) {
            Log::error('Withdrawal Webhook Processing Error', [
                'message' => $e->getMessage(),
                'data' => $webhookData
            ]);
            return false;
        }
    }

    /**
     * Compléter un retrait après succès
     */
    private function completeWithdrawal(NkapPaymentTracking $tracking, array $webhookData): bool
    {
        return DB::transaction(function () use ($tracking, $webhookData) {
            $user = $tracking->user;

            // Marquer la transaction comme complète
            $transaction = NkapTransaction::where('reference_externe', $tracking->token_pay)
                ->where('statut', 'en_attente')
                ->first();

            if ($transaction) {
                $transaction->update([
                    'statut' => 'complete',
                    'description' => str_replace('en cours', 'effectué', $transaction->description),
                ]);

                // Créditer les frais au fondateur/admin
                $fondateur = NkapConfiguration::getFondateur();
                if ($fondateur && $fondateur->id !== $user->id && $tracking->frais > 0) {
                    $fondateur->crediter(
                        $tracking->frais,
                        "Frais de retrait - Transaction #{$transaction->reference}",
                        NkapTransaction::TYPE_FRAIS_ADMIN
                    );
                }
            }

            // Marquer le tracking comme complété
            $tracking->markAsCompleted();

            Log::info('Withdrawal completed', [
                'user_id' => $user->id,
                'montant' => $tracking->montant,
                'token' => $tracking->token_pay
            ]);

            return true;
        });
    }

    /**
     * Annuler un retrait et recréditer le compte
     */
    private function cancelWithdrawal(NkapPaymentTracking $tracking, array $webhookData): bool
    {
        return DB::transaction(function () use ($tracking, $webhookData) {
            $user = $tracking->user;

            // Recréditer le montant total (montant net + frais)
            $montantTotal = $tracking->montant + ($tracking->frais ?? 0);
            $soldeAvant = $user->solde;
            $user->solde += $montantTotal;
            $user->save();

            // Marquer la transaction comme échouée
            $transaction = NkapTransaction::where('reference_externe', $tracking->token_pay)
                ->where('statut', 'en_attente')
                ->first();

            if ($transaction) {
                $transaction->update(['statut' => 'echouee']);
            }

            // Créer une transaction de recréditation
            NkapTransaction::create([
                'user_id' => $user->id,
                'type' => NkapTransaction::TYPE_RETRAIT,
                'montant' => $montantTotal,
                'solde_avant' => $soldeAvant,
                'solde_apres' => $user->solde,
                'description' => "Recréditation suite à échec de retrait",
                'statut' => 'complete',
                'reference_externe' => $tracking->token_pay . '_refund',
            ]);

            // Marquer le tracking comme échoué
            $tracking->markAsFailed();

            Log::info('Withdrawal cancelled and refunded', [
                'user_id' => $user->id,
                'montant' => $montantTotal,
                'token' => $tracking->token_pay
            ]);

            return true;
        });
    }

    /**
     * Transfert entre utilisateurs (frais 5%)
     */
    public function transferer(NkapUser $expediteur, string $destinataireIdentifiant, float $montant): array
    {
        $fraisPourcentage = NkapConfiguration::getFraisTransfertPourcentage();
        $frais = $montant * ($fraisPourcentage / 100);
        $montantTotal = $montant + $frais;

        if ($expediteur->solde < $montantTotal) {
            return [
                'success' => false,
                'message' => "Solde insuffisant. Montant requis: " . number_format($montantTotal, 0, ',', ' ') . " FCFA (dont " . number_format($frais, 0, ',', ' ') . " FCFA de frais)",
            ];
        }

        $destinataire = NkapUser::where('email', $destinataireIdentifiant)
            ->orWhere('telephone', $destinataireIdentifiant)
            ->orWhere('code_parrainage', $destinataireIdentifiant)
            ->first();

        if (!$destinataire) {
            return [
                'success' => false,
                'message' => 'Destinataire introuvable',
            ];
        }

        if ($destinataire->id === $expediteur->id) {
            return [
                'success' => false,
                'message' => 'Vous ne pouvez pas vous transférer de l\'argent à vous-même',
            ];
        }

        return DB::transaction(function () use ($expediteur, $destinataire, $montant, $frais, $montantTotal) {
            $soldeAvantExp = $expediteur->solde;
            $expediteur->solde -= $montantTotal;
            $expediteur->save();

            $transactionEnvoi = NkapTransaction::create([
                'user_id' => $expediteur->id,
                'type' => NkapTransaction::TYPE_TRANSFERT_ENVOYE,
                'montant' => $montantTotal,
                'solde_avant' => $soldeAvantExp,
                'solde_apres' => $expediteur->solde,
                'description' => "Transfert vers {$destinataire->nom_complet}",
                'statut' => 'complete',
                'destinataire_id' => $destinataire->id,
                'frais' => $frais,
            ]);

            $soldeAvantDest = $destinataire->solde;
            $destinataire->solde += $montant;
            $destinataire->save();

            NkapTransaction::create([
                'user_id' => $destinataire->id,
                'type' => NkapTransaction::TYPE_TRANSFERT_RECU,
                'montant' => $montant,
                'solde_avant' => $soldeAvantDest,
                'solde_apres' => $destinataire->solde,
                'description' => "Transfert reçu de {$expediteur->nom_complet}",
                'statut' => 'complete',
            ]);

            $fondateur = NkapConfiguration::getFondateur();
            if ($fondateur) {
                $fondateur->crediter($frais, "Frais de transfert - {$transactionEnvoi->reference}", NkapTransaction::TYPE_FRAIS_ADMIN);
            }

            return [
                'success' => true,
                'message' => 'Transfert effectué avec succès',
                'montant' => $montant,
                'frais' => $frais,
                'destinataire' => $destinataire->nom_complet,
                'nouveau_solde' => $expediteur->solde,
            ];
        });
    }

    /**
     * Historique des transactions
     */
    public function historique(NkapUser $user, int $page = 1, int $perPage = 20): array
    {
        $transactions = $user->transactions()
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        return [
            'success' => true,
            'transactions' => $transactions,
        ];
    }
}