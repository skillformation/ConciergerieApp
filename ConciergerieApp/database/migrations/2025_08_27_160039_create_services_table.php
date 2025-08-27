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
        Schema::create('services', function (Blueprint $table) {
            $table->id('id_service');
            $table->foreignId('id_categorie')->constrained('categorie_services', 'id_categorie')->onDelete('cascade');
            $table->string('nom_service', 200);
            $table->text('description')->nullable();
            $table->boolean('disponible_24h')->default(false);
            $table->enum('niveau_requis', ['essentiel', 'prestige', 'excellence']);
            $table->integer('duree_moyenne')->nullable()->comment('Durée en minutes');
            $table->decimal('prix_unitaire', 10, 2)->nullable();
            $table->boolean('actif')->default(true);
            $table->timestamps();

            $table->index(['id_categorie']);
            $table->index(['niveau_requis']);
            $table->index(['actif']);
            $table->index(['disponible_24h']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
