<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ===== BR_USERS : ajout des champs OAuth & OTP =====
        Schema::table('br_users', function (Blueprint $table) {
            // Firebase / OAuth
            $table->string('firebase_uid')->nullable()->unique()->after('whatsapp');
            $table->string('google_id')->nullable()->unique()->after('firebase_uid');
            $table->string('apple_id')->nullable()->unique()->after('google_id');
            $table->string('auth_provider')->nullable()->after('apple_id'); // 'google', 'apple', 'email', null

            // OTP email
            $table->string('otp_code', 6)->nullable()->after('auth_provider');
            $table->timestamp('otp_expires_at')->nullable()->after('otp_code');
            $table->boolean('email_verified')->default(false)->after('otp_expires_at');

            // Le mot de passe devient nullable (OAuth n'en a pas)
            $table->string('password')->nullable()->change();
        });

        // ===== BR_LOANS : ajout des champs durée & frais =====
        Schema::table('br_loans', function (Blueprint $table) {
            // Durée choisie par l'emprunteur
            $table->integer('duree_valeur')->nullable()->after('montant_demande');      // ex: 30, 3
            $table->enum('duree_unite', ['jours', 'mois'])->nullable()->after('duree_valeur'); // 'jours' ou 'mois'

            // Frais de dossier (3% prélevés au déblocage)
            $table->decimal('frais_dossier', 12, 2)->default(0)->after('taux_assurance');

            // Montant net reçu par le membre (montant_accorde - frais_dossier)
            $table->decimal('montant_net_verse', 12, 2)->nullable()->after('frais_dossier');

            // Taux de pénalité courant (peut changer selon dépassement)
            $table->decimal('taux_penalite_jour', 5, 4)->default(0.1000)->after('penalites');  // 0.1% / jour
            $table->decimal('taux_penalite_mois', 5, 4)->default(2.0000)->after('taux_penalite_jour'); // 2% / mois

            // Date du dernier calcul de pénalité (pour éviter les doublons)
            $table->date('date_dernier_calcul_penalite')->nullable()->after('date_approbation');
        });
    }

    public function down(): void
    {
        Schema::table('br_users', function (Blueprint $table) {
            $table->dropColumn([
                'firebase_uid', 'google_id', 'apple_id', 'auth_provider',
                'otp_code', 'otp_expires_at', 'email_verified',
            ]);
            $table->string('password')->nullable(false)->change();
        });

        Schema::table('br_loans', function (Blueprint $table) {
            $table->dropColumn([
                'duree_valeur', 'duree_unite',
                'frais_dossier', 'montant_net_verse',
                'taux_penalite_jour', 'taux_penalite_mois',
                'date_dernier_calcul_penalite',
            ]);
        });
    }
};