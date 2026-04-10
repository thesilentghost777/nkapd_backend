<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ===== USERS =====
        Schema::create('br_users', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('telephone')->unique();
            $table->string('email')->nullable()->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'membre'])->default('membre');
            $table->enum('statut', ['en_attente', 'membre', 'suspendu'])->default('en_attente');
            $table->decimal('solde_adhesion', 12, 2)->default(0);
            $table->boolean('adhesion_payee')->default(false);
            $table->string('photo')->nullable();
            $table->string('ville')->nullable();
            $table->string('quartier')->nullable();
            $table->text('bio')->nullable();
            $table->string('whatsapp')->nullable();
            $table->timestamp('derniere_connexion')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // ===== REFERRALS (PARRAINAGE) =====
        Schema::create('br_referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parrain_id')->constrained('br_users')->cascadeOnDelete();
            $table->foreignId('filleul_id')->constrained('br_users')->cascadeOnDelete();
            $table->enum('statut', ['en_attente', 'actif', 'inactif'])->default('en_attente');
            $table->timestamps();

            $table->unique(['parrain_id', 'filleul_id']);
        });

        // ===== TONTINES =====
        Schema::create('br_tontines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('br_users')->cascadeOnDelete();
            $table->enum('type', ['journaliere', 'hebdomadaire']);
            $table->decimal('objectif', 12, 2);
            $table->decimal('montant_cotisation', 12, 2); // calculé auto
            $table->decimal('total_cotise', 12, 2)->default(0);
            $table->decimal('total_a_recevoir', 12, 2); // calculé auto
            $table->integer('nb_cotisations_faites')->default(0);
            $table->integer('nb_cotisations_total');
            $table->enum('statut', ['active', 'complete', 'retrait_demande', 'retrait_valide', 'cloturee'])->default('active');
            $table->date('date_debut');
            $table->date('date_fin_estimee')->nullable();
            $table->timestamps();
        });

        // ===== CONTRIBUTIONS (COTISATIONS TONTINE) =====
        Schema::create('br_contributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tontine_id')->constrained('br_tontines')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('br_users')->cascadeOnDelete();
            $table->decimal('montant', 12, 2);
            $table->date('date_cotisation');
            $table->enum('statut', ['pending', 'paid', 'failure'])->default('pending');
            $table->string('token_paiement')->nullable()->index();
            $table->timestamps();
        });

        // ===== LOANS (PRÊTS) =====
        Schema::create('br_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('br_users')->cascadeOnDelete();
            $table->decimal('montant_demande', 12, 2);
            $table->decimal('montant_accorde', 12, 2)->nullable();
            $table->decimal('taux_interet', 5, 2)->default(5.00); // 5%
            $table->decimal('taux_assurance', 5, 2)->default(6.50); // 6.5%
            $table->decimal('montant_total_du', 12, 2)->nullable(); // capital + intérêt + assurance
            $table->decimal('montant_rembourse', 12, 2)->default(0);
            $table->decimal('penalites', 12, 2)->default(0);
            $table->integer('nb_filleuls_au_moment')->default(0);
            $table->decimal('plafond_calcule', 12, 2)->default(0); // 50000 * filleuls
            $table->enum('statut', ['en_attente', 'approuve', 'rejete', 'en_cours', 'rembourse', 'en_retard'])->default('en_attente');
            $table->text('motif_refus')->nullable();
            $table->date('date_echeance')->nullable();
            $table->date('date_approbation')->nullable();
            $table->timestamps();
        });

        // ===== LOAN REPAYMENTS =====
        Schema::create('br_loan_repayments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained('br_loans')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('br_users')->cascadeOnDelete();
            $table->decimal('montant', 12, 2);
            $table->date('date_paiement');
            $table->enum('statut', ['pending', 'paid', 'failure'])->default('pending');
            $table->string('token_paiement')->nullable()->index();
            $table->timestamps();
        });

        // ===== PAYMENTS (TRANSACTIONS MONEYFUSION) =====
        Schema::create('br_payments', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->foreignId('user_id')->constrained('br_users')->cascadeOnDelete();
            $table->enum('type', ['adhesion', 'tontine', 'remboursement']);
            $table->morphs('payable'); // payable_type + payable_id
            $table->decimal('montant', 12, 2);
            $table->decimal('frais', 12, 2)->default(0);
            $table->string('token_paiement')->nullable()->unique();
            $table->string('numero_telephone')->nullable();
            $table->string('nom_client')->nullable();
            $table->string('url_paiement')->nullable();
            $table->enum('statut', ['pending', 'paid', 'failure', 'no_paid'])->default('pending');
            $table->string('moyen_paiement')->nullable();
            $table->string('numero_transaction')->nullable();
            $table->json('webhook_data')->nullable();
            $table->json('personal_info')->nullable();
            $table->timestamps();
        });

        // ===== CASHBOOKS =====
        Schema::create('br_cashbooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('br_users')->cascadeOnDelete();
            $table->integer('mois');
            $table->integer('annee');
            $table->decimal('total_entrees', 12, 2)->default(0);
            $table->decimal('total_sorties', 12, 2)->default(0);
            $table->decimal('solde', 12, 2)->default(0);
            $table->boolean('valide')->default(false);
            $table->date('date_validation')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'mois', 'annee']);
        });

        // ===== CASHBOOK ENTRIES =====
        Schema::create('br_cashbook_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cashbook_id')->constrained('br_cashbooks')->cascadeOnDelete();
            $table->date('date');
            $table->string('libelle');
            $table->enum('type', ['entree', 'sortie']);
            $table->decimal('montant', 12, 2);
            $table->string('categorie')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });

        // ===== BUSINESS ITEMS =====
        Schema::create('br_business_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('br_users')->cascadeOnDelete();
            $table->string('titre');
            $table->text('description');
            $table->decimal('prix', 12, 2)->nullable();
            $table->string('categorie');
            $table->string('image')->nullable();
            $table->string('whatsapp')->nullable();
            $table->boolean('actif')->default(true);
            $table->integer('vues')->default(0);
            $table->timestamps();
        });

        // ===== ASSISTANCE REQUESTS =====
Schema::create('br_assistance_requests', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('br_users')->cascadeOnDelete();
    $table->string('sujet');
    $table->text('description');
    $table->enum('type', ['maladie_grave', 'sinistre', 'invalidite', 'pret_bancaire', 'juridique', 'managerial', 'marketing', 'mise_en_relation', 'autre'])->default('autre');
    $table->enum('statut', ['en_attente', 'en_cours', 'resolu', 'rejete'])->default('en_attente');
    $table->text('reponse_admin')->nullable();
    $table->timestamps();
});

        // ===== MESSAGES =====
        Schema::create('br_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assistance_id')->constrained('br_assistance_requests')->cascadeOnDelete();
            $table->foreignId('sender_id')->constrained('br_users')->cascadeOnDelete();
            $table->text('contenu');
            $table->boolean('lu')->default(false);
            $table->timestamps();
        });

        // ===== NOTIFICATIONS =====
        Schema::create('br_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('br_users')->cascadeOnDelete();
            $table->boolean('globale')->default(false);
            $table->string('titre');
            $table->text('contenu');
            $table->enum('type', ['info', 'success', 'warning', 'danger'])->default('info');
            $table->boolean('lu')->default(false);
            $table->timestamp('expire_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('br_notifications');
        Schema::dropIfExists('br_messages');
        Schema::dropIfExists('br_assistance_requests');
        Schema::dropIfExists('br_business_items');
        Schema::dropIfExists('br_cashbook_entries');
        Schema::dropIfExists('br_cashbooks');
        Schema::dropIfExists('br_payments');
        Schema::dropIfExists('br_loan_repayments');
        Schema::dropIfExists('br_loans');
        Schema::dropIfExists('br_contributions');
        Schema::dropIfExists('br_tontines');
        Schema::dropIfExists('br_referrals');
        Schema::dropIfExists('br_users');
    }
};
