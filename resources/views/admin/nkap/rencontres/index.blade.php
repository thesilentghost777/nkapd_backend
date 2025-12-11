@extends('layouts.admin')

@section('title', 'Gestion des Annonces Rencontre')

@section('admin-content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-heart text-pink-600 mr-2"></i>
                Annonces Rencontre
            </h1>
            <p class="text-gray-500 mt-1">Gérer les annonces de rencontre des utilisateurs Nkap D</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1 bg-pink-100 text-pink-800 rounded-full text-sm font-medium">
                {{ $annonces->total() }} annonce(s)
            </span>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <form method="GET" action="{{ route('admin.nkap.rencontres.index') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Rechercher par titre, description, nom..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                </div>
            </div>
            <div>
                <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                    <option value="">Tous les types</option>
                    @foreach($types as $key => $label)
                    <option value="{{ $key }}" {{ request('type') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="statut" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                    <option value="">Tous les statuts</option>
                    <option value="actif" {{ request('statut') === 'actif' ? 'selected' : '' }}>Actif</option>
                    <option value="inactif" {{ request('statut') === 'inactif' ? 'selected' : '' }}>Inactif</option>
                    <option value="expire" {{ request('statut') === 'expire' ? 'selected' : '' }}>Expiré</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition-colors">
                    <i class="fas fa-filter mr-1"></i> Filtrer
                </button>
                <a href="{{ route('admin.nkap.rencontres.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($annonces as $annonce)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-gray-900">#{{ $annonce->id }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-pink-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-pink-600 text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $annonce->user->prenom ?? 'N/A' }} {{ $annonce->user->nom ?? '' }}
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $annonce->user->telephone ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-gray-900 max-w-xs truncate">{{ $annonce->titre }}</p>
                            @if($annonce->description)
                            <p class="text-xs text-gray-500 max-w-xs truncate">{{ Str::limit($annonce->description, 50) }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $typeColors = [
                                    'amoureuse' => 'bg-red-100 text-red-800',
                                    'partenaire_business' => 'bg-blue-100 text-blue-800',
                                    'autre' => 'bg-gray-100 text-gray-800',
                                ];
                                $typeIcons = [
                                    'amoureuse' => 'fa-heart',
                                    'partenaire_business' => 'fa-briefcase',
                                    'autre' => 'fa-users',
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $typeColors[$annonce->type] ?? 'bg-gray-100 text-gray-800' }}">
                                <i class="fas {{ $typeIcons[$annonce->type] ?? 'fa-question' }} mr-1"></i>
                                {{ $types[$annonce->type] ?? $annonce->type }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statutColors = [
                                    'actif' => 'bg-green-100 text-green-800',
                                    'inactif' => 'bg-yellow-100 text-yellow-800',
                                    'expire' => 'bg-red-100 text-red-800',
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statutColors[$annonce->statut] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($annonce->statut) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-500">{{ $annonce->created_at->format('d/m/Y H:i') }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.nkap.rencontres.show', $annonce->id) }}" 
                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.nkap.rencontres.toggle-statut', $annonce->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                        class="p-2 {{ $annonce->statut === 'actif' ? 'text-yellow-600 hover:bg-yellow-50' : 'text-green-600 hover:bg-green-50' }} rounded-lg transition-colors"
                                        title="{{ $annonce->statut === 'actif' ? 'Désactiver' : 'Activer' }}">
                                        <i class="fas {{ $annonce->statut === 'actif' ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                    </button>
                                </form>
                                <button type="button" onclick="confirmDelete({{ $annonce->id }})"
                                    class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <form id="delete-form-{{ $annonce->id }}" action="{{ route('admin.nkap.rencontres.destroy', $annonce->id) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-heart-broken text-gray-300 text-5xl mb-4"></i>
                                <p class="text-gray-500 text-lg">Aucune annonce rencontre trouvée</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($annonces->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $annonces->withQueryString()->links() }}
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
        text: "Cette action supprimera l'annonce de rencontre. Cette action est irréversible !",
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
