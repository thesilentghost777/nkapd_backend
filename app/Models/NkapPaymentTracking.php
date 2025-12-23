<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NkapPaymentTracking extends Model
{
    use HasFactory;

    protected $table = 'nkap_payment_tracking';

    protected $fillable = [
        'user_id',
        'token_pay',
        'type',
        'montant',
        'frais',
        'numero_telephone',
        'methode_paiement',
        'statut',
        'payment_url',
        'numero_transaction',
        'moyen',
        'webhook_data',
        'completed_at',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'frais' => 'decimal:2',
        'webhook_data' => 'array',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(NkapUser::class, 'user_id');
    }

    public function scopePending($query)
    {
        return $query->where('statut', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('statut', 'completed');
    }

    public function markAsCompleted()
    {
        $this->update([
            'statut' => 'completed',
            'completed_at' => now(),
        ]);
    }

    public function markAsCancelled()
    {
        $this->update([
            'statut' => 'cancelled',
        ]);
    }

    public function markAsFailed()
    {
        $this->update([
            'statut' => 'failed',
        ]);
    }
}