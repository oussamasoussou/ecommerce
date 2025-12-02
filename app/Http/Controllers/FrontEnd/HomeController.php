<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Banniere;
use App\Models\Slider;
use Illuminate\Http\Request;

use App\Models\Produit;
use App\Models\SousCategorie;
use App\Models\Category;


class HomeController extends Controller
{
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
        $sliders = Slider::actif()->ordonne()->get();
        $bannieres = Banniere::actif()->get();
        
        // Produits populaires pour la section "Products Tabs"
        $produitsPopulaires = Produit::with([
                'sousCategorie.category', 
                'marque', 
                'images',
                'variants'
            ])
            ->where('est_actif', true)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Query pour les produits de la boutique (garder votre logique existante)
        $query = Produit::query()->where('est_actif', true);

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where('nom', 'like', "%{$q}%")
                ->orWhere('description', 'like', "%{$q}%");
        }

        if ($request->filled('categorie')) {
            $query->where('sous_categorie_id', $request->input('categorie'));
        }

        // Pagination pour la boutique
        $produits = $query->with(['sousCategorie', 'variants'])->paginate(18)->withQueryString();

        $categories = Category::with(['sousCategories'])->get();

        return view('front-end.index', compact(
            'produits', 
            'categories', 
            'sliders', 
            'bannieres',
            'produitsPopulaires'
        ));
    }
}