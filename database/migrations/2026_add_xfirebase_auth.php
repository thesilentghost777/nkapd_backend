<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('elite_users', function (Blueprint $table) {
            // Identifiant Firebase unique (Google, Apple, Phone)
            $table->string('firebase_uid')->nullable()->unique()->after('id');

            // Méthode d'authentification : 'phone', 'email', 'google', 'apple'
            $table->enum('auth_provider', ['phone', 'email', 'google', 'apple'])
                  ->default('phone')
                  ->after('firebase_uid');

            // Pour l'OTP email — stocké haché
            $table->string('email_otp_hash')->nullable()->after('auth_provider');
            $table->timestamp('email_otp_expires_at')->nullable()->after('email_otp_hash');

            // Le mot de passe devient nullable (inutile pour Google/Apple)
            $table->string('password')->nullable()->change();

            // Le téléphone devient nullable (inutile pour Google/Apple/Email)
            $table->string('telephone')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('elite_users', function (Blueprint $table) {
            $table->dropColumn([
                'firebase_uid',
                'auth_provider',
                'email_otp_hash',
                'email_otp_expires_at',
            ]);

            $table->string('password')->nullable(false)->change();
            $table->string('telephone')->nullable(false)->change();
        });
    }
};