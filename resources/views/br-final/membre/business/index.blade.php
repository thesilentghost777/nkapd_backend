@extends('br-final.layouts.app')
@section('title', 'Business')
@section('content')

<style>
  .biz-inp{width:100%;background:#F0F4F1;border:1px solid #c8d9ce;border-radius:10px;padding:11px 13px;font-size:13px;outline:none;color:#1B4332;font-family:inherit;box-sizing:border-box}
  .biz-inp:focus{border-color:#2D6A4F;box-shadow:0 0 0 3px rgba(45,106,79,.1)}
  .biz-lbl{display:block;font-size:10px;color:#2D6A4F;margin-bottom:5px;font-weight:600;letter-spacing:.5px;text-transform:uppercase}
  .cat-scroll::-webkit-scrollbar{display:none}
</style>

{{-- Header --}}
<div style="background:#1B4332;padding:22px 20px 20px;position:relative;overflow:hidden">
  <div style="position:absolute;right:-20px;top:-20px;width:130px;height:130px;border-radius:50%;background:rgba(212,160,23,.07)"></div>
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;position:relative">
    <div>
      <p style="font-size:10px;color:rgba(255,255,255,.45);font-weight:600;letter-spacing:.8px;text-transform:uppercase;margin-bottom:1px">Business Room</p>
      <p style="font-size:11px;color:#D4A017;font-weight:600;letter-spacing:.5px">COMMUNITY MARKETPLACE</p>
    </div>
    <div style="width:34px;height:34px;border-radius:50%;border:1px solid rgba(212,160,23,.3);display:flex;align-items:center;justify-content:center;font-size:15px;color:#D4A017">🔔</div>
  </div>
  <h1 style="font-size:28px;font-weight:700;color:#fff;line-height:1.15;margin-bottom:6px;position:relative">Explorer les<br><span style="color:#D4A017">opportunités</span></h1>
  <p style="font-size:12px;color:rgba(255,255,255,.55);margin-bottom:18px;position:relative">Connectez-vous avec la communauté et faites croître votre entreprise.</p>
  <button onclick="document.getElementById('modal-publish').style.display='flex'"
    style="width:100%;background:#D4A017;color:#1B4332;border:none;border-radius:12px;padding:14px;font-size:14px;font-weight:700;cursor:pointer;position:relative">
    ⊕ Publier une annonce
  </button>
</div>

<div style="background:#F0F4F1;padding:16px;min-height:100vh">

  <a href="{{ route('br.membre.dashboard') }}" style="font-size:12px;color:#2D6A4F;display:inline-flex;align-items:center;gap:4px;margin-bottom:16px;font-weight:500;text-decoration:none">← Retour</a>

  {{-- Catégories --}}
  <div class="cat-scroll" style="display:flex;gap:8px;overflow-x:auto;padding-bottom:12px;margin-bottom:18px;-webkit-overflow-scrolling:touch;scrollbar-width:none">
    <a href="{{ route('br.membre.business.index') }}"
       style="flex-shrink:0;padding:8px 18px;border-radius:22px;font-size:12px;font-weight:600;text-decoration:none;{{ !request('cat') ? 'background:#1B4332;color:#D4A017' : 'background:#fff;color:#2D6A4F;border:0.5px solid #c8d9ce' }}">Tout</a>
    @foreach($categories as $cat)
    <a href="{{ route('br.membre.business.index', ['cat'=>$cat]) }}"
       style="flex-shrink:0;padding:8px 18px;border-radius:22px;font-size:12px;font-weight:600;text-decoration:none;{{ request('cat')===$cat ? 'background:#1B4332;color:#D4A017' : 'background:#fff;color:#2D6A4F;border:0.5px solid #c8d9ce' }}">{{ $cat }}</a>
    @endforeach
  </div>

  {{-- Listings --}}
  @forelse($items as $item)
  <a href="{{ route('br.membre.business.show', $item) }}" style="display:block;text-decoration:none;margin-bottom:16px">
    <div style="border-radius:18px;overflow:hidden;background:#fff;border:0.5px solid #d0ddd6">
      {{-- Image --}}
      <div style="position:relative;aspect-ratio:16/9;background:#E8F5EC;overflow:hidden">
        @if($item->image)
          <img src="{{ Storage::url($item->image) }}" alt="{{ $item->titre }}" style="width:100%;height:100%;object-fit:cover">
        @else
          <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:50px;background:#E8F5EC">🛍</div>
        @endif
        <div style="position:absolute;top:12px;left:12px">
          <span style="background:#1B4332;color:#D4A017;font-size:10px;font-weight:700;padding:4px 11px;border-radius:20px;letter-spacing:.5px;text-transform:uppercase">{{ $item->categorie }}</span>
        </div>
        @if($item->vues > 50)
        <div style="position:absolute;top:12px;right:12px">
          <span style="background:#D4A017;color:#1B4332;font-size:10px;font-weight:700;padding:4px 10px;border-radius:20px">Vetted</span>
        </div>
        @endif
      </div>
      {{-- Content --}}
      <div style="padding:14px 16px 16px">
        <h2 style="font-size:18px;font-weight:700;color:#1B4332;margin-bottom:5px;line-height:1.25">{{ $item->titre }}</h2>
        <p style="font-size:12px;color:#5A8A6A;line-height:1.6;margin-bottom:12px">{{ Str::limit($item->description, 90) }}</p>
        <div style="display:flex;align-items:center;justify-content:space-between">
          @if($item->prix)
            <p style="font-size:20px;font-weight:700;color:#1B4332">{{ number_format($item->prix,0,',',' ') }} <span style="font-size:11px;font-weight:400;color:#9FC0A8">FCFA</span></p>
          @else
            <p style="font-size:13px;color:#9FC0A8">Prix sur demande</p>
          @endif
          <div style="width:34px;height:34px;border-radius:50%;background:#FEF9EC;display:flex;align-items:center;justify-content:center;font-size:15px">⭐</div>
        </div>
      </div>
    </div>
  </a>
  @empty
  <div style="text-align:center;padding:60px 20px;background:#fff;border-radius:16px;border:0.5px solid #d0ddd6">
    <p style="font-size:46px;margin-bottom:10px">🏪</p>
    <p style="font-size:14px;font-weight:600;color:#1B4332;margin-bottom:4px">Aucune publication</p>
    <p style="font-size:12px;color:#5A8A6A">Soyez le premier à publier une annonce !</p>
  </div>
  @endforelse

  {{ $items->links() }}

  {{-- CTA Banner --}}
  <div style="background:#1B4332;border-radius:18px;padding:24px 20px;margin-bottom:16px;text-align:center;border:1px solid rgba(212,160,23,.2)">
    <div style="width:52px;height:52px;border-radius:14px;background:rgba(212,160,23,.15);display:flex;align-items:center;justify-content:center;font-size:24px;margin:0 auto 12px">🚀</div>
    <h3 style="font-size:18px;font-weight:700;color:#fff;margin-bottom:6px">Votre business ici ?</h3>
    <p style="font-size:12px;color:rgba(255,255,255,.55);margin-bottom:16px;line-height:1.6">Atteignez plus de 5 000 entrepreneurs vérifiés dans la salle communautaire dès aujourd'hui.</p>
    <button onclick="document.getElementById('modal-publish').style.display='flex'"
      style="background:transparent;color:#D4A017;border:1.5px solid #D4A017;border-radius:22px;padding:10px 26px;font-size:13px;font-weight:600;cursor:pointer">
      Publier une annonce
    </button>
  </div>

  {{-- Mes publications --}}
  @if($mesItems->count())
  <div style="background:#fff;border-radius:16px;padding:18px;border:0.5px solid #d0ddd6;margin-bottom:24px">
    <p style="font-size:15px;font-weight:700;color:#1B4332;margin-bottom:14px">Mes publications</p>
    @foreach($mesItems as $item)
    <div style="padding:13px 0;border-bottom:0.5px solid #E8F0EB;display:flex;justify-content:space-between;align-items:center">
      <div>
        <p style="font-size:13px;font-weight:600;color:#1B4332">{{ $item->titre }}</p>
        <p style="font-size:11px;color:#9FC0A8;margin-top:3px">{{ $item->vues }} vues · {{ $item->categorie }}</p>
      </div>
      <form action="{{ route('br.membre.business.destroy', $item) }}" method="POST" onsubmit="return confirm('Supprimer ?')">
        @csrf @method('DELETE')
        <button style="font-size:12px;color:#c0392b;background:none;border:none;padding:8px;cursor:pointer;font-weight:500">Supprimer</button>
      </form>
    </div>
    @endforeach
  </div>
  @endif

</div>

{{-- Modal publier --}}
<div id="modal-publish" style="display:none;position:fixed;inset:0;z-index:50;align-items:flex-end;background:rgba(0,0,0,.5)">
  <div style="background:#fff;border-radius:22px 22px 0 0;padding:22px 20px;width:100%;max-height:92vh;overflow-y:auto;box-sizing:border-box">
    <div style="width:34px;height:4px;background:#d0ddd6;border-radius:4px;margin:0 auto 18px"></div>
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px">
      <p style="font-size:18px;font-weight:700;color:#1B4332">Publier une annonce</p>
      <button onclick="document.getElementById('modal-publish').style.display='none'"
        style="width:30px;height:30px;border-radius:50%;background:#F0F4F1;border:none;font-size:14px;color:#5A8A6A;cursor:pointer;display:flex;align-items:center;justify-content:center">✕</button>
    </div>
    <form action="{{ route('br.membre.business.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div style="margin-bottom:13px">
        <label class="biz-lbl">Titre</label>
        <input type="text" name="titre" required maxlength="255" placeholder="Ex: Sacs en cuir artisanaux" class="biz-inp">
      </div>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:13px">
        <div>
          <label class="biz-lbl">Catégorie</label>
          <input type="text" name="categorie" required placeholder="Mode, Alim..." class="biz-inp">
        </div>
        <div>
          <label class="biz-lbl">Prix (FCFA)</label>
          <input type="number" name="prix" min="0" placeholder="0 = sur demande" class="biz-inp">
        </div>
      </div>

      <div style="margin-bottom:13px">
        <label class="biz-lbl">Description</label>
        <textarea name="description" rows="3" required placeholder="Décrivez votre produit..." class="biz-inp" style="resize:none"></textarea>
      </div>

      <div style="margin-bottom:13px">
        <label class="biz-lbl">WhatsApp</label>
        <input type="text" name="whatsapp" placeholder="6XXXXXXXX" class="biz-inp">
      </div>

      <div style="margin-bottom:18px">
        <label class="biz-lbl">Image (optionnel)</label>
        <label style="display:block;background:#F0F4F1;border:1.5px dashed #9FC0A8;border-radius:10px;padding:18px;text-align:center;cursor:pointer">
          <span style="font-size:20px;display:block;margin-bottom:5px;color:#2D6A4F">↑</span>
          <span style="font-size:12px;color:#5A8A6A;display:block">Cliquez pour choisir une image</span>
          <span style="font-size:10px;color:#9FC0A8;display:block;margin-top:2px">JPG, PNG — max 2 Mo</span>
          <input type="file" name="image" accept="image/*" style="display:none">
        </label>
      </div>

      <button type="submit"
        style="width:100%;background:#1B4332;color:#D4A017;border:none;border-radius:12px;padding:14px;font-size:14px;font-weight:700;cursor:pointer">
        Publier l'annonce
      </button>
    </form>
  </div>
</div>

@endsection