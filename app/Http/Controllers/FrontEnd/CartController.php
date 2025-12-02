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

    // Ajouter au panier
    public function add(Request $request)
    {
        // Validation avec valeur par défaut pour variant_id
        $validated = $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'qty' => 'required|integer|min:1'
        ]);

        // Récupérer variant_id s'il existe, sinon null
        $variantId = $request->has('variant_id') ? $request->input('variant_id') : null;

        // Valider variant_id seulement s'il est présent
        if ($variantId) {
            $request->validate([
                'variant_id' => 'exists:produit_variants,id'
            ]);
        }

        $result = Cart::addToCart(
            $validated['produit_id'],
            $variantId,
            $validated['qty']
        );

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => $result['success'],
                'message' => $result['message'],
                'cart_count' => Cart::getCartCount(),
                'cart_total' => Cart::getCartTotal()
            ]);
        }

        return redirect()->back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    // Mettre à jour la quantité
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'quantite' => 'required|integer|min:1'
        ]);

        $result = Cart::updateQuantity($id, $validated['quantite']);

        if ($request->ajax() || $request->wantsJson()) {
            $result['cart_count'] = Cart::getCartCount();
            $result['cart_total'] = Cart::getCartTotal();
            return response()->json($result);
        }

        return redirect()->route('cart.index')->with($result['success'] ? 'success' : 'error', $result['message']);
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