<?php

namespace App\Models\BrFinal;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'br_payments';

    protected $fillable = [
        'reference', 'user_id', 'type', 'payable_type', 'payable_id',
        'montant', 'frais', 'token_paiement', 'numero_telephone',
        'nom_client', 'url_paiement', 'statut', 'moyen_paiement',
        'numero_transaction', 'webhook_data', 'personal_info',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'frais' => 'decimal:2',
        'webhook_data' => 'array',
        'personal_info' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($p) {
            if (empty($p->reference)) {
                $p->reference = 'BR' . date('YmdHis') . strtoupper(substr(md5(uniqid()), 0, 6));
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payable()
    {
        return $this->morphTo();
    }
}
