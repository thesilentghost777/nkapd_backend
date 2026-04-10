<?php

namespace App\Http\Controllers\BrFinal;

use App\Http\Controllers\Controller;
use App\Models\BrFinal\AssistanceRequest;
use Illuminate\Http\Request;

class AssistanceController extends Controller
{
    public function index()
    {
        $user = auth('brfinal')->user();

        // Vérifier tontine active
        $aTontineActive = $user->tontinesActives()->exists();
        $demandes = $user->assistanceRequests()->latest()->get();

        return view('br-final.membre.assistance.index', compact('aTontineActive', 'demandes'));
    }

    public function store(Request $request)
    {
        $user = auth('brfinal')->user();

        if (!$user->tontinesActives()->exists()) {
            return back()->with('error', 'Vous devez avoir une tontine active pour demander de l\'aide.');
        }

        $request->validate([
            'sujet' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:maladie_grave,sinistre,invalidite,pret_bancaire,juridique,managerial,marketing,mise_en_relation,autre',
        ]);

        $demande = AssistanceRequest::create([
            'user_id' => $user->id,
            'sujet' => $request->sujet,
            'description' => $request->description,
            'type' => $request->type,
        ]);

        // Premier message
        $demande->messages()->create([
            'sender_id' => $user->id,
            'contenu' => $request->description,
        ]);

        return back()->with('success', 'Demande envoyée.');
    }

    public function show(AssistanceRequest $assistance)
    {
        $assistance->load(['messages.sender']);
        // Marquer messages lus
        $assistance->messages()->where('sender_id', '!=', auth('brfinal')->id())->update(['lu' => true]);
        return view('br-final.membre.assistance.show', compact('assistance'));
    }

    public function message(Request $request, AssistanceRequest $assistance)
    {
        $request->validate(['contenu' => 'required|string']);
        $assistance->messages()->create([
            'sender_id' => auth('brfinal')->id(),
            'contenu' => $request->contenu,
        ]);
        return back();
    }
}