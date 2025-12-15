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
        'variant_nom',
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
    public static function addToCart($produit_id, $variant_id, $qty = 1)
    {
        $session_id = session()->getId();
        $produit = Produit::find($produit_id);

        if (!$produit) {
            return ['success' => false, 'message' => 'Produit non trouvé'];
        }

        // Calculer le prix
        $prix_unitaire = $produit->prix_ttc;
        $nom_variant = null;

        if ($variant_id) {
            $variant = ProduitVariant::with(['couleur', 'taille'])->find($variant_id);
            if ($variant) {
                // Utiliser le prix du variant si disponible
                $prix_unitaire = $variant->prix_promotionnel_variant ?? $variant->prix_ttc_variant ?? $produit->prix_ttc;

                // Créer le nom du variant pour l'affichage
                $nom_variant = '';
                if ($variant->couleur) {
                    $nom_variant .= 'Couleur: ' . $variant->couleur->name;
                }
                if ($variant->taille) {
                    $nom_variant .= $nom_variant ? ' - Taille: ' . $variant->taille->name : 'Taille: ' . $variant->taille->name;
                }
            }
        }

        // Calculer le prix total
        $prix_total = $prix_unitaire * $qty;

        // Vérifier si l'article est déjà dans le panier
        $existing = self::where('session_id', $session_id)
            ->where('produit_id', $produit_id)
            ->where('variant_id', $variant_id)
            ->first();

        if ($existing) {
            // Mettre à jour la quantité
            $existing->quantite += $qty;

            // Vérifier le stock
            if ($variant_id) {
                $variant = ProduitVariant::find($variant_id);
                if ($variant && $existing->quantite > $variant->quantite_variant) {
                    return ['success' => false, 'message' => 'Quantité non disponible'];
                }
            } elseif ($existing->quantite > $produit->quantite) {
                return ['success' => false, 'message' => 'Quantité non disponible'];
            }

            // Mettre à jour les prix
            $existing->prix_total = $prix_unitaire * $existing->quantite;
            $existing->save();
        } else {
            // Vérifier le stock
            if ($variant_id) {
                $variant = ProduitVariant::find($variant_id);
                if ($variant && $qty > $variant->quantite_variant) {
                    return ['success' => false, 'message' => 'Quantité non disponible'];
                }
            } elseif ($qty > $produit->quantite) {
                return ['success' => false, 'message' => 'Quantité non disponible'];
            }

            // Créer un nouvel élément avec TOUS les champs requis
            self::create([
                'session_id' => $session_id,
                'produit_id' => $produit_id,
                'variant_id' => $variant_id,
                'variant_nom' => $nom_variant,
                'quantite' => $qty,
                'prix_unitaire' => $prix_unitaire,
                'prix_total' => $prix_total
            ]);
        }

        return ['success' => true, 'message' => 'Produit ajouté au panier'];
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