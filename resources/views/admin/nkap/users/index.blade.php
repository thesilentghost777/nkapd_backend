@extends('layouts.admin')

@section('title', 'Utilisateurs NKAP')

@section('admin-content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Utilisateurs</h1>
            <p class="text-gray-500 mt-1">Gérez les utilisateurs de la plateforme NKAP</p>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl p-5 text-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <p class="text-emerald-100 text-sm">Total</p>
                    <p class="text-2xl font-bold">{{ number_format($stats['total']) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-green-500 to-teal-600 rounded-2xl p-5 text-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-check"></i>
                </div>
                <div>
                    <p class="text-green-100 text-sm">Actifs</p>
                    <p class="text-2xl font-bold">{{ number_format($stats['actifs']) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl p-5 text-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div>
                    <p class="text-purple-100 text-sm">Admins</p>
                    <p class="text-2xl font-bold">{{ number_format($stats['admins']) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl p-5 text-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-wallet"></i>
                </div>
                <div>
                    <p class="text-amber-100 text-sm">Solde Total</p>
                    <p class="text-xl font-bold">{{ number_format($stats['solde_total']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <form action="{{ route('admin.nkap.users.index') }}" method="GET" class="grid md:grid-cols-4 gap-4">
            <div class="md:col-span-2">
                <div class="relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Rechercher par nom, email, téléphone..."
                        class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    >
                </div>
            </div>
            <div>
                <select name="statut" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">Tous les statuts</option>
                    <option value="actif" {{ request('statut') == 'actif' ? 'selected' : '' }}>Actifs</option>
                    <option value="inactif" {{ request('statut') == 'inactif' ? 'selected' : '' }}>Inactifs</option>
                </select>
            </div>
            <div>
                <select name="role" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">Tous les rôles</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrateurs</option>
                    <option value="founder" {{ request('role') == 'founder' ? 'selected' : '' }}>Fondateurs</option>
                </select>
            </div>
            <div class="md:col-span-4 flex gap-3">
                <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-2 rounded-xl font-medium transition-colors">
                    <i class="fas fa-filter mr-2"></i>Filtrer
                </button>
                <a href="{{ route('admin.nkap.users.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-xl font-medium transition-colors">
                    <i class="fas fa-times mr-2"></i>Réinitialiser
                </a>
            </div>
        </form>
    </div>

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-xl flex items-center gap-3">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl flex items-center gap-3">
        <i class="fas fa-exclamation-circle"></i>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    <!-- Tableau -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Utilisateur</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Solde</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Activité</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-green-500 rounded-xl flex items-center justify-center text-white font-bold text-lg">
                                    {{ strtoupper(substr($user->prenom ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $user->prenom }} {{ $user->nom }}</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-xs text-gray-500">{{ $user->code_parrainage }}</span>
                                        @if($user->is_founder)
                                        <span class="bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full text-xs font-medium">
                                            <i class="fas fa-crown mr-1"></i>Fondateur
                                        </span>
                                        @endif
                                        @if($user->is_admin)
                                        <span class="bg-purple-100 text-purple-700 px-2 py-0.5 rounded-full text-xs font-medium">
                                            <i class="fas fa-shield-alt mr-1"></i>Admin
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-gray-900">{{ $user->email }}</p>
                            <p class="text-gray-500 text-sm">{{ $user->telephone }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-900">{{ number_format($user->solde) }} FCFA</p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4 text-sm">
                                <div class="text-center">
                                    <p class="font-medium text-gray-900">{{ $user->tontines_creees_count ?? 0 }}</p>
                                    <p class="text-gray-500 text-xs">Tontines</p>
                                </div>
                                <div class="text-center">
                                    <p class="font-medium text-gray-900">{{ $user->transactions_count ?? 0 }}</p>
                                    <p class="text-gray-500 text-xs">Trans.</p>
                                </div>
                                <div class="text-center">
                                    <p class="font-medium text-gray-900">{{ $user->filleuls->count() ?? 0 }}</p>
                                    <p class="text-gray-500 text-xs">Filleuls</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($user->is_active)
                            <span class="inline-flex items-center gap-1 bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-sm font-medium">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                                Actif
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-medium">
                                <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                Inactif
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.nkap.users.show', $user->id) }}" class="w-9 h-9 bg-emerald-100 hover:bg-emerald-200 text-emerald-600 rounded-lg flex items-center justify-center transition-colors" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.nkap.users.transactions', $user->id) }}" class="w-9 h-9 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg flex items-center justify-center transition-colors" title="Transactions">
                                    <i class="fas fa-exchange-alt"></i>
                                </a>
                                <form action="{{ route('admin.nkap.users.toggle-status', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-9 h-9 {{ $user->is_active ? 'bg-orange-100 hover:bg-orange-200 text-orange-600' : 'bg-green-100 hover:bg-green-200 text-green-600' }} rounded-lg flex items-center justify-center transition-colors" title="{{ $user->is_active ? 'Désactiver' : 'Activer' }}">
                                        <i class="fas {{ $user->is_active ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.nkap.users.toggle-admin', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-9 h-9 {{ $user->is_admin ? 'bg-purple-100 hover:bg-purple-200 text-purple-600' : 'bg-gray-100 hover:bg-gray-200 text-gray-600' }} rounded-lg flex items-center justify-center transition-colors" title="{{ $user->is_admin ? 'Retirer admin' : 'Rendre admin' }}">
                                        <i class="fas fa-user-shield"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-3 text-gray-500">
                                <i class="fas fa-users text-5xl text-gray-300"></i>
                                <p class="text-lg font-medium">Aucun utilisateur trouvé</p>
                                <p class="text-sm">Modifiez vos critères de recherche</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $users->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
