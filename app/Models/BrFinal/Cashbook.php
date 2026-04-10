<?php

namespace App\Models\BrFinal;

use Illuminate\Database\Eloquent\Model;

class Cashbook extends Model
{
    protected $table = 'br_cashbooks';

    protected $fillable = [
        'user_id', 'mois', 'annee', 'total_entrees', 'total_sorties', 'solde', 'valide', 'date_validation',
    ];

    protected $casts = [
        'total_entrees' => 'decimal:2',
        'total_sorties' => 'decimal:2',
        'solde' => 'decimal:2',
        'valide' => 'boolean',
        'date_validation' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function entries()
    {
        return $this->hasMany(CashbookEntry::class);
    }

    public function recalculer(): void
    {
        $this->total_entrees = $this->entries()->where('type', 'entree')->sum('montant');
        $this->total_sorties = $this->entries()->where('type', 'sortie')->sum('montant');
        $this->solde = $this->total_entrees - $this->total_sorties;
        $this->save();
    }

    public function getLibelleMoisAttribute(): string
    {
        $mois = ['', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
        return ($mois[$this->mois] ?? '') . ' ' . $this->annee;
    }
}
