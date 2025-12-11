<?php

namespace App\Services\Nkap;

use App\Models\FaqQuestion;

class FaqService
{
    /**
     * Réponses prédéfinies pour le simulateur IA
     */
    private array $reponsesSimulees = [
        'inscription' => "Pour vous inscrire sur Nkap D, téléchargez l'application et suivez les étapes. Vous pouvez utiliser un code de parrainage si quelqu'un vous a invité.",
        'tontine' => "Une tontine est un système d'épargne collective. Créez une tontine en définissant un montant et un nombre de membres. Les membres paient 50% du montant à l'adhésion, et vous recevez leurs contributions directement.",
        'parrainage' => "Partagez votre code de parrainage pour inviter des amis. Vous recevez 500 FCFA de bonus quand votre filleul rejoint sa première tontine.",
        'retrait' => "Les retraits sont soumis à 25% de frais. Vous devez conserver un minimum de 1500 FCFA après le retrait.",
        'transfert' => "Vous pouvez transférer de l'argent à d'autres membres Nkap D. Les frais de transfert sont de 5% du montant.",
        'business' => "L'espace Business vous permet de vendre vos produits. Ajoutez photos, description et prix. L'affichage est aléatoire pour donner une chance égale à tous.",
        'rencontre' => "L'espace Rencontre propose 3 catégories : Amoureuse (matching par préférences), Business (recherche de partenaires), et Autre (chat ouvert).",
    ];

    /**
     * Poser une question à la FAQ
     */
    public function poserQuestion(string $question): array
    {
        // Recherche dans la base de données
        $faq = FaqQuestion::rechercher($question);

        if ($faq) {
            return [
                'success' => true,
                'reponse' => $faq->reponse,
                'categorie' => $faq->categorie,
                'question_trouvee' => $faq->question,
            ];
        }

        // Simuler une réponse IA basée sur des mots-clés
        $reponse = $this->simulerReponseIA($question);

        return [
            'success' => true,
            'reponse' => $reponse,
            'source' => 'simulateur',
        ];
    }

    /**
     * Simuler une réponse IA basée sur des mots-clés
     */
    private function simulerReponseIA(string $question): string
    {
        $questionLower = strtolower($question);

        foreach ($this->reponsesSimulees as $motCle => $reponse) {
            if (str_contains($questionLower, $motCle)) {
                return $reponse;
            }
        }

        // Réponse par défaut
        return "Je n'ai pas trouvé de réponse précise à votre question. Vous pouvez consulter notre section d'aide ou contacter le support. Les thèmes que je peux aborder : inscription, tontine, parrainage, retrait, transfert, business, rencontre.";
    }

    /**
     * Liste des FAQ par catégorie
     */
    public function listeParCategorie(string $categorie = null): array
    {
        $query = FaqQuestion::actif()->orderBy('ordre');

        if ($categorie) {
            $query->parCategorie($categorie);
        }

        $faqs = $query->get()->groupBy('categorie');

        return [
            'success' => true,
            'faqs' => $faqs,
            'categories' => FaqQuestion::categories(),
        ];
    }

    /**
     * Toutes les FAQ
     */
    public function toutesLesFaq(): array
    {
        $faqs = FaqQuestion::actif()
            ->orderBy('categorie')
            ->orderBy('ordre')
            ->get();

        return [
            'success' => true,
            'faqs' => $faqs,
        ];
    }
}
