@extends('front-end.layouts.app')

@section('content')
<main class="main">
    <div class="page-header mt-30 mb-50">
        <div class="container">
            <div class="archive-header">
                <div class="row align-items-center">
                    <div class="col-xl-3">
                        <h1 class="mb-15">Recherche</h1>
                        <div class="breadcrumb">
                            <a href="{{ route('shop.index') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                            <span></span> Recherche
                        </div>
                    </div>
                    <div class="col-xl-9 text-end d-none d-xl-block">
                        <ul class="tags-list">
                            @foreach($categoriesMenu as $cat)
                                <li class="hover-up">
                                    <a href="{{ route('shop.index', ['categorie' => $cat->id]) }}">
                                        {{ $cat->name }}
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
                <!-- Barre de recherche -->
                <div class="shop-product-fillter mb-30">
                    <div class="totall-product">
                        @if($query || $categoryId)
                            <p>Nous avons trouvé <strong class="text-brand">{{ $produits->total() }}</strong> 
                            produit(s) 
                            @if($query)
                                pour "<strong>{{ $query }}</strong>"
                            @endif
                            @if($categoryId && $sousCategorie = \App\Models\SousCategorie::find($categoryId))
                                dans <strong>{{ $sousCategorie->name }}</strong>
                            @endif
                            </p>
                        @else
                            <p><strong class="text-brand">{{ $produits->total() }}</strong> produits trouvés</p>
                        @endif
                    </div>
                    
                    <!-- Formulaire de recherche -->
                    <div class="search-style-2" style="max-width: 400px;">
                        <form action="{{ route('frontend.search') }}" method="GET">
                            <select class="select-active" name="category">
                                <option value="">Toutes catégories</option>
                                @foreach($categoriesMenu as $category)
                                    <optgroup label="{{ $category->name }}">
                                        @foreach($category->sousCategories as $sousCategorie)
                                            <option value="{{ $sousCategorie->id }}" 
                                                {{ request('category') == $sousCategorie->id ? 'selected' : '' }}>
                                                {{ $sousCategorie->name }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            <input type="text" name="q" placeholder="Rechercher..." 
                                   value="{{ $query }}" />
                            <button type="submit" style="border: none; background: none; cursor: pointer;">
                                <i class="fi-rs-search"></i>
                            </button>
                        </form>
                    </div>
                </div>

                @if($produits->count() > 0)
                    <div class="row product-grid">
                        @foreach($produits as $produit)
                        <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                            <div class="product-cart-wrap mb-30">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="{{ route('shop.show', $produit->id) }}">
                                            <img class="default-img" 
                                                 src="{{ $produit->image ? asset('storage/' . $produit->image) : asset('front-end/imgs/shop/product-1-1.jpg') }}" 
                                                 alt="{{ $produit->nom }}" />
                                        </a>
                                    </div>
                                    <div class="product-action-1">
                                        <a aria-label="Add To Wishlist" class="action-btn" href="#"><i class="fi-rs-heart"></i></a>
                                        <a aria-label="Compare" class="action-btn" href="#"><i class="fi-rs-shuffle"></i></a>
                                        <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                    </div>
                                    @if($produit->prix_promotionnel)
                                        <div class="product-badges product-badges-position product-badges-mrg">
                                            <span class="hot">Promo</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="product-content-wrap">
                                    <div class="product-category">
                                        <a href="#">{{ $produit->sousCategorie->name ?? '' }}</a>
                                    </div>
                                    <h2><a href="{{ route('shop.show', $produit->id) }}">{{ $produit->nom }}</a></h2>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 80%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (3.5)</span>
                                    </div>
                                    <div class="product-card-bottom">
                                        <div class="product-price">
                                            @if($produit->prix_promotionnel)
                                                <span>€{{ number_format($produit->prix_promotionnel, 2) }}</span>
                                                <span class="old-price">€{{ number_format($produit->prix_ttc, 2) }}</span>
                                            @else
                                                <span>€{{ number_format($produit->prix_ttc, 2) }}</span>
                                            @endif
                                        </div>
                                        <div class="add-cart">
                                            <a class="add" href="#"><i class="fi-rs-shopping-cart mr-5"></i>Add</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                  
                @else
                    <div class="text-center py-5">
                        <div class="empty-search">
                            <img src="{{ asset('front-end/imgs/theme/empty-search.svg') }}" alt="Aucun résultat" style="max-width: 200px;" class="mb-4">
                            <h4 class="mb-3">Aucun produit trouvé</h4>
                            <p class="text-muted mb-4">Essayez de modifier vos critères de recherche</p>
                            <a href="{{ route('shop.index') }}" class="btn btn-default">Voir tous les produits</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection