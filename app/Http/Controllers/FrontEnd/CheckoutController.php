<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;
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
        $cart = Cart::getCart()->load(['produit', 'variant.couleur', 'variant.taille'])->map(function ($item) {
            return [
                'produit_id' => $item->produit_id,
                'variant_id' => $item->variant_id,
                'name' => $item->produit->nom ?? $item->variant_nom ?? 'Produit',
                'image' => $item->produit->image ?? null,
                'couleur' => optional(optional($item->variant)->couleur)->name,
                'taille' => optional(optional($item->variant)->taille)->name,
                'price' => (float) $item->prix_unitaire,
                'qty' => $item->quantite,
            ];
        });

        $total = $cart->sum(fn ($item) => $item['price'] * $item['qty']);

        // Pré-remplissage du formulaire avec les informations du client connecté
        $user = Auth::user();
        $billing = [
            'nom' => $user ? trim($user->firstname . ' ' . $user->lastname) : '',
            'telephone' => $user->phone ?? '',
            'adresse' => $user ? trim(implode(', ', array_filter([$user->address, $user->city]))) : '',
        ];

        return view('front-end.checkout.index', compact('cart', 'total', 'billing'));
    }

    // Validation de la commande en paiement à la livraison (pas de passerelle de paiement)
    public function placeOrder(Request $request, OrderController $orderController)
    {
        $request->validate([
            'billing.nom' => 'required|string|max:255',
            'billing.adresse' => 'required|string|max:255',
            'billing.telephone' => 'required|string|max:20',
        ], [
            'billing.nom.required' => 'Le nom complet est obligatoire.',
            'billing.adresse.required' => "L'adresse de livraison est obligatoire.",
            'billing.adresse.max' => "L'adresse ne doit pas dépasser 255 caractères.",
            'billing.telephone.required' => 'Le téléphone est obligatoire.',
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

        // Mémorise la commande pour la page de confirmation (utile pour les invités)
        $request->session()->put('last_order_id', $order->id);

        return response()->json([
            'success' => true,
            'order_id' => $order->id,
            'redirect' => route('checkout.confirmation'),
        ]);
    }

    // Page de confirmation : n'affiche que la dernière commande passée dans cette session
    public function confirmation(Request $request)
    {
        $orderId = $request->session()->get('last_order_id');
        $order = $orderId ? Order::with('items.produit')->find($orderId) : null;

        if (!$order) {
            return redirect()->route('shop.index');
        }

        return view('front-end.checkout.confirmation', compact('order'));
    }
}
