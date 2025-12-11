@extends('layouts.admin')

@section('title', 'Configuration NKAP')

@section('admin-content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Configuration</h1>
            <p class="text-gray-500 mt-1">Gérez les paramètres de la plateforme NKAP</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="bg-emerald-100 text-emerald-700 px-4 py-2 rounded-xl text-sm font-medium">
                <i class="fas fa-cog mr-2"></i>Paramètres système
            </span>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-xl flex items-center gap-3" x-data="{ show: true }" x-show="show">
        <i class="fas fa-check-circle text-xl"></i>
        <span>{{ session('success') }}</span>
        <button @click="show = false" class="ml-auto text-emerald-500 hover:text-emerald-700">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl flex items-center gap-3" x-data="{ show: true }" x-show="show">
        <i class="fas fa-exclamation-circle text-xl"></i>
        <span>{{ session('error') }}</span>
        <button @click="show = false" class="ml-auto text-red-500 hover:text-red-700">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl">
        <div class="flex items-start gap-3">
            <i class="fas fa-exclamation-triangle text-xl"></i>
            <div>
                <p class="font-semibold mb-2">Erreurs de validation :</p>
                <ul class="list-disc list-inside space-y-1 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <form action="{{ route('admin.nkap.configurations.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('POST')

        <div class="grid lg:grid-cols-2 gap-6">
            <!-- Paramètres Financiers -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-500 to-green-600 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                        <i class="fas fa-money-bill-wave"></i>
                        Paramètres Financiers
                    </h2>
                </div>
                <div class="p-6 space-y-5">
                    @foreach(['frais_retrait_pourcentage', 'frais_transfert_pourcentage', 'solde_minimum_apres_retrait', 'bonus_parrainage', 'frais_mensuel'] as $cle)
                        @if(isset($configMap[$cle]))
                        <div>
                            <label for="{{ $cle }}" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $configMap[$cle]['label'] }}
                            </label>
                            <div class="relative">
                                <input 
                                    type="{{ $configMap[$cle]['type'] }}" 
                                    name="{{ $cle }}" 
                                    id="{{ $cle }}"
                                    value="{{ old($cle, $configurations[$cle]->getValeurBrute() ?? '') }}"
                                    @if(isset($configMap[$cle]['step'])) step="{{ $configMap[$cle]['step'] }}" @endif
                                    @if(isset($configMap[$cle]['min'])) min="{{ $configMap[$cle]['min'] }}" @endif
                                    @if(isset($configMap[$cle]['max'])) max="{{ $configMap[$cle]['max'] }}" @endif
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all @error($cle) border-red-300 @enderror"
                                    placeholder="{{ $configMap[$cle]['label'] }}"
                                >
                                @if(str_contains($cle, 'pourcentage'))
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i class="fas fa-percent"></i>
                                </div>
                                @elseif(str_contains($cle, 'montant') || str_contains($cle, 'bonus') || str_contains($cle, 'frais') || str_contains($cle, 'solde'))
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
                                    FCFA
                                </div>
                                @endif
                            </div>
                            <p class="mt-1 text-xs text-gray-500">{{ $configMap[$cle]['description'] }}</p>
                            @error($cle)
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Paramètres Tontines -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="bg-gradient-to-r from-teal-500 to-cyan-600 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                        <i class="fas fa-piggy-bank"></i>
                        Paramètres Tontines
                    </h2>
                </div>
                <div class="p-6 space-y-5">
                    @foreach(['max_tontines_en_cours', 'montant_min_tontine'] as $cle)
                        @if(isset($configMap[$cle]))
                        <div>
                            <label for="{{ $cle }}" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $configMap[$cle]['label'] }}
                            </label>
                            <div class="relative">
                                <input 
                                    type="{{ $configMap[$cle]['type'] }}" 
                                    name="{{ $cle }}" 
                                    id="{{ $cle }}"
                                    value="{{ old($cle, $configurations[$cle]->getValeurBrute() ?? '') }}"
                                    @if(isset($configMap[$cle]['min'])) min="{{ $configMap[$cle]['min'] }}" @endif
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all @error($cle) border-red-300 @enderror"
                                    placeholder="{{ $configMap[$cle]['label'] }}"
                                >
                                @if(str_contains($cle, 'montant'))
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
                                    FCFA
                                </div>
                                @endif
                            </div>
                            <p class="mt-1 text-xs text-gray-500">{{ $configMap[$cle]['description'] }}</p>
                            @error($cle)
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Paramètres Parrainage -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="bg-gradient-to-r from-amber-500 to-orange-600 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                        <i class="fas fa-user-plus"></i>
                        Paramètres Parrainage
                    </h2>
                </div>
                <div class="p-6 space-y-5">
                    @if(isset($configMap['code_parrainage_defaut']))
                    <div>
                        <label for="code_parrainage_defaut" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ $configMap['code_parrainage_defaut']['label'] }}
                        </label>
                        <input 
                            type="text" 
                            name="code_parrainage_defaut" 
                            id="code_parrainage_defaut"
                            value="{{ old('code_parrainage_defaut', $configurations['code_parrainage_defaut']->getValeurBrute() ?? '') }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all @error('code_parrainage_defaut') border-red-300 @enderror"
                            placeholder="Code parrainage par défaut"
                        >
                        <p class="mt-1 text-xs text-gray-500">{{ $configMap['code_parrainage_defaut']['description'] }}</p>
                        @error('code_parrainage_defaut')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    @endif
                </div>
            </div>

            <!-- Fondateur -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                        <i class="fas fa-crown"></i>
                        Fondateur de la Plateforme
                    </h2>
                </div>
                <div class="p-6">
                    @if(isset($configMap['fondateur_id']))
                    <div>
                        <label for="fondateur_id" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ $configMap['fondateur_id']['label'] }}
                        </label>
                        <select 
                            name="fondateur_id" 
                            id="fondateur_id"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all @error('fondateur_id') border-red-300 @enderror"
                        >
                            <option value="">-- Sélectionner un fondateur --</option>
                            @foreach($fondateurs as $fondateur)
                            <option value="{{ $fondateur->id }}" 
                                {{ old('fondateur_id', $configurations['fondateur_id']->getValeurBrute() ?? '') == $fondateur->id ? 'selected' : '' }}>
                                {{ $fondateur->prenom }} {{ $fondateur->nom }} ({{ $fondateur->email }})
                                @if($fondateur->is_founder) - Fondateur @endif
                                @if($fondateur->is_admin) - Admin @endif
                            </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500">{{ $configMap['fondateur_id']['description'] }}</p>
                        @error('fondateur_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Bouton Sauvegarder -->
        <div class="flex justify-end">
            <button type="submit" class="bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white px-8 py-3 rounded-xl font-semibold shadow-lg shadow-emerald-500/30 transition-all flex items-center gap-2">
                <i class="fas fa-save"></i>
                Enregistrer les modifications
            </button>
        </div>
    </form>

    <!-- Informations -->
    <div class="bg-gradient-to-r from-emerald-50 to-green-50 border border-emerald-200 rounded-2xl p-6">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-info-circle text-white text-xl"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-emerald-900 mb-2">À propos des configurations</h3>
                <p class="text-emerald-700 text-sm leading-relaxed">
                    Ces paramètres affectent le fonctionnement global de la plateforme NKAP. 
                    Les modifications sont appliquées immédiatement. Soyez prudent lors de la modification 
                    des frais et des montants car cela impacte directement les utilisateurs.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection