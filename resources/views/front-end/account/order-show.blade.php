@extends('front-end.layouts.app')

@section('title', 'Commande n° ' . $order->id)

@section('content')
    <div class="account-page">
        <div class="container">
            <h1>Commande n° {{ $order->id }}</h1>

            <div class="row">
                <div class="col-lg-3">
                    @include('front-end.account._layout', ['active' => 'orders'])
                </div>

                <div class="col-lg-9">
                    <div class="ac-card">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                            <span>Passée le {{ $order->created_at->format('d/m/Y à H:i') }}</span>
                            <span class="ac-status {{ $order->status }}">{{ $order->statusLabel() }}</span>
                        </div>

                        <div class="table-responsive">
                            <table class="ac-table">
                                <thead>
                                    <tr>
                                        <th>Produit</th>
                                        <th>Prix unitaire</th>
                                        <th>Quantité</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td>
                                                {{ $item->produit->nom ?? 'Produit supprimé' }}
                                                @if ($item->variant)
                                                    <div class="text-muted small">
                                                        {{ collect([optional($item->variant->couleur)->name, optional($item->variant->taille)->name])->filter()->implode(' · ') }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ number_format($item->prix_unitaire, 2, ',', ' ') }} DT</td>
                                            <td>{{ $item->quantite }}</td>
                                            <td class="text-end">{{ number_format($item->total, 2, ',', ' ') }} DT</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3"><strong>Total (paiement à la livraison)</strong></td>
                                        <td class="text-end"><strong>{{ number_format($order->total, 2, ',', ' ') }} DT</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="ac-card">
                        <h3>Livraison</h3>
                        <p class="mb-1"><strong>{{ $order->nom_client }}</strong></p>
                        <p class="mb-1">{{ $order->telephone }}</p>
                        <p class="mb-0">{{ $order->adresse_livraison }}</p>
                    </div>

                    <a href="{{ route('account.orders') }}"><i class="fi-rs-arrow-left"></i> Retour à mes commandes</a>
                </div>
            </div>
        </div>
    </div>
@endsection
