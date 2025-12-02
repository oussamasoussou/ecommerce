<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banniere;
use Illuminate\Support\Facades\Storage;

class BanniereController extends Controller
{
    public function index()
    {
        $bannieres = Banniere::orderBy('position')->paginate(10);
        return view('back-end.bannieres.index', compact('bannieres'));
    }

    public function create()
    {
        $positions = [
            'accueil' => 'Accueil',
            'header' => 'Header',
            'sidebar' => 'Sidebar',
            'footer' => 'Footer',
        ];
        
        return view('back-end.bannieres.create', compact('positions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'lien' => 'nullable|url|max:500',
            'texte_bouton' => 'nullable|string|max:100',
            'position' => 'required|string|max:50',
            'est_actif' => 'boolean',
        ], [
            'titre.required' => 'Le titre est obligatoire.',
            'image.required' => 'L\'image est obligatoire.',
            'image.image' => 'Le fichier doit être une image valide.',
            'image.mimes' => 'L\'image doit être au format JPEG, PNG, JPG, GIF ou WEBP.',
            'image.max' => 'L\'image ne doit pas dépasser 5MB.',
            'lien.url' => 'Le lien doit être une URL valide.',
            'position.required' => 'La position est obligatoire.',
        ]);

        $data = $request->only('titre', 'lien', 'texte_bouton', 'position');
        $data['est_actif'] = $request->has('est_actif');

        // Gestion de l'image
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageFilename = 'banniere-' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
            $data['image'] = $imageFile->storeAs('bannieres', $imageFilename, 'public');
        }

        Banniere::create($data);

        return redirect()->route('bannieres.index')->with('success', 'Bannière créée avec succès');
    }

    public function edit(Banniere $banniere)
    {
        $positions = [
            'accueil' => 'Accueil',
            'header' => 'Header',
            'sidebar' => 'Sidebar',
            'footer' => 'Footer',
        ];
        
        return view('back-end.bannieres.edit', compact('banniere', 'positions'));
    }

    public function update(Request $request, Banniere $banniere)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'lien' => 'nullable|url|max:500',
            'texte_bouton' => 'nullable|string|max:100',
            'position' => 'required|string|max:50',
            'est_actif' => 'boolean',
        ], [
            'titre.required' => 'Le titre est obligatoire.',
            'image.image' => 'Le fichier doit être une image valide.',
            'image.mimes' => 'L\'image doit être au format JPEG, PNG, JPG, GIF ou WEBP.',
            'image.max' => 'L\'image ne doit pas dépasser 5MB.',
            'lien.url' => 'Le lien doit être une URL valide.',
            'position.required' => 'La position est obligatoire.',
        ]);

        $data = $request->only('titre', 'lien', 'texte_bouton', 'position');
        $data['est_actif'] = $request->has('est_actif');

        // Gestion de l'image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image s'il existe
            if ($banniere->image && Storage::disk('public')->exists($banniere->image)) {
                Storage::disk('public')->delete($banniere->image);
            }

            $imageFile = $request->file('image');
            $imageFilename = 'banniere-' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
            $data['image'] = $imageFile->storeAs('bannieres', $imageFilename, 'public');
        }

        $banniere->update($data);

        return redirect()->route('bannieres.index')->with('success', 'Bannière mise à jour avec succès');
    }

    public function destroy(Banniere $banniere)
    {
        // Supprimer l'image s'il existe
        if ($banniere->image && Storage::disk('public')->exists($banniere->image)) {
            Storage::disk('public')->delete($banniere->image);
        }

        $banniere->delete();
        
        return redirect()->route('bannieres.index')->with('success', 'Bannière supprimée avec succès');
    }

    public function toggleStatus(Banniere $banniere)
    {
        $banniere->update([
            'est_actif' => !$banniere->est_actif
        ]);

        $status = $banniere->est_actif ? 'activée' : 'désactivée';
        
        return redirect()->route('bannieres.index')->with('success', "Bannière {$status} avec succès");
    }
}