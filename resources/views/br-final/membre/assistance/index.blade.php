@extends('br-final.layouts.app')
@section('title', 'Assistance')
@section('content')

<style>
  .asst-inp { width:100%; background:#F0F4F1; border:1px solid #c8d9ce; border-radius:10px; padding:11px 13px; font-size:13px; outline:none; color:#1B4332; font-family:inherit; appearance:none; box-sizing:border-box; }
  .asst-inp:focus { border-color:#2D6A4F; box-shadow:0 0 0 3px rgba(45,106,79,.1); }
  .asst-lbl { display:block; font-size:10px; color:#2D6A4F; margin-bottom:5px; font-weight:600; letter-spacing:.5px; text-transform:uppercase; }
  .asst-card { background:#fff; border-radius:16px; padding:20px; margin-bottom:12px; border:0.5px solid #d0ddd6; }
  .asst-faq { background:#fff; border-radius:12px; padding:14px 16px; margin-bottom:8px; display:flex; align-items:center; gap:12px; border:0.5px solid #d0ddd6; }
  .asst-hist { display:flex; align-items:flex-start; gap:12px; background:#fff; border-radius:14px; padding:14px; margin-bottom:9px; text-decoration:none; border-top:0.5px solid #d0ddd6; border-right:0.5px solid #d0ddd6; border-bottom:0.5px solid #d0ddd6; }
  .asst-badge { display:inline-block; padding:3px 10px; border-radius:20px; font-size:10px; font-weight:600; }
  @keyframes spin { from{transform:rotate(0deg)} to{transform:rotate(360deg)} }
  .spinning { animation:spin .8s linear infinite; }
</style>

{{-- Hero --}}
<div style="background:#1B4332;padding:28px 20px 26px;position:relative;overflow:hidden">
  <div style="position:absolute;right:-30px;top:-30px;width:160px;height:160px;border-radius:50%;background:rgba(212,160,23,.08)"></div>
  <div style="position:absolute;right:30px;bottom:-40px;width:100px;height:100px;border-radius:50%;background:rgba(212,160,23,.06)"></div>

  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;position:relative">
    <div style="display:flex;align-items:center;gap:10px">
      <div style="width:36px;height:36px;border-radius:50%;background:#D4A017;display:flex;align-items:center;justify-content:center;font-weight:700;color:#1B4332;font-size:13px">BR</div>
      <span style="color:#D4A017;font-weight:700;font-size:13px;letter-spacing:.5px">BUSINESS ROOM</span>
    </div>
    <div style="width:34px;height:34px;border-radius:50%;border:1px solid rgba(212,160,23,.3);display:flex;align-items:center;justify-content:center;color:#D4A017;font-size:15px">🔔</div>
  </div>

  <h2 style="font-size:26px;font-weight:700;color:#fff;line-height:1.2;margin-bottom:6px;position:relative">Centre d'Assistance<br><span style="color:#D4A017">Premium</span></h2>
  <p style="font-size:12px;color:rgba(255,255,255,.6);line-height:1.7;margin-bottom:18px;position:relative">Besoin d'aide pour vos investissements ou votre réseau ? Notre équipe d'experts est là pour vous accompagner.</p>

  <div style="background:#2D6A4F;border-radius:14px;padding:16px;display:flex;align-items:center;gap:14px;position:relative;border:1px solid rgba(212,160,23,.2)">
    <div style="width:44px;height:44px;border-radius:12px;background:rgba(212,160,23,.15);display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0">🛡️</div>
    <div>
      <p style="font-size:13px;font-weight:700;color:#fff;margin-bottom:2px">⚡ Assistance 24/7 disponible</p>
      <p style="font-size:11px;color:rgba(255,255,255,.6)">Réponse garantie en moins de 2h pour les membres VIP</p>
    </div>
  </div>
</div>

<div style="background:#F0F4F1;padding:16px;min-height:100vh">

  <a href="{{ route('br.membre.dashboard') }}" style="font-size:12px;color:#2D6A4F;display:inline-flex;align-items:center;gap:4px;margin-bottom:14px;font-weight:500;text-decoration:none">← Retour</a>

  @if(!$aTontineActive)
    <div style="border:1.5px solid #2D6A4F;border-radius:16px;background:#E8F5EC;padding:16px;margin-bottom:18px;display:flex;gap:14px;align-items:flex-start">
      <div style="width:40px;height:40px;border-radius:12px;background:#1B4332;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0">🔒</div>
      <div>
        <p style="font-size:15px;font-weight:700;color:#1B4332;margin-bottom:4px">Action Requise</p>
        <p style="font-size:12px;color:#2D6A4F;line-height:1.6">Pour bénéficier de l'assistance prioritaire et soumettre une nouvelle demande, une tontine active est requise sur votre compte.</p>
      </div>
    </div>
  @else
    {{-- Formulaire --}}
    <div class="asst-card">
      <p style="font-size:16px;font-weight:700;color:#1B4332;margin-bottom:16px;display:flex;align-items:center;gap:8px">
        <span style="color:#D4A017">📋</span> Soumettre une demande
      </p>

      <form action="{{ route('br.membre.assistance.store') }}" method="POST" id="assistance-form">
        @csrf

        <div style="margin-bottom:13px">
          <label class="asst-lbl">Catégorie</label>
          <select name="type" required class="asst-inp"
            style="background-image:url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%232D6A4F' d='M6 8L1 3h10z'/%3E%3C/svg%3E\");background-repeat:no-repeat;background-position:right 13px center;background-color:#F0F4F1">
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
        </div>

        <div style="margin-bottom:13px">
          <label class="asst-lbl">Priorité</label>
          <select name="priorite" class="asst-inp"
            style="background-image:url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%232D6A4F' d='M6 8L1 3h10z'/%3E%3C/svg%3E\");background-repeat:no-repeat;background-position:right 13px center;background-color:#F0F4F1">
            <option value="standard">Standard</option>
            <option value="urgent">Urgent</option>
            <option value="critique">Critique</option>
          </select>
        </div>

        <div style="margin-bottom:13px">
          <label class="asst-lbl">Sujet de votre message</label>
          <input type="text" name="sujet" placeholder="Comment pouvons-nous vous aider ?" required maxlength="255" class="asst-inp">
        </div>

        <div style="margin-bottom:18px">
          <label class="asst-lbl">Détails</label>
          <textarea name="description" rows="4" required placeholder="Décrivez votre situation en détail..." class="asst-inp" style="resize:none"></textarea>
        </div>

        <button type="submit" id="assistance-btn"
          style="width:100%;background:#1B4332;color:#D4A017;border:none;border-radius:12px;padding:14px;font-size:14px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px">
          <span id="assistance-btn-text">Envoyer la demande ➤</span>
          <span id="assistance-btn-spinner" style="display:none;align-items:center;justify-content:center">
            <svg class="spinning" width="18" height="18" viewBox="0 0 18 18">
              <circle cx="9" cy="9" r="7" fill="none" stroke="#D4A017" stroke-width="2.5" stroke-dasharray="30" stroke-dashoffset="10" stroke-linecap="round"/>
            </svg>
          </span>
        </button>
      </form>
    </div>
  @endif

  {{-- Historique --}}
  <div style="margin-bottom:14px">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
      <p style="font-size:16px;font-weight:700;color:#1B4332">Historique</p>
      <span style="font-size:12px;color:#2D6A4F;font-weight:500">Tout voir</span>
    </div>

    @php
      $icons=['maladie_grave'=>'🏥','sinistre'=>'🔥','invalidite'=>'♿','pret_bancaire'=>'🏦','juridique'=>'⚖️','managerial'=>'📊','marketing'=>'📢','mise_en_relation'=>'🤝'];
      $statusStyles=[
        'en_attente'=>['bg'=>'#FEF9EC','color'=>'#9A6C00','border'=>'#D4A017','label'=>'En attente'],
        'en_cours'  =>['bg'=>'#E8F5EC','color'=>'#1B4332','border'=>'#2D6A4F','label'=>'En cours'],
        'resolu'    =>['bg'=>'#F0F4F1','color'=>'#5A8A6A','border'=>'#9FC0A8','label'=>'✓ Résolu'],
      ];
    @endphp

    @forelse($demandes as $d)
      @php $st=$statusStyles[$d->statut]??$statusStyles['en_attente']; @endphp
      <a href="{{ route('br.membre.assistance.show', $d) }}" class="asst-hist"
         style="border-left:3px solid {{ $st['border'] }}">
        <div style="width:38px;height:38px;border-radius:10px;background:#E8F5EC;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0">{{ $icons[$d->type]??'❓' }}</div>
        <div style="flex:1;min-width:0">
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:3px">
            <p style="font-size:13px;font-weight:600;color:#1B4332;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:60%">{{ $d->sujet }}</p>
            <span style="font-size:10px;color:#9FC0A8;flex-shrink:0">{{ $d->created_at->diffForHumans() }}</span>
          </div>
          <p style="font-size:11px;color:#5A8A6A;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ Str::limit($d->description ?? '', 55) }}</p>
          <span class="asst-badge" style="background:{{ $st['bg'] }};color:{{ $st['color'] }};margin-top:6px">{{ $st['label'] }}</span>
        </div>
      </a>
    @empty
      <div style="text-align:center;padding:40px 20px;background:#fff;border-radius:16px;border:0.5px solid #d0ddd6">
        <p style="font-size:36px;margin-bottom:8px">🛟</p>
        <p style="font-size:14px;font-weight:600;color:#1B4332;margin-bottom:4px">Aucune demande d'assistance</p>
        <p style="font-size:12px;color:#5A8A6A">Soumettez votre première demande ci-dessus</p>
      </div>
    @endforelse
  </div>

  {{-- VIP Banner --}}
  <div style="background:#1B4332;border-radius:16px;padding:18px;margin-bottom:16px;display:flex;align-items:center;gap:14px;border:1px solid rgba(212,160,23,.2)">
    <div style="width:44px;height:44px;border-radius:12px;background:rgba(212,160,23,.15);display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0">🚀</div>
    <div>
      <p style="font-size:13px;font-weight:700;color:#D4A017;margin-bottom:3px">Boostez votre support</p>
      <p style="font-size:11px;color:rgba(255,255,255,.6);line-height:1.6">Les membres VIP avec une tontine active bénéficient d'un temps de réponse inférieur à 2 heures.</p>
    </div>
  </div>

  {{-- FAQ --}}
  <p style="font-size:16px;font-weight:700;color:#1B4332;margin-bottom:12px">Questions fréquentes</p>
  @php
    $faqs=[
      ['icon'=>'❓','label'=>'Fonctionnement Tontine'],
      ['icon'=>'💰','label'=>'Retraits & Gains'],
      ['icon'=>'👥','label'=>'Gestion du Réseau'],
      ['icon'=>'🔒','label'=>'Sécurité du Compte'],
    ];
  @endphp
  @foreach($faqs as $faq)
  <div class="asst-faq">
    <span style="font-size:18px">{{ $faq['icon'] }}</span>
    <p style="font-size:13px;font-weight:500;color:#1B4332;flex:1">{{ $faq['label'] }}</p>
    <span style="color:#2D6A4F;font-size:16px;font-weight:700">›</span>
  </div>
  @endforeach

</div>

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