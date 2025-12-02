<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Taille;

class TailleController extends Controller
{
    public function index()
    {
        $tailles = Taille::paginate(10);
        return view('back-end.tailles.index', compact('tailles'));
    }

    public function create()
    {
        return view('back-end.tailles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Taille::create($request->only('name', 'description'));

        return redirect()->route('tailles.index')->with('success', 'Taille créée avec succès');
    }

    public function edit(Taille $taille)
    {
        return view('back-end.tailles.edit', compact('taille'));
    }

    public function update(Request $request, Taille $taille)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $taille->update($request->only('name', 'description'));

        return redirect()->route('tailles.index')->with('success', 'Taille mise à jour avec succès');
    }

    public function destroy(Taille $taille)
    {
        $taille->delete();
        return redirect()->route('tailles.index')->with('success', 'Taille supprimée avec succès');
    }
}