@extends('layouts.admin')

@section('title', 'Gestion des Conversations')

@section('admin-content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-comments text-blue-600 mr-2"></i>
                Conversations
            </h1>
            <p class="text-gray-500 mt-1">Gérer les conversations entre utilisateurs Nkap D</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                {{ $conversations->total() }} conversation(s)
            </span>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <form method="GET" action="{{ route('admin.nkap.conversations.index') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Rechercher par nom, prénom, téléphone..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
            <div>
                <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Tous les types</option>
                    <option value="prive" {{ request('type') === 'prive' ? 'selected' : '' }}>Privé</option>
                    <option value="groupe" {{ request('type') === 'groupe' ? 'selected' : '' }}>Groupe</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-filter mr-1"></i> Filtrer
                </button>
                <a href="{{ route('admin.nkap.conversations.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                    <i class="fas fa-times mr-1"></i> Réinitialiser
                </a>
            </div>
        </form>
    </div>

    <!-- Tableau -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Participant 1</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Participant 2</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Messages</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dernier message</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($conversations as $conversation)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-gray-900">#{{ $conversation->id }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-blue-600 text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $conversation->participant1->prenom ?? 'N/A' }} {{ $conversation->participant1->nom ?? '' }}
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $conversation->participant1->telephone ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-green-600 text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $conversation->participant2->prenom ?? 'N/A' }} {{ $conversation->participant2->nom ?? '' }}
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $conversation->participant2->telephone ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $conversation->type === 'prive' ? 'bg-purple-100 text-purple-800' : 'bg-orange-100 text-orange-800' }}">
                                {{ ucfirst($conversation->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-sm">
                                {{ $conversation->messages_count }} message(s)
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-500">
                                {{ $conversation->dernier_message_at ? $conversation->dernier_message_at->diffForHumans() : 'Jamais' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.nkap.conversations.show', $conversation->id) }}" 
                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button type="button" onclick="confirmDelete({{ $conversation->id }})"
                                    class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <form id="delete-form-{{ $conversation->id }}" action="{{ route('admin.nkap.conversations.destroy', $conversation->id) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-comments text-gray-300 text-5xl mb-4"></i>
                                <p class="text-gray-500 text-lg">Aucune conversation trouvée</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($conversations->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $conversations->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Êtes-vous sûr ?',
        text: "Cette action supprimera la conversation et tous ses messages. Cette action est irréversible !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Oui, supprimer',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
@endsection
