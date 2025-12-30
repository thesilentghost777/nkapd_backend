<?php

use Illuminate\Support\Facades\Route;

// Controllers API Nkap
use App\Http\Controllers\Api\Nkap\AuthController;
use App\Http\Controllers\Api\Nkap\TransactionController;
use App\Http\Controllers\Api\Nkap\TontineController;
use App\Http\Controllers\Api\Nkap\ParrainageController;
use App\Http\Controllers\Api\Nkap\BusinessController;
use App\Http\Controllers\Api\Nkap\RencontreController;
use App\Http\Controllers\Api\Nkap\MessageController;
use App\Http\Controllers\Api\Nkap\NotificationController;
use App\Http\Controllers\Api\Nkap\FaqController;
use App\Http\Controllers\Api\Nkap\PaymentController;

Route::prefix('nkap')->group(function () {

    //route de test
    Route::get('/test', function () {
        return response()->json(['success' => true, 'message' => 'API NKAP fonctionne correctement.']);
    });
    //route de test de post
    Route::post('/test', function () {
        return response()->json(['success' => true, 'message' => 'API NKAP fonctionne correctement.']);
    });
    // Routes publiques de callback/webhook
    Route::get('/payment/return', [PaymentController::class, 'paymentReturn'])->name('nkap.payment.return');
    Route::post('/payment/webhook', [PaymentController::class, 'paymentWebhook'])->name('nkap.payment.webhook');
    Route::post('/payout/webhook', [PaymentController::class, 'payoutWebhook'])->name('nkap.payout.webhook');

    
    // Auth (public)
    Route::post('/inscription', [AuthController::class, 'inscription']);
    Route::post('/connexion', [AuthController::class, 'connexion']);
    Route::post('/verifier-code-parrainage', [ParrainageController::class, 'verifierCode']);

    // Routes protégées
    Route::middleware('auth:sanctum')->group(function () {
        // Auth
        Route::post('/deconnexion', [AuthController::class, 'deconnexion']);
        Route::get('/profil', [AuthController::class, 'profil']);
        Route::put('/profil', [AuthController::class, 'mettreAJourProfil']);
        Route::put('/mot-de-passe', [AuthController::class, 'changerMotDePasse']);

        // Transactions
        Route::post('/recharger', [TransactionController::class, 'recharger']);
        Route::post('/retirer', [TransactionController::class, 'retirer']);
        Route::post('/transferer', [TransactionController::class, 'transferer']);
        Route::get('/transactions', [TransactionController::class, 'historique']);
        Route::get('/solde', [TransactionController::class, 'solde']);

        // Tontines
        Route::post('/tontines', [TontineController::class, 'creer']);
        Route::post('/tontines/rejoindre', [TontineController::class, 'rejoindre']);
        Route::get('/tontines/rechercher/{code}', [TontineController::class, 'rechercher']);
        Route::get('/tontines/mes-creations', [TontineController::class, 'mesCreations']);
        Route::get('/tontines/mes-adhesions', [TontineController::class, 'mesAdhesions']);
        Route::get('/tontines/{id}', [TontineController::class, 'details']);

        // Parrainage
        Route::get('/parrainage/statistiques', [ParrainageController::class, 'statistiques']);
        Route::get('/parrainage/filleuls', [ParrainageController::class, 'filleuls']);

        // Business
        Route::get('/business/produits', [BusinessController::class, 'liste']);
        Route::post('/business/produits', [BusinessController::class, 'creer']);
        Route::get('/business/produits/{id}', [BusinessController::class, 'details']);
        Route::put('/business/produits/{id}', [BusinessController::class, 'modifier']);
        Route::delete('/business/produits/{id}', [BusinessController::class, 'supprimer']);
        Route::get('/business/mes-produits', [BusinessController::class, 'mesProduits']);
        Route::post('/business/produits/{id}/vendu', [BusinessController::class, 'marquerVendu']);

        Route::post('/business/upload-image', [BusinessController::class, 'uploadImage']);
        // Rencontre
        Route::post('/rencontre/annonces', [RencontreController::class, 'creerAnnonce']);
        Route::get('/rencontre/mes-annonces', [RencontreController::class, 'mesAnnonces']);
        Route::get('/rencontre/amoureuse', [RencontreController::class, 'profilsAmoureuse']);
        Route::get('/rencontre/business', [RencontreController::class, 'annoncesBusiness']);
        Route::get('/rencontre/autre', [RencontreController::class, 'annoncesAutre']);
        Route::post('/rencontre/contacter/{userId}', [RencontreController::class, 'contacter']);

        // Messages
        Route::get('/messages/conversations', [MessageController::class, 'conversations']);
        Route::get('/messages/conversations/{id}', [MessageController::class, 'messages']);
        Route::post('/messages/conversations/{id}', [MessageController::class, 'envoyer']);
        Route::post('/messages/nouvelle', [MessageController::class, 'nouvelleConversation']);
        Route::get('/messages/non-lus', [MessageController::class, 'nombreNonLus']);
         // FAQ
        Route::post('/faq/question', [FaqController::class, 'poserQuestion']);
        Route::get('/faq', [FaqController::class, 'liste']);
    });
});
