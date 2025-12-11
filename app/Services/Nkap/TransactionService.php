<?php

namespace App\Services\Nkap;

use App\Models\NkapUser;
use App\Models\NkapTransaction;
use App\Models\NkapConfiguration;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    /**
     * Simulation d'appel API de paiement
     * Retourne success ou failed avec une raison aléatoire
     */
    private function appelApiPaiement(float $montant, string $methodePaiement, string $type = 'recharge'): array
    {
        // Simulation d'attente de 1 seconde
        sleep(1);

        // Probabilité de succès (70% de réussite)
        $success = rand(1, 100) <= 70;

        if ($success) {
            return [
                'success' => true,
                'reference_paiement' => 'PAY-' . strtoupper(uniqid()),
                'message' => 'Paiement effectué avec succès',
            ];
        }

        // En cas d'échec, choisir une raison aléatoire
        $raisonsEchec = [
            'Solde insuffisant sur le compte de paiement',
            'Transaction refusée par la banque',
            'Limite de transaction dépassée',
            'Compte de paiement temporairement bloqué',
            'Erreur de connexion avec le service de paiement',
            'Numéro de carte invalide',
            'Transaction expirée - délai dépassé',
        ];

        return [
            'success' => false,
            'raison' => $raisonsEchec[array_rand($raisonsEchec)],
            'message' => 'Échec du paiement',
        ];
    }

    /**
     * Recharger le compte d'un utilisateur
     */
    public function recharger(NkapUser $user, float $montant, string $methodePaiement, ?string $referenceExterne = null): array
    {
        // Appel à l'API de paiement simulée
        $resultatPaiement = $this->appelApiPaiement($montant, $methodePaiement, 'recharge');

        if (!$resultatPaiement['success']) {
            // Enregistrer la transaction échouée
            NkapTransaction::create([
                'user_id' => $user->id,
                'type' => NkapTransaction::TYPE_RECHARGE,
                'montant' => $montant,
                'solde_avant' => $user->solde,
                'solde_apres' => $user->solde,
                'description' => "Tentative de recharge via {$methodePaiement} - Échec",
                'statut' => 'echouee',  // ✅ CORRIGÉ: 'echouee' au lieu de 'echoue'
                'methode_paiement' => $methodePaiement,
                'reference_externe' => $referenceExterne,
                'metadata' => json_encode(['raison_echec' => $resultatPaiement['raison']]),
            ]);

            return [
                'success' => false,
                'message' => 'Échec de la recharge: ' . $resultatPaiement['raison'],
            ];
        }

        // Si le paiement est réussi, effectuer la transaction
        return DB::transaction(function () use ($user, $montant, $methodePaiement, $referenceExterne, $resultatPaiement) {
            $soldeAvant = $user->solde;
            $user->solde += $montant;
            $user->save();

            $transaction = NkapTransaction::create([
                'user_id' => $user->id,
                'type' => NkapTransaction::TYPE_RECHARGE,
                'montant' => $montant,
                'solde_avant' => $soldeAvant,
                'solde_apres' => $user->solde,
                'description' => "Recharge via {$methodePaiement}",
                'statut' => 'complete',
                'methode_paiement' => $methodePaiement,
                'reference_externe' => $referenceExterne ?? $resultatPaiement['reference_paiement'],
            ]);

            return [
                'success' => true,
                'message' => 'Recharge effectuée avec succès',
                'transaction' => $transaction,
                'nouveau_solde' => $user->solde,
                'reference_paiement' => $resultatPaiement['reference_paiement'],
            ];
        });
    }

    /**
     * Effectuer un retrait (25% pour l'admin, solde min 1500F après retrait)
     */
    public function retirer(NkapUser $user, float $montant): array
    {
        $fraisPourcentage = NkapConfiguration::getFraisRetraitPourcentage();
        $soldeMinimum = NkapConfiguration::getSoldeMinimumApresRetrait();
        
        $frais = $montant * ($fraisPourcentage / 100);
        $montantNet = $montant - $frais;
        $soldeApresRetrait = $user->solde - $montant;

        if ($soldeApresRetrait < $soldeMinimum) {
            $montantMaxRetrait = $user->solde - $soldeMinimum;
            return [
                'success' => false,
                'message' => "Retrait impossible. Vous devez conserver au moins " . number_format($soldeMinimum, 0, ',', ' ') . " FCFA. Montant maximum de retrait: " . number_format($montantMaxRetrait, 0, ',', ' ') . " FCFA",
            ];
        }

        if ($user->solde < $montant) {
            return [
                'success' => false,
                'message' => 'Solde insuffisant',
            ];
        }

        // Appel à l'API de paiement simulée pour le retrait
        $resultatPaiement = $this->appelApiPaiement($montantNet, 'retrait', 'retrait');

        if (!$resultatPaiement['success']) {
            // Enregistrer la tentative de retrait échouée
            NkapTransaction::create([
                'user_id' => $user->id,
                'type' => NkapTransaction::TYPE_RETRAIT,
                'montant' => $montant,
                'solde_avant' => $user->solde,
                'solde_apres' => $user->solde,
                'description' => "Tentative de retrait - Échec",
                'statut' => 'echouee',  // ✅ CORRIGÉ: 'echouee' au lieu de 'echoue'
                'frais' => $frais,
                'metadata' => json_encode(['raison_echec' => $resultatPaiement['raison']]),
            ]);

            return [
                'success' => false,
                'message' => 'Échec du retrait: ' . $resultatPaiement['raison'],
            ];
        }

        // Si le paiement est réussi, effectuer le retrait
        return DB::transaction(function () use ($user, $montant, $montantNet, $frais, $resultatPaiement) {
            $soldeAvant = $user->solde;
            $user->solde -= $montant;
            $user->save();

            $transaction = NkapTransaction::create([
                'user_id' => $user->id,
                'type' => NkapTransaction::TYPE_RETRAIT,
                'montant' => $montant,
                'solde_avant' => $soldeAvant,
                'solde_apres' => $user->solde,
                'description' => "Retrait - Frais: " . number_format($frais, 0, ',', ' ') . " FCFA",
                'statut' => 'complete',
                'frais' => $frais,
                'reference_externe' => $resultatPaiement['reference_paiement'],
            ]);

            // Créditer les frais au fondateur/admin
            $fondateur = NkapConfiguration::getFondateur();
            if ($fondateur && $fondateur->id !== $user->id) {
                $fondateur->crediter($frais, "Frais de retrait - Transaction #{$transaction->reference}", NkapTransaction::TYPE_FRAIS_ADMIN);
            }

            return [
                'success' => true,
                'message' => 'Retrait effectué avec succès',
                'transaction' => $transaction,
                'montant_brut' => $montant,
                'frais' => $frais,
                'montant_net' => $montantNet,
                'nouveau_solde' => $user->solde,
                'reference_paiement' => $resultatPaiement['reference_paiement'],
            ];
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

        // Trouver le destinataire par email, téléphone ou code de parrainage
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
            // Débiter l'expéditeur
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

            // Créditer le destinataire
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

            // Créditer les frais au fondateur
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