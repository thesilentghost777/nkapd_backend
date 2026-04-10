<?php

namespace App\Http\Controllers\BrFinal;

use App\Http\Controllers\Controller;
use App\Models\BrFinal\Loan;
use App\Services\BrFinal\LoanService;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        $user = auth('brfinal')->user();
        $pretActif = $user->loans()->whereIn('statut', ['en_attente', 'approuve', 'en_cours', 'en_retard'])->first();
        $historique = $user->loans()->whereIn('statut', ['rembourse', 'rejete'])->latest()->get();

        return view('br-final.membre.pret.index', compact('pretActif', 'historique', 'user'));
    }

    public function demander(Request $request, LoanService $service)
    {
        $request->validate(['montant' => 'required|numeric|min:10000']);

        try {
            $service->demanderPret(auth('brfinal')->user(), $request->montant);
            return back()->with('success', 'Demande de prêt envoyée.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function rembourser(Request $request, Loan $loan, LoanService $service)
    {
        $request->validate(['montant' => 'required|numeric|min:1000']);

        try {
            $result = $service->rembourser($loan, $request->montant);
            return redirect($result['url']);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
