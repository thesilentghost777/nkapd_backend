<?php

namespace App\Models\BrFinal;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    protected $table = 'br_referrals';

    protected $fillable = ['parrain_id', 'filleul_id', 'statut'];

    public function parrain()
    {
        return $this->belongsTo(User::class, 'parrain_id');
    }

    public function filleul()
    {
        return $this->belongsTo(User::class, 'filleul_id');
    }
}
