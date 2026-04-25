@extends('br-final.layouts.app')
@section('title', $item->titre)
@section('content')
<div class="p-4">

    <a href="{{ route('br.membre.business.index') }}" style="font-size:13px;color:#888;display:inline-block;margin-bottom:16px;padding-top:8px">← Retour au marketplace</a>

    {{-- Image --}}
    <div style="position:relative;border-radius:20px;overflow:hidden;background:#f0ede8;margin-bottom:6px">
        <div style="aspect-ratio:1">
            @if($item->image)
                <img src="{{ Storage::url($item->image) }}" alt="{{ $item->titre }}" style="width:100%;height:100%;object-fit:cover">
            @else
                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:70px;background:linear-gradient(135deg,#f0ede8,#e8e4de)">🛍</div>
            @endif
        </div>
        {{-- Category pill on image --}}
        <div style="position:absolute;top:14px;left:14px">
            <span style="background:rgba(0,0,0,.75);color:#fff;font-size:10px;font-weight:700;padding:6px 14px;border-radius:20px;letter-spacing:.6px;text-transform:uppercase;backdrop-filter:blur(4px)">{{ $item->categorie }}</span>
        </div>
    </div>

    {{-- Title & Price --}}
    <div style="padding:14px 0 10px">
        <h1 style="font-family:Syne,sans-serif;font-size:26px;font-weight:600;color:#1a1a1a;line-height:1.2;margin-bottom:10px">{{ $item->titre }}</h1>

        @if($item->prix)
            <p style="font-family:Syne,sans-serif;font-size:30px;font-weight:600;color:#c2601a;margin-bottom:4px">
                {{ number_format($item->prix,0,',',' ') }} <span style="font-size:15px;font-weight:400;color:#aaa">FCFA</span>
            </p>
        @else
            <p style="font-size:16px;color:#888;margin-bottom:10px">Prix sur demande</p>
        @endif

        <div style="display:flex;align-items:center;gap:8px;margin-top:6px">
            <span style="font-size:12px;color:#aaa">{{ $item->vues }} vues</span>
            <span style="color:#ddd">·</span>
            <span style="font-size:12px;color:#aaa">{{ $item->created_at->diffForHumans() }}</span>
        </div>
    </div>

    {{-- Description --}}
    <div style="background:#f9f8f6;border-radius:16px;padding:18px;margin-bottom:16px">
        <p style="font-size:14px;color:#555;line-height:1.8">{{ $item->description }}</p>
    </div>

    {{-- Vendeur --}}
    <div style="background:#fff;border:1px solid #f0ede8;border-radius:16px;padding:16px;margin-bottom:16px;display:flex;align-items:center;gap:12px;box-shadow:0 1px 8px rgba(0,0,0,.05)">
        <div style="width:46px;height:46px;border-radius:14px;background:linear-gradient(135deg,#c2601a,#e8823a);display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:600;color:#fff;flex-shrink:0">
            {{ substr($item->user->prenom,0,1) }}
        </div>
        <div>
            <p style="font-size:15px;font-weight:600;color:#1a1a1a">{{ $item->user->nom_complet }}</p>
            <p style="font-size:12px;color:#aaa;margin-top:2px">Vendeur · {{ $item->vues }} vues</p>
        </div>
        <div style="margin-left:auto">
            <div style="width:36px;height:36px;border-radius:50%;background:#f5f4f0;display:flex;align-items:center;justify-content:center;font-size:16px;color:#ccc">⭐</div>
        </div>
    </div>

    @if($item->whatsapp)
        <a href="https://wa.me/237{{ ltrim($item->whatsapp,'0') }}" target="_blank"
            style="display:flex;align-items:center;justify-content:center;gap:10px;width:100%;background:#25d366;color:#fff;border-radius:14px;padding:17px;font-size:16px;font-weight:700;margin-bottom:24px;text-decoration:none;box-shadow:0 4px 16px rgba(37,211,102,.3)">
            <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            Contacter sur WhatsApp
        </a>
    @endif

    {{-- Similaires --}}
    @if($similaires->count())
    <h2 style="font-family:Syne,sans-serif;font-size:18px;font-weight:700;margin-bottom:14px">Annonces similaires</h2>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:24px">
        @foreach($similaires as $s)
        <a href="{{ route('br.membre.business.show', $s) }}" style="display:block;text-decoration:none;background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 2px 10px rgba(0,0,0,.06)">
            <div style="aspect-ratio:1;background:#f5f4f0;overflow:hidden">
                @if($s->image)
                    <img src="{{ Storage::url($s->image) }}" style="width:100%;height:100%;object-fit:cover">
                @else
                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:32px;background:linear-gradient(135deg,#f0ede8,#e8e4de)">🛍</div>
                @endif
            </div>
            <div style="padding:10px 12px 12px">
                <p style="font-size:13px;font-weight:600;color:#1a1a1a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin-bottom:4px">{{ $s->titre }}</p>
                @if($s->prix)
                    <p style="font-size:13px;font-weight:700;color:#c2601a">{{ number_format($s->prix,0,',',' ') }} FCFA</p>
                @else
                    <p style="font-size:12px;color:#aaa">Sur demande</p>
                @endif
            </div>
        </a>
        @endforeach
    </div>
    @endif

</div>
@endsection