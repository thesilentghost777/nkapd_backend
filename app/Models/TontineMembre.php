<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TontineMembre extends Model
{
    use HasFactory;

    protected $table = 'tontine_membres';

    protected $fillable = [
        'tontine_id',
        'user_id',
        'montant_paye',
        'date_adhesion',
    ];

    protected $casts = [
        'montant_paye' => 'decimal:2',
        'date_adhesion' => 'datetime',
        'tontine_id' => 'integer',
        'user_id' => 'integer',
    ];

    public function tontine()
    {
        return $this->belongsTo(Tontine::class);
    }

    public function user()
    {
        return $this->belongsTo(NkapUser::class, 'user_id');
    }
}
