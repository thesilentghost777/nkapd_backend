<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NkapUser;
use App\Models\NkapTransaction;
use Illuminate\Http\Request;

class NkapUserController extends Controller
{
    public function index(Request $request)
    {
        $query = NkapUser::with(['parrain', 'filleuls'])
            ->withCount(['tontinesCreees', 'tontinesRejointes', 'transactions', 'produits']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telephone', 'like', "%{$search}%")
                  ->orWhere('code_parrainage', 'like', "%{$search}%");
            });
        }

        if ($request->filled('statut')) {
            $query->where('is_active', $request->statut === 'actif');
        }

        if ($request->filled('role')) {
            if ($request->role === 'admin') {
                $query->where('is_admin', true);
            } elseif ($request->role === 'founder') {
                $query->where('is_founder', true);
            }
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);

        $stats = [
            'total' => NkapUser::count(),
            'actifs' => NkapUser::where('is_active', true)->count(),
            'admins' => NkapUser::where('is_admin', true)->count(),
            'solde_total' => NkapUser::sum('solde'),
        ];

        return view('admin.nkap.users.index', compact('users', 'stats'));
    }

    public function show($id)
    {
        $user = NkapUser::with([
            'parrain',
            'filleuls',
            'tontinesCreees',
            'tontinesRejointes',
            'transactions' => fn($q) => $q->latest()->limit(20),
            'produits',
            'annoncesRencontre'
        ])->findOrFail($id);

        $stats = [
            'filleuls_count' => $user->filleuls->count(),
            'tontines_creees' => $user->tontinesCreees->count(),
            'tontines_rejointes' => $user->tontinesRejointes->count(),
            'transactions_count' => $user->transactions()->count(),
            'total_recharges' => $user->transactions()->where('type', 'recharge')->sum('montant'),
            'total_retraits' => $user->transactions()->where('type', 'retrait')->sum('montant'),
        ];

        return view('admin.nkap.users.show', compact('user', 'stats'));
    }

    public function toggleStatus($id)
    {
        $user = NkapUser::findOrFail($id);
        $user->update(['is_active' => !$user->is_active]);

        return redirect()->back()->with('success', $user->is_active ? 'Utilisateur activé' : 'Utilisateur désactivé');
    }

    public function toggleAdmin($id)
    {
        $user = NkapUser::findOrFail($id);
        $user->update(['is_admin' => !$user->is_admin]);

        return redirect()->back()->with('success', $user->is_admin ? 'Droits admin accordés' : 'Droits admin révoqués');
    }

    public function destroy($id)
    {
        $user = NkapUser::findOrFail($id);

        if ($user->solde > 0) {
            return redirect()->back()->with('error', 'Impossible de supprimer un utilisateur avec un solde positif');
        }

        if ($user->tontinesCreees()->where('statut', 'en_cours')->exists()) {
            return redirect()->back()->with('error', 'Impossible de supprimer un utilisateur avec des tontines en cours');
        }

        $user->delete();

        return redirect()->route('admin.nkap.users.index')->with('success', 'Utilisateur supprimé');
    }

    public function transactions($id)
    {
        $user = NkapUser::findOrFail($id);
        $transactions = $user->transactions()->with('destinataire')->latest()->paginate(30);

        return view('admin.nkap.users.transactions', compact('user', 'transactions'));
    }
}
