<?php

namespace App\Services\Nkap;

use App\Models\NkapUser;
use App\Models\NkapConversation;
use App\Models\NkapMessage;

class MessageService
{
    /**
     * Liste des conversations
     */
    public function listeConversations(NkapUser $user): array
    {
        $conversations = NkapConversation::with(['participant1:id,nom,prenom,photo_profil', 'participant2:id,nom,prenom,photo_profil', 'dernierMessage'])
            ->where('participant1_id', $user->id)
            ->orWhere('participant2_id', $user->id)
            ->orderBy('dernier_message_at', 'desc')
            ->get()
            ->map(function ($conv) use ($user) {
                $autre = $conv->participant1_id === $user->id ? $conv->participant2 : $conv->participant1;
                $nonLus = NkapMessage::where('conversation_id', $conv->id)
                    ->where('destinataire_id', $user->id)
                    ->where('lu', false)
                    ->count();

                return [
                    'id' => $conv->id,
                    'autre_participant' => [
                        'id' => $autre->id,
                        'nom_complet' => $autre->nom_complet,
                        'photo_profil' => $autre->photo_profil,
                    ],
                    'dernier_message' => $conv->dernierMessage ? [
                        'contenu' => $conv->dernierMessage->contenu,
                        'date' => $conv->dernierMessage->created_at,
                        'est_moi' => $conv->dernierMessage->expediteur_id === $user->id,
                    ] : null,
                    'non_lus' => $nonLus,
                    'type' => $conv->type,
                ];
            });

        return [
            'success' => true,
            'conversations' => $conversations,
        ];
    }

    /**
     * Messages d'une conversation
     */
    public function messagesConversation(NkapUser $user, int $conversationId, int $page = 1, int $perPage = 50): array
    {
        $conversation = NkapConversation::find($conversationId);

        if (!$conversation) {
            return [
                'success' => false,
                'message' => 'Conversation introuvable',
            ];
        }

        if ($conversation->participant1_id !== $user->id && $conversation->participant2_id !== $user->id) {
            return [
                'success' => false,
                'message' => 'Accès non autorisé',
            ];
        }

        // Marquer les messages comme lus
        NkapMessage::where('conversation_id', $conversationId)
            ->where('destinataire_id', $user->id)
            ->where('lu', false)
            ->update(['lu' => true, 'date_lecture' => now()]);

        $messages = NkapMessage::where('conversation_id', $conversationId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        return [
            'success' => true,
            'messages' => $messages,
        ];
    }

    /**
     * Envoyer un message
     */
    public function envoyerMessage(NkapUser $user, int $conversationId, string $contenu, string $type = 'texte'): array
    {
        $conversation = NkapConversation::find($conversationId);

        if (!$conversation) {
            return [
                'success' => false,
                'message' => 'Conversation introuvable',
            ];
        }

        if ($conversation->participant1_id !== $user->id && $conversation->participant2_id !== $user->id) {
            return [
                'success' => false,
                'message' => 'Accès non autorisé',
            ];
        }

        $destinataireId = $conversation->participant1_id === $user->id 
            ? $conversation->participant2_id 
            : $conversation->participant1_id;

        $message = NkapMessage::create([
            'expediteur_id' => $user->id,
            'destinataire_id' => $destinataireId,
            'conversation_id' => $conversationId,
            'contenu' => $contenu,
            'type' => $type,
        ]);

        $conversation->dernier_message_at = now();
        $conversation->save();

        

        return [
            'success' => true,
            'message' => $message,
        ];
    }

    /**
     * Démarrer une nouvelle conversation
     */
    public function demarrerConversation(NkapUser $user, int $autreUserId, string $premierMessage): array
    {
        if ($user->id === $autreUserId) {
            return [
                'success' => false,
                'message' => 'Vous ne pouvez pas vous envoyer un message',
            ];
        }

        $autreUser = NkapUser::find($autreUserId);
        if (!$autreUser) {
            return [
                'success' => false,
                'message' => 'Utilisateur introuvable',
            ];
        }

        $conversation = NkapConversation::trouverOuCreer($user->id, $autreUserId);

        $message = NkapMessage::create([
            'expediteur_id' => $user->id,
            'destinataire_id' => $autreUserId,
            'conversation_id' => $conversation->id,
            'contenu' => $premierMessage,
            'type' => 'texte',
        ]);

        $conversation->dernier_message_at = now();
        $conversation->save();

        

        return [
            'success' => true,
            'conversation_id' => $conversation->id,
            'message' => $message,
        ];
    }

    /**
     * Nombre de messages non lus
     */
    public function nombreNonLus(NkapUser $user): int
    {
        return NkapMessage::where('destinataire_id', $user->id)
            ->where('lu', false)
            ->count();
    }
}
