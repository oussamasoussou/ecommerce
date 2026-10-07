<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Produit;
use App\Models\ProduitVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/**
 * Gestion des commandes dans le back-office (liste, détail, changement de statut).
 */
class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $search = trim((string) $request->query('q'));

        $orders = Order::query()
            ->withCount('items')
            ->when($status && array_key_exists($status, Order::STATUSES), fn ($q) => $q->where('status', $status))
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($q) use ($search) {
                    $q->where('nom_client', 'like', "%{$search}%")
                        ->orWhere('telephone', 'like', "%{$search}%");

                    if (ctype_digit(ltrim($search, '#'))) {
                        $q->orWhere('id', (int) ltrim($search, '#'));
                    }
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        // Nombre de commandes par statut (pour les onglets de filtre)
        $counts = Order::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('back-end.orders.index', compact('orders', 'counts', 'status', 'search'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.produit', 'items.variant.couleur', 'items.variant.taille']);

        return view('back-end.orders.show', compact('order'));
    }

    /**
     * Change le statut d'une commande. Une annulation remet les articles en stock.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => ['required', Rule::in(array_keys(Order::STATUSES))],
        ]);

        $newStatus = $request->input('status');

        if ($newStatus === $order->status) {
            return back();
        }

        DB::transaction(function () use ($order, $newStatus) {
            // Verrou : évite qu'une double soumission remette le stock deux fois
            $order = Order::lockForUpdate()->with('items')->findOrFail($order->id);

            if ($order->isFinal()) {
                abort(back()->with('error', "La commande n° {$order->id} est « {$order->statusLabel()} » : son statut ne peut plus être modifié."));
            }

            if ($newStatus === 'cancelled') {
                foreach ($order->items as $item) {
                    if ($item->variant_id && ($variant = ProduitVariant::withTrashed()->lockForUpdate()->find($item->variant_id))) {
                        $variant->increment('quantite_variant', $item->quantite);
                    } elseif (!$item->variant_id && ($produit = Produit::withTrashed()->lockForUpdate()->find($item->produit_id))) {
                        $produit->increment('quantite', $item->quantite);
                    }
                }
            }

            $order->update(['status' => $newStatus]);
        });

        $message = $newStatus === 'cancelled'
            ? "Commande n° {$order->id} annulée. Les articles ont été remis en stock."
            : "Commande n° {$order->id} : statut mis à jour (« " . Order::STATUSES[$newStatus] . ' »).';

        return back()->with('success', $message);
    }
}
