<?php

namespace App\Models\BrFinal;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Loan extends Model
{
    protected $table = 'br_loans';

    protected $fillable = [
        'user_id',
        'montant_demande',
        'montant_accorde',
        'montant_net_verse',
        'taux_interet',
        'taux_assurance',
        'frais_dossier',
        'montant_total_du',
        'montant_rembourse',
        'penalites',
        'taux_penalite_jour',
        'taux_penalite_mois',
        'nb_filleuls_au_moment',
        'plafond_calcule',
        'statut',
        'motif_refus',
        'date_echeance',
        'date_approbation',
        'date_dernier_calcul_penalite',
        'duree_valeur',
        'duree_unite',
    ];

    protected $casts = [
        'montant_demande'              => 'decimal:2',
        'montant_accorde'              => 'decimal:2',
        'montant_net_verse'            => 'decimal:2',
        'montant_total_du'             => 'decimal:2',
        'montant_rembourse'            => 'decimal:2',
        'penalites'                    => 'decimal:2',
        'frais_dossier'                => 'decimal:2',
        'taux_interet'                 => 'decimal:2',
        'taux_assurance'               => 'decimal:2',
        'taux_penalite_jour'           => 'decimal:4',
        'taux_penalite_mois'           => 'decimal:4',
        'plafond_calcule'              => 'decimal:2',
        'date_echeance'                => 'date',
        'date_approbation'             => 'date',
        'date_dernier_calcul_penalite' => 'date',
    ];

    // =============================================
    //  ACCESSEURS
    // =============================================

    /** Reste à payer = total_dû - remboursé (min 0) */
    public function getResteAPayerAttribute(): float
    {
        $total = ($this->montant_total_du ?? 0) + ($this->penalites ?? 0);
        return max(0, $total - ($this->montant_rembourse ?? 0));
    }

    /** Indique si la deadline est dépassée */
    public function getEnRetardAttribute(): bool
    {
        return $this->date_echeance
            && Carbon::today()->greaterThan($this->date_echeance)
            && !in_array($this->statut, ['rembourse', 'rejete']);
    }

    /** Nombre de jours de retard */
    public function getNbJoursRetardAttribute(): int
    {
        if (!$this->en_retard || !$this->date_echeance) return 0;
        return (int) Carbon::parse($this->date_echeance)->diffInDays(Carbon::today());
    }

    // =============================================
    //  RELATIONS
    // =============================================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function repayments()
    {
        return $this->hasMany(LoanRepayment::class);
    }
}