<?php

namespace App\Models\BrFinal;

use Illuminate\Database\Eloquent\Model;

class BusinessItem extends Model
{
    protected $table = 'br_business_items';

    protected $fillable = [
        'user_id', 'titre', 'description', 'prix', 'categorie', 'image', 'whatsapp', 'actif', 'vues',
    ];

    protected $casts = [
        'prix' => 'decimal:2',
        'actif' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
