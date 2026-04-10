<?php

namespace App\Services\BrFinal;

use App\Models\BrFinal\User;
use App\Models\BrFinal\Loan;
use App\Models\BrFinal\LoanRepayment;
use App\Models\BrFinal\Payment;
use App\Models\BrFinal\Notification;

class LoanService
{
    protected MoneyFusionService $mf;

    public function __construct(MoneyFusionService $mf)
    {
        $this->mf = $mf;
    }

    public function demanderPret(User $user, float $montant): Loan
    {
        if (!$user->estMembre()) {
            throw new \Exception('Vous devez être membre pour demander un prêt.');
        }

        $nbFilleuls = $user->nb_filleuls_actifs;
        if ($nbFilleuls < 1) {
            throw new \Exception('Vous devez avoir au moins 1 filleul actif.');
        }

        $plafond = $nbFilleuls * 50000;
        if ($montant > $plafond) {
            throw new \Exception("Votre plafond est de " . number_format($plafond, 0, ',', ' ') . " FCFA ({$nbFilleuls} filleul(s)).");
        }

        // Vérifier pas de prêt en cours
        $pretEnCours = $user->loans()->whereIn('statut', ['en_attente', 'approuve', 'en_cours'])->exists();
        if ($pretEnCours) {
            throw new \Exception('Vous avez déjà un prêt en cours.');
        }

        $calcul = Loan::calculerMontantTotal($montant);

        return Loan::create([
            'user_id' => $user->id,
            'montant_demande' => $montant,
            'montant_total_du' => $calcul['total'],
            'nb_filleuls_au_moment' => $nbFilleuls,
            'plafond_calcule' => $plafond,
        ]);
    }

    public function approuverPret(Loan $loan, float $montantAccorde = null): void
    {
        if ($loan->statut !== 'en_attente') {
            throw new \Exception('Ce prêt ne peut pas être approuvé.');
        }

        $montant = $montantAccorde ?? $loan->montant_demande;
        $calcul = Loan::calculerMontantTotal($montant);

        $loan->update([
            'montant_accorde' => $montant,
            'montant_total_du' => $calcul['total'],
            'statut' => 'en_cours',
            'date_approbation' => now(),
            'date_echeance' => now()->addMonths(6),
        ]);

        Notification::envoyer($loan->user_id, 'Prêt approuvé',
            "Votre prêt de " . number_format($montant, 0, ',', ' ') . " FCFA a été approuvé.", 'success');
    }

    public function rejeterPret(Loan $loan, string $motif): void
    {
        $loan->update(['statut' => 'rejete', 'motif_refus' => $motif]);
        Notification::envoyer($loan->user_id, 'Prêt refusé', "Motif : {$motif}", 'danger');
    }

    public function rembourser(Loan $loan, float $montant): array
    {
        if (!in_array($loan->statut, ['en_cours', 'en_retard'])) {
            throw new \Exception('Ce prêt ne peut pas être remboursé.');
        }

        $reste = $loan->reste_a_payer;
        if ($montant > $reste) $montant = $reste;

        $user = $loan->user;

        $repayment = LoanRepayment::create([
            'loan_id' => $loan->id,
            'user_id' => $user->id,
            'montant' => $montant,
            'date_paiement' => now()->toDateString(),
            'statut' => 'pending',
        ]);

        $payment = Payment::create([
            'user_id' => $user->id,
            'type' => 'remboursement',
            'payable_type' => LoanRepayment::class,
            'payable_id' => $repayment->id,
            'montant' => $montant,
            'numero_telephone' => $user->telephone,
            'nom_client' => $user->nom_complet,
            'personal_info' => ['loan_id' => $loan->id],
        ]);

        $result = $this->mf->initierPaiement([
            'montant' => $montant,
            'telephone' => $user->telephone,
            'nom_client' => $user->nom_complet,
            'type' => 'remboursement',
            'reference' => $payment->reference,
            'user_id' => $user->id,
            'description' => "Remboursement prêt #{$loan->id}",
            'return_url' => route('br.membre.pret.index'),
        ]);

        if ($result['success']) {
            $payment->update(['token_paiement' => $result['token'], 'url_paiement' => $result['url']]);
            $repayment->update(['token_paiement' => $result['token']]);
            return ['success' => true, 'url' => $result['url']];
        }

        $repayment->update(['statut' => 'failure']);
        $payment->update(['statut' => 'failure']);
        throw new \Exception($result['message']);
    }

    /**
     * CRON: Appliquer pénalités de retard (10%)
     */
    public function appliquerPenalites(): int
    {
        $count = 0;
        $loans = Loan::where('statut', 'en_cours')
            ->where('date_echeance', '<', now())
            ->get();

        foreach ($loans as $loan) {
            $reste = $loan->reste_a_payer;
            $penalite = round($reste * 0.10, 0);
            $loan->update([
                'statut' => 'en_retard',
                'penalites' => $loan->penalites + $penalite,
                'montant_total_du' => $loan->montant_total_du + $penalite,
            ]);
            Notification::envoyer($loan->user_id, 'Pénalité de retard',
                "Une pénalité de " . number_format($penalite, 0, ',', ' ') . " FCFA a été appliquée.", 'warning');
            $count++;
        }
        return $count;
    }
}
