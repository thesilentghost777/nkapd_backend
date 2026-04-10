<?php

namespace App\Http\Controllers\BrFinal;

use App\Http\Controllers\Controller;
use App\Models\BrFinal\Tontine;
use App\Services\BrFinal\TontineService;
use Illuminate\Http\Request;

class TontineController extends Controller
{
    public function index()
    {
        $user = auth('brfinal')->user();
        $tontines = $user->tontines()->latest()->get();
        $journaliereActive = $tontines->where('type', 'journaliere')->where('statut', 'active')->first();
        $hebdoActive = $tontines->where('type', 'hebdomadaire')->where('statut', 'active')->first();
        $historique = $tontines->whereNotIn('statut', ['active']);

        return view('br-final.membre.tontine.index', compact('tontines', 'journaliereActive', 'hebdoActive', 'historique'));
    }

    public function creer(Request $request, TontineService $service)
{
    $request->validate([
        'type'               => 'required|in:journaliere,hebdomadaire',
        'objectif'           => 'required|numeric|min:1200',
        'montant_cotisation' => [
            'required', 'numeric', 'min:1',
            function ($attribute, $value, $fail) use ($request) {
                $multiple = $request->type === 'journaliere' ? 1200 : 6100;
                if ($value % $multiple !== 0) {
                    $fail("Le montant doit être un multiple de {$multiple} FCFA.");
                }
            },
        ],
    ]);

    try {
        $service->creerTontine(
            auth('brfinal')->user(),
            $request->type,
            $request->objectif,
            $request->montant_cotisation  // ← ajout
        );
        return back()->with('success', 'Tontine créée avec succès !');
    } catch (\Exception $e) {
        return back()->with('error', $e->getMessage());
    }
}

    public function cotiser(Tontine $tontine, TontineService $service)
    {
        try {
            $result = $service->cotiser($tontine);
            return redirect($result['url']);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function demanderRetrait(Tontine $tontine, TontineService $service)
    {
        try {
            $service->demanderRetrait($tontine);
            return back()->with('success', 'Demande de retrait envoyée.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function retirerTout(TontineService $service)
    {
        $user = auth('brfinal')->user();
        $tontines = $user->tontines()->whereIn('statut', ['active', 'complete'])->get();

        foreach ($tontines as $tontine) {
            $service->demanderRetrait($tontine);
        }

        return back()->with('success', 'Demande de retrait global envoyée.');
    }
}
