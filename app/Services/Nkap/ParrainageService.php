<?php

namespace App\Services\Nkap;

use App\Models\NkapUser;
use App\Models\NkapConfiguration;
use App\Models\NkapTransaction;
use App\Models\NkapNotification;
use Illuminate\Support\Facades\DB;

class ParrainageService
{
    /**
     * Obtenir les statistiques de parrainage d'un utilisateur
     */
    public function statistiques(NkapUser $user): array
    {
        $filleuls = $user->filleuls()->get();
        $nombreFilleuls = $filleuls->count();
        
        // Filleuls qui ont participé à au moins une tontine
        $filleulsActifs = 0;
        foreach ($filleuls as $filleul) {
            if ($filleul->tontinesRejointes()->exists()) {
                $filleulsActifs++;
            }
        }

        // Total des bonus reçus
        $totalBonus = NkapTransaction::where('user_id', $user->id)
            ->where('type', NkapTransaction::TYPE_BONUS_PARRAINAGE)
            ->sum('montant');

        return [
            'success' => true,
            'code_parrainage' => $user->code_parrainage,
            'nombre_filleuls' => $nombreFilleuls,
            'filleuls_actifs' => $filleulsActifs,
            'total_bonus' => $totalBonus,
            'bonus_par_filleul' => NkapConfiguration::getBonusParrainage(),
        ];
    }

    /**
     * Liste des filleuls d'un utilisateur
     */
    public function listeFilleuls(NkapUser $user): array
    {
        $filleuls = $user->filleuls()
            ->select('id', 'nom', 'prenom', 'photo_profil', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($filleul) {
                return [
                    'id' => $filleul->id,
                    'nom_complet' => $filleul->nom_complet,
                    'photo_profil' => $filleul->photo_profil,
                    'date_inscription' => $filleul->created_at->format('d/m/Y'),
                    'a_participe_tontine' => $filleul->tontinesRejointes()->exists(),
                ];
            });

        return [
            'success' => true,
            'filleuls' => $filleuls,
        ];
    }

    /**
     * Vérifier si un code de parrainage est valide
     */
    public function verifierCode(string $code): array
    {
        $parrain = NkapUser::where('code_parrainage', $code)->first();

        if (!$parrain) {
            return [
                'success' => false,
                'message' => 'Code de parrainage invalide',
            ];
        }

        return [
            'success' => true,
            'message' => 'Code valide',
            'parrain' => [
                'prenom' => $parrain->prenom,
                'nom' => $parrain->nom[0] . '.', // Anonymiser le nom
            ],
        ];
    }
}
