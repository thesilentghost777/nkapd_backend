<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
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

    public function down(): void
    {
        Schema::dropIfExists('nkap_payment_tracking');
    }
};