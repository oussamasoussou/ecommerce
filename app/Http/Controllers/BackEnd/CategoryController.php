<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10);
        return view('back-end.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('back-end.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|mimes:svg|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
        ], [
            'logo.mimes' => 'Le logo doit être un fichier SVG.',
            'logo.max' => 'Le logo ne doit pas dépasser 2MB.',
            'image.image' => 'L\'image doit être un fichier image valide.',
            'image.mimes' => 'L\'image doit être au format JPEG, PNG, JPG, GIF ou WEBP.',
            'image.max' => 'L\'image ne doit pas dépasser 5MB.',
        ]);

        $data = $request->only('name', 'description');

        // Gestion du logo (SVG)
        if ($request->hasFile('logo')) {
            $logoFile = $request->file('logo');
            $logoFilename = 'category-logo-' . uniqid() . '.svg';
            $data['logo'] = $logoFile->storeAs('categories', $logoFilename, 'public');
        }

        // Gestion de l'image
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageFilename = 'category-image-' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
            $data['image'] = $imageFile->storeAs('categories', $imageFilename, 'public');
        }

        Category::create($data);

        return redirect()->route('categories.index')->with('success', 'Catégorie créée avec succès');
    }

    public function edit(Category $category)
    {
        return view('back-end.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|mimes:svg|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ], [
            'logo.mimes' => 'Le logo doit être un fichier SVG.',
            'logo.max' => 'Le logo ne doit pas dépasser 2MB.',
            'image.image' => 'L\'image doit être un fichier image valide.',
            'image.mimes' => 'L\'image doit être au format JPEG, PNG, JPG, GIF ou WEBP.',
            'image.max' => 'L\'image ne doit pas dépasser 5MB.',
        ]);

        $data = $request->only('name', 'description');

        // Gestion du logo (SVG)
        if ($request->hasFile('logo')) {
            // Supprimer l'ancien logo s'il existe
            if ($category->logo && Storage::disk('public')->exists($category->logo)) {
                Storage::disk('public')->delete($category->logo);
            }

            $logoFile = $request->file('logo');
            $logoFilename = 'category-logo-' . uniqid() . '.svg';
            $data['logo'] = $logoFile->storeAs('categories', $logoFilename, 'public');
        }

        // Gestion de l'image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image s'il existe
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $imageFile = $request->file('image');
            $imageFilename = 'category-image-' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
            $data['image'] = $imageFile->storeAs('categories', $imageFilename, 'public');
        }

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Catégorie mise à jour avec succès');
    }

    public function destroy(Category $category)
    {
        // Supprimer le logo s'il existe
        if ($category->logo && Storage::disk('public')->exists($category->logo)) {
            Storage::disk('public')->delete($category->logo);
        }

        // Supprimer l'image s'il existe
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Catégorie supprimée avec succès');
    }
}