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
        Schema::create('categorie_services', function (Blueprint $table) {
            $table->id('id_categorie');
            $table->string('nom_categorie', 100);
            $table->text('description')->nullable();
            $table->string('icone', 50)->nullable();
            $table->integer('ordre_affichage')->default(0);
            $table->boolean('actif')->default(true);
            $table->timestamp('created_at')->default(now());

            $table->index(['actif']);
            $table->index(['ordre_affichage']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorie_services');
    }
};
