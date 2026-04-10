@extends('br-final.layouts.guest')
@section('title', 'Inscription')
@section('content')
<div class="p-4" style="max-width:500px;margin:0 auto">

<a href="{{ route('br.portail') }}" 
   style="font-size:13px;color:#888;display:inline-block;margin-bottom:10px;padding-top:8px">
   ← Retour
</a>
    <div class="mb-5 pt-2 text-center">
        <div style="width:60px;height:60px;background:#c2601a;border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px auto">
            <span style="color:white;font-size:28px;font-weight:bold">B</span>
        </div>
        <h1 style="font-family:Syne,sans-serif;font-size:24px;font-weight:700;margin-bottom:6px">Rejoindre la communauté</h1>
        <p style="font-size:13px;color:#888;margin-top:2px">Créez votre compte Business Room gratuitement</p>
    </div>

    <div class="card" style="padding:24px">
        <form action="{{ route('br.register') }}" method="POST" id="registerForm">
            @csrf
            
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:18px">
                <div>
                    <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;font-weight:500">Nom</label>
                    <input type="text" name="nom" value="{{ old('nom') }}" placeholder="KAMGA" required
                        style="width:100%;background:#f5f4f0;border:none;border-radius:10px;padding:12px;font-size:13px;outline:none">
                    @error('nom')<p style="color:#dc3545;font-size:11px;margin-top:6px">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;font-weight:500">Prénom</label>
                    <input type="text" name="prenom" value="{{ old('prenom') }}" placeholder="Jean" required
                        style="width:100%;background:#f5f4f0;border:none;border-radius:10px;padding:12px;font-size:13px;outline:none">
                    @error('prenom')<p style="color:#dc3545;font-size:11px;margin-top:6px">{{ $message }}</p>@enderror
                </div>
            </div>

            <div style="margin-bottom:18px">
                <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;font-weight:500">Téléphone <span style="color:#dc3545">*</span></label>
                <input type="tel" name="telephone" value="{{ old('telephone') }}" placeholder="6XXXXXXXX" required
                    style="width:100%;background:#f5f4f0;border:none;border-radius:10px;padding:12px;font-size:13px;outline:none">
                @error('telephone')<p style="color:#dc3545;font-size:11px;margin-top:6px">{{ $message }}</p>@enderror
                <p style="font-size:10px;color:#aaa;margin-top:4px">Format : 6XXXXXXXX (9 chiffres)</p>
            </div>

            <div style="margin-bottom:18px">
                <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;font-weight:500">Email <span style="color:#aaa">(optionnel)</span></label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="jean@email.com"
                    style="width:100%;background:#f5f4f0;border:none;border-radius:10px;padding:12px;font-size:13px;outline:none">
            </div>

            <div style="margin-bottom:18px">
                <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;font-weight:500">WhatsApp <span style="color:#aaa">(optionnel)</span></label>
                <input type="tel" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="6XXXXXXXX"
                    style="width:100%;background:#f5f4f0;border:none;border-radius:10px;padding:12px;font-size:13px;outline:none">
            </div>

            <div style="margin-bottom:12px">
                <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;font-weight:500">Code parrain <span style="color:#dc3545">*</span></label>
                <input type="text" name="code_parrain" id="code_parrain" value="{{ old('code_parrain', request('parrain')) }}" placeholder="Téléphone du parrain" required
                    style="width:100%;background:#f5f4f0;border:none;border-radius:10px;padding:12px;font-size:13px;outline:none">
                @error('code_parrain')<p style="color:#dc3545;font-size:11px;margin-top:6px">{{ $message }}</p>@enderror
                <p style="font-size:10px;color:#aaa;margin-top:4px">Entrez le numéro de téléphone de votre parrain (obligatoire)</p>
            </div>

            <!-- Bouton "Je n'ai pas de code" -->
            <div style="margin-bottom:18px;text-align:center">
                <button type="button" id="noCodeBtn" style="background:none;border:none;color:#c2601a;font-size:12px;cursor:pointer;text-decoration:underline;padding:8px">
                    Je n'ai pas de code de parrainage ?
                </button>
            </div>

            <div style="margin-bottom:18px">
                <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;font-weight:500">Mot de passe</label>
                <input type="password" name="password" placeholder="Minimum 6 caractères" required
                    style="width:100%;background:#f5f4f0;border:none;border-radius:10px;padding:12px;font-size:13px;outline:none">
                @error('password')<p style="color:#dc3545;font-size:11px;margin-top:6px">{{ $message }}</p>@enderror
            </div>

            <div style="margin-bottom:24px">
                <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;font-weight:500">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" placeholder="••••••••" required
                    style="width:100%;background:#f5f4f0;border:none;border-radius:10px;padding:12px;font-size:13px;outline:none">
            </div>

            <button type="submit" style="background:#c2601a;color:white;border:none;border-radius:12px;padding:12px;font-size:14px;font-weight:600;cursor:pointer;width:100%">Créer mon compte →</button>
        </form>

        <p style="text-align:center;font-size:13px;color:#888;margin-top:22px;padding-top:18px;border-top:1px solid #f0ede8">
            Déjà membre ?
            <a href="{{ route('br.login') }}" style="color:#c2601a;text-decoration:none;font-weight:500">Se connecter</a>
        </p>
    </div>

</div>

<script>
document.getElementById('noCodeBtn').addEventListener('click', function() {
    // Vérifier si le téléphone est déjà renseigné
    const telephone = document.querySelector('input[name="telephone"]').value;
    let message = "Bonjour, je souhaite m'inscrire sur Business Room mais je n'ai pas de code de parrainage.";
    
    if (telephone && telephone.length >= 9) {
        message += " Mon numéro est le : " + telephone;
    }
    
    // Encoder le message pour l'URL
    const encodedMessage = encodeURIComponent(message);
    
    // Ouvrir WhatsApp avec le numéro 659292001
    window.open(`https://wa.me/237659292001?text=${encodedMessage}`, '_blank');
});
</script>

@endsection