<?php

namespace App\Services\Nkap;

use App\Models\Produit;
use App\Models\NkapUser;
use Illuminate\Support\Facades\Validator;

class BusinessService
{
    /**
     * Liste des produits (ordre aléatoire)
     */
    public function listeProduits(array $filtres = []): array
    {
        $page = $filtres['page'] ?? 1;
        $perPage = $filtres['per_page'] ?? 20;

        $query = Produit::with('vendeur')
            ->actif()
            ->aleatoire();

        if (!empty($filtres['categorie'])) {
            $query->parCategorie($filtres['categorie']);
        }

        if (!empty($filtres['ville'])) {
            $query->where('ville', $filtres['ville']);
        }

        if (!empty($filtres['prix_min'])) {
            $query->where('prix', '>=', $filtres['prix_min']);
        }

        if (!empty($filtres['prix_max'])) {
            $query->where('prix', '<=', $filtres['prix_max']);
        }

        if (!empty($filtres['recherche'])) {
            $recherche = $filtres['recherche'];
            $query->where(function ($q) use ($recherche) {
                $q->where('titre', 'like', "%{$recherche}%")
                  ->orWhere('description', 'like', "%{$recherche}%");
            });
        }

        $produits = $query->paginate($perPage, ['*'], 'page', $page);

        return [
            'success' => true,
            'data' => [
                'produits' => $produits->items(),
                'pagination' => [
                    'total' => $produits->total(),
                    'per_page' => $produits->perPage(),
                    'current_page' => $produits->currentPage(),
                    'last_page' => $produits->lastPage(),
                    'from' => $produits->firstItem(),
                    'to' => $produits->lastItem(),
                ],
                'categories' => Produit::categories(),
            ]
        ];
    }

    /**
     * Créer un produit
     */
    public function creerProduit(NkapUser $user, array $data): array
    {
        $validator = Validator::make($data, [
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'categorie' => 'required|string',
            'images' => 'nullable|array',
            'ville' => 'nullable|string',
            'telephone_contact' => 'nullable|string',
            'whatsapp' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $validator->errors(),
            ];
        }

        $produit = Produit::create([
            'vendeur_id' => $user->id,
            'titre' => $data['titre'],
            'description' => $data['description'],
            'prix' => $data['prix'],
            'categorie' => $data['categorie'],
            'images' => $data['images'] ?? [],
            'ville' => $data['ville'] ?? $user->ville,
            'telephone_contact' => $data['telephone_contact'] ?? $user->telephone,
            'whatsapp' => $data['whatsapp'] ?? null,
            'statut' => 'actif',
        ]);

        return [
            'success' => true,
            'message' => 'Produit publié avec succès',
            'data' => [
                'produit' => $produit->load('vendeur'),
            ]
        ];
    }

    /**
     * Modifier un produit
     */
    public function modifierProduit(NkapUser $user, int $produitId, array $data): array
    {
        $produit = Produit::find($produitId);

        if (!$produit) {
            return [
                'success' => false,
                'message' => 'Produit introuvable',
            ];
        }

        if ($produit->vendeur_id !== $user->id) {
            return [
                'success' => false,
                'message' => 'Vous n\'êtes pas autorisé à modifier ce produit',
            ];
        }

        $validator = Validator::make($data, [
            'titre' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'prix' => 'sometimes|numeric|min:0',
            'categorie' => 'sometimes|string',
            'images' => 'sometimes|array',
            'ville' => 'sometimes|string',
            'telephone_contact' => 'sometimes|string',
            'whatsapp' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $validator->errors(),
            ];
        }

        $produit->update($data);

        return [
            'success' => true,
            'message' => 'Produit modifié avec succès',
            'data' => [
                'produit' => $produit->fresh()->load('vendeur'),
            ]
        ];
    }

    /**
     * Supprimer un produit
     */
    public function supprimerProduit(NkapUser $user, int $produitId): array
    {
        $produit = Produit::find($produitId);

        if (!$produit) {
            return [
                'success' => false,
                'message' => 'Produit introuvable',
            ];
        }

        if ($produit->vendeur_id !== $user->id) {
            return [
                'success' => false,
                'message' => 'Vous n\'êtes pas autorisé à supprimer ce produit',
            ];
        }

        $produit->delete();

        return [
            'success' => true,
            'message' => 'Produit supprimé avec succès',
        ];
    }

    /**
     * Détails d'un produit
     */
    public function detailsProduit(int $produitId): array
    {
        $produit = Produit::with('vendeur')->find($produitId);

        if (!$produit) {
            return [
                'success' => false,
                'message' => 'Produit introuvable',
            ];
        }

        // Incrémenter les vues
        $produit->increment('vues');

        return [
            'success' => true,
            'data' => [
                'produit' => $produit,
            ]
        ];
    }

    /**
     * Mes produits
     */
    public function mesProduits(NkapUser $user): array
    {
        $produits = Produit::where('vendeur_id', $user->id)
            ->with('vendeur')
            ->orderBy('created_at', 'desc')
            ->get();

        return [
            'success' => true,
            'data' => [
                'produits' => $produits,
            ]
        ];
    }

    /**
     * Marquer un produit comme vendu
     */
    public function marquerVendu(NkapUser $user, int $produitId): array
    {
        $produit = Produit::find($produitId);

        if (!$produit) {
            return [
                'success' => false,
                'message' => 'Produit introuvable',
            ];
        }

        if ($produit->vendeur_id !== $user->id) {
            return [
                'success' => false,
                'message' => 'Vous n\'êtes pas autorisé à modifier ce produit',
            ];
        }

        $produit->statut = 'vendu';
        $produit->save();

        return [
            'success' => true,
            'message' => 'Produit marqué comme vendu',
            'data' => [
                'produit' => $produit->fresh()->load('vendeur'),
            ]
        ];
    }
}