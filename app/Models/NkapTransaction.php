<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NkapTransaction extends Model
{
    use HasFactory;

    protected $table = 'nkap_transactions';

    protected $fillable = [
        'user_id',
        'type',
        'montant',
        'solde_avant',
        'solde_apres',
        'description',
        'reference',
        'statut',
        'destinataire_id',
        'frais',
        'methode_paiement',
        'reference_externe',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'solde_avant' => 'decimal:2',
        'solde_apres' => 'decimal:2',
        'frais' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($transaction) {
            if (empty($transaction->reference)) {
                $transaction->reference = 'TXN-' . strtoupper(uniqid());
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(NkapUser::class, 'user_id');
    }

    public function destinataire()
    {
        return $this->belongsTo(NkapUser::class, 'destinataire_id');
    }

    // Types de transactions
    public const TYPE_RECHARGE = 'recharge';
    public const TYPE_RETRAIT = 'retrait';
    public const TYPE_TRANSFERT_ENVOYE = 'transfert_envoye';
    public const TYPE_TRANSFERT_RECU = 'transfert_recu';
    public const TYPE_CREATION_TONTINE = 'creation_tontine';
    public const TYPE_ADHESION_TONTINE = 'adhesion_tontine';
    public const TYPE_GAIN_TONTINE = 'gain_tontine';
    public const TYPE_BONUS_PARRAINAGE = 'bonus_parrainage';
    public const TYPE_FRAIS_MENSUEL = 'frais_mensuel';
    public const TYPE_FRAIS_ADMIN = 'frais_admin';
    
}
