<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendeur_id',
        'titre',
        'description',
        'prix',
        'categorie',
        'images',
        'ville',
        'telephone_contact',
        'whatsapp',
        'statut',
    ];

    protected $casts = [
        'prix' => 'decimal:2',
        'images' => 'array',
        'vues' => 'integer',
    ];

    // Relation avec le vendeur
    public function vendeur()
    {
        return $this->belongsTo(NkapUser::class, 'vendeur_id');
    }

    public function receptions()
    {
        return $this->hasMany(ReceptionPointeur::class);
    }

    public function retours()
    {
        return $this->hasMany(RetourProduit::class);
    }

    // Scopes
    public function scopeActif($query)
    {
        return $query->where('statut', 'actif');
    }

    public function scopeParCategorie($query, $categorie)
    {
        return $query->where('categorie', $categorie);
    }

    public function scopeAleatoire($query)
    {
        return $query->inRandomOrder();
    }

    // Méthode statique pour récupérer les catégories
    public static function categories(): array
    {
        return [
            'electronique' => 'Électronique',
            'mode' => 'Mode & Vêtements',
            'maison' => 'Maison & Jardin',
            'vehicules' => 'Véhicules',
            'immobilier' => 'Immobilier',
            'emploi' => 'Emploi & Services',
            'loisirs' => 'Loisirs & Divertissement',
            'autre' => 'Autre',
        ];
    }
}