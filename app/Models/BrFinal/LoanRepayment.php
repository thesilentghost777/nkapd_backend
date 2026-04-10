<?php

namespace App\Models\BrFinal;

use Illuminate\Database\Eloquent\Model;

class LoanRepayment extends Model
{
    protected $table = 'br_loan_repayments';

    protected $fillable = [
        'loan_id', 'user_id', 'montant', 'date_paiement', 'statut', 'token_paiement',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'date_paiement' => 'date',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
