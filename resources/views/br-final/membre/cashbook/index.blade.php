@extends('br-final.layouts.app')
@section('title', 'Cahier de caisse')
@section('content')

<style>
  :root{
    --green:#1B4332;--green-mid:#2D6A4F;--gold:#D4A017;
    --bg:#F0F4F1;--white:#fff;
    --border:#d0ddd6;--muted:#9FC0A8;--text:#1B4332;--text-2:#5A8A6A;
    --r-sm:10px;--r-md:14px;--r-lg:18px;
  }
  *{box-sizing:border-box;margin:0;padding:0}
  body{background:var(--bg);font-family:var(--font-sans,sans-serif);color:var(--text)}
  .page{max-width:430px;margin:0 auto;padding:0 16px 100px}
  .card{background:var(--white);border-radius:var(--r-lg);padding:18px;margin-bottom:12px;border:0.5px solid var(--border)}
  .inp{width:100%;background:var(--bg);border:1px solid var(--border);border-radius:var(--r-sm);padding:11px 13px;font-size:13px;outline:none;color:var(--text);font-family:inherit;margin-bottom:12px}
  .inp:focus{border-color:var(--green-mid);box-shadow:0 0 0 3px rgba(45,106,79,.1)}
  .lbl{display:block;font-size:10px;color:var(--green-mid);margin-bottom:5px;font-weight:600;letter-spacing:.5px;text-transform:uppercase}
  .btn-gold{display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:11px 18px;background:var(--gold);color:var(--green);font-size:13px;font-weight:700;border:none;border-radius:var(--r-md);cursor:pointer;text-decoration:none;font-family:inherit}
  .btn-outline{display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:11px 18px;background:var(--white);color:var(--green);font-size:13px;font-weight:600;border:1.5px solid var(--border);border-radius:var(--r-md);cursor:pointer;text-decoration:none;font-family:inherit}
  select.inp{appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%232D6A4F' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 13px center;padding-right:34px;background-color:var(--bg)}
  .toggle-btn{display:flex;align-items:center;justify-content:center;gap:6px;padding:12px;border-radius:var(--r-sm);font-size:13px;font-weight:600;border:2px solid var(--border);background:var(--white);color:var(--muted);cursor:pointer;transition:all .2s;width:100%}
  .entree-inp:checked~.toggle-btn{background:#E8F5EC;border-color:var(--green-mid);color:var(--green)}
  .sortie-inp:checked~.toggle-btn{background:#FDECEA;border-color:#E53935;color:#E53935}
</style>

{{-- Hero Header --}}
<div style="background:var(--green);padding:24px 20px 22px;position:relative;overflow:hidden">
  <div style="position:absolute;right:-20px;top:-20px;width:130px;height:130px;border-radius:50%;background:rgba(212,160,23,.07)"></div>
  <div style="position:absolute;left:-30px;bottom:-30px;width:100px;height:100px;border-radius:50%;background:rgba(212,160,23,.05)"></div>

  <div class="page" style="padding-bottom:0;padding-top:0">
    <a href="{{ route('br.membre.dashboard') }}"
       style="font-size:12px;color:rgba(255,255,255,.55);display:inline-flex;align-items:center;gap:4px;margin-bottom:16px;text-decoration:none;font-weight:500;position:relative">
      ← Retour
    </a>

    <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:10px;position:relative">
      <div>
        <h1 style="font-size:26px;font-weight:700;color:#fff;line-height:1.15;margin-bottom:4px">Cahier de caisse</h1>
        <p style="font-size:12px;color:var(--gold);font-weight:600">{{ $current->libelle_mois }}</p>
      </div>
      <div style="display:flex;gap:8px;align-items:center">
        @if(!$current->valide)
        <form action="{{ route('br.membre.cashbook.valider', $current) }}" method="POST"
              onsubmit="return confirm('Valider définitivement ce cahier ?')" style="margin:0">
          @csrf
          <button type="submit" class="btn-outline" style="font-size:12px;padding:9px 14px">✓ Valider</button>
        </form>
        @endif
        <a href="{{ route('br.membre.cashbook.pdf', $current) }}" class="btn-gold" style="font-size:12px;padding:9px 14px">⬇ PDF</a>
      </div>
    </div>

    {{-- Solde net pill --}}
    @php $solde = $current->solde ?? 0; @endphp
    <div style="margin-top:18px;background:var(--green-mid);border-radius:var(--r-md);padding:16px;border:1px solid rgba(212,160,23,.2);position:relative">
      <p style="font-size:11px;color:rgba(255,255,255,.55);margin-bottom:4px;font-weight:500">Solde net du mois</p>
      <div style="display:flex;align-items:baseline;gap:6px">
        <span style="font-size:32px;font-weight:700;color:#fff">{{ number_format($solde,0,',',' ') }}</span>
        <span style="font-size:13px;color:rgba(255,255,255,.6)">FCFA</span>
      </div>
      @if($current->valide)
        <span style="position:absolute;top:14px;right:14px;background:rgba(212,160,23,.2);color:var(--gold);font-size:10px;font-weight:700;padding:4px 10px;border-radius:20px">✓ Validé</span>
      @elseif($solde >= 0)
        <span style="position:absolute;top:14px;right:14px;background:rgba(212,160,23,.2);color:var(--gold);font-size:10px;font-weight:700;padding:4px 10px;border-radius:20px">↑ Excédent</span>
      @else
        <span style="position:absolute;top:14px;right:14px;background:rgba(229,57,53,.2);color:#ff8a80;font-size:10px;font-weight:700;padding:4px 10px;border-radius:20px">↓ Déficit</span>
      @endif
    </div>
  </div>
</div>

<div class="page" style="padding-top:16px">

  {{-- KPI --}}
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:12px">
    <div class="card" style="margin-bottom:0;padding:16px">
      <div style="width:34px;height:34px;border-radius:10px;background:#E8F5EC;display:flex;align-items:center;justify-content:center;margin-bottom:10px">
        <svg width="14" height="14" fill="none" stroke="var(--green-mid)" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
      </div>
      <p style="font-size:10px;color:var(--muted);margin-bottom:4px;font-weight:500">Entrées</p>
      <p style="font-size:20px;font-weight:700;color:var(--green)">{{ number_format($current->total_entrees??0,0,',',' ') }}</p>
      <p style="font-size:10px;color:var(--muted);margin-top:2px">FCFA</p>
    </div>
    <div class="card" style="margin-bottom:0;padding:16px">
      <div style="width:34px;height:34px;border-radius:10px;background:#FDECEA;display:flex;align-items:center;justify-content:center;margin-bottom:10px">
        <svg width="14" height="14" fill="none" stroke="#E53935" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
      </div>
      <p style="font-size:10px;color:var(--muted);margin-bottom:4px;font-weight:500">Sorties</p>
      <p style="font-size:20px;font-weight:700;color:#E53935">{{ number_format($current->total_sorties??0,0,',',' ') }}</p>
      <p style="font-size:10px;color:var(--muted);margin-top:2px">FCFA</p>
    </div>
  </div>

  {{-- Ajouter une ligne --}}
  @if(!$current->valide)
  <div class="card">
    <p style="font-size:15px;font-weight:700;color:var(--text);margin-bottom:16px;display:flex;align-items:center;gap:7px">
      <span style="color:var(--gold)">+</span> Ajouter une ligne
    </p>
    <form action="{{ route('br.membre.cashbook.store') }}" method="POST">
      @csrf
      <input type="hidden" name="date" value="{{ date('Y-m-d') }}">

      <label class="lbl">Libellé</label>
      <input type="text" name="libelle" required placeholder="ex: Vente de stock" class="inp">

      <label class="lbl">Type</label>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:12px">
        <label style="cursor:pointer;display:flex;flex-direction:column">
          <input type="radio" name="type" value="entree" checked class="entree-inp" style="position:absolute;opacity:0;pointer-events:none">
          <div class="toggle-btn" id="tb-entree">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
            Entrée
          </div>
        </label>
        <label style="cursor:pointer;display:flex;flex-direction:column">
          <input type="radio" name="type" value="sortie" class="sortie-inp" style="position:absolute;opacity:0;pointer-events:none">
          <div class="toggle-btn" id="tb-sortie">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
            Sortie
          </div>
        </label>
      </div>

      <label class="lbl">Montant (FCFA)</label>
      <input type="number" name="montant" min="1" required placeholder="0" class="inp">

      <label class="lbl">Catégorie</label>
      <input type="text" name="categorie" placeholder="Ex: Vente, Achat..." class="inp" style="margin-bottom:16px">

      <button type="submit"
        style="width:100%;background:var(--green);color:var(--gold);border:none;border-radius:var(--r-md);padding:14px;font-size:14px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;font-family:inherit">
        Enregistrer l'opération
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </button>
    </form>
  </div>
  @endif

  {{-- Transactions --}}
  <div class="card">
    <p style="font-size:15px;font-weight:700;color:var(--text);margin-bottom:14px">Transactions du mois</p>

    @forelse($entries as $e)
    <div style="display:flex;align-items:center;gap:12px;padding:11px 0;border-top:0.5px solid var(--border)">
      <div style="width:30px;height:30px;border-radius:50%;background:{{ $e->type==='entree'?'#E8F5EC':'#FDECEA' }};display:flex;align-items:center;justify-content:center;flex-shrink:0">
        @if($e->type==='entree')
          <svg width="13" height="13" fill="none" stroke="var(--green-mid)" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
        @else
          <svg width="13" height="13" fill="none" stroke="#E53935" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
        @endif
      </div>
      <div style="flex:1;min-width:0">
        <p style="font-size:13px;font-weight:600;color:var(--text);overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $e->libelle }}</p>
        <p style="font-size:10px;color:var(--muted);margin-top:2px">
          {{ \Carbon\Carbon::parse($e->date)->format('d/m') }}
          @if($e->categorie)
            · <span style="background:var(--bg);border-radius:5px;padding:1px 6px;font-size:10px;font-weight:600;color:var(--text-2)">{{ $e->categorie }}</span>
          @endif
        </p>
      </div>
      <p style="font-size:13px;font-weight:700;white-space:nowrap;padding-left:10px;color:{{ $e->type==='entree'?'var(--green-mid)':'#E53935' }}">
        {{ $e->type==='entree'?'+':'-' }}{{ number_format($e->montant,0,',',' ') }}
      </p>
    </div>
    @empty
      <p style="text-align:center;padding:24px 0;color:var(--muted);font-size:13px">Aucune transaction ce mois</p>
    @endforelse
  </div>

  {{-- Cahiers précédents --}}
  @if($cashbooks->count() > 1)
  <div class="card">
    <p style="font-size:15px;font-weight:700;color:var(--text);margin-bottom:12px">Cahiers précédents</p>
    <div style="display:flex;flex-wrap:wrap;gap:8px">
      @foreach($cashbooks as $cb)
        @if($cb->id !== $current->id)
        <a href="{{ route('br.membre.cashbook.show', $cb) }}"
           style="padding:7px 14px;border:1.5px solid var(--border);border-radius:20px;font-size:12px;color:var(--green-mid);text-decoration:none;font-weight:500">
          {{ $cb->libelle_mois }}{{ $cb->valide?' ✓':'' }}
        </a>
        @endif
      @endforeach
    </div>
  </div>
  @endif

</div>

<script>
  document.querySelectorAll('input[name="type"]').forEach(function(r){
    r.addEventListener('change',function(){
      var te=document.getElementById('tb-entree');
      var ts=document.getElementById('tb-sortie');
      if(this.value==='entree'){
        te.style.background='#E8F5EC';te.style.borderColor='#2D6A4F';te.style.color='#1B4332';
        ts.style.background='#fff';ts.style.borderColor='#d0ddd6';ts.style.color='#9FC0A8';
      } else {
        ts.style.background='#FDECEA';ts.style.borderColor='#E53935';ts.style.color='#E53935';
        te.style.background='#fff';te.style.borderColor='#d0ddd6';te.style.color='#9FC0A8';
      }
    });
  });
  // init state
  document.getElementById('tb-entree').style.background='#E8F5EC';
  document.getElementById('tb-entree').style.borderColor='#2D6A4F';
  document.getElementById('tb-entree').style.color='#1B4332';
</script>

@endsection