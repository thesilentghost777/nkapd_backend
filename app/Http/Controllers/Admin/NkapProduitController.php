<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use Illuminate\Http\Request;

class NkapProduitController extends Controller
{
    public function index(Request $request)
    {
        $query = Produit::with('vendeur');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('categorie')) {
            $query->where('categorie', $request->categorie);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $produits = $query->orderBy('created_at', 'desc')->paginate(20);

        $stats = [
            'total' => Produit::count(),
            'actifs' => Produit::where('statut', 'actif')->count(),
            'vendus' => Produit::where('statut', 'vendu')->count(),
            'categories' => Produit::distinct('categorie')->pluck('categorie'),
        ];

        return view('admin.nkap.produits.index', compact('produits', 'stats'));
    }

    public function show($id)
    {
        $produit = Produit::with('vendeur')->findOrFail($id);

        return view('admin.nkap.produits.show', compact('produit'));
    }

    public function updateStatut(Request $request, $id)
    {
        $produit = Produit::findOrFail($id);

        $request->validate([
            'statut' => 'required|in:actif,inactif,vendu,refuse'
        ]);

        $produit->update(['statut' => $request->statut]);

        return redirect()->back()->with('success', 'Statut du produit mis à jour');
    }

    public function destroy($id)
    {
        $produit = Produit::findOrFail($id);
        $produit->delete();

        return redirect()->route('admin.nkap.produits.index')->with('success', 'Produit supprimé');
    }
}
