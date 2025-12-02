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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Nom du rôle (admin, super-admin, client)
            $table->string('description')->nullable(); // Description optionnelle
            $table->timestamps();
        });

        // Insertion des rôles par défaut
        DB::table('roles')->insert([
            ['name' => 'super-admin', 'description' => 'Accès complet à toutes les fonctionnalités', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'admin', 'description' => 'Gestion des utilisateurs et des ressources', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'client', 'description' => 'Utilisateur final avec accès limité', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
