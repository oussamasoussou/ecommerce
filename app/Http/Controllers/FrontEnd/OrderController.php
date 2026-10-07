<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Order;
use App\Models\SousCategorie;
use App\Models\OrderItem;
use App\Exceptions\OrderException;
use App\Models\Produit;
use App\Models\ProduitVariant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
    {
        // Catégories pour le header (même pattern que les autres contrôleurs front)
        view()->share([
            'categoriesMenu' => Category::with(['sousCategories'])->get(),
            'allSousCategories' => SousCategorie::with('category')->get(),
        ]);
    }

    // La liste des commandes du client est dans l'espace compte
    public function index()
    {
        return redirect()->route('account.orders');
    }

    // Détail d'une commande : uniquement pour son propriétaire ou un administrateur
    public function show(Order $order)
    {
        $user = Auth::user();

        if ((int) $order->user_id !== (int) $user->id && !$user->isAdmin()) {
            abort(404);
        }

        $order->load('items.produit', 'items.variant.couleur', 'items.variant.taille');

        return view('front-end.account.order-show', compact('order'));
    }

    /**
     * Crée une commande depuis le panier (paiement à la livraison).
     *
     * Le prix est recalculé depuis la base (jamais celui stocké dans le panier) et le stock
     * est vérifié puis décrémenté sous verrou, pour éviter de vendre un article épuisé.
     *
     * @throws OrderException si un produit n'existe plus ou si le stock est insuffisant
     */
    public function createFromCart(?int $userId, array $cart, array $billing)
    {
        return DB::transaction(function () use ($userId, $cart, $billing) {
            $lines = [];
            $total = 0;

            foreach ($cart as $item) {
                $qty = (int) $item['qty'];
                $produit = Produit::lockForUpdate()->find($item['produit_id']);

                if (!$produit || $qty < 1) {
                    throw new OrderException('Un produit de votre panier n\'est plus disponible.');
                }

                if (!empty($item['variant_id'])) {
                    $variant = ProduitVariant::lockForUpdate()
                        ->where('produit_id', $produit->id)
                        ->find($item['variant_id']);

                    if (!$variant) {
                        throw new OrderException("L'option choisie pour « {$produit->nom} » n'est plus disponible.");
                    }

                    $stock = (int) $variant->quantite_variant;
                    $prix = (float) ($variant->prix_promotionnel_variant ?? $variant->prix_ttc_variant);
                } else {
                    $variant = null;
                    $stock = (int) $produit->quantite;
                    $prix = (float) ($produit->prix_promotionnel ?? $produit->prix_ttc);
                }

                if ($qty > $stock) {
                    throw new OrderException($stock > 0
                        ? "Stock insuffisant pour « {$produit->nom} » : {$stock} disponible(s)."
                        : "« {$produit->nom} » est en rupture de stock.");
                }

                $lineTotal = round($prix * $qty, 2);
                $total += $lineTotal;
                $lines[] = compact('produit', 'variant', 'qty', 'prix', 'lineTotal');
            }

            $order = Order::create([
                'user_id' => $userId,
                'status' => 'pending', // paiement à la livraison : confirmé à la réception
                'total' => round($total, 2),
                'tva' => 0.20,
                'adresse_livraison' => $billing['adresse'] ?? null,
                'nom_client' => $billing['nom'] ?? null,
                'telephone' => $billing['telephone'] ?? null,
            ]);

            foreach ($lines as $line) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'produit_id' => $line['produit']->id,
                    'variant_id' => $line['variant']?->id,
                    'prix_unitaire' => $line['prix'],
                    'quantite' => $line['qty'],
                    'total' => $line['lineTotal'],
                ]);

                $line['variant']
                    ? $line['variant']->decrement('quantite_variant', $line['qty'])
                    : $line['produit']->decrement('quantite', $line['qty']);
            }

            return $order;
        });
    }
}
