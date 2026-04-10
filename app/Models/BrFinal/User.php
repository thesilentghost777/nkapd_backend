<?php

namespace App\Models\BrFinal;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'br_users';

    protected $fillable = [
        'nom', 'prenom', 'telephone', 'email', 'password', 'role', 'statut',
        'solde_adhesion', 'adhesion_payee', 'photo', 'ville', 'quartier',
        'bio', 'whatsapp', 'derniere_connexion',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'adhesion_payee' => 'boolean',
        'solde_adhesion' => 'decimal:2',
        'derniere_connexion' => 'datetime',
    ];

    public function getNomCompletAttribute(): string
    {
        return "{$this->prenom} {$this->nom}";
    }

    public function estMembre(): bool
    {
        return $this->statut === 'membre' && $this->adhesion_payee;
    }

    public function estAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Relations
    public function filleuls()
    {
        return $this->hasMany(Referral::class, 'parrain_id');
    }

    public function filleulsActifs()
    {
        return $this->filleuls()->where('statut', 'actif');
    }

    public function parrain()
    {
        return $this->hasOne(Referral::class, 'filleul_id');
    }

    public function tontines()
    {
        return $this->hasMany(Tontine::class);
    }

    public function tontinesActives()
    {
        return $this->tontines()->where('statut', 'active');
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function cashbooks()
    {
        return $this->hasMany(Cashbook::class);
    }

    public function businessItems()
    {
        return $this->hasMany(BusinessItem::class);
    }

    public function assistanceRequests()
    {
        return $this->hasMany(AssistanceRequest::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getNbFilleulsActifsAttribute(): int
    {
        return $this->filleulsActifs()->count();
    }

    public function getPlafondPretAttribute(): float
    {
        return $this->nb_filleuls_actifs * 50000;
    }
}
