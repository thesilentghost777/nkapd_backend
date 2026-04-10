<?php

namespace App\Models\BrFinal;

use Illuminate\Database\Eloquent\Model;

class CashbookEntry extends Model
{
    protected $table = 'br_cashbook_entries';

    protected $fillable = ['cashbook_id', 'date', 'libelle', 'type', 'montant', 'categorie', 'note'];

    protected $casts = [
        'montant' => 'decimal:2',
        'date' => 'date',
    ];

    public function cashbook()
    {
        return $this->belongsTo(Cashbook::class);
    }
}
