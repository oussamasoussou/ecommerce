@extends('front-end.layouts.app')

@section('content')
    <main class="main">
        <div class="page-header mt-30 mb-50">
            <div class="container">
                <div class="archive-header">
                    <div class="row align-items-center">
                        <div class="col-xl-3">
                            <h1 class="mb-15">Mon Panier</h1>
                            <div class="breadcrumb">
                                <a href="{{ route('shop.index') }}" rel="nofollow"><i
                                        class="fi-rs-home mr-5"></i>Accueil</a>
                                <span></span> Panier
                            </div>
                        </div>
                        <div class="col-xl-9 text-end d-none d-xl-block">
                            <div class="d-flex justify-content-end align-items-center">
                                <span class="text-muted mr-20">
                                    <i class="fi-rs-shopping-cart mr-5"></i>
                                    {{ $cartCount }} article(s)
                                </span>
                                <a href="{{ route('shop.index') }}" class="btn btn-xs">
                                    <i class="fi-rs-shopping-bag mr-5"></i>Continuer mes achats
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mb-30">
            @if($cartItems->count() > 0)
                <div class="row">
                    <div class="col-lg-8">
                        <div class="table-responsive">
                            <table class="table cart-table">
                                <thead>
                                    <tr class="thead-primary">
                                        <th class="text-start" scope="col">Produit</th>
                                        <th class="text-center" scope="col">Prix</th>
                                        <th class="text-center" scope="col">Quantité</th>
                                        <th class="text-center" scope="col">Total</th>
                                        <th class="text-center" scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $item)
                                        <tr class="cart-item-{{ $item->id }}">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <a href="{{ route('shop.show', $item->produit_id) }}" class="me-3"
                                                        style="width: 80px;">
                                                        <img src="{{ asset('storage/' . $item->produit->image) }}"
                                                            alt="{{ $item->produit->nom }}" class="img-fluid rounded"
                                                            style="width: 80px; height: 80px; object-fit: cover;">
                                                    </a>
                                                    <div>
                                                        <h6 class="mb-1">
                                                            <a href="{{ route('shop.show', $item->produit_id) }}" class="text-body">
                                                                {{ $item->produit->nom }}
                                                            </a>
                                                        </h6>
                                                        @if($item->variant)
                                                            <p class="text-muted mb-0 small">
                                                                @if($item->variant->couleur)
                                                                    <span class="me-2">Couleur: {{ $item->variant->couleur->name }}</span>
                                                                @endif
                                                                @if($item->variant->taille)
                                                                    <span>Taille: {{ $item->variant->taille->name }}</span>
                                                                @endif
                                                            </p>
                                                        @endif
                                                        <p class="text-muted mb-0 small">
                                                            Réf: {{ $item->produit->reference ?? 'N/A' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center align-middle">
                                                <span class="text-brand fw-600">
                                                    {{ number_format($item->prix_unitaire, 2, ',', ' ') }} €
                                                </span>
                                            </td>
                                            <!-- Dans cart.blade.php - section du tableau -->
                                            <td class="text-center align-middle">
                                                <div class="quantity d-inline-flex align-items-center">
                                                    <button class="btn btn-sm btn-outline-secondary btn-minus" 
                                                            data-cart-id="{{ $item->id }}"
                                                            data-url="{{ route('cart.update', $item->id) }}">-</button>
                                                    <input type="number" 
                                                        class="form-control form-control-sm text-center qty-input" 
                                                        value="{{ $item->quantite }}" 
                                                        min="1"
                                                        max="{{ $item->variant ? $item->variant->quantite_variant : $item->produit->quantite }}"
                                                        data-cart-id="{{ $item->id }}"
                                                        data-url="{{ route('cart.update', $item->id) }}"
                                                        style="width: 60px;">
                                                    <button class="btn btn-sm btn-outline-secondary btn-plus" 
                                                            data-cart-id="{{ $item->id }}"
                                                            data-url="{{ route('cart.update', $item->id) }}">+</button>
                                                </div>
                                            </td>
                                            <td class="text-center align-middle">
                                                <span class="text-brand fw-600 cart-total-{{ $item->id }}">
                                                    {{ number_format($item->prix_total, 2, ',', ' ') }} €
                                                </span>
                                            </td>
                                            <td class="text-center align-middle">
                                                <button class="btn btn-link text-danger btn-remove" data-cart-id="{{ $item->id }}"
                                                    title="Supprimer">
                                                    <i class="fi-rs-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('shop.index') }}" class="btn btn-secondary">
                                <i class="fi-rs-arrow-left mr-10"></i>Continuer mes achats
                            </a>
                            <button id="clear-cart" class="btn btn-outline-danger">
                                <i class="fi-rs-trash mr-10"></i>Vider le panier
                            </button>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title mb-4">Récapitulatif de la commande</h5>

                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">Sous-total</span>
                                    <span class="fw-600" id="cart-subtotal">
                                        {{ number_format($cartTotal, 2, ',', ' ') }} €
                                    </span>
                                </div>

                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">Livraison</span>
                                    <span class="text-success fw-600">Gratuite</span>
                                </div>

                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">Taxes</span>
                                    <span class="fw-600">Incluses</span>
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between mb-4">
                                    <span class="h5 mb-0">Total</span>
                                    <span class="h5 mb-0 text-brand" id="cart-grand-total">
                                        {{ number_format($cartTotal, 2, ',', ' ') }} €
                                    </span>
                                </div>

                                <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-lg w-100 mb-3">
                                    <i class="fi-rs-shopping-cart mr-10"></i>Passer la commande
                                </a>

                                <div class="alert alert-info mt-3" role="alert">
                                    <i class="fi-rs-info mr-10"></i>
                                    Livraison gratuite à partir de 50€ d'achat.
                                    <a href="#" class="alert-link">Voir les conditions</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fi-rs-shopping-cart display-1 text-muted"></i>
                    </div>
                    <h3 class="mb-3">Votre panier est vide</h3>
                    <p class="text-muted mb-4">Vous n'avez pas encore ajouté de produit à votre panier.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-primary">
                        <i class="fi-rs-shopping-bag mr-10"></i>Découvrir nos produits
                    </a>
                </div>
            @endif
        </div>
    </main>


@endsection