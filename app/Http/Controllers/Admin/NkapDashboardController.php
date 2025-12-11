<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NkapUser;
use App\Models\Tontine;
use App\Models\NkapTransaction;
use App\Models\Produit;
use App\Models\AnnonceRencontre;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NkapDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => [
                'total' => NkapUser::count(),
                'actifs' => NkapUser::where('is_active', true)->count(),
                'nouveaux_mois' => NkapUser::whereMonth('created_at', now()->month)->count(),
                'solde_total' => NkapUser::sum('solde'),
            ],
            'tontines' => [
                'total' => Tontine::count(),
                'en_cours' => Tontine::where('statut', 'en_cours')->count(),
                'fermees' => Tontine::where('statut', 'fermee')->count(),
                'montant_total' => Tontine::sum('montant_total'),
            ],
            'transactions' => [
                'total' => NkapTransaction::count(),
                'aujourd_hui' => NkapTransaction::whereDate('created_at', today())->count(),
                'montant_jour' => NkapTransaction::whereDate('created_at', today())->where('statut', 'complete')->sum('montant'),
                'frais_collectes' => NkapTransaction::whereNotNull('frais')->sum('frais'),
            ],
            'produits' => [
                'total' => Produit::count(),
                'actifs' => Produit::where('statut', 'actif')->count(),
            ],
            'annonces' => [
                'total' => AnnonceRencontre::count(),
                'actives' => AnnonceRencontre::where('statut', 'actif')->count(),
            ],
        ];

        // Transactions récentes
        $transactionsRecentes = NkapTransaction::with('user')
            ->latest()
            ->limit(10)
            ->get();

        // Nouveaux utilisateurs
        $nouveauxUsers = NkapUser::latest()
            ->limit(10)
            ->get();

        // Graphique transactions 7 derniers jours
        $transactionsParJour = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $transactionsParJour[] = [
                'date' => $date->format('d/m'),
                'montant' => NkapTransaction::whereDate('created_at', $date)->where('statut', 'complete')->sum('montant'),
                'count' => NkapTransaction::whereDate('created_at', $date)->count(),
            ];
        }

        return view('admin.nkap.dashboard', compact('stats', 'transactionsRecentes', 'nouveauxUsers', 'transactionsParJour'));
    }
}
