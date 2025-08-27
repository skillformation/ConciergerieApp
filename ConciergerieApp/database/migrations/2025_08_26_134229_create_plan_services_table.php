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
        Schema::create('plan_services', function (Blueprint $table) {
            $table->id('id_plan');
            $table->string('nom_plan', 100);
            $table->decimal('prix_mensuel', 10, 2);
            $table->text('description')->nullable();
            $table->enum('niveau_service', ['base', 'intermediaire', 'premium']);
            $table->text('target')->nullable();
            $table->text('positionnement')->nullable();
            $table->boolean('actif')->default(true);
            $table->timestamps();

            $table->index(['niveau_service']);
            $table->index(['actif']);
            $table->index(['prix_mensuel']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_services');
    }
};
