<?php

namespace App\Http\Controllers\BrFinal;

use App\Http\Controllers\Controller;
use App\Models\BrFinal\User;
use App\Models\BrFinal\Referral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function portail()
    {
        return view('br-final.auth.portail');
    }

    public function loginForm()
    {
        return view('br-final.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'telephone' => 'required',
            'password' => 'required',
        ]);

        if (auth('brfinal')->attempt($request->only('telephone', 'password'), $request->boolean('remember'))) {
            $user = auth('brfinal')->user();
            $user->update(['derniere_connexion' => now()]);

            return $user->estAdmin()
                ? redirect()->route('br.admin.dashboard')
                : redirect()->route('br.membre.dashboard');
        }

        return back()->with('error', 'Identifiants incorrects.')->withInput();
    }

    public function registerForm()
    {
        return view('br-final.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'telephone' => 'required|string|unique:br_users,telephone',
            'email' => 'nullable|email|unique:br_users,email',
            'password' => 'required|min:6|confirmed',
            'code_parrain' => 'nullable|exists:br_users,telephone',
            'whatsapp' => 'nullable|string',
        ]);

        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'whatsapp' => $request->whatsapp ?? $request->telephone,
        ]);

        if ($request->code_parrain) {
            $parrain = User::where('telephone', $request->code_parrain)->first();
            if ($parrain && $parrain->id !== $user->id) {
                Referral::create([
                    'parrain_id' => $parrain->id,
                    'filleul_id' => $user->id,
                    'statut' => 'en_attente',
                ]);
            }
        }

        auth('brfinal')->login($user);
        return redirect()->route('br.membre.dashboard');
    }

    public function logout()
    {
        auth('brfinal')->logout();
        return redirect()->route('br.login');
    }

    // ===== DEV PORTAL =====
    public function devLogin(Request $request)
    {
        $role = $request->input('role', 'membre');
        $user = User::where('role', $role)->first();

        if (!$user) {
            return back()->with('error', 'Aucun utilisateur trouvé.');
        }

        auth('brfinal')->login($user);
        return $role === 'admin'
            ? redirect()->route('br.admin.dashboard')
            : redirect()->route('br.membre.dashboard');
    }
}
