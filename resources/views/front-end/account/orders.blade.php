@extends('front-end.layouts.app')

@section('title', 'Mes commandes')

@section('content')
    <div class="account-page">
        <div class="container">
            <h1>Mon compte</h1>

            <div class="row">
                <div class="col-lg-3">
                    @include('front-end.account._layout', ['active' => 'orders'])
                </div>

                <div class="col-lg-9">
                    <div class="ac-card">
                        <h3>Mes commandes</h3>

                        @if ($orders->isEmpty())
                            <div class="ac-empty">
                                <p>Vous n'avez pas encore passé de commande.</p>
                                <a href="{{ route('shop.index') }}" class="btn btn-primary">Découvrir nos produits</a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="ac-table">
                                    <thead>
                                        <tr>
                                            <th>Commande</th>
                                            <th>Date</th>
                                            <th>Articles</th>
                                            <th>Total</th>
                                            <th>Statut</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td><strong>n° {{ $order->id }}</strong></td>
                                                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                                <td>{{ $order->items->sum('quantite') }}</td>
                                                <td><strong>{{ number_format($order->total, 2, ',', ' ') }} DT</strong></td>
                                                <td><span class="ac-status {{ $order->status }}">{{ $order->statusLabel() }}</span></td>
                                                <td class="text-end">
                                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Détail</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">{{ $orders->links() }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
