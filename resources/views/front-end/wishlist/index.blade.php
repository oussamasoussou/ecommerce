@extends('front-end.layouts.app')

@section('content')
<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="#" rel="nofollow"><i class="fi-rs-home mr-5"></i>Accueil</a>
                <span></span> Boutique <span></span> Favoris
            </div>
        </div>
    </div>
    <div class="container mb-30 mt-50">
        <div class="row">
            <div class="col-xl-10 col-lg-12 m-auto">
                
                
                @if($items->count() > 0)
                <div class="table-responsive shopping-summery">
                    <table class="table table-wishlist">
                        <thead>
                            <tr class="main-heading">
                                <th class="custome-checkbox start pl-30">
                                    <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox11" value="" />
                                    <label class="form-check-label" for="exampleCheckbox11"></label>
                                </th>
                                <th scope="col" colspan="2">Produit</th>
                                <th scope="col">Prix</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Action</th>
                                <th scope="col" class="end">Supprimer</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            @php $produit = $item->produit; @endphp
                            <tr class="pt-30">
                                <td class="custome-checkbox pl-30">
                                    <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox{{ $produit->id }}" value="" />
                                    <label class="form-check-label" for="exampleCheckbox{{ $produit->id }}"></label>
                                </td>
                                <td class="image product-thumbnail" style="padding-top: 20px !important;">
                                    <img src="{{ $produit->image ? asset('storage/' . $produit->image) : asset('front-end/imgs/shop/product-1-1.jpg') }}" 
                                         alt="{{ $produit->nom }}" />
                                </td>
                                <td class="product-des product-name">
                                    <h6>
                                        <a class="product-name mb-10" href="{{ route('shop.show', $produit->id) }}">
                                            {{ $produit->nom }}
                                        </a>
                                    </h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    <div class="product-category">
                                        <span class="text-muted">{{ $produit->sousCategorie->name ?? '' }}</span>
                                    </div>
                                </td>
                                <td class="price" data-title="Price">
                                    @if($produit->prix_promotionnel)
                                        <h3 class="text-brand">{{ number_format($produit->prix_promotionnel, 2, ',', ' ') }} €</h3>
                                        <del class="old-price">{{ number_format($produit->prix_ttc, 2, ',', ' ') }} €</del>
                                    @else
                                        <h3 class="text-brand">{{ number_format($produit->prix_ttc, 2, ',', ' ') }} €</h3>
                                    @endif
                                </td>
                                <td class="text-center detail-info" data-title="Stock">
                                    @if($produit->quantite > 0)
                                        <span class="stock-status in-stock mb-0">En stock</span>
                                    @else
                                        <span class="stock-status out-stock mb-0">Rupture</span>
                                    @endif
                                </td>
                                <td class="text-right" data-title="Cart">
                                    @if($produit->quantite > 0)
                                        <button class="btn btn-sm">Ajouter au panier</button>
                                    @else
                                        <button class="btn btn-sm btn-secondary">Nous contacter</button>
                                    @endif
                                </td>
                                <td class="action text-center" data-title="Remove">
                                    <form action="{{ route('wishlist.remove', $produit->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button  class="btn btn-link" style="padding: 12px 10px;" 
                                                onclick="return confirm('Êtes-vous sûr de vouloir retirer ce produit de vos favoris ?')">
                                            <i class="fi-rs-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination-area mt-20 mb-20">
                    {{ $items->links() }}
                </div>

                @else
                <div class="text-center py-5">
                    <div class="empty-wishlist">
                        <img src="{{ asset('front-end/imgs/theme/empty-wishlist.svg') }}" alt="Liste de favoris vide" style="max-width: 200px;" class="mb-4">
                        <h4 class="mb-3">Votre liste de favoris est vide</h4>
                        <p class="text-muted mb-4">Ajoutez des produits que vous aimez à vos favoris</p>
                        <a href="{{ route('shop.index') }}" class="btn btn-default">Découvrir nos produits</a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection
