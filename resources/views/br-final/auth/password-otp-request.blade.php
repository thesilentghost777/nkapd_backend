@extends('br-final.layouts.guest')
@section('title', 'Mot de passe oublié')
@section('content')

<div style="max-width:460px;margin:0 auto;padding:0 16px">

    <a href="{{ route('br.login') }}"
       style="font-size:13px;color:#888;display:inline-block;margin-bottom:16px;padding-top:8px">
        ← Retour à la connexion
    </a>

    <div style="text-align:center;margin-bottom:28px">
        <div style="width:60px;height:60px;background:#c2601a;border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px auto">
            {{-- Icône cadenas --}}
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
        </div>
        <h1 style="font-family:Syne,sans-serif;font-size:22px;font-weight:700;margin-bottom:6px">Mot de passe oublié ?</h1>
        <p style="font-size:13px;color:#888;margin:0">Entrez votre numéro de téléphone ou votre email.<br>Vous recevrez un code OTP pour réinitialiser votre mot de passe.</p>
    </div>

    @if(session('error'))
        <div style="background:#fce8e8;border-radius:12px;padding:12px 16px;color:#c0302a;font-size:13px;margin-bottom:16px;text-align:center">
            {{ session('error') }}
        </div>
    @endif

    <div style="background:white;border-radius:24px;padding:28px;box-shadow:0 2px 12px rgba(0,0,0,0.04);border:1px solid #efede8">

        <form action="{{ route('br.password.otp.envoyer') }}" method="POST">
            @csrf

            {{-- Onglets : Téléphone / Email --}}
            <div style="display:flex;background:#f5f4f0;border-radius:12px;padding:4px;margin-bottom:22px;gap:4px" id="methodTabs">
                <button type="button" data-method="telephone" class="tab-btn tab-active"
                    style="flex:1;border:none;border-radius:9px;padding:9px;font-size:13px;font-weight:600;cursor:pointer;background:white;color:#c2601a;box-shadow:0 1px 4px rgba(0,0,0,0.08);transition:all 0.2s">
                    📱 Téléphone
                </button>
                <button type="button" data-method="email" class="tab-btn"
                    style="flex:1;border:none;border-radius:9px;padding:9px;font-size:13px;font-weight:500;cursor:pointer;background:transparent;color:#888;transition:all 0.2s">
                    ✉️ Email
                </button>
            </div>

            <input type="hidden" name="methode" id="methodeInput" value="telephone">

            {{-- Champ Téléphone --}}
            <div id="fieldTelephone" style="margin-bottom:22px">
                <label style="display:block;font-size:13px;color:#555;margin-bottom:8px;font-weight:500">Numéro de téléphone</label>
                <input type="tel" name="telephone" value="{{ old('telephone') }}" placeholder="6XXXXXXXX"
                       style="width:100%;background:#fafaf8;border:1px solid #e5e2dc;border-radius:14px;padding:14px 16px;font-size:14px;color:#1a1a1a;outline:none;box-sizing:border-box">
                @error('telephone')<p style="color:#e74c3c;font-size:12px;margin-top:6px">{{ $message }}</p>@enderror
                <p style="font-size:11px;color:#aaa;margin-top:6px">Format : 6XXXXXXXX — le compte doit être lié à ce numéro.</p>
            </div>

            {{-- Champ Email (caché par défaut) --}}
            <div id="fieldEmail" style="margin-bottom:22px;display:none">
                <label style="display:block;font-size:13px;color:#555;margin-bottom:8px;font-weight:500">Adresse email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="jean@email.com"
                       style="width:100%;background:#fafaf8;border:1px solid #e5e2dc;border-radius:14px;padding:14px 16px;font-size:14px;color:#1a1a1a;outline:none;box-sizing:border-box">
                @error('email')<p style="color:#e74c3c;font-size:12px;margin-top:6px">{{ $message }}</p>@enderror
                <p style="font-size:11px;color:#aaa;margin-top:6px">L'email doit être associé à votre compte Business Room.</p>
            </div>

            <button type="submit"
                style="background:#c2601a;color:white;border:none;border-radius:14px;padding:15px;font-size:15px;font-weight:700;font-family:'Syne',sans-serif;cursor:pointer;width:100%">
                Recevoir le code OTP →
            </button>
        </form>
    </div>
</div>

<script>
// Gestion des onglets téléphone / email
document.querySelectorAll('.tab-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        const method = this.dataset.method;

        // Styles des onglets
        document.querySelectorAll('.tab-btn').forEach(function(b) {
            b.style.background = 'transparent';
            b.style.color = '#888';
            b.style.boxShadow = 'none';
            b.style.fontWeight = '500';
        });
        this.style.background = 'white';
        this.style.color = '#c2601a';
        this.style.boxShadow = '0 1px 4px rgba(0,0,0,0.08)';
        this.style.fontWeight = '600';

        // Champs
        document.getElementById('methodeInput').value = method;
        document.getElementById('fieldTelephone').style.display = method === 'telephone' ? 'block' : 'none';
        document.getElementById('fieldEmail').style.display     = method === 'email'     ? 'block' : 'none';
    });
});
</script>

<style>
input:focus {
    border-color: #c2601a !important;
    background: white !important;
    box-shadow: 0 0 0 3px rgba(194,96,26,0.08);
}
</style>

@endsection