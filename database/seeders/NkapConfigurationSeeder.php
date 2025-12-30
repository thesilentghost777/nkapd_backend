<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NkapConfiguration;

class NkapConfigurationSeeder extends Seeder
{
    public function run(): void
    {
        $configurations = [
            [
                'cle' => NkapConfiguration::CODE_PARRAINAGE_DEFAUT,
                'valeur' => ['value' => 'NKAP2024'],
                'description' => 'Code de parrainage par défaut pour les nouveaux utilisateurs',
            ],
            [
                'cle' => NkapConfiguration::FRAIS_RETRAIT_POURCENTAGE,
                'valeur' => ['value' => 2.5],
                'description' => 'Pourcentage des frais appliqués lors des retraits',
            ],
            [
                'cle' => NkapConfiguration::FRAIS_TRANSFERT_POURCENTAGE,
                'valeur' => ['value' => 1],
                'description' => 'Pourcentage des frais appliqués lors des transferts',
            ],
            [
                'cle' => NkapConfiguration::SOLDE_MINIMUM_APRES_RETRAIT,
                'valeur' => ['value' => 500],
                'description' => 'Solde minimum requis sur le compte après un retrait',
            ],
            [
                'cle' => NkapConfiguration::BONUS_PARRAINAGE,
                'valeur' => ['value' => 1000],
                'description' => 'Montant du bonus accordé pour chaque parrainage réussi',
            ],
            [
                'cle' => NkapConfiguration::FRAIS_MENSUEL,
                'valeur' => ['value' => 0],
                'description' => 'Frais mensuels de maintenance du compte',
            ],
            [
                'cle' => NkapConfiguration::MAX_TONTINES_EN_COURS,
                'valeur' => ['value' => 5],
                'description' => 'Nombre maximum de tontines auxquelles un utilisateur peut participer simultanément',
            ],
            [
                'cle' => NkapConfiguration::MONTANT_MIN_TONTINE,
                'valeur' => ['value' => 5000],
                'description' => 'Montant minimum requis pour créer une tontine',
            ],
            [
                'cle' => NkapConfiguration::FONDATEUR_ID,
                'valeur' => ['value' => null],
                'description' => 'ID de l\'utilisateur fondateur de la plateforme',
            ],
        ];

        foreach ($configurations as $config) {
            NkapConfiguration::updateOrCreate(
                ['cle' => $config['cle']],
                [
                    'valeur' => $config['valeur'],
                    'description' => $config['description'],
                ]
            );
        }

        $this->command->info('✅ Configurations NKAP initialisées avec succès !');
    }
}