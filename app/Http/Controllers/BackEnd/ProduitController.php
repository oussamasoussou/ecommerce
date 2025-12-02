<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\Marque;
use App\Models\ProduitVariant;
use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\SousCategorie;
use App\Models\Couleur;
use App\Models\Taille;
use App\Models\ProduitImage;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class ProduitController extends Controller
{

    // Afficher la liste des produits
    public function index()
    {
        // On charge seulement les variantes et la sous-catégorie
        $produits = Produit::with(['sousCategorie', 'variants'])->paginate(10);
        return view('back-end.produits.index', compact('produits'));
    }

    // Afficher le formulaire de création
    public function create()
    {
        $sousCategories = SousCategorie::with('category')->get();
        $couleurs = Couleur::all();
        $tailles = Taille::all();
        $marques = Marque::all();

        return view('back-end.produits.create', compact('sousCategories', 'couleurs', 'tailles', 'marques'));
    }

    // Enregistrer un nouveau produit et ses variantes
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $avecVariant = $request->has('avec_variant') && $request->boolean('avec_variant');

            // Validation
            $rules = [
                'nom' => 'required|string|max:255',
                'description' => 'nullable|string',
                'sous_categorie_id' => 'required|exists:sous_categories,id',
                'marque_id' => 'required|exists:marque,id',
                'price' => 'required|numeric|min:0.01',
                'prix_promotionnel' => 'nullable|numeric|min:0.01',
                'poids' => 'nullable|numeric|min:0',
                'est_actif' => 'sometimes|boolean',
                'avec_variant' => 'sometimes|boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp',
                'images_supplementaires' => 'nullable|array', // Correction importante
                'images_supplementaires.*' => 'image|mimes:jpeg,png,jpg,webp',
            ];

            if ($avecVariant) {
                $rules['variants'] = 'required|array|min:1';
                $rules['variants.*.couleurs'] = 'required|array|min:1';
                $rules['variants.*.tailles'] = 'required|array|min:1';
                $rules['variants.*.quantite_variant'] = 'required|integer|min:0';
                $rules['variants.*.prix_ttc_variant'] = 'nullable|numeric|min:0.01';
                $rules['variants.*.prix_promotionnel_variant'] = 'nullable|numeric|min:0.01';
                $rules['variants.*.image_variant'] = 'nullable|image|mimes:jpeg,png,jpg,webp';
            } else {
                $rules['quantite'] = 'required|integer|min:0';
            }

            $request->validate($rules);

            // Calcul TVA
            $tauxTVA = 0.20;
            $prixTTC = (float) $request->price;
            $prixHT = $prixTTC / (1 + $tauxTVA);
            $prixTVA = $prixTTC - $prixHT;

            // Gestion de l'image principale
            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('produits', $imageName, 'public');
            }

            // Création du produit
            $produit = new Produit();
            $produit->sous_categorie_id = $request->sous_categorie_id;
            $produit->marque_id = $request->marque_id;
            $produit->nom = $request->nom;
            $produit->description = $request->description;
            $produit->prix_ht = $prixHT;
            $produit->prix_tva = $prixTVA;
            $produit->prix_ttc = $prixTTC;
            $produit->prix_promotionnel = $request->prix_promotionnel;
            $produit->poids = $request->poids;
            $produit->est_actif = $request->boolean('est_actif');
            $produit->avec_variant = $avecVariant;
            $produit->image = $imagePath;
            $produit->quantite = $avecVariant ? 0 : $request->quantite;

            $produit->save();



            if ($request->hasFile('images_supplementaires')) {
                foreach ($request->file('images_supplementaires') as $img) {
                    $imageProduit = new ProduitImage();
                    $imageProduit->produit_id = $produit->id;
                    $imageName = time() . '_' . $img->getClientOriginalName();
                    $imagePath = $img->storeAs('produits', $imageName, 'public');
                    $imageProduit->image_path = $imagePath; // <-- important
                    $imageProduit->save();

                }
            }

            // Création des variantes
            if ($avecVariant) {
                $totalStock = 0;

                foreach ($request->variants as $variantInput) {
                    $couleurs = $variantInput['couleurs'] ?? [];
                    $tailles = $variantInput['tailles'] ?? [];

                    foreach ($couleurs as $couleur) {
                        foreach ($tailles as $taille) {
                            $prixTTCVar = $variantInput['prix_ttc_variant'] ?? $prixTTC;
                            $prixHTVar = $prixTTCVar / (1 + $tauxTVA);
                            $prixTVAVar = $prixTTCVar - $prixHTVar;

                            // Gestion de l'image variant
                            $imageVariantPath = null;
                            if (!empty($variantInput['image_variant']) && $variantInput['image_variant'] instanceof \Illuminate\Http\UploadedFile) {
                                $imageVariant = $variantInput['image_variant'];
                                if ($imageVariant->isValid()) {
                                    $imageVariantName = time() . '_variant_' . uniqid() . '_' . $imageVariant->getClientOriginalName();
                                    $imageVariantPath = $imageVariant->storeAs('produits/variants', $imageVariantName, 'public');
                                }
                            }


                            $variant = new ProduitVariant();
                            $variant->produit_id = $produit->id;
                            $variant->couleur_id = $couleur;
                            $variant->taille_id = $taille;
                            $variant->quantite_variant = $variantInput['quantite_variant'];
                            $variant->prix_ht_variant = $prixHTVar;
                            $variant->prix_tva_variant = $prixTVAVar;
                            $variant->prix_ttc_variant = $prixTTCVar;
                            $variant->prix_promotionnel_variant = $variantInput['prix_promotionnel_variant'] ?? null;
                            $variant->image_variant = $imageVariantPath;

                            $variant->save();

                            $totalStock += $variant->quantite_variant;
                        }
                    }
                }
         
                // Mise à jour du stock total du produit
                $produit->quantite = $totalStock;
                $produit->save();
            }

            DB::commit();
            return redirect()->route('produits.index')->with('success', 'Produit créé avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erreur création produit:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erreur lors de la création: ' . $e->getMessage())->withInput();
        }
    }
    // Afficher le formulaire d'édition
    public function edit(Produit $produit)
    {
        // Charge les relations nécessaires pour le formulaire d'édition
        $produit->load(['variants.couleur', 'variants.taille', 'images', 'sousCategorie']);
        $sousCategories = SousCategorie::with('category')->get();
        $couleurs = Couleur::all();
        $tailles = Taille::all();
        $marques = Marque::all();

        return view('back-end.produits.edit', compact('produit', 'sousCategories', 'couleurs', 'tailles', 'marques'));
    }

    // Mettre à jour un produit et ses variantes
    public function update(Request $request, Produit $produit)
    {
        DB::beginTransaction();
        try {
            $avecVariant = $request->has('avec_variant') && $request->boolean('avec_variant');

            // Validation
            $rules = [
                'nom' => 'required|string|max:255',
                'description' => 'nullable|string',
                'sous_categorie_id' => 'required|exists:sous_categories,id',
                'marque_id' => 'required|exists:marque,id',
                'price' => 'required|numeric|min:0.01',
                'prix_promotionnel' => 'nullable|numeric|min:0.01',
                'poids' => 'nullable|numeric|min:0',
                'est_actif' => 'sometimes|boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp',
            ];

            if ($avecVariant) {
                $rules['variants'] = 'required|array|min:1';
                $rules['variants.*.couleurs'] = 'required|array|min:1';
                $rules['variants.*.tailles'] = 'required|array|min:1';
                $rules['variants.*.quantite_variant'] = 'required|integer|min:0';
                $rules['variants.*.prix_ttc_variant'] = 'nullable|numeric|min:0.01';
                $rules['variants.*.prix_promotionnel_variant'] = 'nullable|numeric|min:0.01';
                $rules['variants.*.image_variant'] = 'nullable|image|mimes:jpeg,png,jpg,webp';
            } else {
                $rules['quantite'] = 'required|integer|min:0';
            }

            $request->validate($rules);

            $tauxTVA = 0.20;
            $prixTTC = (float) $request->price;
            $prixHT = $prixTTC / (1 + $tauxTVA);
            $prixTVA = $prixTTC - $prixHT;

            // Mise à jour du produit
            $produit->update([
                'sous_categorie_id' => $request->sous_categorie_id,
                'marque_id' => $request->marque_id,
                'nom' => $request->nom,
                'description' => $request->description,
                'prix_ht' => $prixHT,
                'prix_tva' => $prixTVA,
                'prix_ttc' => $prixTTC,
                'prix_promotionnel' => $request->prix_promotionnel,
                'poids' => $request->poids,
                'est_actif' => $request->boolean('est_actif'),
                'avec_variant' => $avecVariant,
                'quantite' => $avecVariant ? 0 : $request->quantite,
            ]);

            // Après la création du produit
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $img) {
                    $produit->images()->create([
                        'image_path' => $img->store('produits/supplementaires', 'public')
                    ]);
                }
            }

            // Variantes
            if ($avecVariant) {
                $totalStock = 0;
                $variantIds = [];

                foreach ($request->variants as $variantInput) {
                    $couleurs = $variantInput['couleurs'] ?? [];
                    $tailles = $variantInput['tailles'] ?? [];

                    foreach ($couleurs as $couleur) {
                        foreach ($tailles as $taille) {

                            $prixTTCVar = $variantInput['prix_ttc_variant'] ?? $prixTTC;
                            $prixHTVar = $prixTTCVar / (1 + $tauxTVA);
                            $prixTVAVar = $prixTTCVar - $prixHTVar;

                            $variant = ProduitVariant::updateOrCreate(
                                [
                                    'produit_id' => $produit->id,
                                    'couleur_id' => $couleur,
                                    'taille_id' => $taille,
                                ],
                                [
                                    'quantite_variant' => $variantInput['quantite_variant'],
                                    'prix_ht_variant' => $prixHTVar,
                                    'prix_tva_variant' => $prixTVAVar,
                                    'prix_ttc_variant' => $prixTTCVar,
                                    'prix_promotionnel_variant' => $variantInput['prix_promotionnel_variant'] ?? null,
                                    'image_variant' => isset($variantInput['image_variant'])
                                        ? $variantInput['image_variant']->store('produits/variants', 'public')
                                        : ($variant->image_variant ?? null),
                                ]
                            );

                            $variantIds[] = $variant->id;
                            $totalStock += $variant->quantite_variant;
                        }
                    }
                }

                // Supprimer les variantes supprimées
                ProduitVariant::where('produit_id', $produit->id)
                    ->whereNotIn('id', $variantIds)
                    ->delete();

                // Mettre à jour la quantité totale du produit
                $produit->quantite = $totalStock;
                $produit->save();
            }

            DB::commit();
            return redirect()->route('produits.index')->with('success', 'Produit mis à jour avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur: ' . $e->getMessage())->withInput();
        }
    }



    // Supprimer un produit
    public function destroy(Produit $produit)
    {
        DB::beginTransaction();

        try {
            // Supprimer les images du stockage pour le produit principal et toutes les variantes
            foreach ($produit->images as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }

            // La suppression des variantes (et de leurs images) est gérée par la relation
            // Si vous avez utilisé onDelete('cascade') dans votre migration pour la variante
            // MAIS comme vous utilisez SoftDeletes, il est plus sûr de le faire explicitement.
            foreach ($produit->variants as $variant) {
                // Supprimer les images liées à la variante
                foreach ($variant->images as $img) {
                    Storage::disk('public')->delete($img->image_path);
                    $img->delete();
                }
                $variant->delete(); // Soft delete la variante
            }

            // Soft delete le produit
            $produit->delete();

            DB::commit();

            return redirect()->route('produits.index')
                ->with('success', 'Produit supprimé avec succès!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression du produit: ' . $e->getMessage());
        }
    }

    // Méthode pour supprimer une image spécifique (Garde l'original)
    public function deleteImage(ProduitImage $image)
    {
        try {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();

            return response()->json(['success' => true, 'message' => 'Image supprimée avec succès']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erreur lors de la suppression'], 500);
        }
    }
}