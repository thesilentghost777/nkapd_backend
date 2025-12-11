<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NkapConversation;
use App\Models\NkapMessage;
use Illuminate\Http\Request;

class NkapConversationController extends Controller
{
    public function index(Request $request)
    {
        $query = NkapConversation::with(['participant1', 'participant2', 'dernierMessage'])
            ->withCount('messages');

        // Filtres
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('participant1', function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('telephone', 'like', "%{$search}%");
            })->orWhereHas('participant2', function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('telephone', 'like', "%{$search}%");
            });
        }

        $conversations = $query->orderBy('dernier_message_at', 'desc')
            ->paginate(20);

        return view('admin.nkap.conversations.index', compact('conversations'));
    }

    public function show($id)
    {
        $conversation = NkapConversation::with(['participant1', 'participant2'])
            ->withCount('messages')
            ->findOrFail($id);

        $messages = NkapMessage::where('conversation_id', $id)
            ->with(['expediteur', 'destinataire'])
            ->orderBy('created_at', 'asc')
            ->paginate(50);

        return view('admin.nkap.conversations.show', compact('conversation', 'messages'));
    }

    public function destroy($id)
    {
        $conversation = NkapConversation::findOrFail($id);
        
        // Supprimer tous les messages de la conversation
        NkapMessage::where('conversation_id', $id)->delete();
        
        // Supprimer la conversation
        $conversation->delete();

        return redirect()->route('admin.nkap.conversations.index')
            ->with('success', 'Conversation supprimée avec succès.');
    }

    public function destroyMessage($conversationId, $messageId)
    {
        $message = NkapMessage::where('conversation_id', $conversationId)
            ->findOrFail($messageId);
        
        $message->delete();

        return redirect()->route('admin.nkap.conversations.show', $conversationId)
            ->with('success', 'Message supprimé avec succès.');
    }
}
