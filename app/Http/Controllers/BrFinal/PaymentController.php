<?php

namespace App\Http\Controllers\BrFinal;

use App\Http\Controllers\Controller;
use App\Models\BrFinal\Payment;
use App\Models\BrFinal\User;
use App\Services\BrFinal\MoneyFusionService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // ===== ADHESION =====
    public function adhesion(MoneyFusionService $mf)
    {
        $user = auth('brfinal')->user();
        if ($user->adhesion_payee) {
            return redirect()->route('br.membre.dashboard')->with('info', 'Vous êtes déjà membre.');
        }

        $payment = Payment::create([
            'user_id' => $user->id,
            'type' => 'adhesion',
            'payable_type' => User::class,
            'payable_id' => $user->id,
            'montant' => 10000,
            'numero_telephone' => $user->telephone,
            'nom_client' => $user->nom_complet,
            'personal_info' => ['type' => 'adhesion'],
        ]);

        $result = $mf->initierPaiement([
            'montant' => 10000,
            'telephone' => $user->telephone,
            'nom_client' => $user->nom_complet,
            'type' => 'adhesion',
            'reference' => $payment->reference,
            'user_id' => $user->id,
            'description' => 'Adhésion Business Room',
            'return_url' => route('br.membre.dashboard'),
        ]);

        if ($result['success']) {
            $payment->update(['token_paiement' => $result['token'], 'url_paiement' => $result['url']]);
            return redirect($result['url']);
        }

        $payment->update(['statut' => 'failure']);
        return back()->with('error', $result['message']);
    }

    public function callback()
    {
        return redirect()->route('br.membre.dashboard')->with('info', 'Paiement en cours de traitement.');
    }

    // ===== WEBHOOK =====
    public function webhook(Request $request, MoneyFusionService $mf)
    {
        $mf->traiterWebhook($request->all());
        return response()->json(['status' => 'ok']);
    }
}
