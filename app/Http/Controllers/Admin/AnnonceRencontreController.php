<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnnonceRencontre;
use Illuminate\Http\Request;

class AnnonceRencontreController extends Controller
{
    public function index(Request $request)
    {
        $query = AnnonceRencontre::with('user');

        // Filtres
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            })->orWhereHas('user', function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('telephone', 'like', "%{$search}%");
            });
        }

        $annonces = $query->orderBy('created_at', 'desc')
            ->paginate(20);

        $types = AnnonceRencontre::types();

        return view('admin.nkap.rencontres.index', compact('annonces', 'types'));
    }

    public function show($id)
    {
        $annonce = AnnonceRencontre::with('user')->findOrFail($id);
        $types = AnnonceRencontre::types();

        return view('admin.nkap.rencontres.show', compact('annonce', 'types'));
    }

    public function destroy($id)
    {
        $annonce = AnnonceRencontre::findOrFail($id);
        $annonce->delete();

        return redirect()->route('admin.nkap.rencontres.index')
            ->with('success', 'Annonce rencontre supprimée avec succès.');
    }

    public function toggleStatut($id)
    {
        $annonce = AnnonceRencontre::findOrFail($id);
        
        $annonce->statut = $annonce->statut === 'actif' ? 'inactif' : 'actif';
        $annonce->save();

        $message = $annonce->statut === 'actif' 
            ? 'Annonce activée avec succès.' 
            : 'Annonce désactivée avec succès.';

        return redirect()->back()->with('success', $message);
    }
}
