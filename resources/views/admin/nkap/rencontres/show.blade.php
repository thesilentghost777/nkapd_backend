@extends('layouts.admin')

@section('title', 'Détails de l\'Annonce Rencontre')

@section('admin-content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('admin.nkap.rencontres.index') }}" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-heart text-pink-600 mr-2"></i>
                    Annonce #{{ $annonce->id }}
                </h1>
            </div>
            <p class="text-gray-500">Détails de l'annonce de rencontre</p>
        </div>
        <div class="flex items-center gap-2">
            <form action="{{ route('admin.nkap.rencontres.toggle-statut', $annonce->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" 
                    class="px-4 py-2 {{ $annonce->statut === 'actif' ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} text-white rounded-lg transition-colors">
                    <i class="fas {{ $annonce->statut === 'actif' ? 'fa-toggle-off' : 'fa-toggle-on' }} mr-1"></i>
                    {{ $annonce->statut === 'actif' ? 'Désactiver' : 'Activer' }}
                </button>
            </form>
            <button type="button" onclick="confirmDelete()"
                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                <i class="fas fa-trash mr-1"></i> Supprimer
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Infos principales -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Titre et description -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
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
                        <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full {{ $typeColors[$annonce->type] ?? 'bg-gray-100 text-gray-800' }} mb-2">
                            <i class="fas {{ $typeIcons[$annonce->type] ?? 'fa-question' }} mr-1"></i>
                            {{ $types[$annonce->type] ?? $annonce->type }}
                        </span>
                        <h2 class="text-xl font-bold text-gray-800">{{ $annonce->titre }}</h2>
                    </div>
                    @php
                        $statutColors = [
                            'actif' => 'bg-green-100 text-green-800 border-green-300',
                            'inactif' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                            'expire' => 'bg-red-100 text-red-800 border-red-300',
                        ];
                    @endphp
                    <span class="px-3 py-1 text-sm font-medium rounded-full border {{ $statutColors[$annonce->statut] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst($annonce->statut) }}
                    </span>
                </div>

                @if($annonce->description)
                <div class="prose max-w-none">
                    <h3 class="text-sm font-medium text-gray-500 uppercase mb-2">Description</h3>
                    <p class="text-gray-700 whitespace-pre-line">{{ $annonce->description }}</p>
                </div>
                @else
                <p class="text-gray-400 italic">Aucune description fournie</p>
                @endif
            </div>

            <!-- Préférences -->
            @if($annonce->preferences && count($annonce->preferences) > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-sliders-h text-pink-600 mr-2"></i>
                    Préférences
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($annonce->preferences as $key => $value)
                    <div class="flex items-center gap-2 p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-500 font-medium">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                        <span class="text-gray-800">
                            @if(is_array($value))
                                {{ implode(', ', $value) }}
                            @elseif(is_bool($value))
                                {{ $value ? 'Oui' : 'Non' }}
                            @else
                                {{ $value }}
                            @endif
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Infos utilisateur -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-user text-pink-600 mr-2"></i>
                    Auteur de l'annonce
                </h3>
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-pink-600 text-2xl"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-800">
                            {{ $annonce->user->prenom ?? 'N/A' }} {{ $annonce->user->nom ?? '' }}
                        </h4>
                        <p class="text-gray-500">{{ $annonce->user->telephone ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-500">Email</span>
                        <span class="text-gray-800">{{ $annonce->user->email ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-500">Ville</span>
                        <span class="text-gray-800">{{ $annonce->user->ville ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-gray-500">Inscrit le</span>
                        <span class="text-gray-800">{{ $annonce->user->created_at?->format('d/m/Y') ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <!-- Métadonnées -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-info-circle text-pink-600 mr-2"></i>
                    Informations
                </h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-500">ID Annonce</span>
                        <span class="font-mono text-gray-800">#{{ $annonce->id }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-500">Créée le</span>
                        <span class="text-gray-800">{{ $annonce->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-gray-500">Modifiée le</span>
                        <span class="text-gray-800">{{ $annonce->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Formulaire suppression -->
<form id="delete-form" action="{{ route('admin.nkap.rencontres.destroy', $annonce->id) }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete() {
    Swal.fire({
        title: 'Supprimer cette annonce ?',
        text: "Cette action est irréversible !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Oui, supprimer',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form').submit();
        }
    });
}
</script>
@endsection
