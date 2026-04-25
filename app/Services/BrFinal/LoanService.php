<?php

namespace App\Services\BrFinal;

use App\Models\BrFinal\Loan;
use App\Models\BrFinal\User;
use App\Models\BrFinal\Payment;
use Carbon\Carbon;
use Illuminate\Support\Str;

class LoanService
{
    // =============================================
    //  CONSTANTES
    // =============================================

    const TAUX_INTERET          = 10.00; // 10% (intérêt fixe)
    const TAUX_ASSURANCE        = 6.50;  // 6.5%
    const FRAIS_DOSSIER_PCT     = 3.00;  // 3% prélevés au déblocage
    const PENALITE_NORMAL_JOUR  = 0.10;  // 0.1% / jour tant que crédit actif
    const PENALITE_NORMAL_MOIS  = 2.00;  // 2% / mois tant que crédit actif
    const PENALITE_RETARD_JOUR  = 1.00;  // 1% / jour après la deadline
    const PENALITE_RETARD_MOIS  = 2.00;  // 2% / mois (inchangé)

    // =============================================
    //  DEMANDE DE PRÊT
    // =============================================

    /**
     * Crée une demande de prêt.
     *
     * @param  User   $user
     * @param  float  $montant
     * @param  int    $dureeValeur  ex: 30 (jours) ou 3 (mois)
     * @param  string $dureeUnite   'jours' | 'mois'
     */
    public function demanderPret(User $user, float $montant, int $dureeValeur, string $dureeUnite): Loan
    {
        // --- Vérifications ---
        if (!$user->estMembre()) {
            throw new \Exception('Vous devez être membre actif (adhésion payée) pour demander un prêt.');
        }

        if ($user->nb_filleuls_actifs < 1) {
            throw new \Exception('Vous devez avoir au moins 1 filleul actif pour demander un prêt.');
        }

        $plafond = $user->plafond_pret;
        if ($montant > $plafond) {
            throw new \Exception("Le montant demandé dépasse votre plafond de " . number_format($plafond, 0, ',', ' ') . " FCFA.");
        }

        $pretActif = $user->loans()->whereIn('statut', ['en_attente', 'approuve', 'en_cours', 'en_retard'])->first();
        if ($pretActif) {
            throw new \Exception('Vous avez déjà un prêt actif en cours.');
        }

        if (!in_array($dureeUnite, ['jours', 'mois'])) {
            throw new \Exception('Unité de durée invalide.');
        }

        if ($dureeValeur < 1) {
            throw new \Exception('La durée doit être d\'au moins 1 jour ou 1 mois.');
        }

        // --- Calcul du montant total dû ---
        // Intérêt fixe de 10% + assurance 6.5% sur le montant accordé
        $interet   = $montant * (self::TAUX_INTERET / 100);
        $assurance = $montant * (self::TAUX_ASSURANCE / 100);
        $totalDu   = $montant + $interet + $assurance;

        // Frais de dossier 3% (déduits au déblocage)
        $fraisDossier  = $montant * (self::FRAIS_DOSSIER_PCT / 100);
        $montantNetVerse = $montant - $fraisDossier;

        // --- Création du prêt ---
        return Loan::create([
            'user_id'               => $user->id,
            'montant_demande'       => $montant,
            'montant_accorde'       => null, // renseigné à l'approbation
            'montant_net_verse'     => null, // renseigné à l'approbation
            'frais_dossier'         => $fraisDossier,
            'taux_interet'          => self::TAUX_INTERET,
            'taux_assurance'        => self::TAUX_ASSURANCE,
            'montant_total_du'      => null, // renseigné à l'approbation
            'montant_rembourse'     => 0,
            'penalites'             => 0,
            'taux_penalite_jour'    => self::PENALITE_NORMAL_JOUR,
            'taux_penalite_mois'    => self::PENALITE_NORMAL_MOIS,
            'nb_filleuls_au_moment' => $user->nb_filleuls_actifs,
            'plafond_calcule'       => $plafond,
            'statut'                => 'en_attente',
            'duree_valeur'          => $dureeValeur,
            'duree_unite'           => $dureeUnite,
        ]);
    }

    // =============================================
    //  APPROBATION ADMIN
    // =============================================

    /**
     * Approuve un prêt et calcule l'échéance et le montant total dû.
     */
    public function approuver(Loan $loan, float $montantAccorde): void
    {
        $interet   = $montantAccorde * ($loan->taux_interet / 100);
        $assurance = $montantAccorde * ($loan->taux_assurance / 100);
        $totalDu   = $montantAccorde + $interet + $assurance;

        $fraisDossier    = $montantAccorde * (self::FRAIS_DOSSIER_PCT / 100);
        $montantNetVerse = $montantAccorde - $fraisDossier;

        // Calcul de l'échéance selon la durée choisie
        if ($loan->duree_unite === 'mois') {
            $echeance = Carbon::today()->addMonths($loan->duree_valeur);
        } else {
            $echeance = Carbon::today()->addDays($loan->duree_valeur);
        }

        $loan->update([
            'montant_accorde'              => $montantAccorde,
            'montant_net_verse'            => $montantNetVerse,
            'frais_dossier'                => $fraisDossier,
            'montant_total_du'             => $totalDu,
            'statut'                       => 'approuve',
            'date_approbation'             => Carbon::today(),
            'date_echeance'                => $echeance,
            'date_dernier_calcul_penalite' => Carbon::today(),
        ]);
    }

    // =============================================
    //  CALCUL DES PÉNALITÉS (à appeler quotidiennement via un job)
    // =============================================

    /**
     * Calcule et applique les pénalités pour tous les prêts actifs.
     * À appeler depuis un Command/Job planifié (Schedule::daily).
     */
    public function calculerPenalitesQuotidiennes(): void
    {
        $prets = Loan::whereIn('statut', ['en_cours', 'en_retard'])->get();

        foreach ($prets as $loan) {
            $this->calculerPenalitesPret($loan);
        }
    }

    /**
     * Calcule les pénalités pour un prêt donné depuis le dernier calcul.
     */
    public function calculerPenalitesPret(Loan $loan): void
    {
        $dernierCalcul = $loan->date_dernier_calcul_penalite
            ? Carbon::parse($loan->date_dernier_calcul_penalite)
            : Carbon::parse($loan->date_approbation ?? $loan->created_at);

        $today      = Carbon::today();
        $echeance   = $loan->date_echeance ? Carbon::parse($loan->date_echeance) : null;

        if ($dernierCalcul->greaterThanOrEqualTo($today)) {
            return; // Déjà calculé aujourd'hui
        }

        $penalitesAjoutees   = 0;
        $joursTotal          = $dernierCalcul->diffInDays($today);
        $base                = $loan->montant_total_du ?? 0;

        for ($i = 1; $i <= $joursTotal; $i++) {
            $jour = $dernierCalcul->copy()->addDays($i);

            // Taux selon si on est avant ou après l'échéance
            $enRetard = $echeance && $jour->greaterThan($echeance);

            $tauxJour  = $enRetard ? self::PENALITE_RETARD_JOUR  : self::PENALITE_NORMAL_JOUR;
            $tauxMois  = self::PENALITE_NORMAL_MOIS; // 2% / mois toujours

            // Pénalité journalière
            $penalitesAjoutees += $base * ($tauxJour / 100);

            // Pénalité mensuelle (1er du mois)
            if ($jour->day === 1) {
                $penalitesAjoutees += $base * ($tauxMois / 100);
            }
        }

        // Mise à jour du statut si en retard
        $nouveauStatut = ($echeance && $today->greaterThan($echeance)) ? 'en_retard' : $loan->statut;

        $loan->update([
            'penalites'                    => $loan->penalites + $penalitesAjoutees,
            'statut'                       => $nouveauStatut,
            'date_dernier_calcul_penalite' => $today,
            // Mise à jour des taux pour l'affichage
            'taux_penalite_jour'           => ($echeance && $today->greaterThan($echeance))
                                                 ? self::PENALITE_RETARD_JOUR
                                                 : self::PENALITE_NORMAL_JOUR,
        ]);
    }

    // =============================================
    //  REMBOURSEMENT
    // =============================================

    /**
     * Initie un remboursement via MoneyFusion.
     *
     * @return array ['url' => string]
     */
    public function rembourser(Loan $loan, float $montant): array
    {
        if (!in_array($loan->statut, ['en_cours', 'en_retard'])) {
            throw new \Exception('Ce prêt ne peut pas être remboursé dans son état actuel.');
        }

        $resteAPayer = $loan->reste_a_payer;
        if ($montant > $resteAPayer) {
            throw new \Exception("Le montant saisi dépasse le reste à payer (" . number_format($resteAPayer, 0, ',', ' ') . " FCFA).");
        }

        // Création du paiement
        $reference = 'LR-' . strtoupper(Str::random(10));

        $repayment = $loan->repayments()->create([
            'user_id'        => $loan->user_id,
            'montant'        => $montant,
            'date_paiement'  => now()->toDateString(),
            'statut'         => 'pending',
            'token_paiement' => $reference,
        ]);

        $payment = Payment::create([
            'reference'        => $reference,
            'user_id'          => $loan->user_id,
            'type'             => 'remboursement',
            'payable_type'     => get_class($repayment),
            'payable_id'       => $repayment->id,
            'montant'          => $montant,
            'token_paiement'   => $reference,
            'statut'           => 'pending',
        ]);

        // Intégration MoneyFusion (remplacer par votre implémentation réelle)
        $paymentService = app(PaymentService::class);
        $result = $paymentService->initierPaiement($payment, $loan->user);

        return ['url' => $result['url']];
    }

    // =============================================
    //  WEBHOOK : confirmer un remboursement
    // =============================================

    public function confirmerRemboursement(Loan $loan, float $montantPaye): void
    {
        $loan->increment('montant_rembourse', $montantPaye);
        $loan->refresh();

        if ($loan->reste_a_payer <= 0) {
            $loan->update(['statut' => 'rembourse']);
        } elseif ($loan->statut === 'approuve') {
            $loan->update(['statut' => 'en_cours']);
        }
    }
}