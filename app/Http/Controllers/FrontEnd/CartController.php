<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\SousCategorie;
use Illuminate\Http\Request;
use App\Models\Produit;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function __construct()
    {
        // Partage de TOUTES les catégories et sous-catégories
        $allCategories = Category::with(['sousCategories'])->get();
        $allSousCategories = SousCategorie::with('category')->get();

        view()->share([
            'categoriesMenu' => $allCategories,
            'allSousCategories' => $allSousCategories
        ]);
    }

    public function index()
    {
        $cartItems = Cart::getCart();
        $cartTotal = Cart::getCartTotal();
        $cartCount = Cart::getCartCount();

        return view('front-end.cart.index', compact('cartItems', 'cartTotal', 'cartCount'));
    }
    public function add(Request $request)
    {
        try {
            $request->validate([
                'produit_id' => 'required|exists:produits,id',
                'qty' => 'required|integer|min:1',
                'variant_id' => 'nullable|exists:produit_variants,id'
            ]);

            $produit = Produit::findOrFail($request->produit_id);

            // Vérifier si le produit a des variants
            if ($produit->avec_variant && !$request->variant_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Veuillez sélectionner une option'
                ], 400);
            }

            // Vérifier le stock
            $variant = null;
            if ($request->variant_id) {
                $variant = \App\Models\ProduitVariant::find($request->variant_id);
                if (!$variant) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Option sélectionnée non disponible'
                    ], 400);
                }

                if ($variant->quantite_variant < $request->qty) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Stock insuffisant pour cette option'
                    ], 400);
                }
                $prix_unitaire = $variant->prix_promotionnel_variant ?? $variant->prix_ttc_variant;
            } else {
                if ($produit->quantite < $request->qty) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Stock insuffisant'
                    ], 400);
                }
                $prix_unitaire = $produit->prix_promotionnel ?? $produit->prix_ttc;
            }

            // Identifier l'utilisateur ou la session
            $user_id = auth()->check() ? auth()->id() : null;
            $session_id = session()->getId();

            // Chercher un article existant
            $query = Cart::where('produit_id', $request->produit_id);

            if ($request->variant_id) {
                $query->where('variant_id', $request->variant_id);
            } else {
                $query->whereNull('variant_id');
            }

            if ($user_id) {
                $query->where('user_id', $user_id);
            } else {
                $query->where('session_id', $session_id);
            }

            $existingCart = $query->first();

            if ($existingCart) {
                // Mettre à jour la quantité
                $newQuantity = $existingCart->quantite + $request->qty;

                // Re-vérifier le stock avec la nouvelle quantité
                if ($variant) {
                    if ($newQuantity > $variant->quantite_variant) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Stock insuffisant. Vous avez déjà ' . $existingCart->quantite . ' article(s) dans votre panier.'
                        ], 400);
                    }
                } else {
                    if ($newQuantity > $produit->quantite) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Stock insuffisant. Vous avez déjà ' . $existingCart->quantite . ' article(s) dans votre panier.'
                        ], 400);
                    }
                }

                $existingCart->quantite = $newQuantity;
                $existingCart->prix_total = $prix_unitaire * $newQuantity;
                $existingCart->save();
            } else {
                // Créer un nouvel article
                Cart::create([
                    'user_id' => $user_id,
                    'session_id' => $user_id ? null : $session_id,
                    'produit_id' => $request->produit_id,
                    'variant_id' => $request->variant_id,
                    'quantite' => $request->qty,
                    'prix_unitaire' => $prix_unitaire,
                    'prix_total' => $prix_unitaire * $request->qty
                ]);
            }

            // Calculer les totaux
            $cartTotal = Cart::getCartTotal();
            $cartCount = Cart::getCartCount();

            return response()->json([
                'success' => true,
                'message' => 'Produit ajouté au panier',
                'cart_count' => $cartCount,
                'cart_total' => $cartTotal
            ]);

        } catch (\Exception $e) {
            \Log::error('Erreur ajout panier: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de l\'ajout au panier: ' . $e->getMessage()
            ], 500);
        }
    }
    // Mettre à jour la quantité
    public function update(Request $request, $id)
    {
        try {
            $cartItem = Cart::findOrFail($id);

            // Validation
            $request->validate([
                'quantite' => 'required|integer|min:1'
            ]);

            // Vérifier le stock
            $maxQuantity = $cartItem->variant
                ? $cartItem->variant->quantite_variant
                : $cartItem->produit->quantite;

            if ($request->quantite > $maxQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Quantité non disponible. Stock maximum: ' . $maxQuantity
                ], 400);
            }

            // Mettre à jour la quantité
            $cartItem->quantite = $request->quantite;
            $cartItem->prix_total = $cartItem->prix_unitaire * $request->quantite;
            $cartItem->save();

            // Recalculer les totaux
            $cartTotal = Cart::where('user_id', auth()->id())
                ->orWhere('session_id', session()->getId())
                ->sum('prix_total');

            $cartCount = Cart::where('user_id', auth()->id())
                ->orWhere('session_id', session()->getId())
                ->count();

            return response()->json([
                'success' => true,
                'message' => 'Quantité mise à jour',
                'prix_total' => $cartItem->prix_total,
                'cart_total' => $cartTotal,
                'cart_count' => $cartCount
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
            ], 500);
        }
    }

    // Supprimer du panier
    public function remove(Request $request, $id)
    {
        $result = Cart::removeFromCart($id);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($result);
        }

        return redirect()->route('cart.index')->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    // Vider le panier
    public function clear(Request $request)
    {
        Cart::clearCart();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Panier vidé avec succès',
                'cart_count' => 0,
                'cart_total' => 0
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Panier vidé');
    }

    // Récupérer le nombre d'articles (pour AJAX)
    public function getCount()
    {
        $count = Cart::getCartCount();
        return response()->json(['count' => $count]);
    }

    // Récupérer le total (pour AJAX)
    public function getTotal()
    {
        $total = Cart::getCartTotal();
        return response()->json(['total' => $total]);
    }
}