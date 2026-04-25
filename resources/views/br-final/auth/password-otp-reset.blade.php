@extends('br-final.layouts.guest')
@section('title', 'Réinitialiser le mot de passe')
@section('content')

<div style="max-width:460px;margin:0 auto;padding:0 16px">

    <a href="{{ route('br.password.otp.form') }}"
       style="font-size:13px;color:#888;display:inline-block;margin-bottom:16px;padding-top:8px">
        ← Retour
    </a>

    <div style="text-align:center;margin-bottom:28px">
        <div style="width:60px;height:60px;background:#c2601a;border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px auto">
            {{-- Icône clé --}}
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"/>
            </svg>
        </div>
        <h1 style="font-family:Syne,sans-serif;font-size:22px;font-weight:700;margin-bottom:6px">Réinitialiser votre mot de passe</h1>
        @if(session('br_reset_contact'))
            <p style="font-size:13px;color:#888;margin:0">
                Un code à 6 chiffres a été envoyé à<br>
                <strong style="color:#1a1a1a">{{ session('br_reset_contact') }}</strong>
            </p>
        @else
            <p style="font-size:13px;color:#888;margin:0">Entrez le code reçu et votre nouveau mot de passe.</p>
        @endif
    </div>

    @if(session('error'))
        <div style="background:#fce8e8;border-radius:12px;padding:12px 16px;color:#c0302a;font-size:13px;margin-bottom:16px;text-align:center">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div style="background:#e8f5e9;border-radius:12px;padding:12px 16px;color:#2e7d32;font-size:13px;margin-bottom:16px;text-align:center">
            {{ session('success') }}
        </div>
    @endif

    <div style="background:white;border-radius:24px;padding:28px;box-shadow:0 2px 12px rgba(0,0,0,0.04);border:1px solid #efede8">

        <form action="{{ route('br.password.otp.reset') }}" method="POST">
            @csrf

            {{-- Code OTP --}}
            <div style="margin-bottom:22px">
                <label style="display:block;font-size:13px;color:#555;margin-bottom:8px;font-weight:500">Code OTP reçu <span style="color:#dc3545">*</span></label>
                <input type="text" name="code" placeholder="_ _ _ _ _ _" maxlength="6"
                       inputmode="numeric" pattern="[0-9]{6}" autocomplete="one-time-code"
                       style="width:100%;background:#fafaf8;border:1px solid #e5e2dc;border-radius:14px;padding:14px 16px;font-size:22px;letter-spacing:10px;text-align:center;color:#1a1a1a;outline:none;box-sizing:border-box;font-weight:600">
                @error('code')<p style="color:#e74c3c;font-size:12px;margin-top:6px">{{ $message }}</p>@enderror
                <p style="font-size:11px;color:#aaa;margin-top:6px;text-align:center">Code valide pendant 15 minutes.</p>
            </div>

            {{-- Nouveau mot de passe --}}
            <div style="margin-bottom:18px">
                <label style="display:block;font-size:13px;color:#555;margin-bottom:8px;font-weight:500">Nouveau mot de passe <span style="color:#dc3545">*</span></label>
                <div style="position:relative">
                    <input type="password" name="password" id="newPassword" placeholder="Minimum 6 caractères" required
                           style="width:100%;background:#fafaf8;border:1px solid #e5e2dc;border-radius:14px;padding:14px 46px 14px 16px;font-size:14px;color:#1a1a1a;outline:none;box-sizing:border-box">
                    <button type="button" onclick="togglePassword('newPassword', this)"
                            style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#aaa;padding:0">
                        👁
                    </button>
                </div>
                @error('password')<p style="color:#e74c3c;font-size:12px;margin-top:6px">{{ $message }}</p>@enderror
            </div>

            {{-- Confirmer le mot de passe --}}
            <div style="margin-bottom:26px">
                <label style="display:block;font-size:13px;color:#555;margin-bottom:8px;font-weight:500">Confirmer le mot de passe <span style="color:#dc3545">*</span></label>
                <div style="position:relative">
                    <input type="password" name="password_confirmation" id="confirmPassword" placeholder="••••••••" required
                           style="width:100%;background:#fafaf8;border:1px solid #e5e2dc;border-radius:14px;padding:14px 46px 14px 16px;font-size:14px;color:#1a1a1a;outline:none;box-sizing:border-box">
                    <button type="button" onclick="togglePassword('confirmPassword', this)"
                            style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#aaa;padding:0">
                        👁
                    </button>
                </div>
            </div>

            {{-- Indicateur de force du mot de passe --}}
            <div style="margin-top:-16px;margin-bottom:22px" id="passwordStrengthWrap" style="display:none">
                <div style="height:4px;background:#e5e2dc;border-radius:4px;overflow:hidden">
                    <div id="passwordStrengthBar" style="height:100%;width:0%;border-radius:4px;transition:width 0.3s,background 0.3s"></div>
                </div>
                <p id="passwordStrengthLabel" style="font-size:11px;color:#aaa;margin-top:5px;text-align:right"></p>
            </div>

            <button type="submit"
                style="background:#c2601a;color:white;border:none;border-radius:14px;padding:15px;font-size:15px;font-weight:700;font-family:'Syne',sans-serif;cursor:pointer;width:100%">
                Réinitialiser le mot de passe ✓
            </button>
        </form>

        {{-- Renvoyer le code --}}
        <div style="margin-top:20px;padding-top:18px;border-top:1px solid #efede8;text-align:center">
            <p style="font-size:13px;color:#888;margin:0">
                Vous n'avez pas reçu le code ?
                <a href="{{ route('br.password.otp.form') }}" style="color:#c2601a;text-decoration:none;font-weight:600;margin-left:4px">Renvoyer</a>
            </p>
        </div>
    </div>
</div>

<script>
function togglePassword(fieldId, btn) {
    const field = document.getElementById(fieldId);
    if (field.type === 'password') {
        field.type = 'text';
        btn.textContent = '🙈';
    } else {
        field.type = 'password';
        btn.textContent = '👁';
    }
}

// Indicateur de force du mot de passe
document.getElementById('newPassword').addEventListener('input', function() {
    const val = this.value;
    const bar = document.getElementById('passwordStrengthBar');
    const label = document.getElementById('passwordStrengthLabel');

    let strength = 0;
    if (val.length >= 6) strength++;
    if (val.length >= 10) strength++;
    if (/[A-Z]/.test(val)) strength++;
    if (/[0-9]/.test(val)) strength++;
    if (/[^A-Za-z0-9]/.test(val)) strength++;

    const levels = [
        { width: '20%', color: '#e74c3c', label: 'Très faible' },
        { width: '40%', color: '#e67e22', label: 'Faible' },
        { width: '60%', color: '#f39c12', label: 'Moyen' },
        { width: '80%', color: '#27ae60', label: 'Fort' },
        { width: '100%', color: '#1e8449', label: 'Très fort' },
    ];

    if (val.length === 0) {
        bar.style.width = '0%';
        label.textContent = '';
        return;
    }

    const level = levels[Math.min(strength - 1, 4)];
    bar.style.width = level.width;
    bar.style.background = level.color;
    label.textContent = level.label;
    label.style.color = level.color;
});

// Auto-format OTP : ne garder que les chiffres
document.querySelector('input[name="code"]').addEventListener('input', function() {
    this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);
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