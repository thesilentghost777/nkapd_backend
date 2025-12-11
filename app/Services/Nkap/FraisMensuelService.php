<?php

namespace App\Services\Nkap;

use App\Models\NkapUser;
use App\Models\NkapConfiguration;
use App\Models\NkapTransaction;
use Illuminate\Support\Facades\DB;

class FraisMensuelService
{
    /**
     * Prélever les frais mensuels (500F) de tous les utilisateurs actifs
     * À exécuter le 1er de chaque mois via un scheduler
     */
    public function preleverFraisMensuels(): array
    {
        $frais = NkapConfiguration::getFraisMensuel();
        $fondateur = NkapConfiguration::getFondateur();
        
        if (!$fondateur) {
            return [
                'success' => false,
                'message' => 'Fondateur non configuré',
            ];
        }

        $compteurSucces = 0;
        $compteurEchec = 0;
        $montantTotal = 0;

        $users = NkapUser::where('is_active', true)
            ->where('solde', '>=', $frais)
            ->where('id', '!=', $fondateur->id)
            ->cursor();

        foreach ($users as $user) {
            try {
                DB::transaction(function () use ($user, $frais, $fondateur, &$compteurSucces, &$montantTotal) {
                    $user->debiter($frais, 'Frais mensuel Nkap D', NkapTransaction::TYPE_FRAIS_MENSUEL);
                    $fondateur->crediter($frais, "Frais mensuel - {$user->nom_complet}", NkapTransaction::TYPE_FRAIS_ADMIN);
                    $compteurSucces++;
                    $montantTotal += $frais;
                });
            } catch (\Exception $e) {
                $compteurEchec++;
            }
        }

        return [
            'success' => true,
            'message' => "Prélèvements effectués",
            'succes' => $compteurSucces,
            'echecs' => $compteurEchec,
            'montant_total' => $montantTotal,
        ];
    }
}
