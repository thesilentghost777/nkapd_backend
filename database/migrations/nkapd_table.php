<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::create('nkap_users', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('telephone')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->date('date_naissance')->nullable();
            $table->enum('sexe', ['homme', 'femme'])->nullable();
            $table->string('ville')->nullable();
            $table->string('photo_profil')->nullable();
            $table->string('code_parrainage')->unique();
            $table->foreignId('parrain_id')->nullable()->constrained('nkap_users')->onDelete('set null');
            $table->decimal('solde', 15, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_founder')->default(false);
            $table->boolean('is_admin')->default(false);
            $table->json('preferences_rencontre')->nullable();
            $table->text('bio')->nullable();
            $table->timestamp('derniere_connexion')->nullable();
            $table->rememberToken();
            $table->timestamps();
            
            $table->index('code_parrainage');
            $table->index('parrain_id');
            $table->index('is_active');
        });

        Schema::create('tontines', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('nom');
            $table->foreignId('createur_id')->constrained('nkap_users')->onDelete('cascade');
            $table->decimal('prix', 15, 2);
            $table->integer('nombre_membres_requis');
            $table->integer('nombre_membres_actuels')->default(0);
            $table->decimal('montant_total', 15, 2)->default(0);
            $table->enum('statut', ['en_cours', 'fermee', 'annulee'])->default('en_cours');
            $table->timestamp('date_fermeture')->nullable();
            $table->timestamps();
            
            $table->index('code');
            $table->index('createur_id');
            $table->index('statut');
        });

        Schema::create('tontine_membres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tontine_id')->constrained('tontines')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('nkap_users')->onDelete('cascade');
            $table->decimal('montant_paye', 15, 2);
            $table->timestamp('date_adhesion');
            $table->timestamps();
            
            $table->unique(['tontine_id', 'user_id']);
            $table->index('tontine_id');
            $table->index('user_id');
        });

        Schema::create('nkap_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('nkap_users')->onDelete('cascade');
            $table->enum('type', [
                'recharge',
                'retrait',
                'transfert_envoye',
                'transfert_recu',
                'creation_tontine',
                'adhesion_tontine',
                'gain_tontine',
                'bonus_parrainage',
                'frais_mensuel',
                'frais_admin'
            ]);
            $table->decimal('montant', 15, 2);
            $table->decimal('solde_avant', 15, 2);
            $table->decimal('solde_apres', 15, 2);
            $table->string('description')->nullable();
            $table->string('reference')->unique();
            $table->enum('statut', ['en_attente', 'complete', 'echouee', 'annulee'])->default('en_attente');
            $table->foreignId('destinataire_id')->nullable()->constrained('nkap_users')->onDelete('set null');
            $table->decimal('frais', 15, 2)->nullable();
            $table->string('methode_paiement')->nullable();
            $table->string('reference_externe')->nullable();
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('type');
            $table->index('statut');
            $table->index('reference');
            $table->index('created_at');
        });

        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendeur_id')->constrained('nkap_users')->onDelete('cascade');
            $table->string('titre');
            $table->text('description');
            $table->decimal('prix', 15, 2);
            $table->string('categorie');
            $table->json('images')->nullable();
            $table->string('ville')->nullable();
            $table->string('telephone_contact')->nullable();
            $table->string('whatsapp')->nullable();
            $table->enum('statut', ['actif', 'inactif', 'vendu', 'refuse'])->default('actif');
            $table->integer('vues')->default(0);
            $table->timestamps();
            
            $table->index('vendeur_id');
            $table->index('categorie');
            $table->index('statut');
        });

        Schema::create('annonces_rencontre', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('nkap_users')->onDelete('cascade');
            $table->enum('type', ['amoureuse', 'partenaire_business', 'autre']);
            $table->string('titre');
            $table->text('description')->nullable();
            $table->json('preferences')->nullable();
            $table->enum('statut', ['actif', 'inactif', 'expire'])->default('actif');
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('type');
            $table->index('statut');
        });

        Schema::create('nkap_conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participant1_id')->constrained('nkap_users')->onDelete('cascade');
            $table->foreignId('participant2_id')->constrained('nkap_users')->onDelete('cascade');
            $table->enum('type', ['prive', 'business', 'rencontre'])->default('prive');
            $table->timestamp('dernier_message_at')->nullable();
            $table->timestamps();
            
            $table->index(['participant1_id', 'participant2_id']);
        });

        Schema::create('nkap_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('cle')->unique();
            $table->json('valeur');
            $table->string('description')->nullable();
            $table->timestamps();
            
            $table->index('cle');
        });

        Schema::create('nkap_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expediteur_id')->constrained('nkap_users')->onDelete('cascade');
            $table->foreignId('destinataire_id')->constrained('nkap_users')->onDelete('cascade');
            $table->foreignId('conversation_id')->constrained('nkap_conversations')->onDelete('cascade');
            $table->text('contenu');
            $table->enum('type', ['texte', 'image', 'fichier'])->default('texte');
            $table->boolean('lu')->default(false);
            $table->timestamp('date_lecture')->nullable();
            $table->timestamps();
            
            $table->index('conversation_id');
            $table->index('expediteur_id');
            $table->index('destinataire_id');
            $table->index('lu');
        });

        Schema::create('nkap_payment_tracking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('nkap_users')->onDelete('cascade');
            $table->string('token_pay');
            $table->enum('type', ['recharge', 'retrait']);
            $table->decimal('montant', 15, 2);
            $table->decimal('frais', 15, 2)->nullable();
            $table->string('numero_telephone');
            $table->string('methode_paiement')->nullable();
            $table->enum('statut', ['pending', 'completed', 'cancelled', 'failed'])->default('pending');
            $table->string('payment_url')->nullable();
            $table->string('numero_transaction')->nullable();
            $table->string('moyen')->nullable();
            $table->json('webhook_data')->nullable();
            $table->string('operateur')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index('token_pay');
            $table->index('user_id');
            $table->index('statut');
        });
    }
};