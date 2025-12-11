<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NkapTransaction;
use Illuminate\Http\Request;

class NkapTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = NkapTransaction::with(['user', 'destinataire']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($q2) => $q2->where('nom', 'like', "%{$search}%")->orWhere('prenom', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('date_debut')) {
            $query->whereDate('created_at', '>=', $request->date_debut);
        }

        if ($request->filled('date_fin')) {
            $query->whereDate('created_at', '<=', $request->date_fin);
        }

        $transactions = $query->orderBy('created_at', 'desc')->paginate(30);

        $stats = [
            'total' => NkapTransaction::count(),
            'total_montant' => NkapTransaction::where('statut', 'complete')->sum('montant'),
            'recharges' => NkapTransaction::where('type', 'recharge')->where('statut', 'complete')->sum('montant'),
            'retraits' => NkapTransaction::where('type', 'retrait')->where('statut', 'complete')->sum('montant'),
            'frais_collectes' => NkapTransaction::whereNotNull('frais')->sum('frais'),
        ];

        $types = [
            'recharge', 'retrait', 'transfert_envoye', 'transfert_recu',
            'creation_tontine', 'adhesion_tontine', 'gain_tontine',
            'bonus_parrainage', 'frais_mensuel', 'frais_admin'
        ];

        return view('admin.nkap.transactions.index', compact('transactions', 'stats', 'types'));
    }

    public function show($id)
    {
        $transaction = NkapTransaction::with(['user', 'destinataire'])->findOrFail($id);

        return view('admin.nkap.transactions.show', compact('transaction'));
    }
}
