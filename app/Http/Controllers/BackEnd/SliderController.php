<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('ordre')->paginate(10);
        return view('back-end.sliders.index', compact('sliders'));
    }

    public function create()
    {
        $ordres = range(1, 10); // Génère un tableau de 1 à 10 pour l'ordre
        return view('back-end.sliders.create', compact('ordres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'sous_titre' => 'nullable|string|max:500',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'ordre' => 'required|integer|min:1',
            'lien' => 'nullable|url|max:500',
            'texte_bouton' => 'nullable|string|max:100',
            'est_actif' => 'boolean',
        ], [
            'titre.required' => 'Le titre est obligatoire.',
            'image.required' => 'L\'image est obligatoire.',
            'image.image' => 'Le fichier doit être une image valide.',
            'image.mimes' => 'L\'image doit être au format JPEG, PNG, JPG, GIF ou WEBP.',
            'image.max' => 'L\'image ne doit pas dépasser 5MB.',
            'ordre.required' => 'L\'ordre est obligatoire.',
            'ordre.integer' => 'L\'ordre doit être un nombre entier.',
            'ordre.min' => 'L\'ordre doit être au moins 1.',
            'lien.url' => 'Le lien doit être une URL valide.',
        ]);

        $data = $request->only('titre', 'sous_titre', 'ordre', 'lien', 'texte_bouton');
        $data['est_actif'] = $request->has('est_actif');

        // Gestion de l'image
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageFilename = 'slider-' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
            $data['image'] = $imageFile->storeAs('sliders', $imageFilename, 'public');
        }

        Slider::create($data);

        return redirect()->route('sliders.index')->with('success', 'Slide créé avec succès');
    }

    public function edit(Slider $slider)
    {
        $ordres = range(1, 10);
        return view('back-end.sliders.edit', compact('slider', 'ordres'));
    }

    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'sous_titre' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'ordre' => 'required|integer|min:1',
            'lien' => 'nullable|url|max:500',
            'texte_bouton' => 'nullable|string|max:100',
            'est_actif' => 'boolean',
        ], [
            'titre.required' => 'Le titre est obligatoire.',
            'image.image' => 'Le fichier doit être une image valide.',
            'image.mimes' => 'L\'image doit être au format JPEG, PNG, JPG, GIF ou WEBP.',
            'image.max' => 'L\'image ne doit pas dépasser 5MB.',
            'ordre.required' => 'L\'ordre est obligatoire.',
            'ordre.integer' => 'L\'ordre doit être un nombre entier.',
            'ordre.min' => 'L\'ordre doit être au moins 1.',
            'lien.url' => 'Le lien doit être une URL valide.',
        ]);

        $data = $request->only('titre', 'sous_titre', 'ordre', 'lien', 'texte_bouton');
        $data['est_actif'] = $request->has('est_actif');

        // Gestion de l'image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image s'il existe
            if ($slider->image && Storage::disk('public')->exists($slider->image)) {
                Storage::disk('public')->delete($slider->image);
            }

            $imageFile = $request->file('image');
            $imageFilename = 'slider-' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
            $data['image'] = $imageFile->storeAs('sliders', $imageFilename, 'public');
        }

        $slider->update($data);

        return redirect()->route('sliders.index')->with('success', 'Slide mis à jour avec succès');
    }

    public function destroy(Slider $slider)
    {
        // Supprimer l'image s'il existe
        if ($slider->image && Storage::disk('public')->exists($slider->image)) {
            Storage::disk('public')->delete($slider->image);
        }

        $slider->delete();
        
        return redirect()->route('sliders.index')->with('success', 'Slide supprimé avec succès');
    }

    public function toggleStatus(Slider $slider)
    {
        $slider->update([
            'est_actif' => !$slider->est_actif
        ]);

        $status = $slider->est_actif ? 'activé' : 'désactivé';
        
        return redirect()->route('sliders.index')->with('success', "Slide {$status} avec succès");
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'sliders' => 'required|array',
            'sliders.*.id' => 'required|exists:sliders,id',
            'sliders.*.ordre' => 'required|integer|min:1',
        ]);

        foreach ($request->sliders as $sliderData) {
            Slider::where('id', $sliderData['id'])->update(['ordre' => $sliderData['ordre']]);
        }

        return response()->json(['success' => true, 'message' => 'Ordre des slides mis à jour avec succès']);
    }
}