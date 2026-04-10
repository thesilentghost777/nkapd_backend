<?php

namespace App\Http\Controllers\BrFinal;

use App\Http\Controllers\Controller;
use App\Models\BrFinal\User;
use App\Models\BrFinal\Tontine;
use App\Models\BrFinal\Loan;
use App\Models\BrFinal\Payment;
use App\Models\BrFinal\AssistanceRequest;
use App\Models\BrFinal\BusinessItem;
use App\Models\BrFinal\Notification;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_membres' => User::where('role', 'membre')->count(),
            'membres_actifs' => User::where('statut', 'membre')->count(),
            'en_attente' => User::where('statut', 'en_attente')->count(),
            'total_tontines' => Tontine::where('statut', 'active')->count(),
            'volume_tontines' => Tontine::where('statut', 'active')->sum('total_cotise'),
            'prets_en_cours' => Loan::whereIn('statut', ['en_cours', 'en_retard'])->count(),
            'volume_prets' => Loan::whereIn('statut', ['en_cours', 'en_retard'])->sum('montant_accorde'),
            'prets_en_attente' => Loan::where('statut', 'en_attente')->count(),
            'retraits_pending' => Tontine::where('statut', 'retrait_demande')->count(),
            'assistances_pending' => AssistanceRequest::where('statut', 'en_attente')->count(),
            'revenus_adhesion' => Payment::where('type', 'adhesion')->where('statut', 'paid')->sum('montant'),
            'total_paiements' => Payment::where('statut', 'paid')->sum('montant'),
        ];

        $derniersMembers = User::where('role', 'membre')->latest()->take(5)->get();
        $dernieresTx = Payment::where('statut', 'paid')->latest()->take(10)->get();

        return view('br-final.admin.dashboard', compact('stats', 'derniersMembers', 'dernieresTx'));
    }

    // ===== MEMBRES =====
    public function membres(Request $request)
    {
        $query = User::where('role', 'membre');
        if ($request->search) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('nom', 'like', "%{$s}%")->orWhere('prenom', 'like', "%{$s}%")->orWhere('telephone', 'like', "%{$s}%"));
        }
        if ($request->statut) $query->where('statut', $request->statut);
        $membres = $query->withCount('filleuls')->latest()->paginate(20);
        return view('br-final.admin.membres.index', compact('membres'));
    }

    public function membreShow(User $user)
    {
        $user->load(['tontines', 'loans', 'filleuls.filleul', 'payments']);
        return view('br-final.admin.membres.show', compact('user'));
    }

    public function membreToggle(User $user)
    {
        $user->update(['statut' => $user->statut === 'suspendu' ? 'membre' : 'suspendu']);
        return back()->with('success', 'Statut mis à jour.');
    }

    // ===== TONTINES =====
    public function tontines(Request $request)
    {
        $query = Tontine::with('user');
        if ($request->statut) $query->where('statut', $request->statut);
        if ($request->type) $query->where('type', $request->type);
        $tontines = $query->latest()->paginate(20);
        return view('br-final.admin.tontines.index', compact('tontines'));
    }

    public function tontineRetraits()
    {
        $retraits = Tontine::with('user')->where('statut', 'retrait_demande')->latest()->get();
        return view('br-final.admin.tontines.retraits', compact('retraits'));
    }

    public function tontineValiderRetrait(Tontine $tontine)
    {
        app(\App\Services\BrFinal\TontineService::class)->validerRetrait($tontine);
        return back()->with('success', 'Retrait validé.');
    }

    // ===== PRÊTS =====
    public function prets(Request $request)
    {
        $query = Loan::with('user');
        if ($request->statut) $query->where('statut', $request->statut);
        $prets = $query->latest()->paginate(20);
        return view('br-final.admin.prets.index', compact('prets'));
    }

    public function pretShow(Loan $loan)
    {
        $loan->load(['user', 'repayments']);
        return view('br-final.admin.prets.show', compact('loan'));
    }

    public function pretApprouver(Request $request, Loan $loan)
    {
        $montant = $request->input('montant_accorde', $loan->montant_demande);
        app(\App\Services\BrFinal\LoanService::class)->approuverPret($loan, $montant);
        return back()->with('success', 'Prêt approuvé.');
    }

    public function pretRejeter(Request $request, Loan $loan)
    {
        $request->validate(['motif' => 'required|string']);
        app(\App\Services\BrFinal\LoanService::class)->rejeterPret($loan, $request->motif);
        return back()->with('success', 'Prêt refusé.');
    }

    // ===== TRANSACTIONS =====
    public function transactions(Request $request)
    {
        $query = Payment::with('user');
        if ($request->type) $query->where('type', $request->type);
        if ($request->statut) $query->where('statut', $request->statut);
        $transactions = $query->latest()->paginate(20);
        return view('br-final.admin.transactions.index', compact('transactions'));
    }

    // ===== ASSISTANCE =====
    public function assistances(Request $request)
    {
        $query = AssistanceRequest::with('user');
        if ($request->statut) $query->where('statut', $request->statut);
        $assistances = $query->latest()->paginate(20);
        return view('br-final.admin.assistances.index', compact('assistances'));
    }

    public function assistanceShow(AssistanceRequest $assistance)
    {
        $assistance->load(['user', 'messages.sender']);
        return view('br-final.admin.assistances.show', compact('assistance'));
    }

    public function assistanceRepondre(Request $request, AssistanceRequest $assistance)
    {
        $request->validate(['contenu' => 'required|string']);

        $assistance->messages()->create([
            'sender_id' => auth('brfinal')->id(),
            'contenu' => $request->contenu,
        ]);

        if ($request->statut) {
            $assistance->update(['statut' => $request->statut]);
        }

        return back()->with('success', 'Réponse envoyée.');
    }

    // ===== BUSINESS =====
    public function business()
    {
        $items = BusinessItem::with('user')->latest()->paginate(20);
        return view('br-final.admin.business.index', compact('items'));
    }

    public function businessToggle(BusinessItem $item)
    {
        $item->update(['actif' => !$item->actif]);
        return back()->with('success', 'Statut modifié.');
    }

    // ===== NOTIFICATIONS =====
    public function notificationForm()
    {
        return view('br-final.admin.notifications.create');
    }

    public function notificationEnvoyer(Request $request)
    {
        $request->validate(['titre' => 'required|string', 'contenu' => 'required|string', 'type' => 'required']);

        if ($request->user_id) {
            Notification::envoyer($request->user_id, $request->titre, $request->contenu, $request->type);
        } else {
            Notification::globale($request->titre, $request->contenu, $request->type);
        }

        return back()->with('success', 'Notification envoyée.');
    }
}
