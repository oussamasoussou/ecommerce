<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\SousCategorie;
use App\Models\Category;

class ShopController extends Controller
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

    public function index(Request $request)
    {
        $query = Produit::query()->where('est_actif', true);

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where('nom', 'like', "%{$q}%")
                ->orWhere('description', 'like', "%{$q}%");
        }

        if ($request->filled('categorie')) {
            $query->where('sous_categorie_id', $request->input('categorie'));
        }

        // Pagination
        $produits = $query->with(['sousCategorie', 'variants'])->paginate(18)->withQueryString();

        $categories = SousCategorie::with('category')->get();

        return view('front-end.shop.index', compact('produits', 'categories'));
    }

    public function show($id)
    {
        $produit = Produit::with([
            'images',
            'variants.couleur',
            'variants.taille',
            'marque',
            'sousCategorie',
            'produitsAssocies.images',
            'produitsAssocies.variants'
        ])
            ->where('id', $id)
            ->where('est_actif', true)
            ->firstOrFail();

        // 1️⃣ Produits associés définis manuellement
        $relatedProducts = $produit->produitsAssocies->take(4);

        // 2️⃣ Fallback : même marque
        if ($relatedProducts->count() < 4) {
            $fallback = Produit::where('marque_id', $produit->marque_id)
                ->where('id', '!=', $produit->id)
                ->where('est_actif', true)
                ->whereNotIn('id', $relatedProducts->pluck('id'))
                ->inRandomOrder()
                ->limit(4 - $relatedProducts->count())
                ->get();

            $relatedProducts = $relatedProducts->merge($fallback);
        }

        // 3️⃣ Fallback : même sous-catégorie
        if ($relatedProducts->count() < 4) {
            $fallback = Produit::where('sous_categorie_id', $produit->sous_categorie_id)
                ->where('id', '!=', $produit->id)
                ->where('est_actif', true)
                ->whereNotIn('id', $relatedProducts->pluck('id'))
                ->inRandomOrder()
                ->limit(4 - $relatedProducts->count())
                ->get();

            $relatedProducts = $relatedProducts->merge($fallback);
        }

        return view('front-end.shop.show', compact('produit', 'relatedProducts'));
    }


}