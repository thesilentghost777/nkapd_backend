<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NkapConfiguration;
use App\Models\NkapUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NkapConfigurationController extends Controller
{
    public function index()
    {
        $configurations = NkapConfiguration::all()->keyBy('cle');
        $fondateurs = NkapUser::where('is_founder', true)
                              ->orWhere('is_admin', true)
                              ->get();

        $configMap = [
            'code_parrainage_defaut' => [
                'label' => 'Code parrainage par défaut',
                'type' => 'text',
                'description' => 'Code utilisé quand aucun parrain n\'est spécifié'
            ],
            'frais_retrait_pourcentage' => [
                'label' => 'Frais de retrait (%)',
                'type' => 'number',
                'description' => 'Pourcentage prélevé sur les retraits',
                'step' => '0.01',
                'min' => '0',
                'max' => '100'
            ],
            'frais_transfert_pourcentage' => [
                'label' => 'Frais de transfert (%)',
                'type' => 'number',
                'description' => 'Pourcentage prélevé sur les transferts',
                'step' => '0.01',
                'min' => '0',
                'max' => '100'
            ],
            'solde_minimum_apres_retrait' => [
                'label' => 'Solde minimum après retrait (FCFA)',
                'type' => 'number',
                'description' => 'Montant minimum devant rester après un retrait',
                'min' => '0'
            ],
            'bonus_parrainage' => [
                'label' => 'Bonus parrainage (FCFA)',
                'type' => 'number',
                'description' => 'Montant accordé au parrain pour chaque filleul',
                'min' => '0'
            ],
            'frais_mensuel' => [
                'label' => 'Frais mensuel (FCFA)',
                'type' => 'number',
                'description' => 'Frais de maintenance prélevé mensuellement',
                'min' => '0'
            ],
            'max_tontines_en_cours' => [
                'label' => 'Max tontines en cours',
                'type' => 'number',
                'description' => 'Nombre maximum de tontines qu\'un utilisateur peut créer',
                'min' => '1'
            ],
            'montant_min_tontine' => [
                'label' => 'Montant minimum tontine (FCFA)',
                'type' => 'number',
                'description' => 'Montant minimum pour créer une tontine',
                'min' => '0'
            ],
            'fondateur_id' => [
                'label' => 'Fondateur',
                'type' => 'select',
                'description' => 'Utilisateur désigné comme fondateur de la plateforme'
            ],
        ];

        return view('admin.nkap.configurations.index', compact('configurations', 'configMap', 'fondateurs'));
    }

    public function update(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'frais_retrait_pourcentage' => 'nullable|numeric|min:0|max:100',
            'frais_transfert_pourcentage' => 'nullable|numeric|min:0|max:100',
            'solde_minimum_apres_retrait' => 'nullable|numeric|min:0',
            'bonus_parrainage' => 'nullable|numeric|min:0',
            'frais_mensuel' => 'nullable|numeric|min:0',
            'max_tontines_en_cours' => 'nullable|integer|min:1',
            'montant_min_tontine' => 'nullable|numeric|min:0',
            'code_parrainage_defaut' => 'nullable|string|max:50',
            'fondateur_id' => 'nullable|exists:nkap_users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Erreur de validation des données');
        }

        // Mise à jour des configurations
        $updated = 0;
        foreach ($request->except(['_token', '_method']) as $cle => $valeur) {
            if ($valeur !== null && $valeur !== '') {
                NkapConfiguration::set($cle, $valeur);
                $updated++;
            }
        }

        return redirect()->back()->with('success', "{$updated} configuration(s) mise(s) à jour avec succès");
    }
}