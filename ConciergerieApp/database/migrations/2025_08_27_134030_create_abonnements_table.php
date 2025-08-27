<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('abonnements', function (Blueprint $table) {
            $table->id('id_abonnement');
            $table->foreignId('id_client')->constrained('clients', 'id_client')->onDelete('cascade');
            $table->foreignId('id_plan')->constrained('plan_services', 'id_plan')->onDelete('restrict');
            $table->date('date_debut');
            $table->date('date_fin')->nullable();
            $table->enum('statut', ['actif', 'suspendu', 'resilie'])->default('actif');
            $table->decimal('prix_actuel', 10, 2);
            $table->string('mode_paiement', 50)->nullable();
            $table->timestamps();

            
            $table->index(['id_client']);
            $table->index(['statut']);
            $table->index(['date_debut']);
            $table->index(['date_fin']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abonnements');
    }
};
