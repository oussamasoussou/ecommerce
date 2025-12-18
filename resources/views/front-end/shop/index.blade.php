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

                    <div class="row product-grid g-3">
                        @foreach($produits as $produit)
                            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                <div class="product-cart-wrap mb-30">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a href="{{ route('shop.show', $produit->id) }}">
                                                <img class="default-img" src="{{ asset('storage/' . $produit->image) }}"
                                                    alt="{{ $produit->nom }}" />
                                            </a>
                                        </div>
                                        <div class="product-action-1">
                                            @auth
                                                @if($produit->isInWishlist())
                                                    <form action="{{ route('wishlist.remove', $produit->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="action-btn active" aria-label="Retirer des favoris">
                                                            <i class="fi-rs-heart"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('wishlist.add', $produit->id) }}" method="POST"
                                                        class="d-inline">
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
                                            <a aria-label="Vue rapide" class="action-btn quick-view-btn" data-bs-toggle="modal"
                                                data-bs-target="#quickViewModal" data-product-id="{{ $produit->id }}"
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
                                            <!-- Dans la boucle foreach des produits -->
                                            <div class="add-cart">
                                                <!-- Pour les produits AVEC variants -->
                                                @if($produit->avec_variant && $produit->variants->count() > 0)
                                                    <button type="button" class="add add-to-cart-modal-btn" 
                                                            data-product-id="{{ $produit->id }}"
                                                            data-product-name="{{ $produit->nom }}"
                                                            data-product-image="{{ asset('storage/' . $produit->image) }}"
                                                            data-product-price="{{ number_format($produit->prix_promotionnel ?? $produit->prix_ttc, 2, ',', ' ') }} €"
                                                            data-product-old-price="{{ $produit->prix_promotionnel ? number_format($produit->prix_ttc, 2, ',', ' ') : '' }}"
                                                            style="background: none; border: none; color: inherit; cursor: pointer;">
                                                        <i class="fi-rs-shopping-cart mr-5"></i>Ajouter
                                                    </button>
                                                @else
                                                <!-- Pour les produits SANS variant -->
                                                    <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                                                        @csrf
                                                        <input type="hidden" name="produit_id" value="{{ $produit->id }}">
                                                        <input type="hidden" name="qty" value="1">
                                                        <button type="submit" class="add" style="background: none; border: none; color: inherit; cursor: pointer;">
                                                            <i class="fi-rs-shopping-cart mr-5"></i>Ajouter
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
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

        <!-- Modal d'ajout au panier avec variants -->
<div class="modal fade custom-modal" id="addToCartModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sélectionnez les options</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addToCartModalForm" action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="produit_id" id="modal_product_id">
                    
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="detail-gallery">
                                <img src="" id="modal_product_image" alt="Produit" class="img-fluid" style="width: 100%; max-height: 400px; object-fit: contain;">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="detail-info">
                                <h2 class="title-detail" id="modal_product_name"></h2>
                                <div class="product-price-cover">
                                    <div class="product-price primary-color">
                                        <span id="modal_product_price" class="current-price text-brand"></span>
                                        <span id="modal_product_old_price" class="old-price"></span>
                                    </div>
                                </div>
                                
                                <!-- Section des variants -->
                                <div id="variants_section" style="display: none;">
                                    <!-- Sélection de couleur -->
                                    <!-- Dans le modal (déjà présent mais vérifiez cette partie) -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Couleur <span class="text-danger">*</span></label>
                                        <div class="color-options d-flex flex-wrap gap-2" id="color_options">
                                            <!-- Les options de couleur seront générées ici -->
                                        </div>
                                        <input type="hidden" name="variant_id" id="selected_variant_id">
                                        <div class="text-danger mt-1 small" id="color_error" style="display: none;">
                                            <i class="fi-rs-exclamation mr-2"></i>Veuillez sélectionner une couleur
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Taille <span class="text-danger">*</span></label>
                                        <div class="size-options d-flex flex-wrap gap-2" id="size_options">
                                            <!-- Les options de taille seront générées ici -->
                                        </div>
                                        <div class="text-danger mt-1 small" id="size_error" style="display: none;">
                                            <i class="fi-rs-exclamation mr-2"></i>Veuillez sélectionner une taille
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Section pour produits sans variant -->
                                <div id="no_variants_section" style="display: none;">
                                    <div class="mb-3">
                                        <span class="text-muted">Stock disponible: </span>
                                        <span id="product_stock" class="fw-bold"></span>
                                    </div>
                                </div>
                                
                                <!-- Quantité -->
                                <div class="mb-4">
                                    <label class="form-label">Quantité</label>
                                    <div class="detail-qty border radius">
                                        <a href="#" class="qty-down" id="modal_qty_down"><i class="fi-rs-angle-small-down"></i></a>
                                        <input type="number" name="qty" class="qty-val" value="1" min="1" 
                                            id="modal_product_qty" style="width: 60px; text-align: center;">
                                        <a href="#" class="qty-up" id="modal_qty_up"><i class="fi-rs-angle-small-up"></i></a>
                                    </div>
                                </div>
                                
                                <!-- Message d'erreur -->
                                <div class="alert alert-danger" id="variant_error" style="display: none;"></div>
                                
                                <!-- Bouton Ajouter -->
                                <div class="d-flex gap-2">
                                    <button type="submit" class="button button-add-to-cart flex-grow-1">
                                        <i class="fi-rs-shopping-cart"></i> Ajouter au panier
                                    </button>
                                    <a href="#" id="view_details_link" class="button button-secondary">
                                        Voir détails
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
                                            <a aria-label="Voir les détails" href="#" id="quickViewLink"
                                                class="action-btn hover-up">
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