<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use App\Models\Category;
use App\Models\Marque;
use App\Models\SousCategorie;
use Illuminate\Http\Request;

class SearchController extends Controller
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

    
    public function search(Request $request)
    {
        $query = $request->input('q');
        $categoryId = $request->input('category');

        // Initialiser la requête des produits
        $produitsQuery = Produit::where('est_actif', true)
            ->with(['sousCategorie.category', 'marque', 'images']); // Changez ici 'categorie' en 'category'

        // Recherche par terme
        if ($query) {
            $produitsQuery->where(function($q) use ($query) {
                $q->where('nom', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%")
                  ->orWhere('reference', 'LIKE', "%{$query}%")
                  ->orWhereHas('marque', function($q) use ($query) {
                      $q->where('name', 'LIKE', "%{$query}%");
                  })
                  ->orWhereHas('sousCategorie', function($q) use ($query) {
                      $q->where('name', 'LIKE', "%{$query}%")
                        ->orWhereHas('category', function($q) use ($query) { // Changez ici 'categorie' en 'category'
                            $q->where('name', 'LIKE', "%{$query}%");
                        });
                  });
            });
        }

        // Filtre par catégorie
        if ($categoryId) {
            $produitsQuery->where('sous_categorie_id', $categoryId);
        }

        $produits = $produitsQuery->paginate(12);

        return view('front-end.search.search-results', compact('produits', 'query', 'categoryId'));
    }
}