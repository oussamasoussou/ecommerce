<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannieresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bannieres')->insert([
            [
                'titre' => "Fraîcheur Quotidienne & Propreté avec Nos Produits",
                'image' => "banners/banner-1.jpg",
                'lien' => "/produits-frais",
                'texte_bouton' => "Acheter maintenant",
                'position' => "droite_haut",
                'est_actif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => "Les Meilleurs Produits Bio En Ligne",
                'image' => "banners/banner-2.jpg",
                'lien' => "/produits-bio",
                'texte_bouton' => "Acheter maintenant",
                'position' => "droite_bas",
                'est_actif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => "Promotions Spéciales Été",
                'image' => "banners/banner-3.jpg",
                'lien' => "/promotions",
                'texte_bouton' => "Voir les offres",
                'position' => "gauche",
                'est_actif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}