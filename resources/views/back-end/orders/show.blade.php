@extends('back-end.layouts.app')

@section('content')
<section class="content-main">
    <div class="content-header d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <a href="{{ route('admin.orders.index') }}" class="text-muted small">&larr; Retour aux commandes</a>
            <h2 class="content-title mb-1 mt-1">
                Commande #{{ $order->id }}
                <span class="badge {{ $order->statusBadge() }} align-middle ms-2" style="font-size: 14px;">{{ $order->statusLabel() }}</span>
            </h2>
            <p class="text-muted mb-0">Passée le {{ $order->created_at->format('d/m/Y à H:i') }}</p>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    <div class="row">
        {{-- Articles --}}
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white"><strong>Articles</strong></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Produit</th>
                                    <th class="text-end">Prix unitaire</th>
                                    <th class="text-center">Quantité</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if ($item->produit)
                                                    <img src="{{ $item->produit->image_url }}" alt="{{ $item->produit->nom }}"
                                                         class="rounded" style="width: 48px; height: 48px; object-fit: cover;">
                                                @endif
                                                <div>
                                                    <strong>{{ $item->produit->nom ?? 'Produit supprimé (#' . $item->produit_id . ')' }}</strong>
                                                    @if ($item->variant)
                                                        <div class="text-muted small">
                                                            {{ collect([optional($item->variant->couleur)->name, optional($item->variant->taille)->name])->filter()->implode(' · ') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end">{{ number_format($item->prix_unitaire, 2, ',', ' ') }} DT</td>
                                        <td class="text-center">{{ $item->quantite }}</td>
                                        <td class="text-end">{{ number_format($item->total, 2, ',', ' ') }} DT</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Total à encaisser à la livraison</th>
                                    <th class="text-end">{{ number_format($order->total, 2, ',', ' ') }} DT</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            {{-- Statut --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white"><strong>Statut</strong></div>
                <div class="card-body">
                    @if ($order->isFinal())
                        <p class="mb-0 text-muted">
                            Cette commande est <strong>{{ strtolower($order->statusLabel()) }}</strong> :
                            son statut ne peut plus être modifié.
                        </p>
                    @else
                        <form method="POST" action="{{ route('admin.orders.status', $order) }}" id="status-form">
                            @csrf
                            @method('PATCH')
                            <label for="status" class="form-label">Nouveau statut</label>
                            <select name="status" id="status" class="form-select mb-3">
                                @foreach (\App\Models\Order::STATUSES as $key => $label)
                                    <option value="{{ $key }}" {{ $order->status === $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            <p class="small text-muted" id="cancel-warning" hidden>
                                ⚠️ L'annulation remet les articles en stock et est définitive.
                            </p>
                            <button type="submit" class="btn btn-primary w-100">Mettre à jour</button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- Client --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white"><strong>Client et livraison</strong></div>
                <div class="card-body">
                    <p class="mb-1"><strong>{{ $order->nom_client }}</strong></p>
                    <p class="mb-1">
                        <a href="tel:{{ preg_replace('/[^\d+]/', '', (string) $order->telephone) }}">{{ $order->telephone }}</a>
                    </p>
                    <p class="mb-3">{{ $order->adresse_livraison }}</p>

                    @if ($order->user)
                        <hr>
                        <p class="small text-muted mb-1">Compte client</p>
                        <p class="mb-0">
                            {{ trim($order->user->firstname . ' ' . $order->user->lastname) }}<br>
                            <span class="text-muted small">{{ $order->user->email }}</span>
                        </p>
                    @else
                        <p class="small text-muted mb-0">Commande passée sans compte (invité).</p>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body small text-muted">
                    Paiement : <strong>espèces à la livraison</strong>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    (function () {
        const select = document.getElementById('status');
        const form = document.getElementById('status-form');
        const warning = document.getElementById('cancel-warning');
        if (!select || !form) return;

        select.addEventListener('change', () => { warning.hidden = select.value !== 'cancelled'; });

        form.addEventListener('submit', function (e) {
            if (select.value === 'cancelled' && !window.confirm('Annuler la commande #{{ $order->id }} ? Les articles seront remis en stock. Cette action est définitive.')) {
                e.preventDefault();
            }
        });
    })();
</script>
@endsection
