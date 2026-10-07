<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SousCategorie;

/**
 * Pages d'information : contact, livraison, retours, CGV, mentions légales, confidentialité.
 */
class PageController extends Controller
{
    /** slug => [vue, titre, meta description] */
    private const PAGES = [
        'contact' => ['contact', 'Contact', 'Contactez Dar El 3oula pour toute question sur nos produits ou vos commandes.'],
        'livraison' => ['livraison', 'Livraison', 'Délais, zones et frais de livraison de Dar El 3oula en Tunisie.'],
        'retours' => ['retours', 'Retours et remboursements', 'Conditions de retour et de remboursement des produits Dar El 3oula.'],
        'cgv' => ['cgv', 'Conditions générales de vente', 'Conditions générales de vente de la boutique en ligne Dar El 3oula.'],
        'mentions-legales' => ['mentions-legales', 'Mentions légales', 'Mentions légales du site Dar El 3oula.'],
        'confidentialite' => ['confidentialite', 'Politique de confidentialité', 'Comment Dar El 3oula collecte et protège vos données personnelles.'],
    ];

    public function __construct()
    {
        // Catégories pour le header (même pattern que les autres contrôleurs front)
        view()->share([
            'categoriesMenu' => Category::with(['sousCategories'])->get(),
            'allSousCategories' => SousCategorie::with('category')->get(),
        ]);
    }

    public function show(string $slug)
    {
        abort_unless(isset(self::PAGES[$slug]), 404);

        [$view, $title, $description] = self::PAGES[$slug];

        return view('front-end.pages.' . $view, [
            'pageTitle' => $title,
            'metaDescription' => $description,
            'shop' => config('shop'),
        ]);
    }
}
