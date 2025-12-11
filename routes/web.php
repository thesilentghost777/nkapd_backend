<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ComplexeController;

// NKAP Admin Controllers
use App\Http\Controllers\Admin\NkapDashboardController;
use App\Http\Controllers\Admin\NkapUserController;
use App\Http\Controllers\Admin\TontineController;
use App\Http\Controllers\Admin\NkapTransactionController;
use App\Http\Controllers\Admin\NkapProduitController;
use App\Http\Controllers\Admin\NkapConfigurationController;
use App\Http\Controllers\Admin\NkapConversationController;
use App\Http\Controllers\Admin\AnnonceRencontreController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/dashboard', [NkapDashboardController::class, 'index'])->name('dashboard');

// ===================== NKAP ADMIN ROUTES =====================
Route::prefix('admin/nkap')->name('admin.nkap.')->middleware('auth')->group(function () {
    // Dashboard

    // Utilisateurs
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [NkapUserController::class, 'index'])->name('index');
        Route::get('/{id}', [NkapUserController::class, 'show'])->name('show');
        Route::get('/{id}/transactions', [NkapUserController::class, 'transactions'])->name('transactions');
        Route::post('/{id}/toggle-status', [NkapUserController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/{id}/toggle-admin', [NkapUserController::class, 'toggleAdmin'])->name('toggle-admin');
        Route::delete('/{id}', [NkapUserController::class, 'destroy'])->name('destroy');
    });

    // Tontines
    Route::prefix('tontines')->name('tontines.')->group(function () {
        Route::get('/', [TontineController::class, 'index'])->name('index');
        Route::get('/{id}', [TontineController::class, 'show'])->name('show');
        Route::post('/{id}/statut', [TontineController::class, 'updateStatut'])->name('update-statut');
        Route::delete('/{id}', [TontineController::class, 'destroy'])->name('destroy');
    });

    // Transactions
    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', [NkapTransactionController::class, 'index'])->name('index');
        Route::get('/{id}', [NkapTransactionController::class, 'show'])->name('show');
    });

    // Produits
    Route::prefix('produits')->name('produits.')->group(function () {
        Route::get('/', [NkapProduitController::class, 'index'])->name('index');
        Route::get('/{id}', [NkapProduitController::class, 'show'])->name('show');
        Route::post('/{id}/statut', [NkapProduitController::class, 'updateStatut'])->name('update-statut');
        Route::delete('/{id}', [NkapProduitController::class, 'destroy'])->name('destroy');
    });

    // Configurations
    Route::prefix('configurations')->name('configurations.')->group(function () {
        Route::get('/', [NkapConfigurationController::class, 'index'])->name('index');
        Route::post('/', [NkapConfigurationController::class, 'update'])->name('update');
    });

    // ============ CONVERSATIONS ============
    Route::prefix('conversations')->name('conversations.')->group(function () {
        Route::get('/', [NkapConversationController::class, 'index'])->name('index');
        Route::get('/{id}', [NkapConversationController::class, 'show'])->name('show');
        Route::delete('/{id}', [NkapConversationController::class, 'destroy'])->name('destroy');
        Route::delete('/{conversationId}/messages/{messageId}', [NkapConversationController::class, 'destroyMessage'])->name('messages.destroy');
    });

    // ============ ANNONCES RENCONTRE ============
    Route::prefix('rencontres')->name('rencontres.')->group(function () {
        Route::get('/', [AnnonceRencontreController::class, 'index'])->name('index');
        Route::get('/{id}', [AnnonceRencontreController::class, 'show'])->name('show');
        Route::delete('/{id}', [AnnonceRencontreController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/toggle-statut', [AnnonceRencontreController::class, 'toggleStatut'])->name('toggle-statut');
    });
});

require __DIR__.'/auth.php';
