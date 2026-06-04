@extends('br-final.layouts.app')
@section('title', 'Assistance — ' . $assistance->sujet)
@section('content')

<style>
  .asst-inp{width:100%;background:#F0F4F1;border:1px solid #c8d9ce;border-radius:10px;padding:11px 13px;font-size:13px;outline:none;color:#1B4332;font-family:inherit;resize:none}
  .asst-inp:focus{border-color:#2D6A4F;box-shadow:0 0 0 3px rgba(45,106,79,.1)}
</style>

{{-- Header --}}
<div style="background:#1B4332;padding:24px 20px 20px;position:relative;overflow:hidden">
  <div style="position:absolute;right:-20px;top:-20px;width:120px;height:120px;border-radius:50%;background:rgba(212,160,23,.07)"></div>
  <a href="{{ route('br.membre.assistance.index') }}"
     style="font-size:12px;color:rgba(255,255,255,.6);display:inline-flex;align-items:center;gap:4px;margin-bottom:16px;text-decoration:none;font-weight:500;position:relative">
    ← Retour
  </a>
  <h1 style="font-size:20px;font-weight:700;color:#fff;line-height:1.3;margin-bottom:10px;position:relative">{{ $assistance->sujet }}</h1>
  <div style="display:flex;align-items:center;gap:8px;position:relative;flex-wrap:wrap">
    <span style="font-size:11px;color:rgba(255,255,255,.5)">{{ $assistance->created_at->format('d/m/Y à H:i') }}</span>
    @php
      $st = [
        'en_attente' => ['bg'=>'rgba(212,160,23,.2)',  'color'=>'#D4A017', 'label'=>'En attente'],
        'en_cours'   => ['bg'=>'rgba(255,255,255,.15)','color'=>'#fff',    'label'=>'En cours'],
        'resolu'     => ['bg'=>'rgba(45,106,79,.4)',   'color'=>'#9FC0A8', 'label'=>'✓ Résolu'],
      ][$assistance->statut] ?? ['bg'=>'rgba(212,160,23,.2)','color'=>'#D4A017','label'=>$assistance->statut];
    @endphp
    <span style="display:inline-block;padding:3px 10px;border-radius:20px;font-size:10px;font-weight:600;background:{{ $st['bg'] }};color:{{ $st['color'] }}">{{ $st['label'] }}</span>
  </div>
</div>

<div style="background:#F0F4F1;padding:16px;min-height:100vh;display:flex;flex-direction:column">

  {{-- Messages --}}
  <div style="flex:1;background:#fff;border-radius:16px;padding:16px;margin-bottom:12px;border:0.5px solid #d0ddd6;max-height:55vh;overflow-y:auto;-webkit-overflow-scrolling:touch">
    @foreach($assistance->messages as $msg)
      @php $isMe = $msg->sender_id === auth('brfinal')->id(); @endphp
      <div style="display:flex;flex-direction:column;align-items:{{ $isMe ? 'flex-end' : 'flex-start' }};margin-bottom:16px">
        <p style="font-size:10px;color:#9FC0A8;margin-bottom:4px">{{ $isMe ? 'Moi' : ($msg->sender->nom_complet ?? 'Admin') }}</p>
        <div style="max-width:80%;padding:11px 14px;border-radius:{{ $isMe ? '16px 16px 4px 16px' : '16px 16px 16px 4px' }};font-size:13px;line-height:1.6;background:{{ $isMe ? '#1B4332' : '#F0F4F1' }};color:{{ $isMe ? '#D4A017' : '#1B4332' }};border:0.5px solid {{ $isMe ? 'transparent' : '#d0ddd6' }}">
          {{ $msg->contenu }}
        </div>
        <p style="font-size:10px;color:#c8d9ce;margin-top:3px">{{ $msg->created_at->format('H:i') }}</p>
      </div>
    @endforeach
  </div>

  {{-- Répondre --}}
  @if($assistance->statut !== 'resolu')
    <div style="background:#fff;border-radius:16px;padding:16px;border:0.5px solid #d0ddd6">
      <form action="{{ route('br.membre.assistance.message', $assistance) }}" method="POST"
            style="display:flex;gap:10px;align-items:flex-end">
        @csrf
        <textarea name="contenu" rows="2" placeholder="Votre message..." required class="asst-inp" style="flex:1"></textarea>
        <button type="submit"
                style="background:#1B4332;color:#D4A017;border:none;border-radius:10px;padding:12px 16px;font-size:13px;font-weight:600;cursor:pointer;flex-shrink:0;line-height:1.4">
          Envoyer
        </button>
      </form>
    </div>
  @else
    <div style="text-align:center;padding:14px;background:#E8F5EC;border-radius:12px;font-size:13px;color:#1B4332;font-weight:500;border:0.5px solid #c8d9ce">
      ✅ Demande résolue
    </div>
  @endif

</div>

@endsection