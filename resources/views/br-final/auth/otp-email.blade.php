@extends('br-final.layouts.guest')
@section('title', 'Connexion par email')
@section('content')

<div style="text-align:center;margin-bottom:32px">
    <a href="{{ route('br.login') }}"
       style="font-size:13px;color:#888;display:inline-block;margin-bottom:10px;padding-top:8px">
        ← Retour
    </a>
    <div style="width:60px;height:60px;background:#c2601a;border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px auto">
        <span style="color:white;font-size:28px;font-weight:bold">B</span>
    </div>
    <h1 style="font-family:Syne,sans-serif;font-size:22px;font-weight:700;margin-bottom:6px">Connexion par email</h1>
    <p style="font-size:13px;color:#999">Nous vous enverrons un code à 6 chiffres</p>
</div>

@if(session('error'))
    <div style="background:#fce8e8;border-radius:12px;padding:12px 16px;color:#c0302a;font-size:13px;margin-bottom:16px;text-align:center">
        {{ session('error') }}
    </div>
@endif

<div style="background:white;border-radius:24px;padding:36px 32px;box-shadow:0 2px 12px rgba(0,0,0,0.04);border:1px solid #efede8">
    <form action="{{ route('br.otp.envoyer') }}" method="POST" id="otpForm">
        @csrf

        {{-- Champs visibles uniquement pour les nouveaux comptes --}}
        <div id="nouveauCompte" style="display:none">
            <p style="font-size:12px;color:#9a4510;background:#fef0e6;border-radius:10px;padding:10px;margin-bottom:18px">
                📧 Cette adresse email n'existe pas encore. Renseignez votre prénom et nom pour créer votre compte.
            </p>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:18px">
                <div>
                    <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;font-weight:500">Prénom</label>
                    <input type="text" name="prenom" placeholder="Jean"
                           style="width:100%;background:#f5f4f0;border:none;border-radius:10px;padding:12px;font-size:13px;outline:none">
                </div>
                <div>
                    <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;font-weight:500">Nom</label>
                    <input type="text" name="nom" placeholder="KAMGA"
                           style="width:100%;background:#f5f4f0;border:none;border-radius:10px;padding:12px;font-size:13px;outline:none">
                </div>
            </div>
        </div>

        <div style="margin-bottom:24px">
            <label style="display:block;font-size:13px;color:#555;margin-bottom:8px;font-weight:500">Adresse email</label>
            <input type="email" name="email" id="emailInput" value="{{ old('email') }}" placeholder="vous@email.com" required
                   style="width:100%;background:#fafaf8;border:1.5px solid #e5e2dc;border-radius:14px;padding:14px 16px;font-size:14px;color:#1a1a1a;outline:none">
            @error('email')<p style="color:#e74c3c;font-size:12px;margin-top:6px">{{ $message }}</p>@enderror
        </div>

        <button type="submit" style="background:#c2601a;color:white;border:none;border-radius:14px;padding:15px;font-size:15px;font-weight:700;font-family:'Syne',sans-serif;cursor:pointer;width:100%">
            Recevoir le code →
        </button>
    </form>
</div>

<style>input:focus { border-color:#c2601a!important;box-shadow:0 0 0 3px rgba(194,96,26,0.08); }</style>
@endsection