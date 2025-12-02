<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'produit_id',
        'variant_id',
        'quantite',
        'prix_unitaire',
        'prix_total',
        'session_id'
    ];

    protected $casts = [
        'quantite' => 'integer',
        'prix_unitaire' => 'decimal:2',
        'prix_total' => 'decimal:2',
    ];

    // --- Relations ---
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProduitVariant::class, 'variant_id');
    }

    // --- Méthodes statiques pour la gestion du panier ---
    public static function getCart()
    {
        if (Auth::check()) {
            // Utilisateur connecté : utiliser user_id
            return self::where('user_id', Auth::id())->get();
        } else {
            // Utilisateur non connecté : utiliser session_id
            $sessionId = session()->getId();
            return self::where('session_id', $sessionId)->get();
        }
    }

    public static function getCartCount()
    {
        if (Auth::check()) {
            return self::where('user_id', Auth::id())->sum('quantite');
        } else {
            $sessionId = session()->getId();
            return self::where('session_id', $sessionId)->sum('quantite');
        }
    }

    public static function getCartTotal()
    {
        if (Auth::check()) {
            return self::where('user_id', Auth::id())->sum('prix_total');
        } else {
            $sessionId = session()->getId();
            return self::where('session_id', $sessionId)->sum('prix_total');
        }
    }

    // Dans la méthode addToCart de votre modèle Cart
    public static function addToCart($produitId, $variantId = null, $quantite = 1)
    {
        // Récupérer le produit
        $produit = Produit::findOrFail($produitId);

        // Vérifier si c'est un produit avec variant
        if ($variantId && $variantId !== 'null' && $variantId !== '') {
            $variant = ProduitVariant::findOrFail($variantId);
            $prix = $variant->prix_promotionnel_variant ?? $variant->prix_ttc_variant;
            $stock = $variant->quantite_variant;
        } else {
            $prix = $produit->prix_promotionnel ?? $produit->prix_ttc;
            $stock = $produit->quantite;
            $variantId = null; // S'assurer que c'est vraiment null
        }

        // Vérifier le stock
        if ($quantite > $stock) {
            return [
                'success' => false,
                'message' => 'Stock insuffisant. Il ne reste que ' . $stock . ' articles.'
            ];
        }

        // Identifier l'utilisateur ou la session
        $userId = Auth::check() ? Auth::id() : null;
        $sessionId = session()->getId();

        // Vérifier si l'article existe déjà dans le panier
        $cartItem = self::where('produit_id', $produitId)
            ->where(function ($query) use ($variantId) {
                if ($variantId) {
                    $query->where('variant_id', $variantId);
                } else {
                    $query->whereNull('variant_id');
                }
            })
            ->when($userId, function ($query) use ($userId) {
                return $query->where('user_id', $userId);
            })
            ->when(!$userId, function ($query) use ($sessionId) {
                return $query->where('session_id', $sessionId);
            })
            ->first();

        if ($cartItem) {
            // Vérifier le stock total
            $nouvelleQuantite = $cartItem->quantite + $quantite;
            if ($nouvelleQuantite > $stock) {
                return [
                    'success' => false,
                    'message' => 'Vous ne pouvez pas ajouter plus que le stock disponible (' . $stock . ')'
                ];
            }

            // Mettre à jour la quantité
            $cartItem->quantite = $nouvelleQuantite;
            $cartItem->prix_total = $cartItem->quantite * $prix;
            $cartItem->save();

            $message = 'Quantité mise à jour dans le panier';
        } else {
            // Créer un nouvel item
            $cartItem = self::create([
                'user_id' => $userId,
                'session_id' => $userId ? null : $sessionId,
                'produit_id' => $produitId,
                'variant_id' => $variantId,
                'quantite' => $quantite,
                'prix_unitaire' => $prix,
                'prix_total' => $prix * $quantite,
            ]);

            $message = 'Produit ajouté au panier';
        }

        return [
            'success' => true,
            'message' => $message,
            'cart_item' => $cartItem
        ];
    }

    public static function updateQuantity($cartId, $quantite)
    {
        $cartItem = self::findOrFail($cartId);

        // Vérifier le stock
        $stock = $cartItem->variant ? $cartItem->variant->quantite_variant : $cartItem->produit->quantite;

        if ($quantite > $stock) {
            return ['success' => false, 'message' => 'Stock insuffisant'];
        }

        $cartItem->quantite = $quantite;
        $cartItem->prix_total = $cartItem->prix_unitaire * $quantite;
        $cartItem->save();

        return [
            'success' => true,
            'prix_total' => $cartItem->prix_total,
            'cart_total' => self::getCartTotal()
        ];
    }

    public static function removeFromCart($cartId)
    {
        $cartItem = self::find($cartId);

        if (!$cartItem) {
            return [
                'success' => false,
                'message' => 'Article non trouvé',
                'cart_count' => self::getCartCount(),
                'cart_total' => self::getCartTotal()
            ];
        }

        // Vérifier que l'utilisateur a le droit de supprimer cet article
        if (Auth::check()) {
            if ($cartItem->user_id != Auth::id()) {
                return [
                    'success' => false,
                    'message' => 'Non autorisé',
                    'cart_count' => self::getCartCount(),
                    'cart_total' => self::getCartTotal()
                ];
            }
        } else {
            $sessionId = session()->getId();
            if ($cartItem->session_id != $sessionId) {
                return [
                    'success' => false,
                    'message' => 'Non autorisé',
                    'cart_count' => self::getCartCount(),
                    'cart_total' => self::getCartTotal()
                ];
            }
        }

        $cartItem->delete();

        return [
            'success' => true,
            'message' => 'Produit retiré du panier',
            'cart_count' => self::getCartCount(),
            'cart_total' => self::getCartTotal()
        ];
    }

    public static function clearCart()
    {
        if (Auth::check()) {
            self::where('user_id', Auth::id())->delete();
        } else {
            $sessionId = session()->getId();
            self::where('session_id', $sessionId)->delete();
        }
    }

    public static function syncCart($userId)
    {
        $sessionId = session()->getId();

        // Récupérer tous les articles du panier de session
        $sessionCart = self::with(['produit', 'variant'])
            ->where('session_id', $sessionId)
            ->whereNull('user_id')
            ->get();

        foreach ($sessionCart as $item) {
            // Vérifier si l'utilisateur a déjà cet article dans son panier
            $existingItem = self::where('user_id', $userId)
                ->where('produit_id', $item->produit_id)
                ->where('variant_id', $item->variant_id)
                ->first();

            if ($existingItem) {
                // Fusionner les quantités
                $existingItem->quantite += $item->quantite;
                $existingItem->prix_total = $existingItem->prix_unitaire * $existingItem->quantite;
                $existingItem->save();

                // Supprimer l'item de session
                $item->delete();
            } else {
                // Transférer l'item de session à l'utilisateur
                $item->user_id = $userId;
                $item->session_id = null;
                $item->save();
            }
        }

        // Supprimer les éventuels doublons où user_id et session_id sont définis
        self::where('user_id', $userId)
            ->whereNotNull('session_id')
            ->delete();

        return true;
    }
}