@extends('br-final.layouts.app')
@section('title', 'Assistance — ' . $assistance->sujet)
@section('content')
<div class="p-4">

    <a href="{{ route('br.membre.assistance.index') }}" style="font-size:13px;color:#888;display:inline-block;margin-bottom:10px;padding-top:8px">← Retour</a>
    <h1 style="font-family:Syne,sans-serif;font-size:20px;font-weight:700;margin-bottom:6px">{{ $assistance->sujet }}</h1>
    <div style="display:flex;align-items:center;gap:8px;margin-bottom:16px">
        <span style="font-size:12px;color:#aaa">{{ $assistance->created_at->format('d/m/Y à H:i') }}</span>
        @php $bc=['en_attente'=>'badge-yellow','en_cours'=>'badge-blue','resolu'=>'badge-green'][$assistance->statut]??'badge-yellow'; @endphp
        <span class="{{ $bc }}">{{ $assistance->statut }}</span>
    </div>

    {{-- Messages --}}
    <div class="card p-4 mb-3" style="max-height:55vh;overflow-y:auto;-webkit-overflow-scrolling:touch">
        @foreach($assistance->messages as $msg)
            @php $isMe = $msg->sender_id === auth('brfinal')->id(); @endphp
            <div style="display:flex;flex-direction:column;align-items:{{ $isMe?'flex-end':'flex-start' }};margin-bottom:14px">
                <p style="font-size:11px;color:#aaa;margin-bottom:3px">{{ $isMe?'Moi':($msg->sender->nom_complet??'Admin') }}</p>
                <div style="max-width:80%;padding:12px 14px;border-radius:{{ $isMe?'16px 16px 4px 16px':'16px 16px 16px 4px' }};font-size:14px;line-height:1.5;background:{{ $isMe?'#c2601a':'#f5f4f0' }};color:{{ $isMe?'#fff':'#1a1a1a' }}">
                    {{ $msg->contenu }}
                </div>
                <p style="font-size:10px;color:#ccc;margin-top:3px">{{ $msg->created_at->format('H:i') }}</p>
            </div>
        @endforeach
    </div>

    {{-- Répondre --}}
    @if($assistance->statut !== 'resolu')
    <div class="card p-4">
        <form action="{{ route('br.membre.assistance.message', $assistance) }}" method="POST" style="display:flex;gap:8px;align-items:flex-end">
            @csrf
            <textarea name="contenu" rows="2" placeholder="Votre message..." required class="input" style="flex:1;resize:none"></textarea>
            <button type="submit" class="btn-primary" style="padding:12px 16px;flex-shrink:0">Envoyer</button>
        </form>
    </div>
    @else
        <div style="text-align:center;padding:12px;background:#eaf5e6;border-radius:10px;font-size:13px;color:#2d7a22">✅ Demande résolue</div>
    @endif

</div>
@endsection