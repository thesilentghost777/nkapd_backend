@extends('br-final.layouts.admin')
@section('title', 'Membres')
@section('content')
<div class="p-6 lg:p-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 gap-4">
        <h1 class="text-3xl font-800 text-white" style="font-family:Syne,sans-serif">Membres</h1>
        <span class="text-gray-500 text-sm">{{ $membres->total() }} membres</span>
    </div>

    <!-- Filtres -->
    <form method="GET" class="card p-4 mb-6 flex flex-col sm:flex-row gap-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher nom, prénom, téléphone..."
            class="flex-1 bg-gray-900 border border-gray-800 text-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 placeholder-gray-600">
        <select name="statut" class="bg-gray-900 border border-gray-800 text-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500">
            <option value="">Tous les statuts</option>
            <option value="en_attente" {{ request('statut')==='en_attente'?'selected':'' }}>En attente</option>
            <option value="membre" {{ request('statut')==='membre'?'selected':'' }}>Actif</option>
            <option value="suspendu" {{ request('statut')==='suspendu'?'selected':'' }}>Suspendu</option>
        </select>
        <button class="btn-admin px-6 py-2.5 rounded-xl text-sm">Filtrer</button>
        <a href="{{ route('br.admin.membres') }}" class="px-5 py-2.5 text-sm text-gray-500 hover:text-white transition">Reset</a>
    </form>

    <!-- Tableau -->
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead><tr>
                    <th class="text-left px-5 py-4">Membre</th>
                    <th class="text-left px-5 py-4">Téléphone</th>
                    <th class="text-left px-5 py-4">Filleuls</th>
                    <th class="text-left px-5 py-4">Statut</th>
                    <th class="text-left px-5 py-4">Adhésion</th>
                    <th class="text-left px-5 py-4">Inscrit le</th>
                    <th class="text-right px-5 py-4">Actions</th>
                </tr></thead>
                <tbody>
                    @forelse($membres as $m)
                    <tr>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-red-500/20 flex items-center justify-center text-red-400 text-xs font-bold flex-shrink-0">{{ substr($m->prenom, 0, 1) }}</div>
                                <div>
                                    <p class="text-white font-medium">{{ $m->nom_complet }}</p>
                                    <p class="text-gray-600 text-xs">{{ $m->email ?? '—' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-gray-400 font-mono text-xs">{{ $m->telephone }}</td>
                        <td class="px-5 py-4">
                            <span class="text-white font-bold">{{ $m->filleuls_count }}</span>
                        </td>
                        <td class="px-5 py-4">
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium
                                {{ $m->statut === 'membre' ? 'bg-green-500/15 text-green-400' : '' }}
                                {{ $m->statut === 'en_attente' ? 'bg-yellow-500/15 text-yellow-400' : '' }}
                                {{ $m->statut === 'suspendu' ? 'bg-red-500/15 text-red-400' : '' }}">
                                {{ ucfirst($m->statut) }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            @if($m->adhesion_payee)
                                <span class="text-green-400 text-xs">✓ Payée</span>
                            @else
                                <span class="text-gray-600 text-xs">Non payée</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-gray-500 text-xs">{{ $m->created_at->format('d/m/Y') }}</td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('br.admin.membre.show', $m) }}" class="text-xs text-gray-400 hover:text-white px-3 py-1.5 rounded-lg border border-gray-800 hover:border-gray-600 transition">Voir</a>
                                <form action="{{ route('br.admin.membre.toggle', $m) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="text-xs px-3 py-1.5 rounded-lg border transition {{ $m->statut === 'suspendu' ? 'border-green-500/30 text-green-400 hover:border-green-500' : 'border-red-500/30 text-red-400 hover:border-red-500' }}">
                                        {{ $m->statut === 'suspendu' ? 'Réactiver' : 'Suspendre' }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-5 py-12 text-center text-gray-600">Aucun membre trouvé</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($membres->hasPages())
            <div class="px-5 py-4 border-t border-gray-800">{{ $membres->links() }}</div>
        @endif
    </div>
</div>
@endsection