<?php

namespace App\Http\Controllers\Api\Nkap;

use App\Http\Controllers\Controller;
use App\Services\Nkap\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct(private TransactionService $service) {}

    public function recharger(Request $request)
    {
        $data = $request->validate([
            'montant' => 'required|numeric|min:100',
            'methode_paiement' => 'required|string',
            'reference_externe' => 'nullable|string',
        ]);

        return response()->json($this->service->recharger(
            $request->user(), $data['montant'], $data['methode_paiement'], $data['reference_externe'] ?? null
        ));
    }

    public function retirer(Request $request)
    {
        $data = $request->validate(['montant' => 'required|numeric|min:100']);
        return response()->json($this->service->retirer($request->user(), $data['montant']));
    }

    public function transferer(Request $request)
    {
        $data = $request->validate([
            'destinataire' => 'required|string',
            'montant' => 'required|numeric|min:100',
        ]);

        return response()->json($this->service->transferer($request->user(), $data['destinataire'], $data['montant']));
    }

    public function historique(Request $request)
    {
        return response()->json($this->service->historique($request->user(), $request->get('page', 1)));
    }

    public function solde(Request $request)
    {
        return response()->json(['success' => true, 'solde' => $request->user()->solde]);
    }
}
