<?php

namespace Tests\Feature;

use App\Http\Controllers\FrontEnd\OrderController;
use App\Exceptions\OrderException;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShopSecurityTest extends TestCase
{
    use RefreshDatabase;

    private function produit(array $attributes = []): Produit
    {
        return Produit::create(array_merge([
            'nom' => 'Bsissa test',
            'quantite' => 5,
            'prix_ttc' => 10,
            'est_actif' => true,
        ], $attributes));
    }

    private function order(?User $user): Order
    {
        return Order::create([
            'user_id' => $user?->id,
            'status' => 'pending',
            'total' => 10,
            'tva' => 0.2,
            'nom_client' => 'Client Test',
            'adresse_livraison' => 'Tunis',
            'telephone' => '20123456',
        ]);
    }

    // ---- Back-office ----

    public function test_un_client_ne_peut_pas_acceder_au_back_office(): void
    {
        $client = User::factory()->create(['role_id' => 3]);

        $this->actingAs($client)->get('/categories')->assertRedirect('/');
        $this->actingAs($client)->get('/produits')->assertRedirect('/');
    }

    public function test_un_admin_accede_au_back_office(): void
    {
        $admin = User::factory()->create(['role_id' => 2]);

        $this->actingAs($admin)->get('/categories')->assertOk();
    }

    public function test_un_client_ne_peut_pas_se_connecter_au_login_admin(): void
    {
        User::factory()->create(['email' => 'client@test.tn', 'role_id' => 3]);

        $this->post('/login', ['email' => 'client@test.tn', 'password' => 'password'])
            ->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    // ---- Commandes ----

    public function test_un_visiteur_ne_peut_pas_voir_une_commande(): void
    {
        $order = $this->order(User::factory()->create());

        $this->get('/orders/' . $order->id)->assertRedirect(route('frontend.login'));
    }

    public function test_un_client_ne_voit_pas_la_commande_d_un_autre(): void
    {
        $order = $this->order(User::factory()->create());
        $autre = User::factory()->create();

        $this->actingAs($autre)->get('/orders/' . $order->id)->assertNotFound();
    }

    public function test_un_client_voit_sa_commande(): void
    {
        $client = User::factory()->create();
        $order = $this->order($client);

        $this->actingAs($client)->get('/orders/' . $order->id)->assertOk()->assertSee('Client Test');
        $this->actingAs($client)->get('/account/orders')->assertOk();
    }

    // ---- Panier ----

    public function test_on_ne_peut_pas_modifier_le_panier_d_un_autre(): void
    {
        $produit = $this->produit();
        $item = Cart::create([
            'session_id' => 'session-d-un-autre-visiteur',
            'produit_id' => $produit->id,
            'quantite' => 1,
            'prix_unitaire' => 10,
            'prix_total' => 10,
        ]);

        $this->postJson('/cart/' . $item->id . '/update', ['quantite' => 4])->assertStatus(400);
        $this->assertSame(1, (int) $item->fresh()->quantite);
    }

    // ---- Création de commande ----

    public function test_la_commande_utilise_le_prix_de_la_base_et_decremente_le_stock(): void
    {
        $produit = $this->produit(['quantite' => 5, 'prix_ttc' => 12, 'prix_promotionnel' => 9.5]);

        $order = app(OrderController::class)->createFromCart(null, [
            // prix « falsifié » côté panier : doit être ignoré
            ['produit_id' => $produit->id, 'variant_id' => null, 'price' => 0.01, 'qty' => 2],
        ], ['nom' => 'Invité', 'adresse' => 'Sfax', 'telephone' => '20123456']);

        $this->assertEquals(19.00, (float) $order->total);
        $this->assertSame(3, (int) $produit->fresh()->quantite);
    }

    public function test_la_commande_est_refusee_si_le_stock_est_insuffisant(): void
    {
        $produit = $this->produit(['quantite' => 1]);

        $this->expectException(OrderException::class);

        try {
            app(OrderController::class)->createFromCart(null, [
                ['produit_id' => $produit->id, 'variant_id' => null, 'price' => 10, 'qty' => 3],
            ], ['nom' => 'Invité', 'adresse' => 'Sfax', 'telephone' => '20123456']);
        } finally {
            $this->assertSame(1, (int) $produit->fresh()->quantite);
            $this->assertSame(0, Order::count());
        }
    }

    public function test_le_checkout_refuse_un_telephone_invalide(): void
    {
        $this->postJson('/checkout/place-order', [
            'billing' => ['nom' => 'Invité', 'adresse' => 'Tunis', 'telephone' => 'abc'],
        ])->assertStatus(422)->assertJsonValidationErrors('billing.telephone');
    }

    // ---- Pages obligatoires ----

    public function test_les_pages_d_information_existent(): void
    {
        foreach (['contact', 'livraison', 'retours', 'cgv', 'mentions-legales', 'confidentialite'] as $page) {
            $this->get('/' . $page)->assertOk();
        }
    }
}
