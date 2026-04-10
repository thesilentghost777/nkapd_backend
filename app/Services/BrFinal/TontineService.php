<?php

namespace App\Services\BrFinal;

use App\Models\BrFinal\User;
use App\Models\BrFinal\Tontine;
use App\Models\BrFinal\Contribution;
use App\Models\BrFinal\Payment;

class TontineService
{
    protected MoneyFusionService $mf;

    public function __construct(MoneyFusionService $mf)
    {
        $this->mf = $mf;
    }

    public function creerTontine(User $user, string $type, float $objectif, float $montantCotisation): Tontine
{
    // Vérifier l'absence de tontine active du même type
    $existante = $user->tontines()->where('type', $type)->where('statut', 'active')->first();
    if ($existante) {
        throw new \Exception("Vous avez déjà une tontine {$type} active.");
    }

    // Taux de majoration selon le type
    $taux = $type === 'journaliere' ? 0.20 : 0.10;
    $facteur = 1 + $taux;

    // Montant total que le membre doit cotiser (formule de la vue)
    $montantReelACotiser = ($objectif * $facteur) / 2;

    // Nombre total de cotisations nécessaires
    $nbCotisations = (int) ceil($montantReelACotiser / $montantCotisation);

    // Date de fin estimée
    $dateFinEstimee = $type === 'journaliere'
        ? now()->addDays($nbCotisations)
        : now()->addWeeks($nbCotisations);

    return Tontine::create([
        'user_id'                  => $user->id,
        'type'                     => $type,
        'objectif'                 => $objectif,
        'montant_cotisation'       => $montantCotisation,
        'montant_reel_a_atteindre' => $montantReelACotiser,
        'total_a_recevoir'         => $objectif,
        'nb_cotisations_total'     => $nbCotisations,
        'total_cotise'             => 0,
        'nb_cotisations'           => 0,
        'progression'              => 0,
        'date_debut'               => now()->toDateString(),
        'date_fin_estimee'         => $dateFinEstimee->toDateString(),
        'statut'                   => 'active',
    ]);
}

    public function cotiser(Tontine $tontine): array
    {
        if ($tontine->statut !== 'active') {
            throw new \Exception('Cette tontine n\'est plus active.');
        }

        $user = $tontine->user;

        $contribution = Contribution::create([
            'tontine_id' => $tontine->id,
            'user_id' => $user->id,
            'montant' => $tontine->montant_cotisation,
            'date_cotisation' => now()->toDateString(),
            'statut' => 'pending',
        ]);

        $payment = Payment::create([
            'user_id' => $user->id,
            'type' => 'tontine',
            'payable_type' => Contribution::class,
            'payable_id' => $contribution->id,
            'montant' => $tontine->montant_cotisation,
            'numero_telephone' => $user->telephone,
            'nom_client' => $user->nom_complet,
            'personal_info' => ['tontine_id' => $tontine->id, 'type' => $tontine->type],
        ]);

        $result = $this->mf->initierPaiement([
            'montant' => $tontine->montant_cotisation,
            'telephone' => $user->telephone,
            'nom_client' => $user->nom_complet,
            'type' => 'tontine',
            'reference' => $payment->reference,
            'user_id' => $user->id,
            'description' => "Tontine {$tontine->type}",
            'return_url' => route('br.membre.tontine.index'),
        ]);

        if ($result['success']) {
            $payment->update(['token_paiement' => $result['token'], 'url_paiement' => $result['url']]);
            $contribution->update(['token_paiement' => $result['token']]);
            return ['success' => true, 'url' => $result['url']];
        }

        $contribution->update(['statut' => 'failure']);
        $payment->update(['statut' => 'failure']);
        throw new \Exception($result['message']);
    }

    public function demanderRetrait(Tontine $tontine): void
    {
        if (!in_array($tontine->statut, ['active', 'complete'])) {
            throw new \Exception('Retrait impossible pour cette tontine.');
        }
        $tontine->update(['statut' => 'retrait_demande']);
    }

    public function validerRetrait(Tontine $tontine): void
    {
        if ($tontine->statut !== 'retrait_demande') {
            throw new \Exception('Aucune demande de retrait en cours.');
        }
        $tontine->update(['statut' => 'retrait_valide']);
        \App\Models\BrFinal\Notification::envoyer(
            $tontine->user_id,
            'Retrait validé',
            "Votre retrait de " . number_format($tontine->total_cotise, 0, ',', ' ') . " FCFA a été validé.",
            'success'
        );
    }
}
