<?php

namespace App\Http\Controllers\Api\Nkap;

use App\Http\Controllers\Controller;
use App\Services\Nkap\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function inscription(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|unique:nkap_users,email',
            'telephone' => 'required|string|unique:nkap_users,telephone',
            'password' => 'required|string|min:6',
            'code_parrainage' => 'nullable|string',
            'date_naissance' => 'nullable|date',
            'sexe' => 'nullable|in:homme,femme',
            'ville' => 'nullable|string',
        ]);

        return response()->json($this->authService->inscription($data));
    }

    public function connexion(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        return response()->json($this->authService->connexion($data['email'], $data['password']));
    }

    public function deconnexion(Request $request)
    {
        return response()->json($this->authService->deconnexion($request->user()));
    }

    public function profil(Request $request)
    {
        return response()->json(['success' => true, 'user' => $request->user()]);
    }

    public function mettreAJourProfil(Request $request)
    {
        return response()->json($this->authService->mettreAJourProfil($request->user(), $request->all()));
    }

    public function changerMotDePasse(Request $request)
    {
        $data = $request->validate([
            'ancien_mot_de_passe' => 'required|string',
            'nouveau_mot_de_passe' => 'required|string|min:6',
        ]);

        return response()->json($this->authService->changerMotDePasse(
            $request->user(),
            $data['ancien_mot_de_passe'],
            $data['nouveau_mot_de_passe']
        ));
    }
}
