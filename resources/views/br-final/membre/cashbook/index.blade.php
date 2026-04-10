@extends('br-final.layouts.app')
@section('title', 'Cahier de caisse')
@section('content')
<div class="p-4">

<a href="{{ route('br.membre.dashboard') }}" 
   style="font-size:13px;color:#888;display:inline-block;margin-bottom:10px;padding-top:8px">
   ← Retour
</a>
    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:16px;padding-top:8px;flex-wrap:wrap;gap:10px">
        <div>
            <h1 style="font-family:Syne,sans-serif;font-size:24px;font-weight:700">Cahier de caisse</h1>
            <p style="font-size:13px;color:#888;margin-top:2px">{{ $current->libelle_mois }}</p>
        </div>
        <div style="display:flex;gap:8px">
            @if(!$current->valide)
            <form action="{{ route('br.membre.cashbook.valider', $current) }}" method="POST" onsubmit="return confirm('Valider définitivement ce cahier ?')">
                @csrf
                <button style="padding:10px 14px;border:1px solid #e5e3dc;border-radius:10px;font-size:13px;color:#444;background:#fff">✓ Valider</button>
            </form>
            @endif
            <a href="{{ route('br.membre.cashbook.pdf', $current) }}" class="btn-primary" style="padding:10px 14px;font-size:13px">⬇ PDF</a>
        </div>
    </div>

    {{-- Totaux --}}
    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;margin-bottom:16px">
        <div class="card" style="padding:12px">
            <p style="font-size:10px;color:#888;margin-bottom:4px">Entrées</p>
            <p style="font-family:Syne,sans-serif;font-size:18px;font-weight:700;color:#2d7a22">{{ number_format($current->total_entrees??0,0,',',' ') }}</p>
            <p style="font-size:10px;color:#aaa">FCFA</p>
        </div>
        <div class="card" style="padding:12px">
            <p style="font-size:10px;color:#888;margin-bottom:4px">Sorties</p>
            <p style="font-family:Syne,sans-serif;font-size:18px;font-weight:700;color:#c0302a">{{ number_format($current->total_sorties??0,0,',',' ') }}</p>
            <p style="font-size:10px;color:#aaa">FCFA</p>
        </div>
        <div class="card" style="padding:12px;border-color:{{ ($current->solde??0)>=0?'#b8e0b0':'#f5b8b8' }}">
            <p style="font-size:10px;color:#888;margin-bottom:4px">Solde net</p>
            <p style="font-family:Syne,sans-serif;font-size:18px;font-weight:700;color:{{ ($current->solde??0)>=0?'#2d7a22':'#c0302a' }}">{{ number_format($current->solde??0,0,',',' ') }}</p>
            <p style="font-size:10px;color:#aaa">{{ $current->valide?'Validé ✓':'FCFA' }}</p>
        </div>
    </div>

    {{-- Ajouter --}}
    @if(!$current->valide)
    <div class="card p-4 mb-3">
        <h2 style="font-family:Syne,sans-serif;font-size:16px;font-weight:700;margin-bottom:12px">Ajouter une ligne</h2>
        <form action="{{ route('br.membre.cashbook.store') }}" method="POST">
            @csrf
            <input type="hidden" name="date" value="{{ date('Y-m-d') }}">

            <label style="font-size:12px;color:#666;display:block;margin-bottom:6px">Libellé</label>
            <input type="text" name="libelle" required placeholder="Description de l'opération" class="input" style="margin-bottom:10px">

            <label style="font-size:12px;color:#666;display:block;margin-bottom:6px">Type</label>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:10px">
                <label style="display:flex;align-items:center;gap:8px;background:#eaf5e6;border:1px solid #b8e0b0;border-radius:10px;padding:12px;cursor:pointer">
                    <input type="radio" name="type" value="entree" checked>
                    <span style="font-size:14px">📈 Entrée</span>
                </label>
                <label style="display:flex;align-items:center;gap:8px;background:#fce8e8;border:1px solid #f5b8b8;border-radius:10px;padding:12px;cursor:pointer">
                    <input type="radio" name="type" value="sortie">
                    <span style="font-size:14px">📉 Sortie</span>
                </label>
            </div>

            <label style="font-size:12px;color:#666;display:block;margin-bottom:6px">Montant (FCFA)</label>
            <input type="number" name="montant" min="1" required placeholder="0" class="input" style="margin-bottom:10px">

            <label style="font-size:12px;color:#666;display:block;margin-bottom:6px">Catégorie</label>
            <input type="text" name="categorie" placeholder="Ex: Vente, Achat..." class="input" style="margin-bottom:14px">

            <button type="submit" class="btn-primary" style="width:100%">Ajouter</button>
        </form>
    </div>
    @endif

    {{-- Transactions --}}
    <div class="card p-4 mb-3">
        <h2 style="font-family:Syne,sans-serif;font-size:16px;font-weight:700;margin-bottom:12px">Transactions du mois</h2>
        @forelse($entries as $e)
        <div style="padding:10px 0;border-bottom:0.5px solid #e5e3dc;display:flex;justify-content:space-between;align-items:flex-start">
            <div>
                <p style="font-size:14px;font-weight:500">{{ $e->libelle }}</p>
                <p style="font-size:11px;color:#aaa;margin-top:2px">{{ \Carbon\Carbon::parse($e->date)->format('d/m') }}{{ $e->categorie?' · '.$e->categorie:'' }}</p>
            </div>
            <p style="font-size:14px;font-weight:600;color:{{ $e->type==='entree'?'#2d7a22':'#c0302a' }};white-space:nowrap;margin-left:12px">
                {{ $e->type==='entree'?'+':'-' }}{{ number_format($e->montant,0,',',' ') }}
            </p>
        </div>
        @empty
            <p style="font-size:13px;color:#aaa;text-align:center;padding:20px 0">Aucune transaction ce mois</p>
        @endforelse
    </div>

    {{-- Cahiers précédents --}}
    @if($cashbooks->count() > 1)
    <div class="card p-4">
        <h2 style="font-family:Syne,sans-serif;font-size:16px;font-weight:700;margin-bottom:12px">Cahiers précédents</h2>
        <div style="display:flex;flex-wrap:wrap;gap:8px">
            @foreach($cashbooks as $cb)
                @if($cb->id !== $current->id)
                <a href="{{ route('br.membre.cashbook.show', $cb) }}" style="padding:8px 14px;border:0.5px solid #e5e3dc;border-radius:20px;font-size:13px;color:#444">
                    {{ $cb->libelle_mois }} {{ $cb->valide?'✓':'' }}
                </a>
                @endif
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection