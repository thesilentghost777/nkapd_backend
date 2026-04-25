@extends('br-final.layouts.app')
@section('title', 'Assistance')
@section('content')

{{-- Hero Section --}}
<div style="position:relative;background:#000000;overflow:hidden;padding:28px 20px 24px">
    <div style="position:absolute;inset:0;background:linear-gradient(135deg,#1a1a2e 0%,#16213e 50%,#0f3460 100%);opacity:1"></div>    <div style="position:relative;z-index:1">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
            <div style="display:flex;align-items:center;gap:10px">
                <div style="width:36px;height:36px;border-radius:50%;background:#E8521A;display:flex;align-items:center;justify-content:center;font-weight:700;color:#fff;font-size:14px">BR</div>
                <span style="color:#E8521A;font-weight:700;font-size:14px;letter-spacing:.5px">BUSINESS ROOM</span>
            </div>
            <div style="width:36px;height:36px;border-radius:50%;border:1px solid rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:16px">🔔</div>
        </div>
        <h2 style="font-family:Syne,sans-serif;font-size:28px;font-weight:600;color:#fff;line-height:1.2;margin-bottom:6px">Centre d'Assistance<br><span style="color:#E8521A">Premium</span></h2>
        <p style="font-size:13px;color:rgba(255,255,255,.65);line-height:1.6;margin-bottom:16px">Besoin d'aide pour vos investissements ou votre réseau ? Notre équipe d'experts est là pour vous accompagner dans la Business Room.</p>

        <div style="border-radius:16px;overflow:hidden;position:relative;height:140px;background:linear-gradient(135deg,#E8521A,#c2601a)">
            <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-size:60px;opacity:.2">🛡</div>
            <div style="position:absolute;bottom:0;left:0;right:0;background:linear-gradient(transparent,rgba(0,0,0,.5));padding:12px 16px">
                <p style="color:#fff;font-size:13px;font-weight:600">⚡ Assistance 24/7 disponible</p>
            </div>
        </div>
    </div>
</div>

<div class="p-4">

    <a href="{{ route('br.membre.dashboard') }}" style="font-size:13px;color:#E8521A;display:inline-flex;align-items:center;gap:4px;margin-bottom:16px;text-decoration:none;font-weight:500">← Retour</a>

    @if(!$aTontineActive)
        <div style="border:1.5px solid #E8521A;border-radius:16px;background:#fff8f5;padding:16px;margin-bottom:20px;display:flex;gap:14px;align-items:flex-start">
            <div style="width:40px;height:40px;border-radius:12px;background:#E8521A;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0">🔒</div>
            <div>
                <p style="font-family:Syne,sans-serif;font-size:16px;font-weight:700;color:#E8521A;margin-bottom:4px">Action Requise</p>
                <p style="font-size:13px;color:#555;line-height:1.6">Pour bénéficier de l'assistance prioritaire et soumettre une nouvelle demande, une tontine active est requise sur votre compte.</p>
            </div>
        </div>
    @else
        {{-- Formulaire --}}
        <div style="background:#fff;border-radius:20px;padding:20px;margin-bottom:16px;box-shadow:0 2px 12px rgba(232,82,26,.08);border:1px solid rgba(232,82,26,.1)">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
                <h2 style="font-family:Syne,sans-serif;font-size:18px;font-weight:700;color:#1a1a1a">Soumettre une demande</h2>
                <span style="font-size:18px">📋</span>
            </div>
            <form action="{{ route('br.membre.assistance.store') }}" method="POST" id="assistance-form">
                @csrf

                <label style="font-size:12px;color:#E8521A;font-weight:600;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px">Catégorie</label>
                <select name="type" required style="width:100%;padding:13px 14px;border:1.5px solid #ececec;border-radius:12px;font-size:14px;color:#1a1a1a;background:#fafafa;margin-bottom:14px;appearance:none;background-image:url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23E8521A' d='M6 8L1 3h10z'/%3E%3C/svg%3E\");background-repeat:no-repeat;background-position:right 14px center;outline:none">
                    <option value="maladie_grave">🏥 Maladie grave</option>
                    <option value="sinistre">🔥 Sinistre</option>
                    <option value="invalidite">♿ Invalidité</option>
                    <option value="pret_bancaire">🏦 Prêt bancaire</option>
                    <option value="juridique">⚖️ Juridique</option>
                    <option value="managerial">📊 Managerial</option>
                    <option value="marketing">📢 Marketing</option>
                    <option value="mise_en_relation">🤝 Mise en relation</option>
                    <option value="autre">❓ Autre</option>
                </select>

                <label style="font-size:12px;color:#E8521A;font-weight:600;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px">Priorité</label>
                <select name="priorite" style="width:100%;padding:13px 14px;border:1.5px solid #ececec;border-radius:12px;font-size:14px;color:#1a1a1a;background:#fafafa;margin-bottom:14px;appearance:none;background-image:url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23E8521A' d='M6 8L1 3h10z'/%3E%3C/svg%3E\");background-repeat:no-repeat;background-position:right 14px center;outline:none">
                    <option value="standard">Standard</option>
                    <option value="urgent">Urgent</option>
                    <option value="critique">Critique</option>
                </select>

                <label style="font-size:12px;color:#E8521A;font-weight:600;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px">Sujet de votre message</label>
                <input type="text" name="sujet" placeholder="Comment pouvons-nous vous aider ?" required maxlength="255"
                    style="width:100%;padding:13px 14px;border:1.5px solid #ececec;border-radius:12px;font-size:14px;color:#1a1a1a;background:#fafafa;margin-bottom:14px;box-sizing:border-box;outline:none">

                <label style="font-size:12px;color:#E8521A;font-weight:600;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px">Détails</label>
                <textarea name="description" rows="4" required placeholder="Décrivez votre situation en détail..."
                    style="width:100%;padding:13px 14px;border:1.5px solid #ececec;border-radius:12px;font-size:14px;color:#1a1a1a;background:#fafafa;margin-bottom:18px;resize:none;box-sizing:border-box;outline:none"></textarea>

                <button type="submit" id="assistance-btn" style="width:100%;background:#E8521A;color:#fff;border:none;border-radius:14px;padding:16px;font-size:15px;font-weight:700;display:flex;align-items:center;justify-content:center;gap:8px;cursor:pointer">
                    <span id="assistance-btn-text">Envoyer la demande ➤</span>
                    <span id="assistance-btn-spinner" style="display:none;align-items:center;justify-content:center;">
                        <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg" class="spinning">
                            <circle cx="9" cy="9" r="7" fill="none" stroke="currentColor" stroke-width="2.5" stroke-dasharray="30" stroke-dashoffset="10" stroke-linecap="round"/>
                        </svg>
                    </span>
                </button>
            </form>
        </div>
    @endif

    {{-- Historique --}}
    <div style="margin-bottom:20px">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
            <h2 style="font-family:Syne,sans-serif;font-size:18px;font-weight:700;color:#1a1a1a">Historique</h2>
            <span style="font-size:13px;color:#E8521A;font-weight:500">Tout voir</span>
        </div>

        @forelse($demandes as $d)
        @php
            $icons=['maladie_grave'=>'🏥','sinistre'=>'🔥','invalidite'=>'♿','pret_bancaire'=>'🏦','juridique'=>'⚖️','managerial'=>'📊','marketing'=>'📢','mise_en_relation'=>'🤝'];
            $statusStyles=[
                'en_attente'=>['bg'=>'#fff3ed','color'=>'#E8521A','label'=>'En attente'],
                'en_cours'=>['bg'=>'#e8f4fd','color'=>'#2196f3','label'=>'En cours'],
                'resolu'=>['bg'=>'#e8f5e9','color'=>'#43a047','label'=>'Résolu'],
            ];
            $st=$statusStyles[$d->statut]??$statusStyles['en_attente'];
        @endphp
        <a href="{{ route('br.membre.assistance.show', $d) }}"
            style="display:flex;align-items:flex-start;gap:12px;background:#fff;border-radius:16px;padding:14px;margin-bottom:10px;text-decoration:none;border-left:3px solid {{ $st['color'] }};box-shadow:0 1px 6px rgba(232,82,26,.07)">
            <div style="width:38px;height:38px;border-radius:10px;background:#fff3ed;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0">{{ $icons[$d->type]??'❓' }}</div>
            <div style="flex:1;min-width:0">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:3px">
                    <p style="font-size:14px;font-weight:600;color:#1a1a1a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:60%">{{ $d->sujet }}</p>
                    <span style="font-size:10px;color:#aaa;flex-shrink:0">{{ $d->created_at->diffForHumans() }}</span>
                </div>
                <p style="font-size:12px;color:#888;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ Str::limit($d->description ?? '', 55) }}</p>
                <span style="display:inline-block;margin-top:6px;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;background:{{ $st['bg'] }};color:{{ $st['color'] }}">{{ $st['label'] }}</span>
            </div>
        </a>
        @empty
        <div style="text-align:center;padding:40px 0;background:#fff;border-radius:16px;box-shadow:0 1px 6px rgba(232,82,26,.07)">
            <p style="font-size:40px;margin-bottom:8px">🛟</p>
            <p style="font-size:13px;color:#aaa">Aucune demande d'assistance</p>
        </div>
        @endforelse
    </div>

    {{-- VIP Banner --}}
    <div style="background:linear-gradient(135deg,#E8521A,#c2601a);border-radius:20px;padding:20px;margin-bottom:24px;display:flex;align-items:center;gap:14px">
        <div style="width:44px;height:44px;border-radius:14px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0">🚀</div>
        <div>
            <p style="font-size:14px;font-weight:700;color:#fff;margin-bottom:3px">Boostez votre support</p>
            <p style="font-size:12px;color:rgba(255,255,255,.8);line-height:1.5">Les membres VIP avec une tontine active bénéficient d'un temps de réponse inférieur à 2 heures.</p>
        </div>
    </div>

    {{-- FAQ --}}
    <h2 style="font-family:Syne,sans-serif;font-size:18px;font-weight:700;margin-bottom:14px;color:#1a1a1a">Questions fréquentes</h2>
    @php
    $faqs = [
        ['icon'=>'❓','label'=>'Fonctionnement Tontine'],
        ['icon'=>'💰','label'=>'Retraits & Gains'],
        ['icon'=>'👥','label'=>'Gestion du Réseau'],
        ['icon'=>'🔒','label'=>'Sécurité du Compte'],
    ];
    @endphp
    @foreach($faqs as $faq)
    <div style="background:#fff;border-radius:14px;padding:16px 18px;margin-bottom:10px;display:flex;align-items:center;gap:14px;box-shadow:0 1px 6px rgba(232,82,26,.07);border-left:3px solid #E8521A">
        <span style="font-size:20px">{{ $faq['icon'] }}</span>
        <p style="font-size:14px;font-weight:500;color:#1a1a1a">{{ $faq['label'] }}</p>
        <span style="margin-left:auto;color:#E8521A;font-size:18px;font-weight:700">›</span>
    </div>
    @endforeach

</div>

<style>
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .spinning {
        animation: spin 0.8s linear infinite;
    }
    input:focus, select:focus, textarea:focus {
        border-color: #E8521A !important;
        box-shadow: 0 0 0 3px rgba(232,82,26,.1);
    }
</style>

<script>
    const assistanceForm = document.getElementById('assistance-form');
    if (assistanceForm) {
        assistanceForm.addEventListener('submit', function() {
            const btn     = document.getElementById('assistance-btn');
            const text    = document.getElementById('assistance-btn-text');
            const spinner = document.getElementById('assistance-btn-spinner');

            btn.disabled = true;
            text.style.display = 'none';
            spinner.style.display = 'flex';

            setTimeout(function() {
                btn.disabled = false;
                text.style.display = 'inline';
                spinner.style.display = 'none';
            }, 10000);
        });
    }
</script>

@endsection