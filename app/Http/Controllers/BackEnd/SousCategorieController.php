<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SousCategorie;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class SousCategorieController extends Controller
{
    public function index()
    {
        $sousCategories = SousCategorie::with('category')->paginate(10);
        return view('back-end.sous-categories.index', compact('sousCategories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('back-end.sous-categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'categorie_id' => 'required|exists:categories,id',
            'logo' => 'nullable|mimes:svg|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ], [
            'logo.mimes' => 'Le logo doit être un fichier SVG.',
            'logo.max' => 'Le logo ne doit pas dépasser 2MB.',
            'image.image' => 'L\'image doit être un fichier image valide.',
            'image.mimes' => 'L\'image doit être au format JPEG, PNG, JPG, GIF ou WEBP.',
            'image.max' => 'L\'image ne doit pas dépasser 5MB.',
        ]);

        $data = $request->only('name', 'description', 'categorie_id');

        // Gestion du logo (SVG)
        if ($request->hasFile('logo')) {
            $logoFile = $request->file('logo');
            $logoFilename = 'souscategory-logo-' . uniqid() . '.svg';
            $data['logo'] = $logoFile->storeAs('souscategories', $logoFilename, 'public');
        }

        // Gestion de l'image
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageFilename = 'souscategory-image-' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
            $data['image'] = $imageFile->storeAs('souscategories', $imageFilename, 'public');
        }

        SousCategorie::create($data);

        return redirect()->route('souscategories.index')->with('success', 'Sous-catégorie créée avec succès');
    }

    public function edit(SousCategorie $sousCategorie)
    {
        $categories = Category::all();
        return view('back-end.sous-categories.edit', compact('sousCategorie', 'categories'));
    }

    public function update(Request $request, SousCategorie $sousCategorie)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'categorie_id' => 'required|exists:categories,id',
            'logo' => 'nullable|mimes:svg|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ], [
            'logo.mimes' => 'Le logo doit être un fichier SVG.',
            'logo.max' => 'Le logo ne doit pas dépasser 2MB.',
            'image.image' => 'L\'image doit être un fichier image valide.',
            'image.mimes' => 'L\'image doit être au format JPEG, PNG, JPG, GIF ou WEBP.',
            'image.max' => 'L\'image ne doit pas dépasser 5MB.',
        ]);

        $data = $request->only('name', 'description', 'categorie_id');

        // Gestion du logo (SVG)
        if ($request->hasFile('logo')) {
            // Supprimer l'ancien logo s'il existe
            if ($sousCategorie->logo && Storage::disk('public')->exists($sousCategorie->logo)) {
                Storage::disk('public')->delete($sousCategorie->logo);
            }

            $logoFile = $request->file('logo');
            $logoFilename = 'souscategory-logo-' . uniqid() . '.svg';
            $data['logo'] = $logoFile->storeAs('souscategories', $logoFilename, 'public');
        }

        // Gestion de l'image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image s'il existe
            if ($sousCategorie->image && Storage::disk('public')->exists($sousCategorie->image)) {
                Storage::disk('public')->delete($sousCategorie->image);
            }

            $imageFile = $request->file('image');
            $imageFilename = 'souscategory-image-' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
            $data['image'] = $imageFile->storeAs('souscategories', $imageFilename, 'public');
        }

        $sousCategorie->update($data);

        return redirect()->route('souscategories.index')->with('success', 'Sous-catégorie mise à jour avec succès');
    }

    public function destroy(SousCategorie $sousCategorie)
    {
        // Supprimer le logo s'il existe
        if ($sousCategorie->logo && Storage::disk('public')->exists($sousCategorie->logo)) {
            Storage::disk('public')->delete($sousCategorie->logo);
        }

        // Supprimer l'image s'il existe
        if ($sousCategorie->image && Storage::disk('public')->exists($sousCategorie->image)) {
            Storage::disk('public')->delete($sousCategorie->image);
        }

        $sousCategorie->delete();
        return redirect()->route('souscategories.index')->with('success', 'Sous-catégorie supprimée avec succès');
    }
}