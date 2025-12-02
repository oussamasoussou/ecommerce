@extends('front-end.layouts.app')
@section('content')
    <main class="main">
        <div class="page-header mt-30 mb-50">
            <div class="container">
                <div class="archive-header">
                    <div class="row align-items-center">
                        <div class="col-xl-3">
                            <h1 class="mb-15">Boutique</h1>
                            <div class="breadcrumb">
                                <a href="{{ route('shop.index') }}" rel="nofollow"><i
                                        class="fi-rs-home mr-5"></i>Accueil</a>
                                <span></span> Boutique
                            </div>
                        </div>
                        <div class="col-xl-9 text-end d-none d-xl-block">
                            <ul class="tags-list">
                                @foreach($categories as $cat)
                                    <li class="hover-up">
                                        <a href="{{ route('shop.index', ['categorie' => $cat->id]) }}">
                                            {{ $cat->nom }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mb-30">
            <div class="row">
                <div class="col-12">
                    <div class="shop-product-fillter">
                        <div class="totall-product">
                            <p>Nous avons trouvé <strong class="text-brand">{{ $produits->total() }}</strong> articles pour
                                vous !</p>
                        </div>
                    </div>

                    <div class="row product-grid">
                        @foreach($produits as $produit)
                            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                <div class="product-cart-wrap mb-30">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a href="{{ route('shop.show', $produit->id) }}">
                                                <img class="default-img" src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}" />
                                            </a>
                                        </div>
                                        <div class="product-action-1">
                                            @auth
                                                @if($produit->isInWishlist())
                                                    <form action="{{ route('wishlist.remove', $produit->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="action-btn active" aria-label="Retirer des favoris">
                                                            <i class="fi-rs-heart"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('wishlist.add', $produit->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button class="action-btn" aria-label="Ajouter aux favoris">
                                                            <i class="fi-rs-heart"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            @else
                                                <a href="{{ route('login') }}" class="action-btn" aria-label="Ajouter aux favoris">
                                                    <i class="fi-rs-heart"></i>
                                                </a>
                                            @endauth 
                                            
                                            <!-- Bouton Vue Rapide - TOUJOURS VISIBLE -->
                                            <a aria-label="Vue rapide" 
                                                class="action-btn quick-view-btn" 
                                                data-bs-toggle="modal"
                                                data-bs-target="#quickViewModal"
                                                data-product-id="{{ $produit->id }}"
                                                data-product-name="{{ $produit->nom }}"
                                                data-product-image="{{ asset('storage/' . $produit->image) }}"
                                                data-product-price="{{ number_format($produit->prix_ttc, 2, ',', ' ') }}"
                                                data-product-old-price="{{ $produit->prix_promotionnel ? number_format($produit->prix_ht, 2, ',', ' ') : '' }}"
                                                data-product-description="{{ $produit->description ?? 'Aucune description disponible.' }}"
                                                data-product-category="{{ $produit->categorie->nom ?? 'Non catégorisé' }}"
                                                data-product-subcategory="{{ $produit->sousCategorie->nom ?? '' }}"
                                                data-product-stock="{{ $produit->stock ?? 'En stock' }}"
                                                data-product-link="{{ route('shop.show', $produit->id) }}">
                                                <i class="fi-rs-eye"></i>
                                            </a>
                                        </div>
                                        @if($produit->prix_promotionnel)
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="hot">Promo</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-category">
                                            <a href="#">{{ $produit->sousCategorie->nom ?? '' }}</a>
                                        </div>
                                        <h2 class="product-title">
                                            <a href="{{ route('shop.show', $produit->id) }}" title="{{ $produit->nom }}">
                                                {{ $produit->nom }}
                                            </a>
                                        </h2>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 80%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (3.5)</span>
                                        </div>
                                        <div class="product-card-bottom">
                                            <div class="product-price">
                                                <span>{{ number_format($produit->prix_ttc, 2, ',', ' ') }} €</span>
                                                @if($produit->prix_promotionnel)
                                                    <span class="old-price">{{ number_format($produit->prix_ht, 2, ',', ' ') }}
                                                        €</span>
                                                @endif
                                            </div>
                                            <!-- Dans product-card -->
                                            <!-- <div class="add-cart">
                                                <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                                                    @csrf
                                                    <input type="hidden" name="produit_id" value="{{ $produit->id }}">
                                                    <input type="hidden" name="qty" value="1">
                                                    @if($produit->avec_variant && $produit->variants->count() > 0)
                                                        <a href="{{ route('shop.show', $produit->id) }}" class="add">
                                                            <i class="fi-rs-shopping-cart mr-5"></i>Voir les options
                                                        </a>
                                                    @else
                                                        <button type="submit" class="add" style="background: none; border: none; color: inherit; cursor: pointer;">
                                                            <i class="fi-rs-shopping-cart mr-5"></i>Ajouter
                                                        </button>
                                                    @endif
                                                </form>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-area mt-20 mb-20">
                        {{ $produits->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Vue Rapide -->
        <div class="modal fade custom-modal" id="quickViewModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Vue Rapide</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="detail-gallery">
                                    <!-- IMAGE PRINCIPALE -->
                                    <div class="product-image-slider">
                                        <img src="" id="quickViewImage" alt="Produit" class="img-fluid" style="width:100px">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="detail-info">
                                    <h2 class="title-detail" id="quickViewTitle"></h2>
                                    
                                    <div class="product-detail-rating">
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 80%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (3.5)</span>
                                        </div>
                                        <span class="font-small ml-30 text-muted" id="quickViewStock"></span>
                                    </div>
                                    
                                    <div class="clearfix product-price-cover">
                                        <div class="product-price primary-color float-left">
                                            <span id="quickViewPrice" class="current-price"></span>
                                            <span id="quickViewOldPrice" class="old-price"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="short-desc mb-30">
                                        <p id="quickViewDescription" class="font-sm"></p>
                                    </div>
                                    
                                    <div class="detail-extralink mb-50">
                                        <div class="product-extra-link2">
                                            <button type="button" class="button button-add-to-cart">
                                                <i class="fi-rs-shopping-cart"></i>Ajouter au panier
                                            </button>
                                            <a aria-label="Voir les détails" href="#" id="quickViewLink" class="action-btn hover-up">
                                                <i class="fi-rs-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                    
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
