<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NkapConfiguration extends Model
{
    use HasFactory;

    protected $table = 'nkap_configurations';

    protected $fillable = [
        'cle',
        'valeur',
        'description',
    ];

    protected $casts = [
        'valeur' => 'array',
    ];

    // Clés de configuration
    public const CODE_PARRAINAGE_DEFAUT = 'code_parrainage_defaut';
    public const FRAIS_RETRAIT_POURCENTAGE = 'frais_retrait_pourcentage';
    public const FRAIS_TRANSFERT_POURCENTAGE = 'frais_transfert_pourcentage';
    public const SOLDE_MINIMUM_APRES_RETRAIT = 'solde_minimum_apres_retrait';
    public const BONUS_PARRAINAGE = 'bonus_parrainage';
    public const FRAIS_MENSUEL = 'frais_mensuel';
    public const MAX_TONTINES_EN_COURS = 'max_tontines_en_cours';
    public const MONTANT_MIN_TONTINE = 'montant_min_tontine';
    public const FONDATEUR_ID = 'fondateur_id';

    /**
     * Récupère une valeur de configuration
     */
    public static function get(string $cle, $defaut = null)
    {
        $config = self::where('cle', $cle)->first();
        
        if (!$config) {
            return $defaut;
        }

        $valeur = $config->valeur;
        
        // Si c'est un tableau avec la clé 'value', retourner cette valeur
        if (is_array($valeur) && array_key_exists('value', $valeur)) {
            return $valeur['value'];
        }

        // Sinon retourner la valeur telle quelle
        return $valeur;
    }

    /**
     * Récupère la valeur brute (utile pour la vue)
     */
    public function getValeurBrute()
    {
        if (is_array($this->valeur) && array_key_exists('value', $this->valeur)) {
            return $this->valeur['value'];
        }
        
        return $this->valeur;
    }

    /**
     * Définit une valeur de configuration
     */
    public static function set(string $cle, $valeur, string $description = ''): self
    {
        return self::updateOrCreate(
            ['cle' => $cle],
            [
                'valeur' => ['value' => $valeur],
                'description' => $description,
            ]
        );
    }

    // Méthodes d'accès spécifiques
    public static function getCodeParrainageDefaut(): ?string
    {
        return self::get(self::CODE_PARRAINAGE_DEFAUT);
    }

    public static function getFraisRetraitPourcentage(): float
    {
        return (float) self::get(self::FRAIS_RETRAIT_POURCENTAGE, 25);
    }

    public static function getFraisTransfertPourcentage(): float
    {
        return (float) self::get(self::FRAIS_TRANSFERT_POURCENTAGE, 5);
    }

    public static function getSoldeMinimumApresRetrait(): float
    {
        return (float) self::get(self::SOLDE_MINIMUM_APRES_RETRAIT, 1500);
    }

    public static function getBonusParrainage(): float
    {
        return (float) self::get(self::BONUS_PARRAINAGE, 500);
    }

    public static function getFraisMensuel(): float
    {
        return (float) self::get(self::FRAIS_MENSUEL, 500);
    }

    public static function getMaxTontinesEnCours(): int
    {
        return (int) self::get(self::MAX_TONTINES_EN_COURS, 10);
    }

    public static function getMontantMinTontine(): float
    {
        return (float) self::get(self::MONTANT_MIN_TONTINE, 1000);
    }

    public static function getFondateurId(): ?int
    {
        $value = self::get(self::FONDATEUR_ID);
        return $value ? (int) $value : null;
    }

    public static function getFondateur(): ?NkapUser
    {
        $id = self::getFondateurId();
        return $id ? NkapUser::find($id) : null;
    }
}