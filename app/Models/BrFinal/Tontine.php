<?php

namespace App\Models\BrFinal;

use Illuminate\Database\Eloquent\Model;

class Tontine extends Model
{
    protected $table = 'br_tontines';

    protected $fillable = [
        'user_id', 'type', 'objectif', 'montant_cotisation',
        'total_cotise', 'total_a_recevoir', 'nb_cotisations_faites',
        'nb_cotisations_total', 'statut', 'date_debut', 'date_fin_estimee',
    ];

    protected $casts = [
        'objectif' => 'decimal:2',
        'montant_cotisation' => 'decimal:2',
        'total_cotise' => 'decimal:2',
        'total_a_recevoir' => 'decimal:2',
        'date_debut' => 'date',
        'date_fin_estimee' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }

    public function getProgressionAttribute(): float
    {
        if ($this->total_a_recevoir <= 0) return 0;
        return min(100, round(($this->total_cotise / $this->total_a_recevoir) * 100, 1));
    }

    public function estComplete(): bool
    {
        return $this->total_cotise >= $this->total_a_recevoir;
    }

    /**
     * Calcul tontine journalière : cotisation = (objectif + 20%) / 2
     * Calcul tontine hebdomadaire : cotisation = (objectif / 2) + 10%
     */
    public static function calculerCotisation(string $type, float $objectif): array
    {
        if ($type === 'journaliere') {
            // Objectif doit être multiple de 1200
            $objectif = ceil($objectif / 1200) * 1200;
            $totalARecevoir = $objectif;
            $cotisation = ($objectif * 1.20) / 2;
            $nbCotisations = (int) ceil($totalARecevoir / $cotisation);
        } else {
            // Objectif doit être multiple de 6100
            $objectif = ceil($objectif / 6100) * 6100;
            $totalARecevoir = $objectif;
            $cotisation = ($objectif / 2) * 1.10;
            $nbCotisations = (int) ceil($totalARecevoir / $cotisation);
        }

        return [
            'objectif' => $objectif,
            'montant_cotisation' => round($cotisation, 0),
            'total_a_recevoir' => $totalARecevoir,
            'nb_cotisations_total' => max($nbCotisations, 1),
        ];
    }
}
