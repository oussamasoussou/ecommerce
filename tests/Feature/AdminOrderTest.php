<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminOrderTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['role_id' => 2]);
    }

    /** Commande de 3 articles d'un produit dont il reste 2 en stock */
    private function orderWithItem(string $status = 'pending', string $nom = 'Sami Ben Ali'): array
    {
        $produit = Produit::create(['nom' => 'Bsissa', 'quantite' => 2, 'prix_ttc' => 10, 'est_actif' => true]);
        $order = Order::create([
            'status' => $status, 'total' => 30, 'tva' => 0.2,
            'nom_client' => $nom, 'adresse_livraison' => 'Tunis', 'telephone' => '20123456',
        ]);
        OrderItem::create([
            'order_id' => $order->id, 'produit_id' => $produit->id,
            'prix_unitaire' => 10, 'quantite' => 3, 'total' => 30,
        ]);

        return [$order, $produit];
    }

    public function test_un_client_n_accede_pas_aux_commandes_admin(): void
    {
        [$order] = $this->orderWithItem();
        $client = User::factory()->create(['role_id' => 3]);

        $this->actingAs($client)->get(route('admin.orders.index'))->assertRedirect('/');
        $this->actingAs($client)->patch(route('admin.orders.status', $order), ['status' => 'cancelled'])->assertRedirect('/');
        $this->assertSame('pending', $order->fresh()->status);
    }

    public function test_l_admin_voit_la_liste_et_le_detail(): void
    {
        [$order] = $this->orderWithItem();
        $admin = $this->admin();

        $this->actingAs($admin)->get(route('admin.orders.index'))->assertOk()->assertSee('Sami Ben Ali');
        $this->actingAs($admin)->get(route('admin.orders.show', $order))->assertOk()->assertSee('Bsissa');
    }

    public function test_filtre_par_statut_et_recherche(): void
    {
        $this->orderWithItem('pending', 'Client En Attente');
        $this->orderWithItem('delivered', 'Client Livre');
        $admin = $this->admin();

        $this->actingAs($admin)->get(route('admin.orders.index', ['status' => 'delivered']))
            ->assertSee('Client Livre')->assertDontSee('Client En Attente');

        $this->actingAs($admin)->get(route('admin.orders.index', ['q' => 'Attente']))
            ->assertSee('Client En Attente')->assertDontSee('Client Livre');
    }

    public function test_changer_le_statut(): void
    {
        [$order, $produit] = $this->orderWithItem();

        $this->actingAs($this->admin())
            ->patch(route('admin.orders.status', $order), ['status' => 'shipped'])
            ->assertSessionHas('success');

        $this->assertSame('shipped', $order->fresh()->status);
        $this->assertSame(2, (int) $produit->fresh()->quantite); // stock inchangé
    }

    public function test_annuler_remet_le_stock_une_seule_fois(): void
    {
        [$order, $produit] = $this->orderWithItem();
        $admin = $this->admin();

        $this->actingAs($admin)->patch(route('admin.orders.status', $order), ['status' => 'cancelled']);
        $this->assertSame('cancelled', $order->fresh()->status);
        $this->assertSame(5, (int) $produit->fresh()->quantite); // 2 + 3

        // Une commande annulée est définitive : pas de deuxième remise en stock
        $this->actingAs($admin)->patch(route('admin.orders.status', $order), ['status' => 'pending'])
            ->assertSessionHas('error');
        $this->actingAs($admin)->patch(route('admin.orders.status', $order), ['status' => 'cancelled']);
        $this->assertSame('cancelled', $order->fresh()->status);
        $this->assertSame(5, (int) $produit->fresh()->quantite);
    }

    public function test_statut_invalide_refuse(): void
    {
        [$order] = $this->orderWithItem();

        $this->actingAs($this->admin())
            ->patch(route('admin.orders.status', $order), ['status' => 'n-importe-quoi'])
            ->assertSessionHasErrors('status');

        $this->assertSame('pending', $order->fresh()->status);
    }
}
