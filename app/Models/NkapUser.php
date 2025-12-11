<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class NkapUser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'nkap_users';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'password',
        'date_naissance',
        'sexe',
        'ville',
        'photo_profil',
        'code_parrainage',
        'parrain_id',
        'solde',
        'is_active',
        'is_founder',
        'is_admin',
        'preferences_rencontre',
        'bio',
        'derniere_connexion',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'solde' => 'decimal:2',
        'is_active' => 'boolean',
        'is_founder' => 'boolean',
        'is_admin' => 'boolean',
        'preferences_rencontre' => 'array',
        'date_naissance' => 'date',
        'derniere_connexion' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($user) {
            if (empty($user->code_parrainage)) {
                $user->code_parrainage = self::genererCodeParrainage();
            }
        });
    }

    public static function genererCodeParrainage(): string
    {
        do {
            $code = 'NKAP-' . strtoupper(Str::random(6));
        } while (self::where('code_parrainage', $code)->exists());
        
        return $code;
    }

    public function getNomCompletAttribute(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }

    // Relations
    public function parrain()
    {
        return $this->belongsTo(NkapUser::class, 'parrain_id');
    }

    public function filleuls()
    {
        return $this->hasMany(NkapUser::class, 'parrain_id');
    }

    public function tontinesCreees()
    {
        return $this->hasMany(Tontine::class, 'createur_id');
    }

    public function tontinesRejointes()
    {
        return $this->belongsToMany(Tontine::class, 'tontine_membres', 'user_id', 'tontine_id')
                    ->withPivot('montant_paye', 'date_adhesion')
                    ->withTimestamps();
    }

    public function transactions()
    {
        return $this->hasMany(NkapTransaction::class, 'user_id');
    }

    public function produits()
    {
        return $this->hasMany(Produit::class, 'vendeur_id');
    }

    public function annoncesRencontre()
    {
        return $this->hasMany(AnnonceRencontre::class, 'user_id');
    }

    public function messagesEnvoyes()
    {
        return $this->hasMany(NkapMessage::class, 'expediteur_id');
    }

    public function messagesRecus()
    {
        return $this->hasMany(NkapMessage::class, 'destinataire_id');
    }

    public function notifications()
    {
        return $this->hasMany(NkapNotification::class, 'user_id');
    }

    // Méthodes métier
    public function crediter(float $montant, string $description = '', string $type = 'credit'): NkapTransaction
    {
        $this->solde += $montant;
        $this->save();

        return $this->transactions()->create([
            'type' => $type,
            'montant' => $montant,
            'solde_avant' => $this->solde - $montant,
            'solde_apres' => $this->solde,
            'description' => $description,
            'statut' => 'complete',
        ]);
    }

    public function debiter(float $montant, string $description = '', string $type = 'debit'): NkapTransaction
    {
        if ($this->solde < $montant) {
            throw new \Exception('Solde insuffisant');
        }

        $this->solde -= $montant;
        $this->save();

        return $this->transactions()->create([
            'type' => $type,
            'montant' => $montant,
            'solde_avant' => $this->solde + $montant,
            'solde_apres' => $this->solde,
            'description' => $description,
            'statut' => 'complete',
        ]);
    }

    public function nombreTontinesEnCours(): int
    {
        return $this->tontinesCreees()->where('statut', 'en_cours')->count();
    }

    public function peutCreerTontine(): bool
    {
        return $this->nombreTontinesEnCours() < 10;
    }

    public function aParticipePremiereTontine(): bool
    {
        return $this->tontinesRejointes()->exists();
    }

    // ⭐ AJOUTEZ CETTE RELATION
    public function user()
    {
        return $this->belongsTo(NkapUser::class, 'id');
    }
}
