<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnonceRencontre extends Model
{
    use HasFactory;

    protected $table = 'annonces_rencontre';

    protected $fillable = [
        'user_id',
        'type',
        'titre',
        'description',
        'preferences',
        'statut',
    ];

    protected $casts = [
        'preferences' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(NkapUser::class, 'user_id');
    }

    // Types de rencontre
    public const TYPE_AMOUREUSE = 'amoureuse';
    public const TYPE_PARTENAIRE_BUSINESS = 'partenaire_business';
    public const TYPE_AUTRE = 'autre';

    public static function types(): array
    {
        return [
            self::TYPE_AMOUREUSE => 'Rencontre Amoureuse',
            self::TYPE_PARTENAIRE_BUSINESS => 'Partenaire Business',
            self::TYPE_AUTRE => 'Autre',
        ];
    }

    public function scopeParType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeActif($query)
    {
        return $query->where('statut', 'actif');
    }
}
