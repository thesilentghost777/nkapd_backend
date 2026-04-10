<?php

namespace App\Models\BrFinal;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'br_notifications';

    protected $fillable = ['user_id', 'globale', 'titre', 'contenu', 'type', 'lu', 'expire_at'];

    protected $casts = [
        'globale' => 'boolean',
        'lu' => 'boolean',
        'expire_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function envoyer(int $userId, string $titre, string $contenu, string $type = 'info'): self
    {
        return static::create([
            'user_id' => $userId,
            'titre' => $titre,
            'contenu' => $contenu,
            'type' => $type,
            'expire_at' => now()->addHours(48),
        ]);
    }

    public static function globale(string $titre, string $contenu, string $type = 'info'): self
    {
        return static::create([
            'globale' => true,
            'titre' => $titre,
            'contenu' => $contenu,
            'type' => $type,
            'expire_at' => now()->addHours(48),
        ]);
    }

    public function scopeNonLues($query)
    {
        return $query->where('lu', false);
    }

    public function scopeActives($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expire_at')->orWhere('expire_at', '>', now());
        });
    }
}
