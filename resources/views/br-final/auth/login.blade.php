@extends('br-final.layouts.guest')
@section('title', 'Connexion')
@section('content')
<div style="text-align:center;margin-bottom:32px">
    <a href="{{ route('br.portail') }}" 
   style="font-size:13px;color:#888;display:inline-block;margin-bottom:10px;padding-top:8px">
   ← Retour
</a>
    <div style="width:60px;height:60px;background:#c2601a;border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px auto">
            <span style="color:white;font-size:28px;font-weight:bold">B</span>
        </div>
    <p style="font-size:14px;color:#999;margin-top:0">Accédez à votre espace Business Room</p>
</div>

<div style="background:white;border-radius:24px;padding:36px 32px;box-shadow:0 2px 12px rgba(0,0,0,0.04);border:1px solid #efede8">
    <form action="{{ route('br.login') }}" method="POST">
        @csrf
        
        <div style="margin-bottom:22px">
            <label style="display:block;font-size:13px;color:#555;margin-bottom:8px;font-weight:500">Numéro de téléphone</label>
            <input type="text" name="telephone" value="{{ old('telephone') }}" placeholder="6 12 34 56 78" required
                style="width:100%;background:#fafaf8;border:1px solid #e5e2dc;border-radius:14px;padding:14px 16px;font-size:14px;color:#1a1a1a;transition:all 0.2s;outline:none;font-family:'DM Sans',sans-serif">
            @error('telephone')<p style="color:#e74c3c;font-size:12px;margin-top:8px">{{ $message }}</p>@enderror
        </div>

        <div style="margin-bottom:24px">
            <label style="display:block;font-size:13px;color:#555;margin-bottom:8px;font-weight:500">Mot de passe</label>
            <input type="password" name="password" placeholder="••••••••" required
                style="width:100%;background:#fafaf8;border:1px solid #e5e2dc;border-radius:14px;padding:14px 16px;font-size:14px;color:#1a1a1a;transition:all 0.2s;outline:none;font-family:'DM Sans',sans-serif">
            @error('password')<p style="color:#e74c3c;font-size:12px;margin-top:8px">{{ $message }}</p>@enderror
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:30px">
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                <input type="checkbox" name="remember" style="width:16px;height:16px;margin:0;accent-color:#c2601a;cursor:pointer">
                <span style="font-size:13px;color:#888">Se souvenir de moi</span>
            </label>
            <a href="#" style="font-size:13px;color:#c2601a;text-decoration:none;font-weight:500">Mot de passe oublié ?</a>
        </div>

        <button type="submit" style="background:#c2601a;color:white;border:none;border-radius:14px;padding:15px;font-size:15px;font-weight:700;font-family:'Syne',sans-serif;cursor:pointer;width:100%;transition:all 0.2s;letter-spacing:0.3px">Se connecter →</button>
    </form>

    <div style="margin-top:32px;padding-top:28px;border-top:1px solid #efede8;text-align:center">
        <p style="font-size:14px;color:#888;margin:0">
            Nouveau sur Business Room ?
            <a href="{{ route('br.register') }}" style="color:#c2601a;text-decoration:none;font-weight:600;margin-left:4px">Créer un compte</a>
        </p>
    </div>
</div>

<style>
    input:focus {
        border-color: #c2601a !important;
        background: white !important;
        box-shadow: 0 0 0 3px rgba(194,96,26,0.08);
    }
    
    button:hover {
        background: #a04e12 !important;
        transform: translateY(-1px);
        box-shadow: 0 6px 14px rgba(194,96,26,0.25);
    }
</style>
@endsection