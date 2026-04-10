<?php

namespace App\Http\Controllers\BrFinal;

use App\Http\Controllers\Controller;
use App\Models\BrFinal\Cashbook;
use App\Models\BrFinal\CashbookEntry;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CashbookController extends Controller
{
    public function index()
    {
        $user = auth('brfinal')->user();
        $cashbooks = $user->cashbooks()->orderByDesc('annee')->orderByDesc('mois')->get();
        $current = $cashbooks->where('mois', now()->month)->where('annee', now()->year)->first();

        if (!$current) {
            $current = Cashbook::create([
                'user_id' => $user->id,
                'mois' => now()->month,
                'annee' => now()->year,
            ]);
        }

        $entries = $current->entries()->orderByDesc('date')->get();

        return view('br-final.membre.cashbook.index', compact('cashbooks', 'current', 'entries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'libelle' => 'required|string|max:255',
            'type' => 'required|in:entree,sortie',
            'montant' => 'required|numeric|min:1',
            'categorie' => 'nullable|string',
            'note' => 'nullable|string',
        ]);

        $user = auth('brfinal')->user();
        $date = \Carbon\Carbon::parse($request->date);
        $cashbook = Cashbook::firstOrCreate(
            ['user_id' => $user->id, 'mois' => $date->month, 'annee' => $date->year]
        );

        if ($cashbook->valide) {
            return back()->with('error', 'Ce cahier est déjà validé.');
        }

        $cashbook->entries()->create($request->only('date', 'libelle', 'type', 'montant', 'categorie', 'note'));
        $cashbook->recalculer();

        return back()->with('success', 'Entrée ajoutée.');
    }

    public function valider(Cashbook $cashbook)
    {
        $cashbook->update(['valide' => true, 'date_validation' => now()]);
        return back()->with('success', 'Cahier validé. Il ne peut plus être modifié.');
    }

    public function show(Cashbook $cashbook)
    {
        $entries = $cashbook->entries()->orderBy('date')->get();
        return view('br-final.membre.cashbook.show', compact('cashbook', 'entries'));
    }

    public function exportPdf(Cashbook $cashbook)
    {
        $entries = $cashbook->entries()->orderBy('date')->get();
        $pdf = Pdf::loadView('br-final.membre.cashbook.pdf', compact('cashbook', 'entries'));
        return $pdf->download("cahier-caisse-{$cashbook->libelle_mois}.pdf");
    }
}
