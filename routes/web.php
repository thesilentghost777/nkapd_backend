<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrFinal\AuthController;
use App\Http\Controllers\BrFinal\AdminController;
use App\Http\Controllers\BrFinal\MembreController;
use App\Http\Controllers\BrFinal\TontineController;
use App\Http\Controllers\BrFinal\LoanController;
use App\Http\Controllers\BrFinal\PaymentController;
use App\Http\Controllers\BrFinal\CashbookController;
use App\Http\Controllers\BrFinal\BusinessController;
use App\Http\Controllers\BrFinal\AssistanceController;


// ===== ROUTE RACINE AVEC REDIRECTION =====
Route::get('/', function () {
    // Vérifier si l'utilisateur est connecté avec le guard brfinal
    if (Auth::guard('brfinal')->check()) {
        $user = Auth::guard('brfinal')->user();
        
        // Vérifier si c'est un admin
        if ($user->role === 'admin') {
            return redirect()->route('br.admin.dashboard');
        }
        
        // Vérifier si c'est un membre (adherent)
        if ($user->role === 'membre') {
            return redirect()->route('br.membre.dashboard');
        }
    }
    
    // Si non connecté, rediriger vers le portail
    return redirect()->route('br.portail');
})->name('home');

// Route pour le portail (page d'accueil publique)
Route::get('/portail', [AuthController::class, 'portail'])->name('br.portail');



// ===== AUTH =====
Route::prefix('br')->name('br.')->group(function () {

    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/dev-login', [AuthController::class, 'devLogin'])->name('dev-login');

    // Webhook (pas d'auth)
    Route::post('/webhook/moneyfusion', [PaymentController::class, 'webhook'])->name('webhook.moneyfusion');
    Route::get('/paiement/callback', [PaymentController::class, 'callback'])->name('paiement.callback');

    // ===== ESPACE MEMBRE =====
    Route::middleware(['brfinal.membre'])->prefix('membre')->name('membre.')->group(function () {

        Route::get('/dashboard', [MembreController::class, 'dashboard'])->name('dashboard');
        Route::get('/profil', [MembreController::class, 'profil'])->name('profil');
        Route::put('/profil', [MembreController::class, 'updateProfil'])->name('profil.update');
        Route::get('/notifications', [MembreController::class, 'notifications'])->name('notifications');

        // Adhésion
        Route::post('/adhesion', [PaymentController::class, 'adhesion'])->name('adhesion');

        // Tontine
        Route::get('/tontine', [TontineController::class, 'index'])->name('tontine.index');
        Route::post('/tontine/creer', [TontineController::class, 'creer'])->name('tontine.creer');
        Route::post('/tontine/{tontine}/cotiser', [TontineController::class, 'cotiser'])->name('tontine.cotiser');
        Route::post('/tontine/{tontine}/retrait', [TontineController::class, 'demanderRetrait'])->name('tontine.retrait');
        Route::post('/tontine/retirer-tout', [TontineController::class, 'retirerTout'])->name('tontine.retirer-tout');

        // Prêt
        Route::get('/pret', [LoanController::class, 'index'])->name('pret.index');
        Route::post('/pret/demander', [LoanController::class, 'demander'])->name('pret.demander');
        Route::post('/pret/{loan}/rembourser', [LoanController::class, 'rembourser'])->name('pret.rembourser');

        // Cahier de caisse
        Route::get('/cashbook', [CashbookController::class, 'index'])->name('cashbook.index');
        Route::post('/cashbook', [CashbookController::class, 'store'])->name('cashbook.store');
        Route::get('/cashbook/{cashbook}', [CashbookController::class, 'show'])->name('cashbook.show');
        Route::post('/cashbook/{cashbook}/valider', [CashbookController::class, 'valider'])->name('cashbook.valider');
        Route::get('/cashbook/{cashbook}/pdf', [CashbookController::class, 'exportPdf'])->name('cashbook.pdf');

        // Business
        Route::get('/business', [BusinessController::class, 'index'])->name('business.index');
        Route::post('/business', [BusinessController::class, 'store'])->name('business.store');
        Route::get('/business/{item}', [BusinessController::class, 'show'])->name('business.show');
        Route::delete('/business/{item}', [BusinessController::class, 'destroy'])->name('business.destroy');

        // Assistance
        Route::get('/assistance', [AssistanceController::class, 'index'])->name('assistance.index');
        Route::post('/assistance', [AssistanceController::class, 'store'])->name('assistance.store');
        Route::get('/assistance/{assistance}', [AssistanceController::class, 'show'])->name('assistance.show');
        Route::post('/assistance/{assistance}/message', [AssistanceController::class, 'message'])->name('assistance.message');
    });

    // ===== ESPACE ADMIN =====
    Route::middleware(['brfinal.membre', 'brfinal.admin'])->prefix('admin')->name('admin.')->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Membres
        Route::get('/membres', [AdminController::class, 'membres'])->name('membres');
        Route::get('/membres/{user}', [AdminController::class, 'membreShow'])->name('membres.show');
        Route::post('/membres/{user}/toggle', [AdminController::class, 'membreToggle'])->name('membres.toggle');

        // Tontines
        Route::get('/tontines', [AdminController::class, 'tontines'])->name('tontines');
        Route::get('/tontines/retraits', [AdminController::class, 'tontineRetraits'])->name('tontines.retraits');
        Route::post('/tontines/{tontine}/valider-retrait', [AdminController::class, 'tontineValiderRetrait'])->name('tontines.valider-retrait');

        // Prêts
        Route::get('/prets', [AdminController::class, 'prets'])->name('prets');
        Route::get('/prets/{loan}', [AdminController::class, 'pretShow'])->name('prets.show');
        Route::post('/prets/{loan}/approuver', [AdminController::class, 'pretApprouver'])->name('prets.approuver');
        Route::post('/prets/{loan}/rejeter', [AdminController::class, 'pretRejeter'])->name('prets.rejeter');

        // Transactions
        Route::get('/transactions', [AdminController::class, 'transactions'])->name('transactions');

        // Assistance
        Route::get('/assistances', [AdminController::class, 'assistances'])->name('assistances');
        Route::get('/assistances/{assistance}', [AdminController::class, 'assistanceShow'])->name('assistances.show');
        Route::post('/assistances/{assistance}/repondre', [AdminController::class, 'assistanceRepondre'])->name('assistances.repondre');

        // Business
        Route::get('/business', [AdminController::class, 'business'])->name('business');
        Route::post('/business/{item}/toggle', [AdminController::class, 'businessToggle'])->name('business.toggle');

        // Notifications
        Route::get('/notifications/creer', [AdminController::class, 'notificationForm'])->name('notifications.create');
        Route::post('/notifications', [AdminController::class, 'notificationEnvoyer'])->name('notifications.store');
    });
});
