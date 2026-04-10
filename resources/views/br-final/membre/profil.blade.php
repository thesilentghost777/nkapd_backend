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

    <!-- Section Photo + Identité -->
    <div class="card" style="padding:20px;margin-bottom:16px;text-align:center">
        <div style="margin-bottom:16px">
            @if($user->photo)
                <img src="{{ Storage::url($user->photo) }}" style="width:100px;height:100px;border-radius:50%;object-fit:cover;margin:0 auto;border:3px solid #c2601a">
            @else
                <div style="width:100px;height:100px;border-radius:50%;background:linear-gradient(135deg,#e07a2c,#c2601a);display:flex;align-items:center;justify-content:center;margin:0 auto;color:white;font-size:36px;font-weight:bold">
                    {{ substr($user->prenom, 0, 1) }}
                </div>
            @endif
        </div>
        
        <h2 style="font-family:Syne,sans-serif;font-size:20px;font-weight:700;margin-bottom:6px">{{ $user->nom_complet }}</h2>
        <p style="font-size:13px;color:#888;margin-bottom:10px">{{ $user->telephone }}</p>
        
        <span style="display:inline-block;padding:5px 14px;border-radius:20px;font-size:12px;background:{{ $user->estMembre() ? '#e6f4ea' : '#fef0e6' }};color:{{ $user->estMembre() ? '#2d7a22' : '#c2601a' }}">
            {{ $user->statut }}
        </span>
    </div>

    <!-- Statistiques clés -->
    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;margin-bottom:20px">
        <div class="card" style="padding:14px;text-align:center">
            <p style="font-size:11px;color:#888;margin-bottom:6px">Membre depuis</p>
            <p style="font-size:15px;font-weight:600">{{ $user->created_at->format('d/m/Y') }}</p>
        </div>
        <div class="card" style="padding:14px;text-align:center">
            <p style="font-size:11px;color:#888;margin-bottom:6px">Filleuls actifs</p>
            <p style="font-size:18px;font-weight:700;color:#c2601a">{{ $user->nb_filleuls_actifs }}</p>
        </div>
        <div class="card" style="padding:14px;text-align:center">
            <p style="font-size:11px;color:#888;margin-bottom:6px">Plafond prêt</p>
            <p style="font-size:14px;font-weight:600">{{ number_format($user->plafond_pret, 0, ',', ' ') }}<br><span style="font-size:10px">FCFA</span></p>
        </div>
    </div>

    <!-- Formulaire de modification -->
    <div class="card" style="padding:20px;margin-bottom:20px">
        <h2 style="font-family:Syne,sans-serif;font-size:18px;font-weight:700;margin-bottom:18px;padding-bottom:10px;border-bottom:2px solid #f0ede8">✏️ Modifier mes informations</h2>
        
        <form action="{{ route('br.membre.profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            
            <div style="margin-bottom:15px">
                <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;font-weight:500">Nom complet</label>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                    <input type="text" name="nom" value="{{ $user->nom }}" required placeholder="Nom" style="width:100%;background:#f5f4f0;border:none;border-radius:10px;padding:12px;font-size:13px;outline:none">
                    <input type="text" name="prenom" value="{{ $user->prenom }}" required placeholder="Prénom" style="width:100%;background:#f5f4f0;border:none;border-radius:10px;padding:12px;font-size:13px;outline:none">
                </div>
            </div>

            <div style="margin-bottom:15px">
                <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;font-weight:500">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" style="width:100%;background:#f5f4f0;border:none;border-radius:10px;padding:12px;font-size:13px;outline:none">
            </div>

            <div style="margin-bottom:15px">
                <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;font-weight:500">WhatsApp</label>
                <input type="text" name="whatsapp" value="{{ $user->whatsapp }}" style="width:100%;background:#f5f4f0;border:none;border-radius:10px;padding:12px;font-size:13px;outline:none">
            </div>

            <div style="margin-bottom:15px">
                <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;font-weight:500">Ville</label>
                <input type="text" name="ville" value="{{ $user->ville }}" style="width:100%;background:#f5f4f0;border:none;border-radius:10px;padding:12px;font-size:13px;outline:none">
            </div>

            <div style="margin-bottom:15px">
                <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;font-weight:500">Bio</label>
                <textarea name="bio" rows="3" maxlength="500" style="width:100%;background:#f5f4f0;border:none;border-radius:10px;padding:12px;font-size:13px;outline:none;resize:none;font-family:inherit" placeholder="Quelques mots sur vous...">{{ $user->bio }}</textarea>
                <p style="font-size:10px;color:#aaa;margin-top:4px">Maximum 500 caractères</p>
            </div>

            <div style="margin-bottom:20px">
                <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;font-weight:500">Photo de profil</label>
                <input type="file" name="photo" accept="image/*" style="font-size:12px;color:#888;padding:8px 0">
                <p style="font-size:10px;color:#aaa;margin-top:4px">Formats acceptés : JPG, PNG (max 2 Mo)</p>
            </div>

            <button type="submit" style="background:#c2601a;color:white;border:none;border-radius:12px;padding:12px 24px;font-size:14px;font-weight:600;cursor:pointer;width:100%">💾 Sauvegarder les modifications</button>
        </form>
    </div>

    <!-- Section Parrainage -->
    <div class="card" style="padding:20px;margin-bottom:20px">
        <h2 style="font-family:Syne,sans-serif;font-size:18px;font-weight:700;margin-bottom:18px;padding-bottom:10px;border-bottom:2px solid #f0ede8">🤝 Mon réseau de parrainage</h2>
        
        <!-- Lien de parrainage -->
        <div style="background:#fef0e6;border-radius:12px;padding:16px;margin-bottom:20px">
            <p style="font-size:11px;color:#c2601a;margin-bottom:8px;font-weight:600">🔗 MON LIEN DE PARRAINAGE</p>
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">
                <p style="font-size:12px;color:#c2601a;font-family:monospace;word-break:break-all;flex:1;background:white;padding:10px;border-radius:8px">{{ $lienParrainage }}</p>
                <button onclick="navigator.clipboard.writeText('{{ $lienParrainage }}').then(()=>alert('✓ Lien copié !'))" style="background:#c2601a;color:white;border:none;border-radius:10px;padding:10px 18px;font-size:12px;cursor:pointer;font-weight:600">Copier</button>
            </div>
            <p style="font-size:11px;color:#888;margin-top:10px">Partagez ce lien avec vos amis. Gagnez des avantages pour chaque filleul actif !</p>
        </div>

        <!-- Mon parrain -->
        @if($user->parrain)
        <div style="margin-bottom:20px">
            <p style="font-size:13px;color:#888;margin-bottom:10px;font-weight:500">⭐ Mon parrain</p>
            <div style="background:#f5f4f0;border-radius:10px;padding:14px;display:flex;align-items:center;gap:12px">
                <div style="width:45px;height:45px;border-radius:50%;background:#fef0e6;display:flex;align-items:center;justify-content:center;color:#c2601a;font-size:18px;font-weight:bold">
                    {{ substr($user->parrain->parrain->prenom ?? 'P', 0, 1) }}
                </div>
                <div>
                    <p style="font-size:15px;font-weight:600">{{ $user->parrain->parrain->nom_complet ?? '—' }}</p>
                    <p style="font-size:11px;color:#888">Mon référent</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Mes filleuls -->
        @if($user->filleuls->count())
        <div>
            <p style="font-size:13px;color:#888;margin-bottom:12px;font-weight:500">👥 Mes filleuls ({{ $user->filleuls->count() }})</p>
            <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(140px, 1fr));gap:10px">
                @foreach($user->filleuls as $f)
                <div style="background:#f5f4f0;border-radius:10px;padding:10px;display:flex;align-items:center;gap:10px">
                    <div style="width:32px;height:32px;border-radius:50%;background:#e6f4ea;display:flex;align-items:center;justify-content:center;color:#2d7a22;font-size:13px;font-weight:bold">
                        {{ substr($f->filleul->prenom ?? '?', 0, 1) }}
                    </div>
                    <div style="flex:1">
                        <p style="font-size:13px;font-weight:500;margin-bottom:3px">{{ $f->filleul->prenom ?? '—' }} {{ $f->filleul->nom ?? '' }}</p>
                        <p style="font-size:10px;color:{{ $f->statut === 'actif' ? '#2d7a22' : '#aaa' }};font-weight:500">
                            {{ $f->statut === 'actif' ? '✓ Actif' : '○ En attente' }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div style="text-align:center;padding:30px 20px;background:#f5f4f0;border-radius:12px">
            <p style="font-size:36px;margin-bottom:8px">👥</p>
            <p style="font-size:14px;font-weight:600;margin-bottom:5px">Aucun filleul pour le moment</p>
            <p style="font-size:12px;color:#888">Partagez votre lien de parrainage pour inviter des amis !</p>
        </div>
        @endif
    </div>

</div>
@endsection