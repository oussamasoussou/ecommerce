<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\Marque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MarqueController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $marques = Marque::latest()->get();
        return view('back-end.marques.index', compact('marques'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('back-end.marques.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:marque',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('marques', 'public');
            $data['logo'] = $logoPath;
        }

        Marque::create($data);

        return redirect()->route('marques.index')
            ->with('success', 'Marque créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Marque $marque)
    {
        return view('marques.show', compact('marque'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Marque $marque)
    {
        return view('back-end.marques.edit', compact('marque'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Marque $marque)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:marque,name,' . $marque->id,
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            // Supprimer l'ancien logo s'il existe
            if ($marque->logo && Storage::disk('public')->exists($marque->logo)) {
                Storage::disk('public')->delete($marque->logo);
            }
            
            $logoPath = $request->file('logo')->store('marques', 'public');
            $data['logo'] = $logoPath;
        }

        $marque->update($data);

        return redirect()->route('marques.index')
            ->with('success', 'Marque mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Marque $marque)
    {
        // Supprimer le logo s'il existe
        if ($marque->logo && Storage::disk('public')->exists($marque->logo)) {
            Storage::disk('public')->delete($marque->logo);
        }

        $marque->delete();

        return redirect()->route('marques.index')
            ->with('success', 'Marque supprimée avec succès.');
    }
}
