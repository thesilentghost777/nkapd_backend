@extends('br-final.layouts.app')
@section('title', 'Assistance')
@section('content')
<div class="p-4">

<a href="{{ route('br.membre.dashboard') }}" 
   style="font-size:13px;color:#888;display:inline-block;margin-bottom:10px;padding-top:8px">
   ← Retour
</a>

    <div class="mb-5 pt-2">
        <h1 style="font-family:Syne,sans-serif;font-size:24px;font-weight:700">Assistance</h1>
        <p style="font-size:13px;color:#888;margin-top:2px">Soumettez vos demandes à l'équipe</p>
    </div>

    @if(!$aTontineActive)
        <div class="alert-warn mb-4">⚠ Vous devez avoir une tontine active pour soumettre une demande.</div>
    @else
    <div class="card p-4 mb-3">
        <h2 style="font-family:Syne,sans-serif;font-size:16px;font-weight:700;margin-bottom:14px">Nouvelle demande</h2>
        <form action="{{ route('br.membre.assistance.store') }}" method="POST">
            @csrf
            <label style="font-size:12px;color:#666;display:block;margin-bottom:6px">Type d'assistance</label>
            <select name="type" required class="input" style="margin-bottom:10px">
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
            <label style="font-size:12px;color:#666;display:block;margin-bottom:6px">Sujet</label>
            <input type="text" name="sujet" placeholder="Résumez votre demande" required maxlength="255" class="input" style="margin-bottom:10px">
            <label style="font-size:12px;color:#666;display:block;margin-bottom:6px">Description</label>
            <textarea name="description" rows="4" required placeholder="Décrivez votre situation..." class="input" style="margin-bottom:14px;resize:none"></textarea>
            <button type="submit" class="btn-primary" style="width:100%">Envoyer la demande</button>
        </form>
    </div>
    @endif

    <div class="card p-4">
        <h2 style="font-family:Syne,sans-serif;font-size:16px;font-weight:700;margin-bottom:12px">Mes demandes</h2>
        @forelse($demandes as $d)
        @php $icons=['maladie_grave'=>'🏥','sinistre'=>'🔥','invalidite'=>'♿','pret_bancaire'=>'🏦','juridique'=>'⚖️','managerial'=>'📊','marketing'=>'📢','mise_en_relation'=>'🤝']; @endphp
        <a href="{{ route('br.membre.assistance.show', $d) }}" style="display:flex;align-items:center;justify-content:space-between;padding:12px 0;border-bottom:0.5px solid #e5e3dc;text-decoration:none">
            <div style="display:flex;align-items:center;gap:10px">
                <div style="width:40px;height:40px;border-radius:10px;background:#fef0e6;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0">{{ $icons[$d->type]??'❓' }}</div>
                <div>
                    <p style="font-size:14px;font-weight:500;color:#1a1a1a">{{ $d->sujet }}</p>
                    <p style="font-size:11px;color:#aaa;margin-top:2px">{{ $d->created_at->diffForHumans() }}</p>
                </div>
            </div>
            @php $bc=['en_attente'=>'badge-yellow','en_cours'=>'badge-blue','resolu'=>'badge-green'][$d->statut]??'badge-yellow'; @endphp
            <span class="{{ $bc }}" style="flex-shrink:0;margin-left:8px">{{ ucfirst(str_replace('_',' ',$d->statut)) }}</span>
        </a>
        @empty
        <div style="text-align:center;padding:30px 0">
            <p style="font-size:36px;margin-bottom:8px">🛟</p>
            <p style="font-size:13px;color:#aaa">Aucune demande d'assistance</p>
        </div>
        @endforelse
    </div>

</div>
@endsection