@extends('br-final.layouts.app')
@section('title', 'Mon Profil')
@section('content')
<div class="p-4">

<a href="{{ route('br.membre.dashboard') }}" 
   style="font-size:13px;color:#888;display:inline-block;margin-bottom:10px;padding-top:8px">
   ← Retour
</a>

    <div class="mb-5 pt-2">
        <h1 style="font-family:Syne,sans-serif;font-size:24px;font-weight:700">Mon Profil</h1>
        <p style="font-size:13px;color:#888;margin-top:2px">Gérez vos informations personnelles</p>
    </div>

    <div style="display:grid;grid-template-columns:1fr 2fr;gap:16px">
        <!-- Photo + info principale -->
        <div class="card" style="padding:16px;text-align:center">
            <div style="margin-bottom:12px">
                @if($user->photo)
                    <img src="{{ Storage::url($user->photo) }}" style="width:80px;height:80px;border-radius:50%;object-fit:cover;margin:0 auto;border:2px solid #c2601a">
                @else
                    <div style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,#e07a2c,#c2601a);display:flex;align-items:center;justify-content:center;margin:0 auto;color:white;font-size:28px;font-weight:bold">
                        {{ substr($user->prenom, 0, 1) }}
                    </div>
                @endif
            </div>
            <h2 style="font-family:Syne,sans-serif;font-size:16px;font-weight:700;margin-bottom:4px">{{ $user->nom_complet }}</h2>
            <p style="font-size:12px;color:#888;margin-bottom:8px">{{ $user->telephone }}</p>
            <span style="display:inline-block;padding:4px 10px;border-radius:20px;font-size:11px;background:{{ $user->estMembre() ? '#e6f4ea' : '#fef0e6' }};color:{{ $user->estMembre() ? '#2d7a22' : '#c2601a' }}">
                {{ $user->statut }}
            </span>

            <div style="margin-top:16px;text-align:left;border-top:1px solid #e5e3dc;padding-top:14px">
                <div style="display:flex;justify-content:space-between;margin-bottom:10px">
                    <span style="font-size:11px;color:#888">Membre depuis</span>
                    <span style="font-size:12px;font-weight:500">{{ $user->created_at->format('d/m/Y') }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;margin-bottom:10px">
                    <span style="font-size:11px;color:#888">Filleuls actifs</span>
                    <span style="font-size:12px;font-weight:600;color:#c2601a">{{ $user->nb_filleuls_actifs }}</span>
                </div>
                <div style="display:flex;justify-content:space-between">
                    <span style="font-size:11px;color:#888">Plafond prêt</span>
                    <span style="font-size:12px;font-weight:600">{{ number_format($user->plafond_pret, 0, ',', ' ') }} FCFA</span>
                </div>
            </div>
        </div>

        <!-- Formulaire de modification -->
        <div class="card" style="padding:16px">
            <h2 style="font-family:Syne,sans-serif;font-size:16px;font-weight:700;margin-bottom:14px">Modifier mes informations</h2>
            <form action="{{ route('br.membre.profil.update') }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px">
                    <div>
                        <label style="display:block;font-size:11px;color:#888;margin-bottom:4px">Nom</label>
                        <input type="text" name="nom" value="{{ $user->nom }}" required style="width:100%;background:#f5f4f0;border:none;border-radius:10px;padding:10px 12px;font-size:13px;outline:none">
                    </div>
                    <div>
                        <label style="display:block;font-size:11px;color:#888;margin-bottom:4px">Prénom</label>
                        <input type="text" name="prenom" value="{{ $user->prenom }}" required style="width:100%;background:#f5f4f0;border:none;border-radius:10px;padding:10px 12px;font-size:13px;outline:none">
                    </div>
                </div>

                <div style="margin-bottom:12px">
                    <label style="display:block;font-size:11px;color:#888;margin-bottom:4px">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" style="width:100%;background:#f5f4f0;border:none;border-radius:10px;padding:10px 12px;font-size:13px;outline:none">
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px">
                    <div>
                        <label style="display:block;font-size:11px;color:#888;margin-bottom:4px">WhatsApp</label>
                        <input type="text" name="whatsapp" value="{{ $user->whatsapp }}" style="width:100%;background:#f5f4f0;border:none;border-radius:10px;padding:10px 12px;font-size:13px;outline:none">
                    </div>
                    <div>
                        <label style="display:block;font-size:11px;color:#888;margin-bottom:4px">Ville</label>
                        <input type="text" name="ville" value="{{ $user->ville }}" style="width:100%;background:#f5f4f0;border:none;border-radius:10px;padding:10px 12px;font-size:13px;outline:none">
                    </div>
                </div>

                <div style="margin-bottom:12px">
                    <label style="display:block;font-size:11px;color:#888;margin-bottom:4px">Bio</label>
                    <textarea name="bio" rows="3" maxlength="500" style="width:100%;background:#f5f4f0;border:none;border-radius:10px;padding:10px 12px;font-size:13px;outline:none;resize:none;font-family:inherit" placeholder="Quelques mots sur vous...">{{ $user->bio }}</textarea>
                </div>

                <div style="margin-bottom:16px">
                    <label style="display:block;font-size:11px;color:#888;margin-bottom:4px">Photo de profil</label>
                    <input type="file" name="photo" accept="image/*" style="font-size:12px;color:#888">
                </div>

                <button type="submit" style="background:#c2601a;color:white;border:none;border-radius:12px;padding:10px 20px;font-size:13px;font-weight:600;cursor:pointer;width:100%">Sauvegarder</button>
            </form>
        </div>
    </div>

    <!-- Parrainage -->
    <div class="card" style="padding:16px;margin-top:16px">
        <h2 style="font-family:Syne,sans-serif;font-size:16px;font-weight:700;margin-bottom:12px">🤝 Mon réseau de parrainage</h2>
        
        <div style="background:#f5f4f0;border-radius:10px;padding:12px;margin-bottom:16px;display:flex;align-items:center;gap:10px">
            <div style="flex:1">
                <p style="font-size:10px;color:#888;margin-bottom:4px">Mon lien de parrainage</p>
                <p style="font-size:12px;color:#c2601a;font-family:monospace;word-break:break-all">{{ $lienParrainage }}</p>
            </div>
            <button onclick="navigator.clipboard.writeText('{{ $lienParrainage }}').then(()=>alert('Lien copié !'))" style="background:#c2601a;color:white;border:none;border-radius:10px;padding:6px 14px;font-size:12px;cursor:pointer;flex-shrink:0">Copier</button>
        </div>

        @if($user->parrain)
            <div style="margin-bottom:14px">
                <p style="font-size:11px;color:#888;margin-bottom:6px">Mon parrain</p>
                <div style="background:#f5f4f0;border-radius:10px;padding:10px;display:flex;align-items:center;gap:8px">
                    <div style="width:28px;height:28px;border-radius:50%;background:#fef0e6;display:flex;align-items:center;justify-content:center;color:#c2601a;font-size:12px;font-weight:bold">{{ substr($user->parrain->parrain->prenom ?? 'P', 0, 1) }}</div>
                    <span style="font-size:13px">{{ $user->parrain->parrain->nom_complet ?? '—' }}</span>
                </div>
            </div>
        @endif

        @if($user->filleuls->count())
            <p style="font-size:11px;color:#888;margin-bottom:8px">Mes filleuls ({{ $user->filleuls->count() }})</p>
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px">
                @foreach($user->filleuls as $f)
                    <div style="background:#f5f4f0;border-radius:10px;padding:8px;display:flex;align-items:center;gap:6px">
                        <div style="width:24px;height:24px;border-radius:50%;background:#e6f4ea;display:flex;align-items:center;justify-content:center;color:#2d7a22;font-size:10px;font-weight:bold">{{ substr($f->filleul->prenom ?? '?', 0, 1) }}</div>
                        <div>
                            <p style="font-size:11px;font-weight:500;margin-bottom:2px">{{ $f->filleul->prenom ?? '—' }}</p>
                            <p style="font-size:9px;color:{{ $f->statut === 'actif' ? '#2d7a22' : '#aaa' }}">{{ $f->statut }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection