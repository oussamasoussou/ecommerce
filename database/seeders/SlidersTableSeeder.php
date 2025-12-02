<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SlidersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sliders')->insert([
            [
                'titre' => "Ne manquez pas nos incroyables\npromotions alimentaires",
                'sous_titre' => "Inscrivez-vous à notre newsletter quotidienne",
                'image' => "sliders/slider-1.jpg",
                'ordre' => 1,
                'est_actif' => true,
                'lien' => "/promotions",
                'texte_bouton' => "Voir les promotions",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => "Légumes Frais\nGrosses remises",
                'sous_titre' => "Économisez jusqu'à 50% sur votre première commande",
                'image' => "sliders/slider-2.jpg",
                'ordre' => 2,
                'est_actif' => true,
                'lien' => "/legumes-frais",
                'texte_bouton' => "Acheter maintenant",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => "Produits Bio\nLivraison gratuite",
                'sous_titre' => "Profitez de la livraison gratuite sur toutes vos commandes",
                'image' => "sliders/slider-3.jpg",
                'ordre' => 3,
                'est_actif' => true,
                'lien' => "/produits-bio",
                'texte_bouton' => "Découvrir",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => "Nouvelle Collection\nÉté 2024",
                'sous_titre' => "Découvrez nos nouveaux produits de saison",
                'image' => "sliders/slider-4.jpg",
                'ordre' => 4,
                'est_actif' => false, // Désactivé pour l'exemple
                'lien' => "/nouveautes",
                'texte_bouton' => "Explorer",
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}