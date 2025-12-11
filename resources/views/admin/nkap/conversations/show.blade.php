@extends('layouts.admin')

@section('title', 'Détails de la Conversation')

@section('admin-content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('admin.nkap.conversations.index') }}" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-comments text-blue-600 mr-2"></i>
                    Conversation #{{ $conversation->id }}
                </h1>
            </div>
            <p class="text-gray-500">Détails et messages de la conversation</p>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" onclick="confirmDeleteConversation()"
                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                <i class="fas fa-trash mr-1"></i> Supprimer la conversation
            </button>
        </div>
    </div>

    <!-- Infos participants -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Participant 1 -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-blue-600 text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">
                        {{ $conversation->participant1->prenom ?? 'N/A' }} {{ $conversation->participant1->nom ?? '' }}
                    </h3>
                    <p class="text-gray-500">{{ $conversation->participant1->telephone ?? 'N/A' }}</p>
                    <p class="text-sm text-gray-400">{{ $conversation->participant1->email ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Participant 2 -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-green-600 text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">
                        {{ $conversation->participant2->prenom ?? 'N/A' }} {{ $conversation->participant2->nom ?? '' }}
                    </h3>
                    <p class="text-gray-500">{{ $conversation->participant2->telephone ?? 'N/A' }}</p>
                    <p class="text-sm text-gray-400">{{ $conversation->participant2->email ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
            <p class="text-2xl font-bold text-blue-600">{{ $conversation->messages_count }}</p>
            <p class="text-gray-500 text-sm">Messages</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
            <p class="text-2xl font-bold text-purple-600">{{ ucfirst($conversation->type) }}</p>
            <p class="text-gray-500 text-sm">Type</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
            <p class="text-2xl font-bold text-green-600">{{ $conversation->created_at->format('d/m/Y') }}</p>
            <p class="text-gray-500 text-sm">Créée le</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
            <p class="text-2xl font-bold text-orange-600">{{ $conversation->dernier_message_at ? $conversation->dernier_message_at->diffForHumans() : 'N/A' }}</p>
            <p class="text-gray-500 text-sm">Dernier message</p>
        </div>
    </div>

    <!-- Liste des messages -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-envelope text-blue-600 mr-2"></i>
                Messages ({{ $messages->total() }})
            </h2>
        </div>
        
        <div class="p-6 space-y-4 max-h-[600px] overflow-y-auto">
            @forelse($messages as $message)
            <div class="flex {{ $message->expediteur_id === $conversation->participant1_id ? 'justify-start' : 'justify-end' }}">
                <div class="max-w-[70%] {{ $message->expediteur_id === $conversation->participant1_id ? 'bg-blue-50 border-blue-200' : 'bg-green-50 border-green-200' }} rounded-xl p-4 border relative group">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-xs font-medium {{ $message->expediteur_id === $conversation->participant1_id ? 'text-blue-700' : 'text-green-700' }}">
                            {{ $message->expediteur->prenom ?? 'N/A' }} {{ $message->expediteur->nom ?? '' }}
                        </span>
                        <span class="text-xs text-gray-400">
                            {{ $message->created_at->format('d/m/Y H:i') }}
                        </span>
                        @if($message->lu)
                        <span class="text-xs text-gray-400" title="Lu le {{ $message->date_lecture?->format('d/m/Y H:i') }}">
                            <i class="fas fa-check-double text-blue-500"></i>
                        </span>
                        @endif
                    </div>
                    
                    <p class="text-gray-800">{{ $message->contenu }}</p>
                    
                    @if($message->type !== 'texte')
                    <span class="inline-block mt-2 px-2 py-1 bg-gray-200 text-gray-600 text-xs rounded">
                        <i class="fas fa-{{ $message->type === 'image' ? 'image' : 'file' }} mr-1"></i>
                        {{ ucfirst($message->type) }}
                    </span>
                    @endif

                    <!-- Bouton supprimer -->
                    <button type="button" onclick="confirmDeleteMessage({{ $conversation->id }}, {{ $message->id }})"
                        class="absolute top-2 right-2 p-1 text-red-500 hover:bg-red-100 rounded opacity-0 group-hover:opacity-100 transition-opacity"
                        title="Supprimer ce message">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
            </div>
            @empty
            <div class="text-center py-12">
                <i class="fas fa-inbox text-gray-300 text-5xl mb-4"></i>
                <p class="text-gray-500">Aucun message dans cette conversation</p>
            </div>
            @endforelse
        </div>

        @if($messages->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $messages->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Formulaire suppression conversation -->
<form id="delete-conversation-form" action="{{ route('admin.nkap.conversations.destroy', $conversation->id) }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDeleteConversation() {
    Swal.fire({
        title: 'Supprimer la conversation ?',
        text: "Cette action supprimera la conversation et tous ses messages. Cette action est irréversible !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Oui, supprimer',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-conversation-form').submit();
        }
    });
}

function confirmDeleteMessage(conversationId, messageId) {
    Swal.fire({
        title: 'Supprimer ce message ?',
        text: "Cette action est irréversible.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Supprimer',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            // Créer et soumettre le formulaire
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/nkap/conversations/${conversationId}/messages/${messageId}`;
            form.innerHTML = `@csrf @method('DELETE')`;
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endsection
