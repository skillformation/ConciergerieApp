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
        Schema::table('plan_services', function (Blueprint $table) {
            // Changer l'enum pour correspondre aux valeurs Filament
            $table->dropColumn('niveau_service');
        });

        Schema::table('plan_services', function (Blueprint $table) {
            $table->enum('niveau_service', ['basique', 'standard', 'premium', 'entreprise'])
                  ->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plan_services', function (Blueprint $table) {
            $table->dropColumn('niveau_service');
        });

        Schema::table('plan_services', function (Blueprint $table) {
            $table->enum('niveau_service', ['base', 'intermediaire', 'premium'])
                  ->after('description');
        });
    }
};