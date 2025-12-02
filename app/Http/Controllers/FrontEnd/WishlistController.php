<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SousCategorie;
use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // TVA fixe France
    private const TAUX_TVA = 0.20;

    // Constructeur pour partager les catégories avec toutes les vues
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
        $user = Auth::user();

        // Correction : Utiliser 'wishlists' au lieu de 'wishlist'
        $items = $user ? $user->wishlists()->with('produit')->paginate(20) : collect();

        return view('front-end.wishlist.index', compact('items'));
    }

    public function toggle(Request $request)
    {
        $request->validate(['produit_id' => 'required|exists:produits,id']);

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $produitId = $request->produit_id;

        // Correction : Utiliser la relation pour une meilleure pratique
        $existing = $user->wishlists()->where('produit_id', $produitId)->first();

        if ($existing) {
            $existing->delete();
            return back()->with('success', 'Produit retiré des favoris.');
        }

        // Correction : Utiliser la relation pour créer l'entrée
        $user->wishlists()->create([
            'produit_id' => $produitId
        ]);

        return back()->with('success', 'Produit ajouté aux favoris.');
    }

    // Méthode alternative plus spécifique si besoin
    public function add($produitId)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $user->wishlists()->firstOrCreate([
            'produit_id' => $produitId
        ]);

        return back()->with('success', 'Produit ajouté aux favoris.');
    }

    public function remove($produitId)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $user->wishlists()->where('produit_id', $produitId)->delete();

        return back()->with('success', 'Produit retiré des favoris.');
    }
}