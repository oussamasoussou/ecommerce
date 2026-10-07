<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaginationTest extends TestCase
{
    use RefreshDatabase;

    public function test_back_office_affiche_la_pagination_en_francais(): void
    {
        foreach (range(1, 15) as $i) {
            Category::create(['name' => "Catégorie {$i}"]);
        }
        $admin = User::factory()->create(['role_id' => 2]);

        $this->actingAs($admin)->get(route('categories.index'))
            ->assertOk()
            ->assertSee('Affichage de', false)
            ->assertSee('sur', false)
            ->assertSee('categories?page=2', false);

        $this->actingAs($admin)->get(route('categories.index', ['page' => 2]))
            ->assertOk()
            ->assertSee('Catégorie', false);
    }

    public function test_une_liste_sur_une_seule_page_affiche_le_nombre_d_elements(): void
    {
        foreach (range(1, 3) as $i) {
            Category::create(['name' => "Catégorie {$i}"]);
        }
        $admin = User::factory()->create(['role_id' => 2]);

        $this->actingAs($admin)->get(route('categories.index'))
            ->assertOk()
            ->assertSee('3 éléments', false)
            ->assertDontSee('page=2', false);
    }

    public function test_toutes_les_listes_du_back_office_s_affichent(): void
    {
        $admin = User::factory()->create(['role_id' => 2]);

        foreach (['bannieres', 'categories', 'souscategories', 'couleurs', 'tailles', 'marques',
                  'produits', 'sliders', 'deliveries', 'admin.orders'] as $route) {
            $this->actingAs($admin)->get(route($route . '.index'))->assertOk();
        }
    }

    public function test_les_marques_sont_paginees(): void
    {
        $admin = User::factory()->create(['role_id' => 2]);

        $this->actingAs($admin)->get(route('marques.index'))->assertOk();
        $this->assertInstanceOf(
            \Illuminate\Pagination\LengthAwarePaginator::class,
            $this->actingAs($admin)->get(route('marques.index'))->viewData('marques')
        );
    }

    public function test_la_boutique_pagine_et_garde_la_recherche(): void
    {
        foreach (range(1, 20) as $i) {
            Produit::create(['nom' => "Bsissa {$i}", 'quantite' => 5, 'prix_ttc' => 10, 'est_actif' => true]);
        }

        $this->get(route('shop.index'))->assertOk()->assertSee('shop?page=2', false);
        $this->get(route('shop.index', ['page' => 2]))->assertOk();

        // La recherche conserve le terme dans les liens de pagination
        $this->get(route('frontend.search', ['q' => 'Bsissa']))
            ->assertOk()
            ->assertSee('q=Bsissa&amp;page=2', false);
    }

    public function test_la_recherche_boutique_ignore_les_produits_inactifs(): void
    {
        Produit::create(['nom' => 'Bsissa visible', 'description' => 'orge', 'quantite' => 5, 'prix_ttc' => 10, 'est_actif' => true]);
        Produit::create(['nom' => 'Bsissa cachée', 'description' => 'orge', 'quantite' => 5, 'prix_ttc' => 10, 'est_actif' => false]);

        $this->get(route('shop.index', ['q' => 'orge']))
            ->assertSee('Bsissa visible')
            ->assertDontSee('Bsissa cachée');
    }
}
