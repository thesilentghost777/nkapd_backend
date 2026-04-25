@extends('br-final.layouts.guest')
@section('title', 'Vérifier le code')
@section('content')

<div style="text-align:center;margin-bottom:32px">
    <a href="{{ route('br.otp.email.form') }}"
       style="font-size:13px;color:#888;display:inline-block;margin-bottom:10px;padding-top:8px">
        ← Modifier l'email
    </a>
    <div style="width:60px;height:60px;background:#c2601a;border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px auto">
        <span style="color:white;font-size:28px;font-weight:bold">B</span>
    </div>
    <h1 style="font-family:Syne,sans-serif;font-size:22px;font-weight:700;margin-bottom:6px">Entrez le code</h1>
    <p style="font-size:13px;color:#999">Code envoyé à <strong>{{ session('br_otp_email') }}</strong></p>
</div>

@if(session('success'))
    <div style="background:#e8f5e9;border-radius:12px;padding:12px 16px;color:#2d7a22;font-size:13px;margin-bottom:16px;text-align:center">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div style="background:#fce8e8;border-radius:12px;padding:12px 16px;color:#c0302a;font-size:13px;margin-bottom:16px;text-align:center">
        {{ session('error') }}
    </div>
@endif

<div style="background:white;border-radius:24px;padding:36px 32px;box-shadow:0 2px 12px rgba(0,0,0,0.04);border:1px solid #efede8">
    <form action="{{ route('br.otp.verifier') }}" method="POST">
        @csrf

        {{-- Inputs OTP à 6 cases --}}
        <div style="display:flex;gap:8px;justify-content:center;margin-bottom:28px" id="otpInputs">
            @for($i = 0; $i < 6; $i++)
                <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]"
                       class="otp-digit"
                       style="width:46px;height:56px;text-align:center;font-size:24px;font-weight:700;font-family:'Syne',sans-serif;background:#f5f4f0;border:2px solid transparent;border-radius:12px;outline:none;color:#1a1a1a;transition:all 0.2s">
            @endfor
        </div>

        {{-- Champ caché qui reçoit le code complet --}}
        <input type="hidden" name="code" id="codeHidden">

        @error('code')<p style="color:#e74c3c;font-size:13px;text-align:center;margin-bottom:16px">{{ $message }}</p>@enderror

        <button type="submit" id="submitBtn" disabled
                style="background:#e5e2dc;color:#999;border:none;border-radius:14px;padding:15px;font-size:15px;font-weight:700;font-family:'Syne',sans-serif;cursor:not-allowed;width:100%;transition:all 0.2s">
            Valider le code
        </button>
    </form>

    <div style="margin-top:20px;text-align:center">
        <form action="{{ route('br.otp.envoyer') }}" method="POST" style="display:inline">
            @csrf
            <input type="hidden" name="email" value="{{ session('br_otp_email') }}">
            <button type="submit" style="background:none;border:none;color:#c2601a;font-size:13px;cursor:pointer;text-decoration:underline">
                Renvoyer le code
            </button>
        </form>
    </div>
</div>

<script>
const digits   = document.querySelectorAll('.otp-digit');
const hidden   = document.getElementById('codeHidden');
const submitBtn = document.getElementById('submitBtn');

digits.forEach((input, idx) => {
    input.addEventListener('input', e => {
        const val = e.target.value.replace(/\D/g, '');
        e.target.value = val;

        if (val && idx < 5) digits[idx + 1].focus();

        // Assembler le code et activer/désactiver le bouton
        const code = Array.from(digits).map(d => d.value).join('');
        hidden.value = code;
        if (code.length === 6) {
            submitBtn.disabled = false;
            submitBtn.style.background = '#c2601a';
            submitBtn.style.color = 'white';
            submitBtn.style.cursor = 'pointer';
        } else {
            submitBtn.disabled = true;
            submitBtn.style.background = '#e5e2dc';
            submitBtn.style.color = '#999';
            submitBtn.style.cursor = 'not-allowed';
        }
    });

    input.addEventListener('keydown', e => {
        if (e.key === 'Backspace' && !input.value && idx > 0) {
            digits[idx - 1].focus();
        }
    });

    // Coller le code d'un coup
    input.addEventListener('paste', e => {
        e.preventDefault();
        const pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '').slice(0, 6);
        pasted.split('').forEach((char, i) => { if (digits[i]) digits[i].value = char; });
        if (pasted.length === 6) {
            hidden.value = pasted;
            submitBtn.disabled = false;
            submitBtn.style.background = '#c2601a';
            submitBtn.style.color = 'white';
            submitBtn.style.cursor = 'pointer';
            digits[5].focus();
        }
    });
});

digits[0].focus();
</script>

<style>
.otp-digit:focus { border-color:#c2601a!important;background:white!important; }
</style>
@endsection