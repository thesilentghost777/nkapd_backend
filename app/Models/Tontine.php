<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tontine extends Model
{
    use HasFactory;

    protected $table = 'tontines';

    protected $fillable = [
        'code',
        'nom',
        'createur_id',
        'prix',
        'nombre_membres_requis',
        'nombre_membres_actuels',
        'montant_total',
        'statut',
        'date_fermeture',
    ];

    protected $casts = [
        'prix' => 'decimal:2',
        'montant_total' => 'decimal:2',
        'nombre_membres_requis' => 'integer',
        'nombre_membres_actuels' => 'integer',
        'createur_id' => 'integer',
        'date_fermeture' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tontine) {
            if (empty($tontine->code)) {
                $tontine->code = self::genererCode();
            }
        });
    }

    public static function genererCode(): string
    {
        $date = now()->format('dmY');
        $count = self::whereDate('created_at', today())->count() + 1;
        return 'NKAPD-' . $date . str_pad($count, 3, '0', STR_PAD_LEFT);
    }

    // Relations
    public function createur()
    {
        return $this->belongsTo(NkapUser::class, 'createur_id');
    }

    public function membres()
    {
        return $this->belongsToMany(NkapUser::class, 'tontine_membres', 'tontine_id', 'user_id')
                    ->withPivot('montant_paye', 'date_adhesion')
                    ->withTimestamps();
    }

    // Méthodes métier
    public function estComplete(): bool
    {
        return $this->nombre_membres_actuels >= $this->nombre_membres_requis;
    }

    public function estOuverte(): bool
    {
        return $this->statut === 'en_cours';
    }

    public function peutRejoindre(NkapUser $user): bool
    {
        if (!$this->estOuverte()) {
            return false;
        }

        if ($this->estComplete()) {
            return false;
        }

        if ($this->createur_id === $user->id) {
            return false;
        }

        if ($this->membres()->where('user_id', $user->id)->exists()) {
            return false;
        }

        if ($user->solde < $this->prix) {
            return false;
        }

        return true;
    }

    public function fermer(): void
    {
        if (!$this->estComplete()) {
            throw new \Exception('La tontine n\'est pas encore complète');
        }

        $this->statut = 'fermee';
        $this->date_fermeture = now();
        $this->save();

        // Verser le montant total au créateur
        $this->createur->crediter(
            $this->montant_total,
            "Gains tontine {$this->code}",
            'gain_tontine'
        );
    }
}
