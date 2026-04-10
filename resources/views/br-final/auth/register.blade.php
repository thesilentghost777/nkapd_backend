@extends('br-final.layouts.guest')
@section('title', 'Inscription')
@section('content')
<div class="glass rounded-3xl p-8">
    <div class="text-center mb-8">
        <div class="w-14 h-14 rounded-2xl btn-primary flex items-center justify-center text-white font-bold text-2xl mx-auto mb-4">B</div>
        <h1 class="text-2xl font-800 text-white" style="font-family:Syne,sans-serif">Rejoindre la communauté</h1>
        <p class="text-gray-500 text-sm mt-1">Créez votre compte Business Room gratuitement</p>
    </div>

    <form action="{{ route('br.register') }}" method="POST" class="space-y-4">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs text-gray-400 mb-1.5 font-medium">Nom</label>
                <input type="text" name="nom" value="{{ old('nom') }}" placeholder="KAMGA" required class="input w-full px-4 py-3 text-sm placeholder-gray-600">
                @error('nom')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs text-gray-400 mb-1.5 font-medium">Prénom</label>
                <input type="text" name="prenom" value="{{ old('prenom') }}" placeholder="Jean" required class="input w-full px-4 py-3 text-sm placeholder-gray-600">
                @error('prenom')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
        <div>
            <label class="block text-xs text-gray-400 mb-1.5 font-medium">Téléphone *</label>
            <input type="text" name="telephone" value="{{ old('telephone') }}" placeholder="6XXXXXXXX" required class="input w-full px-4 py-3 text-sm placeholder-gray-600">
            @error('telephone')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-xs text-gray-400 mb-1.5 font-medium">Email (optionnel)</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="jean@email.com" class="input w-full px-4 py-3 text-sm placeholder-gray-600">
        </div>
        <div>
            <label class="block text-xs text-gray-400 mb-1.5 font-medium">WhatsApp (optionnel)</label>
            <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="6XXXXXXXX" class="input w-full px-4 py-3 text-sm placeholder-gray-600">
        </div>
        <div>
            <label class="block text-xs text-gray-400 mb-1.5 font-medium">Code parrain (optionnel)</label>
            <input type="text" name="code_parrain" value="{{ old('code_parrain', request('parrain')) }}" placeholder="Téléphone du parrain" class="input w-full px-4 py-3 text-sm placeholder-gray-600">
        </div>
        <div>
            <label class="block text-xs text-gray-400 mb-1.5 font-medium">Mot de passe</label>
            <input type="password" name="password" placeholder="Minimum 6 caractères" required class="input w-full px-4 py-3 text-sm">
            @error('password')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-xs text-gray-400 mb-1.5 font-medium">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" placeholder="••••••••" required class="input w-full px-4 py-3 text-sm">
        </div>
        <button type="submit" class="btn-primary w-full py-3.5 rounded-xl text-sm">Créer mon compte →</button>
    </form>

    <p class="text-center text-sm text-gray-600 mt-6">
        Déjà membre ?
        <a href="{{ route('br.login') }}" class="text-orange-400 hover:underline">Se connecter</a>
    </p>
</div>
@endsection