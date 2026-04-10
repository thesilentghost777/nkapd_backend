<?php

namespace App\Models\BrFinal;

use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    protected $table = 'br_contributions';

    protected $fillable = [
        'tontine_id', 'user_id', 'montant', 'date_cotisation', 'statut', 'token_paiement',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'date_cotisation' => 'date',
    ];

    public function tontine()
    {
        return $this->belongsTo(Tontine::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
