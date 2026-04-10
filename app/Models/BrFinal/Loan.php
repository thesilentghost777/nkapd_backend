<?php

namespace App\Models\BrFinal;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $table = 'br_loans';

    protected $fillable = [
        'user_id', 'montant_demande', 'montant_accorde', 'taux_interet',
        'taux_assurance', 'montant_total_du', 'montant_rembourse', 'penalites',
        'nb_filleuls_au_moment', 'plafond_calcule', 'statut', 'motif_refus',
        'date_echeance', 'date_approbation',
    ];

    protected $casts = [
        'montant_demande' => 'decimal:2',
        'montant_accorde' => 'decimal:2',
        'montant_total_du' => 'decimal:2',
        'montant_rembourse' => 'decimal:2',
        'penalites' => 'decimal:2',
        'plafond_calcule' => 'decimal:2',
        'date_echeance' => 'date',
        'date_approbation' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function repayments()
    {
        return $this->hasMany(LoanRepayment::class);
    }

    public function getResteAPayerAttribute(): float
    {
        return max(0, $this->montant_total_du - $this->montant_rembourse);
    }

    public function getProgressionRemboursementAttribute(): float
    {
        if ($this->montant_total_du <= 0) return 0;
        return min(100, round(($this->montant_rembourse / $this->montant_total_du) * 100, 1));
    }

    public function getMontantMinimumMensuelAttribute(): float
    {
        return round($this->montant_total_du * 0.05, 0); // 5% minimum mensuel
    }

    public function estEnRetard(): bool
    {
        return $this->statut === 'en_cours' && $this->date_echeance && $this->date_echeance->isPast();
    }

    public static function calculerMontantTotal(float $capital): array
    {
        $interet = $capital * 0.05;
        $assurance = $capital * 0.065;
        $total = $capital + $interet + $assurance;

        return [
            'capital' => $capital,
            'interet' => round($interet, 0),
            'assurance' => round($assurance, 0),
            'total' => round($total, 0),
            'minimum_mensuel' => round($total * 0.05, 0),
        ];
    }
}
