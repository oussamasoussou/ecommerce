<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Category;
use App\Models\SousCategorie;

class CheckoutController extends Controller
{
    private const TAUX_TVA = 0.20;

    // Constructeur pour partager les catégories avec le header (même pattern que ShopController)
    public function __construct()
    {
        $allCategories = Category::with(['sousCategories'])->get();
        $allSousCategories = SousCategorie::with('category')->get();

        view()->share([
            'categoriesMenu' => $allCategories,
            'allSousCategories' => $allSousCategories
        ]);
    }

    // Page checkout (récupère le panier réel - table carts - de l'utilisateur ou de la session)
    public function index()
    {
        $cart = Cart::getCart()->load('produit')->map(function ($item) {
            return [
                'produit_id' => $item->produit_id,
                'variant_id' => $item->variant_id,
                'name' => $item->produit->nom ?? $item->variant_nom ?? 'Produit',
                'price' => (float) $item->prix_unitaire,
                'qty' => $item->quantite,
            ];
        });

        return view('front-end.checkout.index', compact('cart'));
    }

    // Validation de la commande en paiement à la livraison (pas de passerelle de paiement)
    public function placeOrder(Request $request, OrderController $orderController)
    {
        $request->validate([
            'billing.nom' => 'required|string|max:255',
            'billing.adresse' => 'required|string',
            'billing.telephone' => 'required|string',
        ]);

        $cartModels = Cart::getCart();
        if ($cartModels->isEmpty()) {
            return response()->json(['error' => 'Panier vide'], 400);
        }

        $cart = $cartModels->map(function ($item) {
            return [
                'produit_id' => $item->produit_id,
                'variant_id' => $item->variant_id,
                'price' => (float) $item->prix_unitaire,
                'qty' => $item->quantite,
            ];
        })->toArray();

        $user = Auth::user();
        $userId = $user ? $user->id : null;

        // Crée la commande (statut "pending" jusqu'à la livraison) et décrémente les stocks
        $order = $orderController->createFromCart($userId, $cart, $request->billing);

        // Vider le panier
        Cart::clearCart();

        return response()->json(['success' => true, 'order_id' => $order->id]);
    }
}
