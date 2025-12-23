<?php

namespace App\Services\Nkap;

use App\Models\NkapUser;
use App\Models\NkapConfiguration;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthService
{
    /**
     * Inscription d'un nouvel utilisateur
     */
    public function inscription(array $data): array
    {
        return DB::transaction(function () use ($data) {
            // Trouver le parrain
            $parrainId = null;
            if (!empty($data['code_parrainage'])) {
                $parrain = NkapUser::where('code_parrainage', $data['code_parrainage'])->first();
                if ($parrain) {
                    $parrainId = $parrain->id;
                }
            }

            // Si pas de parrain, utiliser le code par défaut (fondateur)
            if (!$parrainId) {
                $codeDefaut = NkapConfiguration::getCodeParrainageDefaut();
                if ($codeDefaut) {
                    $parrain = NkapUser::where('code_parrainage', $codeDefaut)->first();
                    if ($parrain) {
                        $parrainId = $parrain->id;
                    }
                }
            }

            $user = NkapUser::create([
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'email' => $data['email'],
                'telephone' => $data['telephone'],
                'password' => Hash::make($data['password']),
                'date_naissance' => $data['date_naissance'] ?? null,
                'sexe' => $data['sexe'] ?? null,
                'ville' => $data['ville'] ?? null,
                'parrain_id' => $parrainId,
                'solde' => 0,
            ]);

            $token = $user->createToken('nkap-mobile')->plainTextToken;

            return [
                'success' => true,
                'message' => 'Inscription réussie',
                'user' => $user,
                'token' => $token,
            ];
        });
    }

    /**
     * Connexion d'un utilisateur avec email OU téléphone
     */
    public function connexion(string $identifiant, string $password): array
    {
        // Déterminer si c'est un email ou un téléphone
        $isEmail = filter_var($identifiant, FILTER_VALIDATE_EMAIL);
        
        // Chercher l'utilisateur par email ou téléphone
        if ($isEmail) {
            $user = NkapUser::where('email', $identifiant)->first();
        } else {
            // Nettoyer le numéro de téléphone (enlever espaces, tirets, etc.)
            $telephone = preg_replace('/[^0-9+]/', '', $identifiant);
            $user = NkapUser::where('telephone', $telephone)
                ->orWhere('telephone', $identifiant)
                ->first();
        }

        if (!$user || !Hash::check($password, $user->password)) {
            return [
                'success' => false,
                'message' => 'Identifiants incorrects',
            ];
        }

        if (!$user->is_active) {
            return [
                'success' => false,
                'message' => 'Votre compte a été désactivé',
            ];
        }

        $user->derniere_connexion = now();
        $user->save();

        $token = $user->createToken('nkap-mobile')->plainTextToken;

        return [
            'success' => true,
            'message' => 'Connexion réussie',
            'user' => $user,
            'token' => $token,
        ];
    }

    /**
     * Déconnexion
     */
    public function deconnexion(NkapUser $user): array
    {
        $user->tokens()->delete();

        return [
            'success' => true,
            'message' => 'Déconnexion réussie',
        ];
    }

    /**
     * Mise à jour du profil
     */
    public function mettreAJourProfil(NkapUser $user, array $data): array
    {
        $user->update([
            'nom' => $data['nom'] ?? $user->nom,
            'prenom' => $data['prenom'] ?? $user->prenom,
            'date_naissance' => $data['date_naissance'] ?? $user->date_naissance,
            'sexe' => $data['sexe'] ?? $user->sexe,
            'ville' => $data['ville'] ?? $user->ville,
            'bio' => $data['bio'] ?? $user->bio,
            'preferences_rencontre' => $data['preferences_rencontre'] ?? $user->preferences_rencontre,
        ]);

        return [
            'success' => true,
            'message' => 'Profil mis à jour',
            'user' => $user->fresh(),
        ];
    }

    /**
     * Changer le mot de passe
     */
    public function changerMotDePasse(NkapUser $user, string $ancienMdp, string $nouveauMdp): array
    {
        if (!Hash::check($ancienMdp, $user->password)) {
            return [
                'success' => false,
                'message' => 'Ancien mot de passe incorrect',
            ];
        }

        $user->password = Hash::make($nouveauMdp);
        $user->save();

        return [
            'success' => true,
            'message' => 'Mot de passe modifié avec succès',
        ];
    }
}