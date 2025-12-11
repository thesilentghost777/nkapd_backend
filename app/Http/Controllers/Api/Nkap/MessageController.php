<?php

namespace App\Http\Controllers\Api\Nkap;

use App\Http\Controllers\Controller;
use App\Services\Nkap\MessageService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct(private MessageService $service) {}

    public function conversations(Request $request) { return response()->json($this->service->listeConversations($request->user())); }
    public function messages($id, Request $request) { return response()->json($this->service->messagesConversation($request->user(), $id)); }
    public function envoyer($id, Request $request) { return response()->json($this->service->envoyerMessage($request->user(), $id, $request->contenu)); }
    public function nouvelleConversation(Request $request) { return response()->json($this->service->demarrerConversation($request->user(), $request->destinataire_id, $request->message)); }
    public function nombreNonLus(Request $request) { return response()->json(['non_lus' => $this->service->nombreNonLus($request->user())]); }
}
