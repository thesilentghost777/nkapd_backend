@extends('br-final.layouts.app')
@section('title', 'Business')
@section('content')
<div class="p-4">

<a href="{{ route('br.membre.dashboard') }}" 
   style="font-size:13px;color:#888;display:inline-block;margin-bottom:10px;padding-top:8px">
   ← Retour
</a>
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;padding-top:8px">
        <div>
            <h1 style="font-family:Syne,sans-serif;font-size:24px;font-weight:700">Business Room</h1>
            <p style="font-size:13px;color:#888;margin-top:2px">Marketplace de la communauté</p>
        </div>
        <button onclick="document.getElementById('modal-publish').style.display='flex'" class="btn-primary" style="padding:10px 16px;font-size:13px">+ Publier</button>
    </div>

    {{-- Catégories --}}
    <div style="display:flex;gap:8px;overflow-x:auto;padding-bottom:8px;margin-bottom:14px;-webkit-overflow-scrolling:touch">
        <a href="{{ route('br.membre.business.index') }}" style="flex-shrink:0;padding:8px 16px;border-radius:20px;font-size:13px;{{ !request('cat')?'background:#c2601a;color:#fff':'background:#fff;color:#666;border:0.5px solid #e5e3dc' }}">Tout</a>
        @foreach($categories as $cat)
        <a href="{{ route('br.membre.business.index',['cat'=>$cat]) }}" style="flex-shrink:0;padding:8px 16px;border-radius:20px;font-size:13px;{{ request('cat')===$cat?'background:#c2601a;color:#fff':'background:#fff;color:#666;border:0.5px solid #e5e3dc' }}">{{ $cat }}</a>
        @endforeach
    </div>

    {{-- Grille produits --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:16px">
        @forelse($items as $item)
        <a href="{{ route('br.membre.business.show', $item) }}" class="card" style="display:block;overflow:hidden">
            <div style="aspect-ratio:1;background:#f5f4f0;overflow:hidden">
                @if($item->image)
                    <img src="{{ Storage::url($item->image) }}" alt="{{ $item->titre }}" style="width:100%;height:100%;object-fit:cover">
                @else
                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:40px">🛍</div>
                @endif
            </div>
            <div style="padding:10px">
                <p style="font-size:11px;color:#c2601a;font-weight:500;margin-bottom:3px">{{ $item->categorie }}</p>
                <p style="font-size:13px;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin-bottom:2px">{{ $item->titre }}</p>
                <p style="font-size:11px;color:#aaa;margin-bottom:6px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ Str::limit($item->description,50) }}</p>
                <div style="display:flex;justify-content:space-between;align-items:center">
                    @if($item->prix)
                        <p style="font-family:Syne,sans-serif;font-size:13px;font-weight:700;color:#c2601a">{{ number_format($item->prix,0,',',' ') }} FCFA</p>
                    @else
                        <p style="font-size:11px;color:#aaa">Sur demande</p>
                    @endif
                    <span style="font-size:10px;color:#ccc">{{ $item->vues }} vues</span>
                </div>
            </div>
        </a>
        @empty
        <div style="grid-column:span 2;text-align:center;padding:40px 0">
            <p style="font-size:40px;margin-bottom:8px">🏪</p>
            <p style="font-size:13px;color:#aaa">Aucune publication pour le moment</p>
        </div>
        @endforelse
    </div>

    {{ $items->links() }}

    {{-- Mes publications --}}
    @if($mesItems->count())
    <div class="card p-4">
        <h2 style="font-family:Syne,sans-serif;font-size:16px;font-weight:700;margin-bottom:12px">Mes publications</h2>
        @foreach($mesItems as $item)
        <div style="padding:12px 0;border-bottom:0.5px solid #e5e3dc;display:flex;justify-content:space-between;align-items:center">
            <div>
                <p style="font-size:14px;font-weight:500">{{ $item->titre }}</p>
                <p style="font-size:12px;color:#aaa;margin-top:2px">{{ $item->vues }} vues · {{ $item->categorie }}</p>
            </div>
            <form action="{{ route('br.membre.business.destroy', $item) }}" method="POST" onsubmit="return confirm('Supprimer ?')">
                @csrf @method('DELETE')
                <button style="font-size:12px;color:#c0302a;background:none;border:none;padding:8px">Supprimer</button>
            </form>
        </div>
        @endforeach
    </div>
    @endif

</div>

{{-- Modal publier --}}
<div id="modal-publish" style="display:none;position:fixed;inset:0;z-index:50;align-items:flex-end;background:rgba(0,0,0,.5)">
    <div style="background:#fff;border-radius:20px 20px 0 0;padding:20px 16px;width:100%;max-height:90vh;overflow-y:auto">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
            <h2 style="font-family:Syne,sans-serif;font-size:18px;font-weight:700">Publier une annonce</h2>
            <button onclick="document.getElementById('modal-publish').style.display='none'" style="font-size:20px;color:#888;background:none;border:none;padding:4px 8px">✕</button>
        </div>
        <form action="{{ route('br.membre.business.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label style="font-size:12px;color:#666;display:block;margin-bottom:6px">Titre</label>
            <input type="text" name="titre" required maxlength="255" placeholder="Ex: Sacs en cuir artisanaux" class="input" style="margin-bottom:10px">

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:10px">
                <div>
                    <label style="font-size:12px;color:#666;display:block;margin-bottom:6px">Catégorie</label>
                    <input type="text" name="categorie" required placeholder="Mode, Alim..." class="input">
                </div>
                <div>
                    <label style="font-size:12px;color:#666;display:block;margin-bottom:6px">Prix (FCFA)</label>
                    <input type="number" name="prix" min="0" placeholder="0 = sur demande" class="input">
                </div>
            </div>

            <label style="font-size:12px;color:#666;display:block;margin-bottom:6px">Description</label>
            <textarea name="description" rows="3" required placeholder="Décrivez votre produit..." class="input" style="margin-bottom:10px;resize:none"></textarea>

            <label style="font-size:12px;color:#666;display:block;margin-bottom:6px">WhatsApp</label>
            <input type="text" name="whatsapp" placeholder="6XXXXXXXX" class="input" style="margin-bottom:10px">

            <label style="font-size:12px;color:#666;display:block;margin-bottom:6px">Image (optionnel)</label>
            <input type="file" name="image" accept="image/*" style="font-size:13px;margin-bottom:14px">

            <button type="submit" class="btn-primary" style="width:100%">Publier l'annonce</button>
        </form>
    </div>
</div>
@endsection