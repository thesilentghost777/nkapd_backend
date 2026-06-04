@extends('br-final.layouts.app')
@section('title', 'Mon Profil')
@section('content')

<style>
  .profil-page { background:#F0F4F1; min-height:100vh; }
  .profil-card { background:#fff; border-radius:16px; padding:20px; margin-bottom:14px; border:0.5px solid #d0ddd6; }
  .profil-input { width:100%; background:#F0F4F1; border:1px solid #c8d9ce; border-radius:10px; padding:11px 13px; font-size:13px; outline:none; color:#1B4332; font-family:inherit; }
  .profil-input:focus { border-color:#2D6A4F; }
  .profil-label { display:block; font-size:11px; color:#2D6A4F; margin-bottom:5px; font-weight:500; }
  .profil-stat { background:#1B4332; border-radius:12px; padding:14px; text-align:center; }
  .profil-section-title { font-size:16px; font-weight:500; margin-bottom:14px; padding-bottom:10px; border-bottom:1.5px solid #E8F0EB; color:#1B4332; display:flex; align-items:center; gap:8px; }
  .profil-filleul { background:#F0F4F1; border-radius:10px; padding:9px 12px; display:flex; align-items:center; gap:10px; border:0.5px solid #d0ddd6; margin-bottom:8px; }
</style>

<div class="profil-page p-4">

  <a href="{{ route('br.membre.dashboard') }}"
     style="font-size:12px;color:#2D6A4F;display:inline-flex;align-items:center;gap:4px;margin-bottom:14px;font-weight:500">
    ← Retour
  </a>

  <div style="margin-bottom:18px">
    <h1 style="font-size:22px;font-weight:700;color:#1B4332">Mon Profil</h1>
    <p style="font-size:12px;color:#5A8A6A;margin-top:3px">Gérez vos informations personnelles</p>
  </div>

  {{-- Carte identité --}}
  <div class="profil-card" style="text-align:center;padding:28px 20px">
    <div style="margin-bottom:14px">
      @if($user->photo)
        <img src="{{ Storage::url($user->photo) }}"
             style="width:90px;height:90px;border-radius:50%;object-fit:cover;margin:0 auto;border:3px solid #D4A017">
      @else
        <div style="width:90px;height:90px;border-radius:50%;background:#2D6A4F;display:flex;align-items:center;justify-content:center;margin:0 auto;color:#D4A017;font-size:32px;font-weight:700;border:3px solid #D4A017">
          {{ substr($user->prenom, 0, 1) }}
        </div>
      @endif
    </div>
    <h2 style="font-size:19px;font-weight:700;color:#1B4332;margin-bottom:5px">{{ $user->nom_complet }}</h2>
    <p style="font-size:12px;color:#5A8A6A;margin-bottom:12px">{{ $user->telephone }}</p>
    <span style="display:inline-block;padding:5px 14px;border-radius:20px;font-size:11px;font-weight:500;background:{{ $user->estMembre() ? '#E8F5EC' : '#FEF3E2' }};color:#1B4332">
      {{ $user->statut }}
    </span>
  </div>

  {{-- Statistiques --}}
  <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;margin-bottom:14px">
    <div class="profil-stat">
      <p style="font-size:10px;color:#9FC0A8;margin-bottom:5px;font-weight:500">Membre depuis</p>
      <p style="font-size:12px;font-weight:500;color:#fff">{{ $user->created_at->format('d/m/Y') }}</p>
    </div>
    <div class="profil-stat">
      <p style="font-size:10px;color:#9FC0A8;margin-bottom:5px;font-weight:500">Filleuls actifs</p>
      <p style="font-size:22px;font-weight:700;color:#D4A017">{{ $user->nb_filleuls_actifs }}</p>
    </div>
    <div class="profil-stat">
      <p style="font-size:10px;color:#9FC0A8;margin-bottom:5px;font-weight:500">Plafond prêt</p>
      <p style="font-size:14px;font-weight:600;color:#D4A017">{{ number_format($user->plafond_pret, 0, ',', ' ') }}<br><span style="font-size:10px;color:#9FC0A8">FCFA</span></p>
    </div>
  </div>

  {{-- Formulaire --}}
  <div class="profil-card">
    <p class="profil-section-title">
      <span style="color:#D4A017">✏️</span> Modifier mes informations
    </p>

    <form action="{{ route('br.membre.profil.update') }}" method="POST" enctype="multipart/form-data">
      @csrf @method('PUT')

      <div style="margin-bottom:13px">
        <label class="profil-label">Nom complet</label>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
          <input type="text" name="nom" value="{{ $user->nom }}" required placeholder="Nom" class="profil-input">
          <input type="text" name="prenom" value="{{ $user->prenom }}" required placeholder="Prénom" class="profil-input">
        </div>
      </div>

      <div style="margin-bottom:13px">
        <label class="profil-label">Email</label>
        <input type="email" name="email" value="{{ $user->email }}" class="profil-input">
      </div>

      <div style="margin-bottom:13px">
        <label class="profil-label">WhatsApp</label>
        <input type="text" name="whatsapp" value="{{ $user->whatsapp }}" class="profil-input">
      </div>

      <div style="margin-bottom:13px">
        <label class="profil-label">Ville</label>
        <input type="text" name="ville" value="{{ $user->ville }}" class="profil-input">
      </div>

      <div style="margin-bottom:13px">
        <label class="profil-label">Bio</label>
        <textarea name="bio" rows="3" maxlength="500" class="profil-input" style="resize:none"
                  placeholder="Quelques mots sur vous...">{{ $user->bio }}</textarea>
        <p style="font-size:10px;color:#9FC0A8;margin-top:4px">Maximum 500 caractères</p>
      </div>

      <div style="margin-bottom:18px">
        <label class="profil-label">Photo de profil</label>
        <label style="display:block;background:#F0F4F1;border:1.5px dashed #9FC0A8;border-radius:10px;padding:16px;text-align:center;cursor:pointer">
          <span style="font-size:22px;display:block;margin-bottom:5px;color:#2D6A4F">↑</span>
          <span style="font-size:12px;color:#5A8A6A;display:block">Cliquez pour choisir une photo</span>
          <span style="font-size:10px;color:#9FC0A8;display:block;margin-top:3px">JPG, PNG — max 2 Mo</span>
          <input type="file" name="photo" accept="image/*" style="display:none">
        </label>
      </div>

      <button type="submit"
              style="background:#1B4332;color:#D4A017;border:none;border-radius:12px;padding:13px 24px;font-size:14px;font-weight:600;cursor:pointer;width:100%">
        💾 Sauvegarder les modifications
      </button>
    </form>
  </div>

  {{-- Parrainage --}}
  <div class="profil-card">
    <p class="profil-section-title">
      <span style="color:#D4A017">🤝</span> Mon réseau de parrainage
    </p>

    {{-- Lien de parrainage --}}
    <div style="background:#1B4332;border-radius:12px;padding:16px;margin-bottom:18px">
      <p style="font-size:10px;color:#D4A017;margin-bottom:8px;font-weight:600;letter-spacing:.5px">MON LIEN DE PARRAINAGE</p>
      <div style="background:rgba(255,255,255,.1);border-radius:8px;padding:10px;margin-bottom:10px">
        <p style="font-size:11px;color:#9FC0A8;font-family:monospace;word-break:break-all">{{ $lienParrainage }}</p>
      </div>
      <button onclick="navigator.clipboard.writeText('{{ $lienParrainage }}').then(()=>alert('✓ Lien copié !'))"
              style="background:#D4A017;color:#1B4332;border:none;border-radius:10px;padding:10px;font-size:12px;font-weight:600;cursor:pointer;width:100%">
        📋 Copier le lien
      </button>
      <p style="font-size:10px;color:#9FC0A8;margin-top:9px">Partagez ce lien — gagnez des avantages pour chaque filleul actif !</p>
    </div>

    {{-- Mon parrain --}}
    @if($user->parrain)
    <p style="font-size:12px;color:#5A8A6A;margin-bottom:9px;font-weight:500">⭐ Mon parrain</p>
    <div style="background:#F0F4F1;border-radius:10px;padding:13px;display:flex;align-items:center;gap:12px;margin-bottom:18px;border:0.5px solid #d0ddd6">
      <div style="width:40px;height:40px;border-radius:50%;background:#2D6A4F;display:flex;align-items:center;justify-content:center;color:#D4A017;font-size:16px;font-weight:700;flex-shrink:0">
        {{ substr($user->parrain->parrain->prenom ?? 'P', 0, 1) }}
      </div>
      <div>
        <p style="font-size:14px;font-weight:600;color:#1B4332">{{ $user->parrain->parrain->nom_complet ?? '—' }}</p>
        <p style="font-size:11px;color:#5A8A6A">Mon référent</p>
      </div>
    </div>
    @endif

    {{-- Filleuls --}}
    @if($user->filleuls->count())
      <p style="font-size:12px;color:#5A8A6A;margin-bottom:10px;font-weight:500">👥 Mes filleuls ({{ $user->filleuls->count() }})</p>
      @foreach($user->filleuls as $f)
      <div class="profil-filleul">
        <div style="width:32px;height:32px;border-radius:50%;background:{{ $f->statut === 'actif' ? '#E8F5EC' : '#F0F4F1' }};display:flex;align-items:center;justify-content:center;color:{{ $f->statut === 'actif' ? '#1B4332' : '#9FC0A8' }};font-size:13px;font-weight:700;flex-shrink:0">
          {{ substr($f->filleul->prenom ?? '?', 0, 1) }}
        </div>
        <div style="flex:1">
          <p style="font-size:13px;font-weight:500;color:#1B4332">{{ $f->filleul->prenom ?? '—' }} {{ $f->filleul->nom ?? '' }}</p>
          <p style="font-size:10px;color:{{ $f->statut === 'actif' ? '#2D6A4F' : '#9FC0A8' }};font-weight:500">
            {{ $f->statut === 'actif' ? '✓ Actif' : '○ En attente' }}
          </p>
        </div>
      </div>
      @endforeach
    @else
      <div style="text-align:center;padding:28px 20px;background:#F0F4F1;border-radius:12px;border:0.5px solid #d0ddd6">
        <p style="font-size:32px;margin-bottom:8px">👥</p>
        <p style="font-size:14px;font-weight:600;color:#1B4332;margin-bottom:4px">Aucun filleul pour le moment</p>
        <p style="font-size:12px;color:#5A8A6A">Partagez votre lien pour inviter des amis !</p>
      </div>
    @endif
  </div>

  {{-- Zone danger --}}
  <div style="background:#fff;border-radius:16px;padding:20px;margin-bottom:30px;border:1px solid #f5c5c5">
    <p style="font-size:16px;font-weight:700;color:#c0392b;margin-bottom:5px">⚠️ Zone de danger</p>
    <p style="font-size:12px;color:#888;margin-bottom:15px">Cette action est irréversible. Votre compte sera désactivé définitivement.</p>
    <button onclick="document.getElementById('modal-supprimer').style.display='flex'"
            style="background:white;color:#c0392b;border:1.5px solid #c0392b;border-radius:12px;padding:12px;font-size:13px;font-weight:600;cursor:pointer;width:100%">
      🗑️ Supprimer mon compte
    </button>
  </div>

</div>

{{-- Modale --}}
<div id="modal-supprimer"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.55);z-index:9999;align-items:center;justify-content:center;padding:20px">
  <div style="background:white;border-radius:20px;padding:28px 22px;max-width:340px;width:100%;text-align:center;box-shadow:0 10px 40px rgba(0,0,0,0.2)">
    <div style="width:56px;height:56px;border-radius:50%;background:#fef0ee;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;font-size:26px">🗑️</div>
    <h3 style="font-size:18px;font-weight:700;color:#1B4332;margin-bottom:8px">Supprimer mon compte ?</h3>
    <p style="font-size:13px;color:#888;margin-bottom:22px;line-height:1.6">
      Cette action désactivera votre accès de façon permanente. Vous serez déconnecté immédiatement.
    </p>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
      <button onclick="document.getElementById('modal-supprimer').style.display='none'"
              style="background:#F0F4F1;color:#1B4332;border:none;border-radius:12px;padding:13px;font-size:14px;font-weight:600;cursor:pointer">
        Annuler
      </button>
      <form action="{{ route('br.membre.supprimer.compte') }}" method="POST" style="margin:0">
        @csrf @method('DELETE')
        <button type="submit"
                style="background:#c0392b;color:white;border:none;border-radius:12px;padding:13px;font-size:14px;font-weight:600;cursor:pointer;width:100%">
          Confirmer
        </button>
      </form>
    </div>
  </div>
</div>

@endsection