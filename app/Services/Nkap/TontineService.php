<?php

namespace App\Services\Nkap;

use App\Models\NkapUser;
use App\Models\Tontine;
use App\Models\TontineMembre;
use App\Models\NkapConfiguration;
use App\Models\NkapTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

            // Crée la tontine
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
                'frais_debite' => (float) $fraisCreation,
                'nouveau_solde' => (float) $user->fresh()->solde,
            ];
        });
    }

    /**
     * Rejoindre une tontine
     */
    public function rejoindre(NkapUser $user, string $codeTontine): array
    {
        Log::info('🔵 Tentative de rejoindre tontine', [
            'user_id' => $user->id,
            'code' => $codeTontine,
        ]);

        $tontine = Tontine::where('code', $codeTontine)->first();

        if (!$tontine) {
            Log::warning('🔴 Tontine introuvable', ['code' => $codeTontine]);
            return [
                'success' => false,
                'message' => 'Tontine introuvable',
            ];
        }

        Log::info('🟢 Tontine trouvée', [
            'tontine_id' => $tontine->id,
            'statut' => $tontine->statut,
            'membres' => "{$tontine->nombre_membres_actuels}/{$tontine->nombre_membres_requis}",
        ]);

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

        $dejaMembre = TontineMembre::where('tontine_id', $tontine->id)
            ->where('user_id', $user->id)
            ->exists();

        if ($dejaMembre) {
            Log::warning('🔴 Utilisateur déjà membre', [
                'user_id' => $user->id,
                'tontine_id' => $tontine->id,
            ]);
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

        Log::info('🟡 Début transaction adhésion', [
            'user_id' => $user->id,
            'tontine_id' => $tontine->id,
            'montant' => $montantADebiter,
        ]);

        try {
            return DB::transaction(function () use ($user, $tontine, $montantADebiter) {
                // Débiter le membre
                $user->debiter($montantADebiter, "Adhésion tontine {$tontine->code}", NkapTransaction::TYPE_ADHESION_TONTINE);
                Log::info('✅ Utilisateur débité', ['montant' => $montantADebiter]);

                
                // Ajouter le membre
                $membre = TontineMembre::create([
                    'tontine_id' => $tontine->id,
                    'user_id' => $user->id,
                    'montant_paye' => $montantADebiter,
                    'date_adhesion' => now(),
                ]);

                Log::info('✅ Membre créé', [
                    'membre_id' => $membre->id,
                    'tontine_id' => $membre->tontine_id,
                    'user_id' => $membre->user_id,
                ]);

                // Mettre à jour la tontine
                $tontine->nombre_membres_actuels = $tontine->nombre_membres_actuels + 1;
                $tontine->montant_total = $tontine->montant_total + $montantADebiter;
                $tontine->save();

                Log::info('✅ Tontine mise à jour', [
                    'membres_actuels' => $tontine->nombre_membres_actuels,
                    'montant_total' => $tontine->montant_total,
                ]);

                // Vérifier si c'est la première tontine du filleul et donner le bonus au parrain
                $this->verifierBonusParrainage($user);

                // Vérifier si tontine complète et la fermer automatiquement
                if ($tontine->estComplete()) {
                    $this->fermerTontine($tontine);
                }

                $tontineFresh = $tontine->fresh();

                return [
                    'success' => true,
                    'message' => 'Vous avez rejoint la tontine avec succès',
                    'tontine' => [
                        'id' => $tontineFresh->id,
                        'nom' => $tontineFresh->nom,
                        'code' => $tontineFresh->code,
                        'prix' => (float) $tontineFresh->prix,
                        'nombre_membres' => $tontineFresh->nombre_membres_requis,
                        'membres_actuels' => $tontineFresh->nombre_membres_actuels,
                        'montant_collecte' => (float) $tontineFresh->montant_total,
                        'statut' => $tontineFresh->statut === 'en_cours' ? 'ouvert' : 'ferme',
                    ],
                    'montant_debite' => (float) $montantADebiter,
                    'nouveau_solde' => (float) $user->fresh()->solde,
                ];
            });
        } catch (\Exception $e) {
            Log::error('🔴 Erreur transaction adhésion', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Erreur lors de l\'adhésion: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Fermer une tontine (automatique quand complète)
     * Crédite le créateur avec le montant total collecté
     */
    private function fermerTontine(Tontine $tontine): void
    {
        Log::info('🟡 Fermeture de la tontine', [
            'tontine_id' => $tontine->id,
            'montant_total' => $tontine->montant_total,
            'createur_id' => $tontine->createur_id,
        ]);

        // Récupérer le créateur de la tontine
        $createur = NkapUser::find($tontine->createur_id);

        if ($createur && $tontine->montant_total > 0) {
            // Créditer le créateur avec le montant total collecté
            $createur->crediter(
                $tontine->montant_total,
                "Clôture tontine {$tontine->code} - {$tontine->nom}",
                NkapTransaction::TYPE_GAIN_TONTINE
            );

            Log::info('✅ Créateur crédité', [
                'createur_id' => $createur->id,
                'montant_credite' => $tontine->montant_total,
                'nouveau_solde' => $createur->fresh()->solde,
            ]);
        }

        // Fermer la tontine
        $tontine->statut = 'fermee';
        $tontine->date_fermeture = now();
        $tontine->save();

        Log::info('✅ Tontine fermée avec succès', [
            'tontine_id' => $tontine->id,
            'date_fermeture' => $tontine->date_fermeture,
        ]);
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
            'id' => $tontine->id,
            'code' => $tontine->code,
            'nom' => $tontine->nom,
            'prix' => (float) $tontine->prix,
            'montant_adhesion' => (float) ($tontine->prix / 2),
            'nombre_membres' => $tontine->nombre_membres_requis,
            'membres_actuels' => $tontine->nombre_membres_actuels,
            'places_restantes' => $tontine->nombre_membres_requis - $tontine->nombre_membres_actuels,
            'statut' => $tontine->statut === 'en_cours' ? 'ouvert' : 'ferme',
            'montant_collecte' => (float) $tontine->montant_total,
            'createur' => [
                'id' => $tontine->createur->id,
                'nom' => $tontine->createur->nom,
                'prenom' => $tontine->createur->prenom,
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
            ->get()
            ->map(function ($tontine) {
                return [
                    'id' => $tontine->id,
                    'nom' => $tontine->nom,
                    'code' => $tontine->code,
                    'prix' => (float) $tontine->prix,
                    'nombre_membres' => $tontine->nombre_membres_requis,
                    'membres_actuels' => $tontine->nombre_membres_actuels,
                    'montant_collecte' => (float) $tontine->montant_total,
                    'statut' => $tontine->statut === 'en_cours' ? 'ouvert' : 'ferme',
                    'created_at' => $tontine->created_at,
                ];
            });

        return [
            'success' => true,
            'tontines' => $tontines,
            'en_cours' => $tontines->where('statut', 'ouvert')->count(),
            'fermees' => $tontines->where('statut', 'ferme')->count(),
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
            ->get()
            ->map(function ($tontine) {
                return [
                    'id' => $tontine->id,
                    'nom' => $tontine->nom,
                    'code' => $tontine->code,
                    'prix' => (float) $tontine->prix,
                    'nombre_membres' => $tontine->nombre_membres_requis,
                    'membres_actuels' => $tontine->nombre_membres_actuels,
                    'montant_collecte' => (float) $tontine->montant_total,
                    'statut' => $tontine->statut === 'en_cours' ? 'ouvert' : 'ferme',
                    'createur' => [
                        'id' => $tontine->createur->id,
                        'nom' => $tontine->createur->nom,
                        'prenom' => $tontine->createur->prenom,
                    ],
                    'created_at' => $tontine->created_at,
                ];
            });

        return [
            'success' => true,
            'tontines' => $tontines,
        ];
    }

    /**
     * Détails d'une tontine avec liste des membres
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

        // Liste des membres
        $membres = $tontine->membres->map(function ($membre) {
            return [
                'id' => $membre->id,
                'nom' => $membre->nom,
                'prenom' => $membre->prenom,
                'telephone' => $membre->telephone,
                'montant_paye' => (float) $membre->pivot->montant_paye,
                'date_adhesion' => $membre->pivot->date_adhesion,
            ];
        });

        return [
            'success' => true,
            'tontine' => [
                'id' => $tontine->id,
                'nom' => $tontine->nom,
                'code' => $tontine->code,
                'prix' => (float) $tontine->prix,
                'nombre_membres' => $tontine->nombre_membres_requis,
                'membres_actuels' => $tontine->nombre_membres_actuels,
                'montant_collecte' => (float) $tontine->montant_total,
                'statut' => $tontine->statut === 'en_cours' ? 'ouvert' : 'ferme',
                'createur' => [
                    'id' => $tontine->createur->id,
                    'nom' => $tontine->createur->nom,
                    'prenom' => $tontine->createur->prenom,
                ],
            ],
            'membres' => $membres,
            'est_createur' => $estCreateur,
            'est_membre' => $estMembre,
        ];
    }
}