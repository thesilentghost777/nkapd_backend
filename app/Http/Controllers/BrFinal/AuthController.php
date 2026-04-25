<?php

namespace App\Http\Controllers\BrFinal;

use App\Http\Controllers\Controller;
use App\Models\BrFinal\User;
use App\Models\BrFinal\Referral;
use App\Mail\BrFinal\OtpMail;
use App\Mail\BrFinal\PasswordResetOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // =============================================
    //  PAGES PUBLIQUES
    // =============================================

    public function portail()
    {
        return view('br-final.auth.portail');
    }

    public function loginForm()
    {
        return view('br-final.auth.login');
    }

    public function registerForm()
    {
        return view('br-final.auth.register');
    }

    // =============================================
    //  CONNEXION CLASSIQUE (téléphone + mot de passe)
    // =============================================

    public function login(Request $request)
    {
        $request->validate([
            'telephone' => 'required',
            'password'  => 'required',
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

    // =============================================
    //  INSCRIPTION CLASSIQUE
    // =============================================

    public function register(Request $request)
    {
        $request->validate([
            'nom'          => 'required|string|max:100',
            'prenom'       => 'required|string|max:100',
            'telephone'    => 'required|string|unique:br_users,telephone',
            'email'        => 'nullable|email|unique:br_users,email',
            'password'     => 'required|min:6|confirmed',
            'code_parrain' => 'nullable|exists:br_users,telephone',
            'whatsapp'     => 'nullable|string',
        ]);

        $user = User::create([
            'nom'           => $request->nom,
            'prenom'        => $request->prenom,
            'telephone'     => $request->telephone,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'whatsapp'      => $request->whatsapp ?? $request->telephone,
            'auth_provider' => null,
        ]);

        $this->attachParrain($user, $request->code_parrain);

        auth('brfinal')->login($user);
        return redirect()->route('br.membre.dashboard');
    }

    // =============================================
    //  OTP EMAIL (connexion)
    // =============================================

    /** Formulaire de connexion/inscription par email */
    public function otpEmailForm()
    {
        return view('br-final.auth.otp-email');
    }

    /**
     * Étape 1 : L'utilisateur saisit son email → on envoie un OTP.
     * Si l'email n'existe pas encore, on crée un compte "provisoire".
     */
    public function otpEnvoyer(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'nom'   => 'nullable|string|max:100',
            'prenom'=> 'nullable|string|max:100',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // Nouveau compte — on exige nom/prénom
            $request->validate([
                'nom'   => 'required|string|max:100',
                'prenom'=> 'required|string|max:100',
            ]);

            $user = User::create([
                'nom'           => $request->nom,
                'prenom'        => $request->prenom,
                'email'         => $request->email,
                'telephone'     => 'email_' . Str::random(8),
                'auth_provider' => 'email',
                'email_verified'=> false,
            ]);
        }

        $code = $user->genererOtp();
        Mail::to($user->email)->send(new OtpMail($user, $code));
        session(['br_otp_email' => $request->email]);

        return redirect()->route('br.otp.verifier.form')
            ->with('success', 'Un code à 6 chiffres a été envoyé à ' . $request->email);
    }

    /** Formulaire de saisie du code OTP (connexion) */
    public function otpVerifierForm()
    {
        if (!session('br_otp_email')) {
            return redirect()->route('br.otp.email.form');
        }
        return view('br-final.auth.otp-verify');
    }

    /**
     * Étape 2 : L'utilisateur saisit le code OTP → connexion automatique.
     */
    public function otpVerifier(Request $request)
    {
        $request->validate(['code' => 'required|string|size:6']);

        $email = session('br_otp_email');
        if (!$email) {
            return redirect()->route('br.otp.email.form')->with('error', 'Session expirée. Recommencez.');
        }

        $user = User::where('email', $email)->first();

        if (!$user || !$user->verifierOtp($request->code)) {
            return back()->with('error', 'Code incorrect ou expiré.')->withInput();
        }

        $user->invaliderOtp();
        $user->update([
            'email_verified'     => true,
            'derniere_connexion' => now(),
        ]);

        session()->forget('br_otp_email');
        auth('brfinal')->login($user, true);

        return $user->estAdmin()
            ? redirect()->route('br.admin.dashboard')
            : redirect()->route('br.membre.dashboard');
    }

    // =============================================
    //  MOT DE PASSE OUBLIÉ — RÉINITIALISATION PAR OTP
    // =============================================

    /**
     * Formulaire de demande de réinitialisation (téléphone ou email).
     */
    public function passwordOtpForm()
    {
        return view('br-final.auth.password-otp-request');
    }

    /**
     * Envoie le code OTP de réinitialisation par SMS (via votre service)
     * ou par email selon le choix de l'utilisateur.
     */
    public function passwordOtpEnvoyer(Request $request)
    {
        $methode = $request->input('methode', 'telephone');

        if ($methode === 'email') {
            $request->validate(['email' => 'required|email|exists:br_users,email']);
            $user = User::where('email', $request->email)->firstOrFail();
            $contact = $user->email;
        } else {
            $request->validate(['telephone' => 'required|exists:br_users,telephone']);
            $user = User::where('telephone', $request->telephone)->firstOrFail();
            $contact = $user->telephone;
        }

        // Générer le code OTP (on réutilise la méthode du modèle)
        $code = $user->genererOtp();

        if ($methode === 'email') {
            // Envoi par email — créez le Mailable PasswordResetOtpMail (voir commentaires)
            Mail::to($user->email)->send(new PasswordResetOtpMail($user, $code));
        } else {
            // Envoi par SMS — intégrez ici votre service SMS (ex: Twilio, Africa's Talking…)
            // Exemple : SMSService::send($user->telephone, "Votre code de réinitialisation Business Room : $code");
            //
            // Si vous n'avez pas encore de service SMS, vous pouvez temporairement
            // envoyer par email si l'utilisateur en a un, sinon afficher le code en session debug.
            if ($user->email) {
                Mail::to($user->email)->send(new PasswordResetOtpMail($user, $code));
            }
            // TODO: ajouter envoi SMS réel ici
        }

        // Stocker en session pour l'étape suivante
        session([
            'br_reset_user_id' => $user->id,
            'br_reset_contact' => $this->maskContact($contact, $methode),
        ]);

        return redirect()->route('br.password.otp.verify.form')
            ->with('success', 'Code OTP envoyé à ' . $this->maskContact($contact, $methode));
    }

    /**
     * Formulaire de saisie du code OTP + nouveau mot de passe.
     */
    public function passwordOtpVerifyForm()
    {
        if (!session('br_reset_user_id')) {
            return redirect()->route('br.password.otp.form')
                ->with('error', 'Session expirée. Recommencez.');
        }
        return view('br-final.auth.password-otp-reset');
    }

    /**
     * Vérification du code OTP + mise à jour du mot de passe.
     */
    public function passwordOtpReset(Request $request)
    {
        $request->validate([
            'code'     => 'required|string|size:6',
            'password' => 'required|min:6|confirmed',
        ]);

        $userId = session('br_reset_user_id');
        if (!$userId) {
            return redirect()->route('br.password.otp.form')
                ->with('error', 'Session expirée. Recommencez.');
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('br.password.otp.form')
                ->with('error', 'Utilisateur introuvable.');
        }

        // Vérifier le code OTP
        if (!$user->verifierOtp($request->code)) {
            return back()->with('error', 'Code OTP incorrect ou expiré. Réessayez.')->withInput();
        }

        // Invalider l'OTP et mettre à jour le mot de passe
        $user->invaliderOtp();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Nettoyer la session
        session()->forget(['br_reset_user_id', 'br_reset_contact']);

        return redirect()->route('br.login')
            ->with('success', 'Mot de passe réinitialisé avec succès. Connectez-vous !');
    }

    // =============================================
    //  AUTHENTIFICATION FIREBASE (Google / Apple)
    // =============================================

    /**
     * Reçoit le token Firebase ID depuis le front (JS SDK Firebase),
     * le vérifie auprès de Firebase REST API, et connecte/crée l'utilisateur.
     *
     * POST /br/auth/firebase
     * Body : { idToken: "...", code_parrain: "..." (optionnel) }
     */
    public function firebaseAuth(Request $request)
    {
        $request->validate(['idToken' => 'required|string']);

        // --- Vérification du token Firebase ---
        $firebaseProjectId = config('services.firebase.project_id');
        $verifyUrl = "https://identitytoolkit.googleapis.com/v1/accounts:lookup?key=" . config('services.firebase.web_api_key');

        $response = Http::post($verifyUrl, ['idToken' => $request->idToken]);

        if (!$response->successful()) {
            return response()->json(['error' => 'Token Firebase invalide.'], 401);
        }

        $firebaseUser = $response->json('users.0');
        if (!$firebaseUser) {
            return response()->json(['error' => 'Utilisateur Firebase introuvable.'], 401);
        }

        $firebaseUid  = $firebaseUser['localId'];
        $email        = $firebaseUser['email'] ?? null;
        $displayName  = $firebaseUser['displayName'] ?? null;
        $provider     = $this->detectProvider($firebaseUser['providerUserInfo'] ?? []);
        $googleId     = $provider === 'google' ? $firebaseUid : null;
        $appleId      = $provider === 'apple'  ? $firebaseUid : null;

        // --- Trouver ou créer l'utilisateur ---
        $user = User::where('firebase_uid', $firebaseUid)->first()
             ?? ($email ? User::where('email', $email)->first() : null);

        if (!$user) {
            // Vérifier le code parrain (obligatoire pour le register)
            $codeParrain = $request->code_parrain;
            if ($codeParrain && !User::where('telephone', $codeParrain)->exists()) {
                return response()->json(['error' => 'Code de parrainage invalide.'], 422);
            }

            // Décomposer le displayName en prénom/nom
            $parts  = $displayName ? explode(' ', $displayName, 2) : [];
            $prenom = $parts[0] ?? 'Membre';
            $nom    = $parts[1] ?? 'Business';

            $user = User::create([
                'nom'           => strtoupper($nom),
                'prenom'        => $prenom,
                'email'         => $email,
                'telephone'     => 'oauth_' . Str::random(10),
                'firebase_uid'  => $firebaseUid,
                'google_id'     => $googleId,
                'apple_id'      => $appleId,
                'auth_provider' => $provider,
                'email_verified'=> (bool) ($firebaseUser['emailVerified'] ?? false),
            ]);

            $this->attachParrain($user, $codeParrain);
        } else {
            // Mettre à jour les infos Firebase si l'utilisateur existait sans OAuth
            $user->update([
                'firebase_uid'  => $firebaseUid,
                'google_id'     => $googleId ?? $user->google_id,
                'apple_id'      => $appleId  ?? $user->apple_id,
                'auth_provider' => $user->auth_provider ?? $provider,
                'email_verified'=> true,
            ]);
        }

        $user->update(['derniere_connexion' => now()]);
        auth('brfinal')->login($user, true);

        $redirectUrl = $user->estAdmin()
            ? route('br.admin.dashboard')
            : route('br.membre.dashboard');

        return response()->json(['redirect' => $redirectUrl]);
    }

    // =============================================
    //  DÉCONNEXION
    // =============================================

    public function logout()
    {
        auth('brfinal')->logout();
        return redirect()->route('br.login');
    }

    // =============================================
    //  HELPERS PRIVÉS
    // =============================================

    private function detectProvider(array $providerUserInfo): string
    {
        foreach ($providerUserInfo as $info) {
            if (str_contains($info['providerId'] ?? '', 'google')) return 'google';
            if (str_contains($info['providerId'] ?? '', 'apple'))  return 'apple';
        }
        return 'email';
    }

    private function attachParrain(User $user, ?string $codeParrain): void
    {
        if (!$codeParrain) return;
        $parrain = User::where('telephone', $codeParrain)->first();
        if ($parrain && $parrain->id !== $user->id) {
            Referral::create([
                'parrain_id' => $parrain->id,
                'filleul_id' => $user->id,
                'statut'     => 'en_attente',
            ]);
        }
    }

    /**
     * Masque partiellement le contact pour l'affichage (confidentialité).
     * Ex: 697123456 → 6***456 | jean@email.com → j***@email.com
     */
    private function maskContact(string $contact, string $methode): string
    {
        if ($methode === 'email') {
            $parts = explode('@', $contact);
            $name  = $parts[0];
            $masked = substr($name, 0, 1) . str_repeat('*', max(strlen($name) - 1, 3)) . '@' . ($parts[1] ?? '');
            return $masked;
        }
        // Téléphone
        return substr($contact, 0, 1) . str_repeat('*', strlen($contact) - 4) . substr($contact, -3);
    }

    // =============================================
    //  DEV PORTAL (développement uniquement)
    // =============================================

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