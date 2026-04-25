@extends('br-final.layouts.app')
@section('title', 'Business')
@section('content')

{{-- Header --}}
<div style="padding:16px 20px 0;display:flex;align-items:center;justify-content:space-between">
    <div>
        <p style="font-size:11px;color:#aaa;font-weight:500;letter-spacing:.8px;text-transform:uppercase;margin-bottom:1px">Business Room</p>
        <p style="font-size:11px;color:#c2601a;font-weight:500;letter-spacing:.5px">COMMUNITY MARKETPLACE</p>
    </div>
    <div style="width:36px;height:36px;border-radius:50%;border:1px solid #ececec;display:flex;align-items:center;justify-content:center;font-size:16px;color:#1a1a1a">🔔</div>
</div>

<div class="p-4">

    <a href="{{ route('br.membre.dashboard') }}" style="font-size:13px;color:#888;display:inline-block;margin-bottom:16px">← Retour</a>

    {{-- Hero heading --}}
    <div style="margin-bottom:20px">
        <h1 style="font-family:Syne,sans-serif;font-size:32px;font-weight:600;color:#1a1a1a;line-height:1.1;margin-bottom:6px">Explorer les opportunités</h1>
        <p style="font-size:14px;color:#888;margin-bottom:16px">Connectez-vous avec la communauté et faites croître votre entreprise.</p>
        <button onclick="document.getElementById('modal-publish').style.display='flex'"
            style="width:100%;background:#c2601a;color:#fff;border:none;border-radius:14px;padding:15px;font-size:15px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px">
            ⊕ Publier
        </button>
    </div>

    {{-- Catégories --}}
    <div style="display:flex;gap:8px;overflow-x:auto;padding-bottom:10px;margin-bottom:20px;-webkit-overflow-scrolling:touch;scrollbar-width:none">
        <a href="{{ route('br.membre.business.index') }}"
            style="flex-shrink:0;padding:9px 20px;border-radius:22px;font-size:13px;font-weight:600;text-decoration:none;{{ !request('cat')?'background:#c2601a;color:#fff':'background:#f5f4f0;color:#666' }}">All</a>
        @foreach($categories as $cat)
        <a href="{{ route('br.membre.business.index',['cat'=>$cat]) }}"
            style="flex-shrink:0;padding:9px 20px;border-radius:22px;font-size:13px;font-weight:600;text-decoration:none;{{ request('cat')===$cat?'background:#c2601a;color:#fff':'background:#f5f4f0;color:#666' }}">{{ $cat }}</a>
        @endforeach
    </div>

    {{-- Listings --}}
    @forelse($items as $item)
    <a href="{{ route('br.membre.business.show', $item) }}" style="display:block;text-decoration:none;margin-bottom:20px">
        <div style="border-radius:20px;overflow:hidden;background:#fff;box-shadow:0 2px 16px rgba(0,0,0,.07)">
            {{-- Image --}}
            <div style="position:relative;aspect-ratio:16/9;background:#f0ede8;overflow:hidden">
                @if($item->image)
                    <img src="{{ Storage::url($item->image) }}" alt="{{ $item->titre }}" style="width:100%;height:100%;object-fit:cover">
                @else
                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:50px;background:linear-gradient(135deg,#f0ede8,#e8e4de)">🛍</div>
                @endif
                {{-- Category badge --}}
                <div style="position:absolute;top:14px;left:14px">
                    <span style="background:#1a1a1a;color:#fff;font-size:10px;font-weight:700;padding:5px 12px;border-radius:20px;letter-spacing:.6px;text-transform:uppercase">{{ $item->categorie }}</span>
                </div>
                {{-- Vues / extra badge --}}
                @if($item->vues > 50)
                <div style="position:absolute;top:14px;right:14px">
                    <span style="background:#c2601a;color:#fff;font-size:10px;font-weight:700;padding:5px 10px;border-radius:20px">Vetted</span>
                </div>
                @endif
            </div>
            {{-- Content --}}
            <div style="padding:16px 18px 18px">
                <h2 style="font-family:Syne,sans-serif;font-size:20px;font-weight:700;color:#1a1a1a;margin-bottom:6px;line-height:1.2">{{ $item->titre }}</h2>
                <p style="font-size:13px;color:#888;line-height:1.5;margin-bottom:14px">{{ Str::limit($item->description, 90) }}</p>
                <div style="display:flex;align-items:center;justify-content:space-between">
                    @if($item->prix)
                        <p style="font-family:Syne,sans-serif;font-size:22px;font-weight:800;color:#c2601a">{{ number_format($item->prix,0,',',' ') }} <span style="font-size:12px;font-weight:400;color:#aaa">FCFA</span></p>
                    @else
                        <p style="font-size:14px;color:#aaa">Prix sur demande</p>
                    @endif
                    <div style="width:36px;height:36px;border-radius:50%;border:1.5px solid #ececec;display:flex;align-items:center;justify-content:center;font-size:16px;color:#ccc">⭐</div>
                </div>
            </div>
        </div>
    </a>
    @empty
    <div style="text-align:center;padding:60px 0">
        <p style="font-size:50px;margin-bottom:12px">🏪</p>
        <p style="font-size:15px;color:#aaa">Aucune publication pour le moment</p>
    </div>
    @endforelse

    {{ $items->links() }}

    {{-- CTA Banner --}}
    <div style="text-align:center;padding:40px 20px;background:#fafaf8;border-radius:20px;margin-bottom:24px">
        <div style="width:56px;height:56px;border-radius:16px;background:linear-gradient(135deg,#c2601a,#e8823a);display:flex;align-items:center;justify-content:center;font-size:26px;margin:0 auto 14px">🚀</div>
        <h3 style="font-family:Syne,sans-serif;font-size:20px;font-weight:700;color:#1a1a1a;margin-bottom:6px">Votre business ici ?</h3>
        <p style="font-size:13px;color:#888;margin-bottom:16px">Atteignez plus de 5 000 entrepreneurs vérifiés dans la salle communautaire dès aujourd’hui..</p>
        <button onclick="document.getElementById('modal-publish').style.display='flex'"
            style="background:transparent;color:#c2601a;border:1.5px solid #c2601a;border-radius:22px;padding:11px 28px;font-size:14px;font-weight:600;cursor:pointer">Publier une annonce</button>
    </div>

    {{-- Mes publications --}}
    @if($mesItems->count())
    <div style="background:#fff;border-radius:20px;padding:20px;box-shadow:0 2px 12px rgba(0,0,0,.06);margin-bottom:24px">
        <h2 style="font-family:Syne,sans-serif;font-size:16px;font-weight:700;margin-bottom:14px">Mes publications</h2>
        @foreach($mesItems as $item)
        <div style="padding:14px 0;border-bottom:0.5px solid #f0ede8;display:flex;justify-content:space-between;align-items:center">
            <div>
                <p style="font-size:14px;font-weight:600;color:#1a1a1a">{{ $item->titre }}</p>
                <p style="font-size:12px;color:#aaa;margin-top:3px">{{ $item->vues }} vues · {{ $item->categorie }}</p>
            </div>
            <form action="{{ route('br.membre.business.destroy', $item) }}" method="POST" onsubmit="return confirm('Supprimer ?')">
                @csrf @method('DELETE')
                <button style="font-size:12px;color:#c0302a;background:none;border:none;padding:8px;cursor:pointer">Supprimer</button>
            </form>
        </div>
        @endforeach
    </div>
    @endif

</div>

{{-- Modal publier --}}
<div id="modal-publish" style="display:none;position:fixed;inset:0;z-index:50;align-items:flex-end;background:rgba(0,0,0,.5)">
    <div style="background:#fff;border-radius:24px 24px 0 0;padding:24px 20px;width:100%;max-height:92vh;overflow-y:auto;box-sizing:border-box">
        <div style="width:36px;height:4px;background:#e5e3dc;border-radius:4px;margin:0 auto 20px"></div>
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
            <h2 style="font-family:Syne,sans-serif;font-size:20px;font-weight:700">Publier une annonce</h2>
            <button onclick="document.getElementById('modal-publish').style.display='none'"
                style="width:32px;height:32px;border-radius:50%;background:#f5f4f0;border:none;font-size:16px;color:#888;cursor:pointer;display:flex;align-items:center;justify-content:center">✕</button>
        </div>
        <form action="{{ route('br.membre.business.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label style="font-size:12px;color:#888;font-weight:500;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px">Titre</label>
            <input type="text" name="titre" required maxlength="255" placeholder="Ex: Sacs en cuir artisanaux"
                style="width:100%;padding:13px 14px;border:1.5px solid #ececec;border-radius:12px;font-size:14px;background:#fafafa;margin-bottom:14px;box-sizing:border-box">

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:14px">
                <div>
                    <label style="font-size:12px;color:#888;font-weight:500;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px">Catégorie</label>
                    <input type="text" name="categorie" required placeholder="Mode, Alim..."
                        style="width:100%;padding:13px 14px;border:1.5px solid #ececec;border-radius:12px;font-size:14px;background:#fafafa;box-sizing:border-box">
                </div>
                <div>
                    <label style="font-size:12px;color:#888;font-weight:500;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px">Prix (FCFA)</label>
                    <input type="number" name="prix" min="0" placeholder="0 = sur demande"
                        style="width:100%;padding:13px 14px;border:1.5px solid #ececec;border-radius:12px;font-size:14px;background:#fafafa;box-sizing:border-box">
                </div>
            </div>

            <label style="font-size:12px;color:#888;font-weight:500;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px">Description</label>
            <textarea name="description" rows="3" required placeholder="Décrivez votre produit..."
                style="width:100%;padding:13px 14px;border:1.5px solid #ececec;border-radius:12px;font-size:14px;background:#fafafa;margin-bottom:14px;resize:none;box-sizing:border-box"></textarea>

            <label style="font-size:12px;color:#888;font-weight:500;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px">WhatsApp</label>
            <input type="text" name="whatsapp" placeholder="6XXXXXXXX"
                style="width:100%;padding:13px 14px;border:1.5px solid #ececec;border-radius:12px;font-size:14px;background:#fafafa;margin-bottom:14px;box-sizing:border-box">

            <label style="font-size:12px;color:#888;font-weight:500;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px">Image (optionnel)</label>
            <div style="border:1.5px dashed #e5e3dc;border-radius:12px;padding:20px;text-align:center;margin-bottom:18px">
                <input type="file" name="image" accept="image/*" style="font-size:13px;color:#888">
            </div>

            <button type="submit"
                style="width:100%;background:#c2601a;color:#fff;border:none;border-radius:14px;padding:16px;font-size:15px;font-weight:700;cursor:pointer">
                Publier l'annonce
            </button>
        </form>
    </div>
</div>
@endsection