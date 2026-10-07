<?php

/*
|--------------------------------------------------------------------------
| Informations de la boutique
|--------------------------------------------------------------------------
| Utilisées dans le header, le footer et les pages légales.
| Renseignez-les dans le fichier .env : une valeur vide n'est pas affichée.
*/

return [
    'name' => env('SHOP_NAME', 'Dar El 3oula'),
    'tagline' => env('SHOP_TAGLINE', 'Bsissa et produits traditionnels tunisiens'),

    // Coordonnées
    'phone' => env('SHOP_PHONE'),           // ex. "+216 20 123 456"
    'email' => env('SHOP_EMAIL'),           // ex. "contact@dar-el-3oula.tn"
    'address' => env('SHOP_ADDRESS'),       // ex. "12 rue …, Tunis"
    'hours' => env('SHOP_HOURS'),           // ex. "Lun - Sam : 9h - 18h"

    // Informations légales (mentions légales / CGV)
    'legal_name' => env('SHOP_LEGAL_NAME'),         // raison sociale ou nom de l'exploitant
    'registration' => env('SHOP_REGISTRATION'),     // n° RNE / registre de commerce
    'tax_id' => env('SHOP_TAX_ID'),                 // matricule fiscal
    'host' => env('SHOP_HOST'),                     // hébergeur du site (nom + adresse)

    // Réseaux sociaux (URL complètes)
    'social' => array_filter([
        'Facebook' => env('SHOP_FACEBOOK'),
        'Instagram' => env('SHOP_INSTAGRAM'),
        'TikTok' => env('SHOP_TIKTOK'),
    ]),
];
