<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('bannieres', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('image');
            $table->string('lien');
            $table->string('texte_bouton');
            $table->string('position'); // 'gauche', 'droite_haut', 'droite_bas'
            $table->boolean('est_actif')->default(true);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bannieres');
    }
};
