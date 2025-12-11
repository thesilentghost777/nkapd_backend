<?php

namespace App\Services\Nkap;

use App\Models\NkapUser;
use App\Models\Tontine;
use App\Models\TontineMembre;
use App\Models\NkapConfiguration;
use App\Models\NkapTransaction;
use Illuminate\Support\Facades\DB;

class TontineService
{
    /**
     * Créer une nouvelle tontine
     */
    public function creer(NkapUser $user, array $data): array
    {
        $prix = $data['prix'];
        $nombreMembres = $data['nombre_membres'];
        $nom = $data['nom'];

        // Validations
        $montantMin = NkapConfiguration::getMontantMinTontine();
        if ($prix < $montantMin) {
            return [
                'success' => false,
                'message' => "Le montant minimum pour une tontine est de " . number_format($montantMin, 0, ',', ' ') . " FCFA",
            ];
        }

        if ($prix % 100 !== 0) {
            return [
                'success' => false,
                'message' => 'Le montant doit être un multiple de 100',
            ];
        }

        if ($nombreMembres < 2) {
            return [
                'success' => false,
                'message' => 'Une tontine doit avoir au moins 2 membres',
            ];
        }

        $maxTontines = NkapConfiguration::getMaxTontinesEnCours();
        if ($user->nombreTontinesEnCours() >= $maxTontines) {
            return [
                'success' => false,
                'message' => "Vous avez atteint le maximum de {$maxTontines} tontines en cours",
            ];
        }

        // Frais de création = 50% du prix (pour le fondateur)
        $fraisCreation = $prix / 2;
        
        if ($user->solde < $fraisCreation) {
            return [
                'success' => false,
                'message' => "Solde insuffisant. Pour créer cette tontine, vous devez avoir au moins " . number_format($fraisCreation, 0, ',', ' ') . " FCFA",
            ];
        }

        return DB::transaction(function () use ($user, $nom, $prix, $nombreMembres, $fraisCreation) {
            // Débiter les frais de création
            $user->debiter($fraisCreation, "Création tontine", NkapTransaction::TYPE_CREATION_TONTINE);

            // Créditer le fondateur
            $fondateur = NkapConfiguration::getFondateur();
            if ($fondateur) {
                $fondateur->crediter($fraisCreation, "Frais création tontine par {$user->nom_complet}", NkapTransaction::TYPE_FRAIS_ADMIN);
            }

            // Créer la tontine
            $tontine = Tontine::create([
                'nom' => $nom,
                'createur_id' => $user->id,
                'prix' => $prix,
                'nombre_membres_requis' => $nombreMembres,
                'nombre_membres_actuels' => 0,
                'montant_total' => 0,
                'statut' => 'en_cours',
            ]);

            return [
                'success' => true,
                'message' => 'Tontine créée avec succès',
                'tontine' => $tontine,
                'code' => $tontine->code,
                'frais_debite' => $fraisCreation,
                'nouveau_solde' => $user->fresh()->solde,
            ];
        });
    }

    /**
     * Rejoindre une tontine
     */
    public function rejoindre(NkapUser $user, string $codeTontine): array
    {
        $tontine = Tontine::where('code', $codeTontine)->first();

        if (!$tontine) {
            return [
                'success' => false,
                'message' => 'Tontine introuvable',
            ];
        }

        if ($tontine->statut === 'fermee') {
            return [
                'success' => false,
                'message' => 'Cette tontine est fermée',
            ];
        }

        if ($tontine->estComplete()) {
            return [
                'success' => false,
                'message' => 'Cette tontine est complète',
            ];
        }

        if ($tontine->createur_id === $user->id) {
            return [
                'success' => false,
                'message' => 'Vous ne pouvez pas rejoindre votre propre tontine',
            ];
        }

        $dejaMembreQuery = TontineMembre::where('tontine_id', $tontine->id)
            ->where('user_id', $user->id);
        if ($dejaMembreQuery->exists()) {
            return [
                'success' => false,
                'message' => 'Vous êtes déjà membre de cette tontine',
            ];
        }

        // Vérifier le solde (doit avoir au moins le prix complet)
        if ($user->solde < $tontine->prix) {
            return [
                'success' => false,
                'message' => "Solde insuffisant. Vous devez avoir au moins " . number_format($tontine->prix, 0, ',', ' ') . " FCFA pour rejoindre cette tontine",
            ];
        }

        // Montant à débiter = 50% du prix
        $montantADebiter = $tontine->prix / 2;

        return DB::transaction(function () use ($user, $tontine, $montantADebiter) {
            // Débiter le membre
            $user->debiter($montantADebiter, "Adhésion tontine {$tontine->code}", NkapTransaction::TYPE_ADHESION_TONTINE);

            // Créditer le créateur de la tontine
            $createur = $tontine->createur;
            $createur->crediter($montantADebiter, "Adhésion à votre tontine {$tontine->code} par {$user->nom_complet}", NkapTransaction::TYPE_GAIN_TONTINE);

            // Ajouter le membre
            TontineMembre::create([
                'tontine_id' => $tontine->id,
                'user_id' => $user->id,
                'montant_paye' => $montantADebiter,
                'date_adhesion' => now(),
            ]);

            // Mettre à jour la tontine
            $tontine->nombre_membres_actuels++;
            $tontine->montant_total += $montantADebiter;
            $tontine->save();

            // Vérifier si c'est la première tontine du filleul et donner le bonus au parrain
            $this->verifierBonusParrainage($user);

            // Vérifier si tontine complète et la fermer automatiquement
            if ($tontine->estComplete()) {
                $this->fermerTontine($tontine);
            }

            return [
                'success' => true,
                'message' => 'Vous avez rejoint la tontine avec succès',
                'tontine' => $tontine->fresh(),
                'montant_debite' => $montantADebiter,
                'nouveau_solde' => $user->fresh()->solde,
            ];
        });
    }

    /**
     * Fermer une tontine (automatique quand complète)
     */
    private function fermerTontine(Tontine $tontine): void
    {
        $tontine->statut = 'fermee';
        $tontine->date_fermeture = now();
        $tontine->save();

        // Le créateur a déjà reçu les paiements au fur et à mesure
        // Notifier le créateur
        $montantTotal = $tontine->montant_total;
        
    }

    /**
     * Vérifier et attribuer le bonus de parrainage lors de la première tontine
     */
    private function verifierBonusParrainage(NkapUser $user): void
    {
        // Si c'est la première tontine rejointe et qu'il a un parrain
        if ($user->parrain_id && $user->tontinesRejointes()->count() === 1) {
            $bonus = NkapConfiguration::getBonusParrainage();
            $parrain = $user->parrain;

            if ($parrain) {
                $parrain->crediter($bonus, "Bonus parrainage - {$user->nom_complet} a rejoint sa première tontine", NkapTransaction::TYPE_BONUS_PARRAINAGE);

               
            }
        }
    }

    /**
     * Rechercher une tontine par code
     */
    public function rechercher(string $code): array
    {
        $tontine = Tontine::with('createur')
            ->where('code', $code)
            ->first();

        if (!$tontine) {
            return [
                'success' => false,
                'message' => 'Tontine introuvable',
            ];
        }

        return [
            'success' => true,
            'tontine' => [
                'id' => $tontine->id,
                'code' => $tontine->code,
                'nom' => $tontine->nom,
                'prix' => $tontine->prix,
                'montant_adhesion' => $tontine->prix / 2,
                'nombre_membres_requis' => $tontine->nombre_membres_requis,
                'nombre_membres_actuels' => $tontine->nombre_membres_actuels,
                'places_restantes' => $tontine->nombre_membres_requis - $tontine->nombre_membres_actuels,
                'statut' => $tontine->statut,
                'createur' => $tontine->createur->nom_complet,
            ],
        ];
    }

    /**
     * Obtenir mes tontines créées
     */
    public function mesTontinesCreees(NkapUser $user): array
    {
        $tontines = $user->tontinesCreees()
            ->orderBy('created_at', 'desc')
            ->get();

        return [
            'success' => true,
            'tontines' => $tontines,
            'en_cours' => $tontines->where('statut', 'en_cours')->count(),
            'fermees' => $tontines->where('statut', 'fermee')->count(),
        ];
    }

    /**
     * Obtenir mes tontines rejointes
     */
    public function mesTontinesRejointes(NkapUser $user): array
    {
        $tontines = $user->tontinesRejointes()
            ->with('createur')
            ->orderBy('tontine_membres.created_at', 'desc')
            ->get();

        return [
            'success' => true,
            'tontines' => $tontines,
        ];
    }

    /**
     * Détails d'une tontine
     */
    public function details(int $tontineId, NkapUser $user): array
    {
        $tontine = Tontine::with(['createur', 'membres'])
            ->find($tontineId);

        if (!$tontine) {
            return [
                'success' => false,
                'message' => 'Tontine introuvable',
            ];
        }

        $estCreateur = $tontine->createur_id === $user->id;
        $estMembre = $tontine->membres()->where('user_id', $user->id)->exists();

        return [
            'success' => true,
            'tontine' => $tontine,
            'est_createur' => $estCreateur,
            'est_membre' => $estMembre,
        ];
    }
}
