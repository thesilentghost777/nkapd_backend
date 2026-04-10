<?php

namespace App\Http\Controllers\BrFinal;

use App\Http\Controllers\Controller;
use App\Models\BrFinal\Notification;

class MembreController extends Controller
{
    public function dashboard()
    {
        $user = auth('brfinal')->user();
        $user->load(['tontinesActives', 'loans']);

        $stats = [
            'adhesion_payee' => $user->adhesion_payee,
            'tontines_actives' => $user->tontinesActives->count(),
            'total_epargne' => $user->tontinesActives->sum('total_cotise'),
            'filleuls' => $user->nb_filleuls_actifs,
            'plafond_pret' => $user->plafond_pret,
            'pret_en_cours' => $user->loans()->whereIn('statut', ['en_cours', 'en_retard'])->first(),
        ];

        $notifications = Notification::where(function ($q) use ($user) {
            $q->where('user_id', $user->id)->orWhere('globale', true);
        })->actives()->nonLues()->latest()->take(5)->get();

        return view('br-final.membre.dashboard', compact('user', 'stats', 'notifications'));
    }

    public function profil()
    {
        $user = auth('brfinal')->user();
        $user->load(['filleuls.filleul', 'parrain.parrain']);
        $lienParrainage = route('br.register', ['parrain' => $user->telephone]);
        return view('br-final.membre.profil', compact('user', 'lienParrainage'));
    }

    public function updateProfil(\Illuminate\Http\Request $request)
    {
        $user = auth('brfinal')->user();
        $request->validate([
            'nom' => 'required|string', 'prenom' => 'required|string',
            'email' => 'nullable|email|unique:br_users,email,' . $user->id,
            'whatsapp' => 'nullable|string', 'ville' => 'nullable|string',
            'quartier' => 'nullable|string', 'bio' => 'nullable|string|max:500',
        ]);

        $user->update($request->only('nom', 'prenom', 'email', 'whatsapp', 'ville', 'quartier', 'bio'));

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('br-photos', 'public');
            $user->update(['photo' => $path]);
        }

        return back()->with('success', 'Profil mis à jour.');
    }

    public function notifications()
    {
        $user = auth('brfinal')->user();
        $notifications = Notification::where(function ($q) use ($user) {
            $q->where('user_id', $user->id)->orWhere('globale', true);
        })->actives()->latest()->paginate(20);

        // Marquer lues
        Notification::where('user_id', $user->id)->update(['lu' => true]);

        return view('br-final.membre.notifications', compact('notifications'));
    }
}
