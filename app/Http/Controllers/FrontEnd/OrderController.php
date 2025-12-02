<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Produit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Liste commandes (admin) ou client
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user && $user->isAdmin()) {
            $orders = Order::with('user')->orderBy('created_at','desc')->paginate(20);
        } else {
            $orders = Order::where('user_id', $user->id)->with('items.produit')->orderBy('created_at','desc')->paginate(20);
        }

        return view('front-end.orders.index', compact('orders'));
    }

    // Voir une commande
    public function show(Order $order)
    {
        $order->load('items.produit', 'user');
        // Vérifie droits si besoin
        return view('front-end.orders.show', compact('order'));
    }

    // Méthode utilitaire pour créer une commande depuis un panier (utilisée par CheckoutController après paiement)
    public function createFromCart(int $userId, array $cart, array $billing)
    {
        DB::beginTransaction();
        try {
            $tauxTVA = 0.20;

            $order = Order::create([
                'user_id' => $userId,
                'status' => 'paid',
                'total' => 0, // on calcule après
                'tva' => $tauxTVA,
                'adresse_livraison' => $billing['adresse'] ?? null,
                'nom_client' => $billing['nom'] ?? null,
                'telephone' => $billing['telephone'] ?? null,
                'stripe_payment_id' => $billing['stripe_payment_id'] ?? null,
            ]);

            $total = 0;
            foreach ($cart as $key => $item) {
                $lineTotal = ($item['price'] * $item['qty']);
                $total += $lineTotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'produit_id' => $item['produit_id'],
                    'variant_id' => $item['variant_id'] ?? null,
                    'prix_unitaire' => $item['price'],
                    'quantite' => $item['qty'],
                    'total' => $lineTotal,
                ]);

                // Optionnel : décrémente stock si tu gères le stock
                if ($item['variant_id']) {
                    $variant = Produit::find($item['produit_id'])->variants()->find($item['variant_id']);
                    if ($variant) {
                        $variant->decrement('quantite_variant', $item['qty']);
                    }
                } else {
                    $produit = Produit::find($item['produit_id']);
                    if ($produit) {
                        $produit->decrement('quantite', $item['qty']);
                    }
                }
            }

            $order->total = $total;
            $order->save();

            DB::commit();
            return $order;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
