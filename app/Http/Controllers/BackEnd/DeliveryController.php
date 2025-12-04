<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DeliveryController extends Controller
{
    /**
     * Affiche la liste des livraisons.
     */
    public function index(): View
    {
        $deliveries = Delivery::latest()->paginate(10);
        
        return view('back-end.deliveries.index', compact('deliveries'));
    }

    /**
     * Affiche le formulaire de création d'une livraison.
     */
    public function create(): View
    {
        return view('back-end.deliveries.create');
    }

    /**
     * Stocke une nouvelle livraison.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'prix' => 'required|numeric|min:0|max:9999999.99',
        ]);

        Delivery::create($validated);

        return redirect()->route('deliveries.index')
            ->with('success', 'Prix de livraison créé avec succès!');
    }

    /**
     * Affiche le formulaire d'édition d'une livraison.
     */
    public function edit(Delivery $delivery): View
    {
        return view('back-end.deliveries.edit', compact('delivery'));
    }

    /**
     * Met à jour une livraison.
     */
    public function update(Request $request, Delivery $delivery): RedirectResponse
    {
        $validated = $request->validate([
            'prix' => 'required|numeric|min:0|max:9999999.99',
        ]);

        $delivery->update($validated);

        return redirect()->route('deliveries.index')
            ->with('success', 'Prix de livraison mis à jour avec succès!');
    }

    /**
     * Supprime une livraison.
     */
    public function destroy(Delivery $delivery): RedirectResponse
    {
        $delivery->delete();

        return redirect()->route('deliveries.index')
            ->with('success', 'Prix de livraison supprimé avec succès!');
    }
}