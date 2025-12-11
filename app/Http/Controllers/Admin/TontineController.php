<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tontine;
use App\Models\TontineMembre;
use Illuminate\Http\Request;

class TontineController extends Controller
{
    public function index(Request $request)
    {
        $query = Tontine::with(['createur', 'membres'])
            ->withCount('membres');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $tontines = $query->orderBy('created_at', 'desc')->paginate(20);

        $stats = [
            'total' => Tontine::count(),
            'en_cours' => Tontine::where('statut', 'en_cours')->count(),
            'fermees' => Tontine::where('statut', 'fermee')->count(),
            'montant_total' => Tontine::sum('montant_total'),
        ];

        return view('admin.nkap.tontines.index', compact('tontines', 'stats'));
    }

    public function show($id)
    {
        $tontine = Tontine::with(['createur', 'membres.user'])->findOrFail($id);

        return view('admin.nkap.tontines.show', compact('tontine'));
    }

    public function updateStatut(Request $request, $id)
    {
        $tontine = Tontine::findOrFail($id);

        $request->validate([
            'statut' => 'required|in:en_cours,fermee,annulee'
        ]);

        $tontine->update([
            'statut' => $request->statut,
            'date_fermeture' => in_array($request->statut, ['fermee', 'annulee']) ? now() : null
        ]);

        return redirect()->back()->with('success', 'Statut de la tontine mis à jour');
    }

    public function destroy($id)
    {
        $tontine = Tontine::findOrFail($id);

        if ($tontine->statut === 'en_cours' && $tontine->membres()->count() > 0) {
            return redirect()->back()->with('error', 'Impossible de supprimer une tontine en cours avec des membres');
        }

        $tontine->delete();

        return redirect()->route('admin.nkap.tontines.index')->with('success', 'Tontine supprimée');
    }
}
