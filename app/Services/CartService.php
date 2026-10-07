<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Produit;
use App\Models\ProduitVariant;
use Illuminate\Support\Facades\Auth;

class CartService
{
    /**
     * Ajoute un produit au panier avec vérification de stock.
     * Retourne ['success' => bool, 'message' => string, 'cart_count' => int, 'cart_total' => float]
     */
    public function add(int $produitId, int $qty = 1, ?int $variantId = null): array
    {
        $produit = Produit::find($produitId);
        if (!$produit) {
            return ['success' => false, 'message' => 'Produit non trouvé'];
        }

        // Produit avec variante obligatoire
        if ($produit->avec_variant && !$variantId) {
            return ['success' => false, 'message' => 'Veuillez sélectionner une option'];
        }

        $variant = null;
        if ($variantId) {
            $variant = ProduitVariant::find($variantId);
            if (!$variant) {
                return ['success' => false, 'message' => 'Option sélectionnée non disponible'];
            }
            $prixUnitaire = $variant->prix_promotionnel_variant ?? $variant->prix_ttc_variant;
            $stockDisponible = $variant->quantite_variant;
        } else {
            $prixUnitaire = $produit->prix_promotionnel ?? $produit->prix_ttc;
            $stockDisponible = $produit->quantite;
        }

        // Vérification de stock initiale
        if ($qty > $stockDisponible) {
            return ['success' => false, 'message' => 'Stock insuffisant'];
        }

        $userId    = Auth::id();
        $sessionId = session()->getId();

        // Chercher l'article existant dans le panier
        $query = Cart::where('produit_id', $produitId);
        $variantId ? $query->where('variant_id', $variantId) : $query->whereNull('variant_id');
        $userId ? $query->where('user_id', $userId) : $query->where('session_id', $sessionId);

        $existingItem = $query->first();

        if ($existingItem) {
            $newQty = $existingItem->quantite + $qty;
            if ($newQty > $stockDisponible) {
                return [
                    'success' => false,
                    'message' => 'Stock insuffisant. Vous avez déjà ' . $existingItem->quantite . ' article(s) dans votre panier.',
                ];
            }
            $existingItem->quantite   = $newQty;
            $existingItem->prix_total = $prixUnitaire * $newQty;
            $existingItem->save();
        } else {
            Cart::create([
                'user_id'       => $userId,
                'session_id'    => $userId ? null : $sessionId,
                'produit_id'    => $produitId,
                'variant_id'    => $variantId,
                'quantite'      => $qty,
                'prix_unitaire' => $prixUnitaire,
                'prix_total'    => $prixUnitaire * $qty,
            ]);
        }

        return [
            'success'    => true,
            'message'    => 'Produit ajouté au panier',
            'cart_count' => Cart::getCartCount(),
            'cart_total' => Cart::getCartTotal(),
        ];
    }

    /**
     * Met à jour la quantité d'un article du panier.
     */
    public function update(int $cartId, int $quantite): array
    {
        // Uniquement un article du panier de l'utilisateur / de la session en cours
        $userId = Auth::id();
        $cartItem = Cart::where('id', $cartId)
            ->when($userId,
                fn ($q) => $q->where('user_id', $userId),
                fn ($q) => $q->whereNull('user_id')->where('session_id', session()->getId()))
            ->first();

        if (!$cartItem) {
            return ['success' => false, 'message' => 'Article non trouvé'];
        }

        $stock = $cartItem->variant
            ? $cartItem->variant->quantite_variant
            : $cartItem->produit->quantite;

        if ($quantite > $stock) {
            return ['success' => false, 'message' => 'Quantité non disponible. Stock maximum: ' . $stock];
        }

        $cartItem->quantite   = $quantite;
        $cartItem->prix_total = $cartItem->prix_unitaire * $quantite;
        $cartItem->save();

        return [
            'success'    => true,
            'message'    => 'Quantité mise à jour',
            'prix_total' => $cartItem->prix_total,
            'cart_total' => Cart::getCartTotal(),
            'cart_count' => Cart::getCartCount(),
        ];
    }

    /**
     * Retourne le résumé du panier.
     */
    public function getSummary(): array
    {
        return [
            'items'      => Cart::getCart(),
            'cart_count' => Cart::getCartCount(),
            'cart_total' => Cart::getCartTotal(),
        ];
    }

    /**
     * Vide le panier de l'utilisateur courant.
     */
    public function clear(): void
    {
        Cart::clearCart();
    }
}
