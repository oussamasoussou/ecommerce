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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('sous_titre')->nullable();
            $table->string('image');
            $table->integer('ordre')->default(0);
            $table->boolean('est_actif')->default(true);
            $table->string('lien')->nullable();
            $table->string('texte_bouton')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
