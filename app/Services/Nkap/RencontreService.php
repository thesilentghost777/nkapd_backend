<?php

namespace App\Services\Nkap;

use App\Models\AnnonceRencontre;
use App\Models\NkapUser;
use App\Models\NkapConversation;
use App\Models\NkapMessage;

class RencontreService
{
    /**
     * Créer une annonce de rencontre
     */
    public function creerAnnonce(NkapUser $user, array $data): array
    {
        // Vérifier si l'utilisateur n'a pas déjà une annonce active du même type
        $annonceExistante = AnnonceRencontre::where('user_id', $user->id)
            ->where('type', $data['type'])
            ->where('statut', 'actif')
            ->first();

        if ($annonceExistante) {
            return [
                'success' => false,
                'message' => 'Vous avez déjà une annonce active de ce type',
            ];
        }

        $annonce = AnnonceRencontre::create([
            'user_id' => $user->id,
            'type' => $data['type'],
            'titre' => $data['titre'],
            'description' => $data['description'] ?? null,
            'preferences' => $data['preferences'] ?? [],
            'statut' => 'actif',
        ]);

        return [
            'success' => true,
            'message' => 'Annonce créée avec succès',
            'annonce' => $annonce,
        ];
    }

    /**
     * Liste des profils pour rencontre amoureuse (matching)
     */
    public function profilsAmoureuse(NkapUser $user, int $page = 1, int $perPage = 20): array
    {
        $preferences = $user->preferences_rencontre ?? [];
        $sexeRecherche = $preferences['sexe_recherche'] ?? null;
        $ageMin = $preferences['age_min'] ?? 18;
        $ageMax = $preferences['age_max'] ?? 99;

        $query = NkapUser::where('id', '!=', $user->id)
            ->where('is_active', true)
            ->whereHas('annoncesRencontre', function ($q) {
                $q->where('type', AnnonceRencontre::TYPE_AMOUREUSE)
                  ->where('statut', 'actif');
            });

        if ($sexeRecherche) {
            $query->where('sexe', $sexeRecherche);
        }

        // Filtrer par âge
        if ($ageMin || $ageMax) {
            $query->whereNotNull('date_naissance');
            if ($ageMin) {
                $query->whereDate('date_naissance', '<=', now()->subYears($ageMin));
            }
            if ($ageMax) {
                $query->whereDate('date_naissance', '>=', now()->subYears($ageMax));
            }
        }

        $profils = $query->inRandomOrder()
            ->paginate($perPage, ['id', 'nom', 'prenom', 'photo_profil', 'ville', 'bio', 'date_naissance'], 'page', $page);

        return [
            'success' => true,
            'profils' => $profils,
        ];
    }

    /**
     * Liste des annonces business
     */
    public function annoncesBusiness(int $page = 1, int $perPage = 20): array
    {
        $annonces = AnnonceRencontre::with('user:id,nom,prenom,photo_profil,ville')
            ->where('type', AnnonceRencontre::TYPE_PARTENAIRE_BUSINESS)
            ->where('statut', 'actif')
            ->inRandomOrder()
            ->paginate($perPage, ['*'], 'page', $page);

        return [
            'success' => true,
            'annonces' => $annonces,
        ];
    }

    /**
     * Espace "Autre" - Chat ouvert
     */
    public function annoncesAutre(int $page = 1, int $perPage = 20): array
    {
        $annonces = AnnonceRencontre::with('user:id,nom,prenom,photo_profil,ville')
            ->where('type', AnnonceRencontre::TYPE_AUTRE)
            ->where('statut', 'actif')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        return [
            'success' => true,
            'annonces' => $annonces,
        ];
    }

    /**
     * Mes annonces
     */
    public function mesAnnonces(NkapUser $user): array
    {
        $annonces = $user->annoncesRencontre()
            ->orderBy('created_at', 'desc')
            ->get();

        return [
            'success' => true,
            'annonces' => $annonces,
        ];
    }

    /**
     * Modifier une annonce
     */
    public function modifierAnnonce(NkapUser $user, int $annonceId, array $data): array
    {
        $annonce = AnnonceRencontre::find($annonceId);

        if (!$annonce || $annonce->user_id !== $user->id) {
            return [
                'success' => false,
                'message' => 'Annonce introuvable ou non autorisée',
            ];
        }

        $annonce->update($data);

        return [
            'success' => true,
            'message' => 'Annonce modifiée',
            'annonce' => $annonce->fresh(),
        ];
    }

    /**
     * Supprimer/désactiver une annonce
     */
    public function supprimerAnnonce(NkapUser $user, int $annonceId): array
    {
        $annonce = AnnonceRencontre::find($annonceId);

        if (!$annonce || $annonce->user_id !== $user->id) {
            return [
                'success' => false,
                'message' => 'Annonce introuvable ou non autorisée',
            ];
        }

        $annonce->statut = 'inactif';
        $annonce->save();

        return [
            'success' => true,
            'message' => 'Annonce désactivée',
        ];
    }

    /**
     * Contacter un utilisateur
     */
    public function contacter(NkapUser $user, int $destinataireId, string $message): array
    {
        $destinataire = NkapUser::find($destinataireId);

        if (!$destinataire) {
            return [
                'success' => false,
                'message' => 'Utilisateur introuvable',
            ];
        }

        $conversation = NkapConversation::trouverOuCreer($user->id, $destinataireId, 'rencontre');

        $messageObj = NkapMessage::create([
            'expediteur_id' => $user->id,
            'destinataire_id' => $destinataireId,
            'conversation_id' => $conversation->id,
            'contenu' => $message,
            'type' => 'texte',
        ]);

        $conversation->dernier_message_at = now();
        $conversation->save();

       

        return [
            'success' => true,
            'message' => 'Message envoyé',
            'conversation_id' => $conversation->id,
        ];
    }
}
