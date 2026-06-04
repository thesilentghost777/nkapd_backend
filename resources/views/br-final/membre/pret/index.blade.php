@extends('br-final.layouts.app')
@section('title', 'Mes Prêts')

@push('styles')
<style>
  :root{
    --green:#1B4332;--green-mid:#2D6A4F;--gold:#D4A017;
    --bg:#F0F4F1;--white:#fff;--border:#d0ddd6;--muted:#9FC0A8;
    --text:#1B4332;--text-2:#5A8A6A;
    --r-sm:10px;--r-md:14px;--r-lg:18px;
  }
  *{box-sizing:border-box;margin:0;padding:0}
  body{background:var(--bg);font-family:var(--font-sans,sans-serif);color:var(--text);-webkit-font-smoothing:antialiased}
  .page{max-width:430px;margin:0 auto;min-height:100svh;padding:0 0 90px;background:var(--bg)}
  .inner{padding:0 16px}
  .card{background:var(--white);border-radius:var(--r-lg);border:0.5px solid var(--border);padding:18px;margin-bottom:12px}
  .inp{width:100%;background:var(--bg);border:1px solid var(--border);border-radius:var(--r-sm);padding:11px 13px;font-size:13px;outline:none;color:var(--text);font-family:inherit}
  .inp:focus{border-color:var(--green-mid);box-shadow:0 0 0 3px rgba(45,106,79,.1)}
  .lbl{display:block;font-size:10px;color:var(--green-mid);margin-bottom:5px;font-weight:600;letter-spacing:.5px;text-transform:uppercase}
  .btn-primary{display:block;width:100%;text-align:center;padding:14px;border-radius:50px;font-size:14px;font-weight:700;border:none;cursor:pointer;background:var(--green);color:var(--gold);font-family:inherit}
  .btn-primary:active{opacity:.88;transform:scale(.98)}
  select.inp{appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%232D6A4F' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 13px center;padding-right:34px;background-color:var(--bg)}
  .badge{display:inline-block;padding:4px 10px;border-radius:20px;font-size:11px;font-weight:600}
  .badge-green{background:#E8F5EC;color:var(--green)}
  .badge-red{background:#FDECEA;color:#C0302A}
  .badge-amber{background:#FEF9EC;color:#9A6C00}
  .alert{border-radius:var(--r-sm);padding:10px 14px;font-size:12px;font-weight:500;margin-bottom:12px;line-height:1.5}
  .alert-warn{background:#FEF9EC;color:#9A6C00;border:1px solid #F0DC80}
  .alert-err{background:#FDECEA;color:#C0302A;border:1px solid #F5BDB9}
  .alert-ok{background:#E8F5EC;color:var(--green-mid);border:1px solid #B2DDB5}
  .loan-cell{background:var(--bg);border-radius:var(--r-sm);padding:10px 12px;border:0.5px solid var(--border)}
  .sim-box{background:#E8F5EC;border:1px solid #c8d9ce;border-radius:var(--r-md);padding:14px 16px;margin-bottom:16px;display:none}
  .sim-box.visible{display:block}
  @keyframes spin{from{transform:rotate(0deg)}to{transform:rotate(360deg)}}
  .spinning{animation:spin .8s linear infinite}
</style>
@endpush

@section('content')

{{-- Hero Header --}}
<div style="background:var(--green);padding:24px 20px 22px;position:relative;overflow:hidden">
  <div style="position:absolute;right:-20px;top:-20px;width:130px;height:130px;border-radius:50%;background:rgba(212,160,23,.07)"></div>
  <div style="position:absolute;left:-30px;bottom:-30px;width:100px;height:100px;border-radius:50%;background:rgba(212,160,23,.05)"></div>
  <div style="position:relative">
    <a href="{{ route('br.membre.dashboard') }}"
       style="font-size:12px;color:rgba(255,255,255,.55);display:inline-flex;align-items:center;gap:4px;margin-bottom:16px;text-decoration:none;font-weight:500">
      ← Retour
    </a>
    <h1 style="font-size:26px;font-weight:700;color:#fff;line-height:1.15;margin-bottom:3px">Tableau de bord</h1>
    <p style="font-size:12px;color:rgba(255,255,255,.55);font-weight:500">Gestion des Prêts</p>
  </div>
</div>

<div class="page">
<div class="inner" style="padding-top:16px">

  {{-- Statut adhésion --}}
  <div class="card" style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px">
    <div style="display:flex;align-items:center;gap:12px">
      <div style="width:40px;height:40px;border-radius:12px;background:var(--bg);display:flex;align-items:center;justify-content:center;font-size:18px;border:0.5px solid var(--border)">🛡️</div>
      <div>
        <p style="font-size:10px;color:var(--muted);margin-bottom:3px;font-weight:500;text-transform:uppercase;letter-spacing:.3px">Statut Adhésion</p>
        <p style="font-size:16px;font-weight:700;color:{{ $user->estMembre() ? 'var(--green-mid)' : '#C0302A' }}">
          {{ $user->estMembre() ? 'Membre' : 'Non Membre' }}
        </p>
      </div>
    </div>
    <div style="width:9px;height:9px;border-radius:50%;background:{{ $user->estMembre() ? 'var(--green-mid)' : '#C0302A' }}"></div>
  </div>

  {{-- Stats grid --}}
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:16px">
    <div class="card" style="margin-bottom:0;display:flex;flex-direction:column;gap:10px">
      <div style="width:38px;height:38px;border-radius:11px;background:var(--bg);display:flex;align-items:center;justify-content:center;font-size:17px;border:0.5px solid var(--border)">👥</div>
      <div>
        <p style="font-size:10px;color:var(--muted);margin-bottom:3px;font-weight:500;text-transform:uppercase;letter-spacing:.3px">Parrainages Actifs</p>
        <p style="font-size:18px;font-weight:700;color:var(--text)">{{ str_pad($user->nb_filleuls_actifs, 2, '0', STR_PAD_LEFT) }}</p>
      </div>
    </div>
    <div class="card" style="margin-bottom:0;display:flex;flex-direction:column;gap:10px">
      <div style="width:38px;height:38px;border-radius:11px;background:var(--bg);display:flex;align-items:center;justify-content:center;font-size:17px;border:0.5px solid var(--border)">💳</div>
      <div>
        <p style="font-size:10px;color:var(--muted);margin-bottom:3px;font-weight:500;text-transform:uppercase;letter-spacing:.3px">Plafond Prêt</p>
        <p style="font-size:14px;font-weight:700;color:var(--gold)">{{ number_format($user->plafond_pret, 0, ',', ' ') }} <span style="font-size:10px;color:var(--muted)">FCFA</span></p>
      </div>
    </div>
  </div>

  @if($user->estMembre() && $user->nb_filleuls_actifs >= 1)

    {{-- Info banner --}}
    <div style="background:#E8F5EC;border-radius:var(--r-md);padding:14px 16px;font-size:12px;color:var(--green-mid);line-height:1.75;margin-bottom:14px;border:1px solid #c8d9ce">
      <strong style="color:var(--green)">💡 Comment ça marche</strong><br>
      • <strong>Frais de dossier :</strong> 3% déduits au déblocage<br>
      • <strong>Pénalité active :</strong> 0,1%/jour + 2%/mois tant que le crédit est ouvert<br>
      • <strong>Après l'échéance :</strong> pénalité monte à <strong>1%/jour</strong> (+ 2%/mois inchangé)
    </div>

    @if($pretActif)
    {{-- Prêt actif --}}
    <div class="card" style="margin-bottom:16px">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px">
        <p style="font-size:15px;font-weight:700;color:var(--text)">Prêt en cours</p>
        @php $bc=['en_cours'=>'badge-green','en_retard'=>'badge-red','en_attente'=>'badge-amber','approuve'=>'badge-amber'][$pretActif->statut]??'badge-amber'; @endphp
        <span class="badge {{ $bc }}">{{ ucfirst(str_replace('_',' ',$pretActif->statut)) }}</span>
      </div>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:14px">
        <div class="loan-cell">
          <p style="font-size:10px;color:var(--muted);margin-bottom:4px;font-weight:500">Montant accordé</p>
          <p style="font-size:13px;font-weight:600">{{ number_format($pretActif->montant_accorde ?? $pretActif->montant_demande, 0, ',', ' ') }} FCFA</p>
        </div>
        <div class="loan-cell">
          <p style="font-size:10px;color:var(--muted);margin-bottom:4px;font-weight:500">Montant net reçu</p>
          <p style="font-size:13px;font-weight:600;color:var(--green-mid)">
            @if($pretActif->montant_net_verse) {{ number_format($pretActif->montant_net_verse, 0, ',', ' ') }} FCFA @else <span style="color:var(--muted)">—</span> @endif
          </p>
        </div>
        <div class="loan-cell">
          <p style="font-size:10px;color:var(--muted);margin-bottom:4px;font-weight:500">Total dû</p>
          <p style="font-size:13px;font-weight:600;color:var(--gold)">{{ number_format($pretActif->montant_total_du ?? 0, 0, ',', ' ') }} FCFA</p>
        </div>
        <div class="loan-cell">
          <p style="font-size:10px;color:var(--muted);margin-bottom:4px;font-weight:500">Reste à payer</p>
          <p style="font-size:13px;font-weight:600">{{ number_format($pretActif->reste_a_payer, 0, ',', ' ') }} FCFA</p>
        </div>
        <div class="loan-cell">
          <p style="font-size:10px;color:var(--muted);margin-bottom:4px;font-weight:500">Durée choisie</p>
          <p style="font-size:13px;font-weight:600">{{ $pretActif->duree_valeur }} {{ $pretActif->duree_unite }}</p>
        </div>
        <div class="loan-cell">
          <p style="font-size:10px;color:var(--muted);margin-bottom:4px;font-weight:500">Échéance</p>
          <p style="font-size:13px;font-weight:600">{{ $pretActif->date_echeance ? \Carbon\Carbon::parse($pretActif->date_echeance)->format('d/m/Y') : '—' }}</p>
        </div>
      </div>

      @if($pretActif->frais_dossier > 0)
      <div style="background:var(--bg);border-radius:var(--r-sm);padding:9px 12px;font-size:12px;color:var(--text-2);margin-bottom:10px;border:0.5px solid var(--border)">
        📎 Frais de dossier prélevés : <strong>{{ number_format($pretActif->frais_dossier, 0, ',', ' ') }} FCFA</strong> (3%)
      </div>
      @endif

      @if($pretActif->penalites > 0)
      <div class="alert alert-err">
        ⚠ Pénalités de retard : <strong>{{ number_format($pretActif->penalites, 0, ',', ' ') }} FCFA</strong>
        @if($pretActif->en_retard) · <span style="font-weight:700">Taux actuel : 1%/jour</span> @endif
      </div>
      @endif

      @if(in_array($pretActif->statut, ['en_cours','en_retard']))
      <form action="{{ route('br.membre.pret.rembourser', $pretActif) }}" method="POST">
        @csrf
        <div style="margin-bottom:12px">
          <label class="lbl">Montant à rembourser (FCFA)</label>
          <input type="number" name="montant" min="1000" max="{{ $pretActif->reste_a_payer }}" placeholder="ex : 25 000" required class="inp">
        </div>
        <button type="submit" class="btn-primary">💳 Payer maintenant</button>
      </form>
      @elseif($pretActif->statut === 'en_attente')
      <div class="alert alert-warn" style="text-align:center">⏳ Votre demande est en cours d'examen par l'administration.</div>
      @elseif($pretActif->statut === 'approuve')
      <div class="alert alert-ok" style="text-align:center">✅ Prêt approuvé — le virement sera effectué sous peu.</div>
      @endif
    </div>

    @else
    {{-- Formulaire demande --}}
    <div class="card" style="margin-bottom:16px">
      <p style="font-size:15px;font-weight:700;color:var(--text);margin-bottom:16px">Faire une demande de prêt</p>
      <form action="{{ route('br.membre.pret.demander') }}" method="POST" id="pretForm">
        @csrf

        <div style="margin-bottom:14px">
          <label class="lbl">Montant souhaité (max : {{ number_format($user->plafond_pret, 0, ',', ' ') }} FCFA)</label>
          <input type="number" name="montant" id="montantInput" min="10000" max="{{ $user->plafond_pret }}" step="1000"
                 placeholder="ex : 50 000" required class="inp" oninput="calculerSimulation()">
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:14px">
          <div>
            <label class="lbl">Durée</label>
            <input type="number" name="duree_valeur" id="dureeValeur" min="1" max="365" placeholder="ex : 30"
                   required class="inp" oninput="calculerSimulation()">
          </div>
          <div>
            <label class="lbl">Unité</label>
            <select name="duree_unite" id="dureeUnite" class="inp" onchange="calculerSimulation()">
              <option value="jours">Jours</option>
              <option value="mois">Mois</option>
            </select>
          </div>
        </div>

        <div id="simulation" class="sim-box">
          <p style="font-size:12px;font-weight:700;color:var(--green);margin-bottom:12px">📊 Simulation de remboursement</p>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
            <div>
              <p style="font-size:10px;color:var(--muted);margin-bottom:3px">Capital + intérêt (10%) + assurance (6,5%)</p>
              <p id="simTotal" style="font-size:13px;font-weight:700;color:var(--gold)"></p>
            </div>
            <div>
              <p style="font-size:10px;color:var(--muted);margin-bottom:3px">Frais de dossier (3%)</p>
              <p id="simFrais" style="font-size:13px;font-weight:700;color:var(--text-2)"></p>
            </div>
            <div>
              <p style="font-size:10px;color:var(--muted);margin-bottom:3px">Montant net reçu</p>
              <p id="simNet" style="font-size:13px;font-weight:700;color:var(--green-mid)"></p>
            </div>
            <div>
              <p style="font-size:10px;color:var(--muted);margin-bottom:3px">Échéance estimée</p>
              <p id="simEcheance" style="font-size:13px;font-weight:700;color:var(--text)"></p>
            </div>
          </div>
        </div>

        <button type="submit" class="btn-primary">Envoyer la demande →</button>
      </form>
    </div>
    @endif

  @else
  {{-- Non éligible --}}
  <div class="card" style="text-align:center;padding:36px 22px 28px;margin-bottom:16px">
    <div style="width:72px;height:72px;border-radius:50%;background:var(--bg);display:flex;align-items:center;justify-content:center;margin:0 auto 18px;font-size:28px;border:0.5px solid var(--border)">🔒</div>
    <p style="font-size:17px;font-weight:700;color:var(--text);margin-bottom:8px">Accès restreint aux prêts</p>
    <p style="font-size:13px;color:var(--muted);line-height:1.6;margin-bottom:18px">Vous n'êtes pas encore éligible pour soumettre une demande de prêt dans le Business Room.</p>
    <span style="display:inline-flex;align-items:center;gap:6px;border:1.5px solid var(--green-mid);border-radius:20px;padding:7px 16px;font-size:12px;font-weight:600;color:var(--green-mid)">🛡 Parainage regis</span>
  </div>
  @endif

  {{-- Historique --}}
  @if($user->estMembre() && $user->nb_filleuls_actifs >= 1 && $historique->count())
  <div class="card" style="margin-bottom:16px">
    <p style="font-size:15px;font-weight:700;color:var(--text);margin-bottom:14px">Historique des prêts</p>
    @foreach($historique as $p)
    <div style="display:flex;justify-content:space-between;align-items:center;padding:13px 0;border-bottom:0.5px solid var(--border)">
      <div>
        <p style="font-size:13px;font-weight:600;color:var(--text)">{{ number_format($p->montant_accorde ?? $p->montant_demande, 0, ',', ' ') }} FCFA</p>
        <p style="font-size:11px;color:var(--muted);margin-top:3px">
          {{ $p->created_at->format('d/m/Y') }}
          @if($p->duree_valeur) · {{ $p->duree_valeur }} {{ $p->duree_unite }} @endif
        </p>
        @if($p->motif_refus)
          <p style="font-size:11px;color:#C0302A;margin-top:2px">{{ $p->motif_refus }}</p>
        @endif
      </div>
      <span class="badge {{ $p->statut === 'rembourse' ? 'badge-green' : 'badge-red' }}">{{ $p->statut }}</span>
    </div>
    @endforeach
  </div>
  @endif

  <p style="text-align:center;font-size:11px;color:var(--muted);margin-top:20px;display:flex;align-items:center;justify-content:center;gap:5px">
    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
    Transaction sécurisée par cryptage SSL
  </p>

  <footer style="text-align:center;padding:20px 20px 10px;border-top:1px solid var(--border);margin-top:16px">
    <p style="font-size:11px;font-weight:600;color:var(--muted);letter-spacing:.5px;text-transform:uppercase;margin-bottom:4px">Propriété du CFPAM GROUP</p>
    <p style="font-size:11px;color:var(--muted)">Développé par <a href="https://tfs237.com" target="_blank" style="color:var(--green-mid);text-decoration:none;font-weight:600">TFS237</a></p>
  </footer>

</div>
</div>

<script>
function fmt(n){ return new Intl.NumberFormat('fr-FR').format(Math.round(n))+' FCFA'; }
function calculerSimulation(){
  const m=parseFloat(document.getElementById('montantInput').value)||0;
  const d=parseInt(document.getElementById('dureeValeur').value)||0;
  const u=document.getElementById('dureeUnite').value;
  const s=document.getElementById('simulation');
  if(m<10000||d<1){s.classList.remove('visible');return;}
  const total=m+(m*.10)+(m*.065);
  const frais=m*.03;
  const net=m-frais;
  const e=new Date();
  if(u==='mois')e.setMonth(e.getMonth()+d); else e.setDate(e.getDate()+d);
  const es=e.toLocaleDateString('fr-FR',{day:'2-digit',month:'2-digit',year:'numeric'});
  document.getElementById('simTotal').textContent=fmt(total);
  document.getElementById('simFrais').textContent=fmt(frais);
  document.getElementById('simNet').textContent=fmt(net);
  document.getElementById('simEcheance').textContent=es;
  s.classList.add('visible');
}
</script>

@endsection