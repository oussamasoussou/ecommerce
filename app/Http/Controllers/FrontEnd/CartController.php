<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SousCategorie;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(protected CartService $cartService)
    {
        $allCategories     = Category::with(['sousCategories'])->get();
        $allSousCategories = SousCategorie::with('category')->get();

        view()->share([
            'categoriesMenu'    => $allCategories,
            'allSousCategories' => $allSousCategories,
        ]);
    }

    /** Affiche le panier */
    public function index()
    {
        $summary = $this->cartService->getSummary();

        return view('front-end.cart.index', [
            'cartItems' => $summary['items'],
            'cartTotal' => $summary['cart_total'],
            'cartCount' => $summary['cart_count'],
        ]);
    }

    /** Ajoute un produit au panier */
    public function add(Request $request)
    {
        $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'qty'        => 'required|integer|min:1',
            'variant_id' => 'nullable|exists:produit_variants,id',
        ]);

        $result = $this->cartService->add(
            (int) $request->produit_id,
            (int) $request->qty,
            $request->variant_id ? (int) $request->variant_id : null
        );

        $statusCode = $result['success'] ? 200 : 400;

        return response()->json($result, $statusCode);
    }

    /** Met à jour la quantité d'un article */
    public function update(Request $request, $id)
    {
        $request->validate(['quantite' => 'required|integer|min:1']);

        $result = $this->cartService->update((int) $id, (int) $request->quantite);

        return response()->json($result, $result['success'] ? 200 : 400);
    }

    /** Supprime un article du panier */
    public function remove(Request $request, $id)
    {
        $result = \App\Models\Cart::removeFromCart($id);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($result);
        }

        return redirect()->route('cart.index')
            ->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    /** Vide le panier */
    public function clear(Request $request)
    {
        $this->cartService->clear();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success'    => true,
                'message'    => 'Panier vidé avec succès',
                'cart_count' => 0,
                'cart_total' => 0,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Panier vidé');
    }

    /** Retourne le nombre d'articles (AJAX) */
    public function getCount()
    {
        $summary = $this->cartService->getSummary();
        return response()->json(['count' => $summary['cart_count']]);
    }

    /** Retourne le total du panier (AJAX) */
    public function getTotal()
    {
        $summary = $this->cartService->getSummary();
        return response()->json(['total' => $summary['cart_total']]);
    }
}