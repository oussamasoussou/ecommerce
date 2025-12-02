<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Couleur;

class CouleurController extends Controller
{
    public function index()
    {
        $couleurs = Couleur::paginate(10);
        return view('back-end.couleurs.index', compact('couleurs'));
    }

    public function create()
    {
        return view('back-end.couleurs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code_hex' => 'required|string|size:7', // ex: #FF0000
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('name', 'code_hex');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('couleurs', 'public');
        }

        Couleur::create($data);

        return redirect()->route('couleurs.index')->with('success', 'Couleur créée avec succès');
    }

    public function edit(Couleur $couleur)
    {
        return view('back-end.couleurs.edit', compact('couleur'));
    }

    public function update(Request $request, Couleur $couleur)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code_hex' => 'required|string|size:7',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('name', 'code_hex');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('couleurs', 'public');
        }

        $couleur->update($data);

        return redirect()->route('couleurs.index')->with('success', 'Couleur mise à jour avec succès');
    }

    public function destroy(Couleur $couleur)
    {
        $couleur->delete();
        return redirect()->route('couleurs.index')->with('success', 'Couleur supprimée avec succès');
    }
}