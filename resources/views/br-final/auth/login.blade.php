@extends('br-final.layouts.guest')
@section('title', 'Connexion')
@section('content')
<div class="glass rounded-3xl p-8">
    <div class="text-center mb-8">
        <div class="w-14 h-14 rounded-2xl btn-primary flex items-center justify-center text-white font-bold text-2xl mx-auto mb-4">B</div>
        <h1 class="text-2xl font-800 text-white" style="font-family:Syne,sans-serif">Bon retour !</h1>
        <p class="text-gray-500 text-sm mt-1">Connectez-vous à votre espace Business Room</p>
    </div>

    <form action="{{ route('br.login') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs text-gray-400 mb-1.5 font-medium">Numéro de téléphone</label>
            <input type="text" name="telephone" value="{{ old('telephone') }}" placeholder="6XXXXXXXX" required
                class="input w-full px-4 py-3 text-sm placeholder-gray-600">
            @error('telephone')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-xs text-gray-400 mb-1.5 font-medium">Mot de passe</label>
            <input type="password" name="password" placeholder="••••••••" required
                class="input w-full px-4 py-3 text-sm">
            @error('password')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="flex items-center gap-2">
            <input type="checkbox" name="remember" id="remember" class="rounded">
            <label for="remember" class="text-xs text-gray-500">Se souvenir de moi</label>
        </div>
        <button type="submit" class="btn-primary w-full py-3.5 rounded-xl text-sm">Connexion →</button>
    </form>

    <p class="text-center text-sm text-gray-600 mt-6">
        Pas encore membre ?
        <a href="{{ route('br.register') }}" class="text-orange-400 hover:underline">Rejoindre Business Room</a>
    </p>
</div>
@endsection