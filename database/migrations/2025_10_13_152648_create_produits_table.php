<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sous_categorie_id')->nullable();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->integer('quantite')->default(0);

            $table->decimal('prix_ht', 10, 2)->nullable();
            $table->decimal('prix_tva', 10, 2)->nullable();
            $table->decimal('prix_ttc', 10, 2)->nullable();
            $table->decimal('prix_promotionnel', 10, 2)->nullable();

            $table->decimal('poids', 10, 2)->nullable();
            $table->boolean('est_actif')->default(false);

            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('sous_categorie_id')
                ->references('id')
                ->on('sous_categories')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
