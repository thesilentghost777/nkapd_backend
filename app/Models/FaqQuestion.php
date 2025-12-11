<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqQuestion extends Model
{
    use HasFactory;

    protected $table = 'faq_questions';

    protected $fillable = [
        'categorie',
        'question',
        'reponse',
        'mots_cles',
        'ordre',
        'actif',
    ];

    protected $casts = [
        'mots_cles' => 'array',
        'ordre' => 'integer',
        'actif' => 'boolean',
    ];

    public function scopeActif($query)
    {
        return $query->where('actif', true);
    }

    public function scopeParCategorie($query, string $categorie)
    {
        return $query->where('categorie', $categorie);
    }

    public static function rechercher(string $question): ?self
    {
        $motsRecherche = array_filter(explode(' ', strtolower($question)));
        
        // Recherche par correspondance de mots-clés
        $faqs = self::actif()->get();
        $meilleurScore = 0;
        $meilleureReponse = null;

        foreach ($faqs as $faq) {
            $score = 0;
            $motsCles = is_array($faq->mots_cles) ? $faq->mots_cles : [];
            
            foreach ($motsRecherche as $mot) {
                if (strlen($mot) < 3) continue;
                
                foreach ($motsCles as $motCle) {
                    if (stripos($motCle, $mot) !== false || stripos($mot, $motCle) !== false) {
                        $score++;
                    }
                }
                
                if (stripos($faq->question, $mot) !== false) {
                    $score += 2;
                }
            }

            if ($score > $meilleurScore) {
                $meilleurScore = $score;
                $meilleureReponse = $faq;
            }
        }

        return $meilleurScore > 0 ? $meilleureReponse : null;
    }

    public static function categories(): array
    {
        return [
            'inscription' => 'Inscription & Compte',
            'tontine' => 'Tontines',
            'paiement' => 'Paiements & Retraits',
            'parrainage' => 'Parrainage',
            'business' => 'Espace Business',
            'rencontre' => 'Espace Rencontre',
            'general' => 'Général',
        ];
    }
}
