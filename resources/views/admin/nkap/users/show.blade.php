@extends('layouts.admin')

@section('title', 'Détails Utilisateur - ' . $user->prenom . ' ' . $user->nom)

@section('admin-content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.nkap.users.index') }}" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition-colors">
                <i class="fas fa-arrow-left text-gray-600"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $user->prenom }} {{ $user->nom }}</h1>
                <p class="text-gray-500 mt-1">Inscrit {{ $user->created_at->diffForHumans() }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <form action="{{ route('admin.nkap.users.toggle-status', $user->id) }}" method="POST" class="inline">
                @csrf
                @method('POST')
                <button type="submit" class="{{ $user->is_active ? 'bg-orange-500 hover:bg-orange-600' : 'bg-emerald-500 hover:bg-emerald-600' }} text-white px-4 py-2 rounded-xl font-medium transition-colors">
                    <i class="fas {{ $user->is_active ? 'fa-user-slash' : 'fa-user-check' }} mr-2"></i>
                    {{ $user->is_active ? 'Désactiver' : 'Activer' }}
                </button>
            </form>
            <form action="{{ route('admin.nkap.users.toggle-admin', $user->id) }}" method="POST" class="inline">
                @csrf
                @method('POST')
                <button type="submit" class="{{ $user->is_admin ? 'bg-red-500 hover:bg-red-600' : 'bg-purple-500 hover:bg-purple-600' }} text-white px-4 py-2 rounded-xl font-medium transition-colors">
                    <i class="fas fa-user-shield mr-2"></i>
                    {{ $user->is_admin ? 'Retirer Admin' : 'Rendre Admin' }}
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-xl flex items-center gap-3">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Profil -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-500 to-green-600 px-6 py-8 text-center">
                <div class="w-24 h-24 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <span class="text-4xl font-bold text-white">{{ strtoupper(substr($user->prenom, 0, 1)) }}{{ strtoupper(substr($user->nom, 0, 1)) }}</span>
                </div>
                <h2 class="text-xl font-bold text-white">{{ $user->prenom }} {{ $user->nom }}</h2>
                <div class="flex items-center justify-center gap-2 mt-2">
                    @if($user->is_founder)
                    <span class="bg-yellow-400/20 text-yellow-100 px-3 py-1 rounded-full text-sm font-medium">
                        <i class="fas fa-crown mr-1"></i>Fondateur
                    </span>
                    @endif
                    @if($user->is_admin)
                    <span class="bg-white/20 text-white px-3 py-1 rounded-full text-sm font-medium">
                        <i class="fas fa-shield-alt mr-1"></i>Admin
                    </span>
                    @endif
                </div>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                    <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-envelope text-emerald-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Email</p>
                        <p class="font-medium text-gray-900">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-phone text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Téléphone</p>
                        <p class="font-medium text-gray-900">{{ $user->telephone }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-tag text-purple-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Code Parrainage</p>
                        <p class="font-medium text-gray-900">{{ $user->code_parrainage }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user text-amber-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Parrain</p>
                        <p class="font-medium text-gray-900">
                            @if($user->parrain)
                            <a href="{{ route('admin.nkap.users.show', $user->parrain->id) }}" class="text-emerald-600 hover:underline">
                                {{ $user->parrain->prenom }} {{ $user->parrain->nom }}
                            </a>
                            @else
                            <span class="text-gray-400">Aucun parrain</span>
                            @endif
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 {{ $user->is_active ? 'bg-emerald-50' : 'bg-red-50' }} rounded-xl">
                    <div class="w-10 h-10 {{ $user->is_active ? 'bg-emerald-100' : 'bg-red-100' }} rounded-lg flex items-center justify-center">
                        <i class="fas {{ $user->is_active ? 'fa-check-circle text-emerald-600' : 'fa-times-circle text-red-600' }}"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Statut</p>
                        <p class="font-medium {{ $user->is_active ? 'text-emerald-700' : 'text-red-700' }}">
                            {{ $user->is_active ? 'Compte actif' : 'Compte inactif' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistiques et Activités -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Solde et Stats -->
            <div class="grid md:grid-cols-2 gap-4">
                <div class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-wallet text-2xl"></i>
                        </div>
                    </div>
                    <p class="text-emerald-100">Solde actuel</p>
                    <p class="text-3xl font-bold">{{ number_format($user->solde) }} FCFA</p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white rounded-2xl border border-gray-100 p-4 text-center">
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['filleuls_count'] }}</p>
                        <p class="text-gray-500 text-sm">Filleuls</p>
                    </div>
                    <div class="bg-white rounded-2xl border border-gray-100 p-4 text-center">
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['tontines_creees'] }}</p>
                        <p class="text-gray-500 text-sm">Tontines créées</p>
                    </div>
                    <div class="bg-white rounded-2xl border border-gray-100 p-4 text-center">
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['tontines_rejointes'] }}</p>
                        <p class="text-gray-500 text-sm">Tontines rejointes</p>
                    </div>
                    <div class="bg-white rounded-2xl border border-gray-100 p-4 text-center">
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['transactions_count'] }}</p>
                        <p class="text-gray-500 text-sm">Transactions</p>
                    </div>
                </div>
            </div>

            <!-- Résumé Financier -->
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Résumé Financier</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="flex items-center gap-4 p-4 bg-emerald-50 rounded-xl">
                        <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-arrow-down text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Recharges</p>
                            <p class="text-xl font-bold text-emerald-700">{{ number_format($stats['total_recharges']) }} FCFA</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 p-4 bg-red-50 rounded-xl">
                        <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-arrow-up text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Retraits</p>
                            <p class="text-xl font-bold text-red-700">{{ number_format($stats['total_retraits']) }} FCFA</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filleuls -->
            @if($user->filleuls->count() > 0)
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900">Filleuls ({{ $user->filleuls->count() }})</h3>
                </div>
                <div class="divide-y divide-gray-100 max-h-64 overflow-y-auto">
                    @foreach($user->filleuls as $filleul)
                    <div class="p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-green-500 rounded-lg flex items-center justify-center text-white font-bold">
                                    {{ strtoupper(substr($filleul->prenom ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $filleul->prenom }} {{ $filleul->nom }}</p>
                                    <p class="text-sm text-gray-500">{{ $filleul->email }}</p>
                                </div>
                            </div>
                            <a href="{{ route('admin.nkap.users.show', $filleul->id) }}" class="text-emerald-600 hover:text-emerald-700">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Transactions Récentes -->
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Transactions Récentes</h3>
                    <a href="{{ route('admin.nkap.users.transactions', $user->id) }}" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">
                        Voir tout <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($user->transactions->take(5) as $transaction)
                    <div class="p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center
                                    @if(in_array($transaction->type, ['recharge', 'transfert_recu', 'gain_tontine', 'bonus_parrainage'])) bg-emerald-100 text-emerald-600
                                    @else bg-red-100 text-red-600 @endif">
                                    <i class="fas fa-exchange-alt"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $transaction->type)) }}</p>
                                    <p class="text-sm text-gray-500">{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            <p class="font-semibold @if(in_array($transaction->type, ['recharge', 'transfert_recu', 'gain_tontine', 'bonus_parrainage'])) text-emerald-600 @else text-red-600 @endif">
                                {{ in_array($transaction->type, ['recharge', 'transfert_recu', 'gain_tontine', 'bonus_parrainage']) ? '+' : '-' }}{{ number_format($transaction->montant) }} FCFA
                            </p>
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-2"></i>
                        <p>Aucune transaction</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Zone Danger -->
    <div class="bg-red-50 border border-red-200 rounded-2xl p-6">
        <h3 class="text-lg font-semibold text-red-800 mb-4">
            <i class="fas fa-exclamation-triangle mr-2"></i>Zone Dangereuse
        </h3>
        <p class="text-red-700 mb-4">La suppression d'un utilisateur est irréversible. Cette action supprimera toutes les données associées.</p>
        <form action="{{ route('admin.nkap.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-xl font-medium transition-colors" {{ $user->solde > 0 ? 'disabled' : '' }}>
                <i class="fas fa-trash mr-2"></i>Supprimer l'utilisateur
            </button>
            @if($user->solde > 0)
            <p class="text-red-600 text-sm mt-2">Impossible de supprimer : l'utilisateur a un solde positif.</p>
            @endif
        </form>
    </div>
</div>
@endsection
