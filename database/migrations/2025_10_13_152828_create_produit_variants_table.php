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
        Schema::create('produit_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produit_id');
            $table->unsignedBigInteger('couleur_id')->nullable();
            $table->unsignedBigInteger('taille_id')->nullable();
            $table->integer('quantite_variant')->default(0);

            $table->decimal('prix_ht_variant', 10, 2)->nullable();
            $table->decimal('prix_tva_variant', 10, 2)->nullable();
            $table->decimal('prix_ttc_variant', 10, 2)->nullable();
            $table->decimal('prix_promotionnel_variant', 10, 2)->nullable();

            $table->string('image_variant')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('produit_id')
                ->references('id')
                ->on('produits')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('couleur_id')
                ->references('id')
                ->on('couleurs')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('taille_id')
                ->references('id')
                ->on('tailles')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produit_variants');
    }
};
