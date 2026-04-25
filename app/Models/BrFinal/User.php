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
        // OAuth / Firebase
        'firebase_uid', 'google_id', 'apple_id', 'auth_provider',
        // OTP
        'otp_code', 'otp_expires_at', 'email_verified',
    ];

    protected $hidden = ['password', 'remember_token', 'otp_code'];

    protected $casts = [
        'adhesion_payee'   => 'boolean',
        'email_verified'   => 'boolean',
        'solde_adhesion'   => 'decimal:2',
        'derniere_connexion' => 'datetime',
        'otp_expires_at'   => 'datetime',
    ];

    // =============================================
    //  ACCESSEURS
    // =============================================

    public function getNomCompletAttribute(): string
    {
        return "{$this->prenom} {$this->nom}";
    }

    // =============================================
    //  MÉTHODES MÉTIER
    // =============================================

    public function estMembre(): bool
    {
        return $this->statut === 'membre' && $this->adhesion_payee;
    }

    public function estAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /** Vérifie si le compte a été créé via OAuth (pas de mot de passe requis) */
    public function estOAuth(): bool
    {
        return in_array($this->auth_provider, ['google', 'apple']);
    }

    /** Génère et sauvegarde un OTP à 6 chiffres valable 10 minutes */
    public function genererOtp(): string
    {
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $this->update([
            'otp_code'       => $code,
            'otp_expires_at' => now()->addMinutes(10),
        ]);
        return $code;
    }

    /** Vérifie si le code OTP fourni est correct et non expiré */
    public function verifierOtp(string $code): bool
    {
        return $this->otp_code === $code
            && $this->otp_expires_at
            && now()->lessThanOrEqualTo($this->otp_expires_at);
    }

    /** Invalide l'OTP après utilisation */
    public function invaliderOtp(): void
    {
        $this->update(['otp_code' => null, 'otp_expires_at' => null]);
    }

    // =============================================
    //  RELATIONS
    // =============================================

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

    // =============================================
    //  ACCESSEURS CALCULÉS
    // =============================================

    public function getNbFilleulsActifsAttribute(): int
    {
        return $this->filleulsActifs()->count();
    }

    public function getPlafondPretAttribute(): float
    {
        return $this->nb_filleuls_actifs * 50000;
    }
}