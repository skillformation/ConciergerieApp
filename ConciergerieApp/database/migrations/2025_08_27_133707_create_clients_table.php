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
        Schema::create('clients', function (Blueprint $table) {
            $table->id('id_client');
            $table->string('nom', 100);
            $table->string('prenom', 100);
            $table->string('email', 255)->unique();
            $table->string('telephone', 20)->nullable();
            $table->text('adresse')->nullable();
            $table->datetime('date_inscription')->default(now());
            $table->enum('type_client', ['particulier', 'entreprise', 'syndic']);
            $table->boolean('actif')->default(true);
            $table->timestamps();

            $table->index(['email']);
            $table->index(['type_client']);
            $table->index(['actif']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
