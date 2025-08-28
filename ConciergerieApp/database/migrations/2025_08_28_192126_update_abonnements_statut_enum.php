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
        Schema::table('abonnements', function (Blueprint $table) {
            // Changer l'enum pour inclure toutes les valeurs nécessaires
            $table->dropColumn('statut');
        });

        Schema::table('abonnements', function (Blueprint $table) {
            $table->enum('statut', ['actif', 'suspendu', 'expiré', 'annulé', 'resilie'])
                  ->default('actif')
                  ->after('date_fin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('abonnements', function (Blueprint $table) {
            $table->dropColumn('statut');
        });

        Schema::table('abonnements', function (Blueprint $table) {
            $table->enum('statut', ['actif', 'suspendu', 'resilie'])
                  ->default('actif')
                  ->after('date_fin');
        });
    }
};