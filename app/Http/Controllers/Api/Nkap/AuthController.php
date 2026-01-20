<?php

namespace App\Http\Controllers\Api\Nkap;

use App\Http\Controllers\Controller;
use App\Services\Nkap\AuthService;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function inscription(Request $request)
    {
        Log::info('Inscription demandée', ['data' => $request->all()]);

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
        Log::info('Connexion demandée', ['data' => $request->all()]);

        $data = $request->validate([
            'identifiant' => 'required|string', // Email OU téléphone
            'password' => 'required|string',
        ]);

        return response()->json($this->authService->connexion($data['identifiant'], $data['password']));
    }

    public function deconnexion(Request $request)
    {
        Log::info('Déconnexion demandée', ['user_id' => $request->user()->id]);
        return response()->json($this->authService->deconnexion($request->user()));
    }

    public function profil(Request $request)
    {
        Log::info('Profil demandé', ['user_id' => $request->user()->id]);
        return response()->json(['success' => true, 'user' => $request->user()]);
    }

    public function mettreAJourProfil(Request $request)
    {
        Log::info('Mise à jour du profil demandée', ['user_id' => $request->user()->id, 'data' => $request->all()]);
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

    public function supprimerUtilisateur(int $id)
    {
        Log::info('Suppression d\'utilisateur demandée', ['user_id' => $id]);
        
        $result = $this->authService->supprimerUtilisateur($id);
        
        return response()->json($result, $result['success'] ? 200 : 404);
    }
}