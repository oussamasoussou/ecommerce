@extends('front-end.layouts.app')
@section('content')
    <main class="main">
        <section class="home-slider position-relative mb-30">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 d-none d-lg-flex">
                        <div class="categories-dropdown-wrap style-2 font-heading mt-30">
                            <div class="d-flex categori-dropdown-inner">
                                <ul>
                                    @foreach($categories->take(10) as $category)
                                        <li>
                                            <a href="{{ route('shop.index', ['categorie' => $category->id]) }}" style="display: flex; align-items: center; white-space: nowrap;">
                                                @if($category->logo)
                                                    <img src="{{ asset('storage/' . $category->logo) }}" alt="{{ $category->name }}"
                                                        class="green-logo" style="flex-shrink: 0; margin-right: 8px;" />
                                                @else
                                                    <img src="{{ asset('assets/imgs/theme/icons/category-' . (($loop->index % 10) + 1) . '.svg') }}"
                                                        alt="{{ $category->name }}" class="green-logo" style="flex-shrink: 0; margin-right: 8px;"/>
                                                @endif
                                                <span style="font-size:13px; overflow: hidden; text-overflow: ellipsis;">{{ $category->name }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            @if($categories->count() > 10)
                                <div class="more_slide_open" style="display: none">
                                    <div class="d-flex categori-dropdown-inner">
                                        <ul>
                                            @foreach($categories->skip(10) as $category)
                                                <li>
                                                    <a href="{{ route('shop.index', ['categorie' => $category->id]) }}" style="display: flex; align-items: center; white-space: nowrap;">
                                                        @if($category->logo)
                                                            <img src="{{ asset('storage/' . $category->logo) }}"
                                                                alt="{{ $category->name }}" 
                                                                class="green-logo" style="flex-shrink: 0; margin-right: 8px;"/>
                                                        @else
                                                            <img src="{{ asset('assets/imgs/theme/icons/icon-' . ((($loop->index + 1) % 4) + 1) . '.svg') }}"
                                                                alt="{{ $category->name }}" 
                                                                class="green-logo" style="flex-shrink: 0; margin-right: 8px;"/>
                                                        @endif
                                                        <span style="font-size:13px; overflow: hidden; text-overflow: ellipsis;">{{ $category->name }}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="more_categories">
                                    <span class="icon"></span> 
                                    <span class="heading-sm-1">Voir plus...</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="home-slide-cover mt-30">
                            @if($sliders->count() > 0)
                                <div class="hero-slider-1 style-5 dot-style-1 dot-style-1-position-2">
                                    @foreach($sliders as $slider)
                                        <div class="single-hero-slider single-animation-wrap"
                                            style="background-image: url({{ asset('storage/' . $slider->image) }})">
                                            <div class="slider-content">
                                                <h1 class="display-2 mb-40">
                                                    {{ $slider->titre }}
                                                </h1>
                                                @if($slider->sous_titre)
                                                    <p class="mb-65">{{ $slider->sous_titre }}</p>
                                                @endif
                                                @if($slider->lien && $slider->texte_bouton)
                                                    <div class="form-subcriber d-flex">
                                                        <a href="{{ $slider->lien }}" class="btn btn-primary">
                                                            {{ $slider->texte_bouton }}
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="slider-arrow hero-slider-1-arrow"></div>
                            @else
                                <div class="hero-slider-1 style-5 dot-style-1 dot-style-1-position-2">
                                    <!-- Slider par défaut si aucun slider n'est configuré -->
                                    <div class="single-hero-slider single-animation-wrap"
                                        style="background-image: url(assets/imgs/slider/slider-7.png)">
                                        <div class="slider-content">
                                            <h1 class="display-2 mb-40">
                                                Bienvenue sur notre site
                                            </h1>
                                            <p class="mb-65">Découvrez nos meilleures offres</p>
                                            <a href="{{ route('shop.index') }}" class="btn btn-primary">Voir les produits</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="row">
                            @foreach($bannieres->take(2) as $index => $banniere)
                                <div class="col-md-6 col-lg-12">
                                    <div
                                        class="banner-img style-{{ $index == 0 ? '4' : '5' }} mt-{{ $index == 0 ? '30' : '5 mt-md-30' }}">
                                        @if($banniere->image)
                                            <img src="{{ asset('storage/' . $banniere->image) }}" alt="{{ $banniere->titre }}" />
                                        @else
                                            <img src="{{ asset('assets/imgs/banner/banner-14.png') }}"
                                                alt="{{ $banniere->titre }}" />
                                        @endif
                                        <div class="banner-text">
                                            <h{{ $index == 0 ? '4' : '5' }} class="mb-{{ $index == 0 ? '30' : '20' }}">
                                                {{ $banniere->titre }}
                                            </h{{ $index == 0 ? '4' : '5' }}>
                                            @if($banniere->lien)
                                                <a href="{{ $banniere->lien }}" class="btn btn-xs{{ $index == 0 ? ' mb-50' : '' }}">
                                                    {{ $banniere->texte_bouton ?: 'Découvrir' }}
                                                    <i class="fi-rs-arrow-small-right"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Bannières par défaut si moins de 2 bannières -->
                            @if($bannieres->count() < 2)
                                <div class="col-md-6 col-lg-12">
                                    <div class="banner-img style-5 mt-5 mt-md-30">
                                        <img src="{{ asset('assets/imgs/banner/banner-15.png') }}" alt="Bannière par défaut" />
                                        <div class="banner-text">
                                            <h5 class="mb-20">
                                                Découvrez nos produits
                                            </h5>
                                            <a href="{{ route('shop.index') }}" class="btn btn-xs">Voir plus <i
                                                    class="fi-rs-arrow-small-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End hero slider-->

        <!-- Featured Categories Section -->
        <section class="popular-categories section-padding">
            <div class="container wow animate__animated animate__fadeIn">
                <div class="section-title">
                    <div class="title">
                        <h3>Catégories Populaires</h3>
                        <ul class="list-inline nav nav-tabs links">
                            @foreach($categories->take(4) as $category)
                                <li class="list-inline-item nav-item">
                                    <a class="nav-link {{ $loop->first ? 'active' : '' }}" 
                                       href="{{ route('shop.index', ['categorie' => $category->id]) }}">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="slider-arrow slider-arrow-2 flex-right carausel-10-columns-arrow" id="carausel-10-columns-arrows"></div>
                </div>
                <div class="carausel-10-columns-cover position-relative">
                    <div class="carausel-10-columns" id="carausel-10-columns">
                        @foreach($categories as $category)
                            <div class="card-2 bg-{{ ($loop->index % 7) + 9 }} wow animate__animated animate__fadeInUp" 
                                 data-wow-delay="{{ $loop->index * 0.1 }}s">
                                <figure class="img-hover-scale overflow-hidden">
                                    <a href="{{ route('shop.index', ['categorie' => $category->id]) }}">
                                        @if($category->image)
                                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" />
                                        @else
                                            <img src="{{ asset('assets/imgs/shop/cat-' . (($loop->index % 15) + 1) . '.png') }}" alt="{{ $category->name }}" />
                                        @endif
                                    </a>
                                </figure>
                                <h6><a href="{{ route('shop.index', ['categorie' => $category->id]) }}">{{ $category->name }}</a></h6>
                                <span>{{ $category->products_count ?? 0 }} produits</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        <!-- End Featured Categories Section -->


        <!-- Products Tabs Section -->
<section class="product-tabs section-padding position-relative">
    <div class="container">
        <div class="section-title style-2 wow animate__animated animate__fadeIn">
            <h3>Produits Populaires</h3>
            <ul class="nav nav-tabs links" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="nav-tab-one" data-bs-toggle="tab" data-bs-target="#tab-one" type="button" role="tab" aria-controls="tab-one" aria-selected="true">Tous</button>
                </li>
                @foreach($categories->take(6) as $category)
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="nav-tab-{{ $category->id }}" data-bs-toggle="tab" data-bs-target="#tab-{{ $category->id }}" type="button" role="tab" aria-controls="tab-{{ $category->id }}" aria-selected="false">{{ $category->name }}</button>
                </li>
                @endforeach
            </ul>
        </div>
        <!--End nav-tabs-->
        <div class="tab-content" id="myTabContent">
            <!-- Tab Tous les produits -->
            <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                <div class="row product-grid-4">
                    @forelse($produitsPopulaires as $produit)
                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                        <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn" data-wow-delay="{{ $loop->index * 0.1 }}s">
                            <div class="product-img-action-wrap">
                                <div class="product-img product-img-zoom">
                                    <a href="{{ route('shop.show', $produit->id) }}">
                                        @if($produit->image)
                                            <img class="default-img" src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}" />
                                        @else
                                            <img class="default-img" src="{{ asset('assets/imgs/shop/product-' . (($loop->index % 10) + 1) . '-1.jpg') }}" alt="{{ $produit->nom }}" />
                                        @endif
                                        <!-- Image hover -->
                                        @if($produit->produitImages && $produit->produitImages->count() > 0)
                                            <img class="hover-img" src="{{ asset('storage/' . $produit->produitImages->first()->image_path) }}" alt="{{ $produit->nom }}" />
                                        @else
                                            <img class="hover-img" src="{{ asset('assets/imgs/shop/product-' . (($loop->index % 10) + 1) . '-2.jpg') }}" alt="{{ $produit->nom }}" />
                                        @endif
                                    </a>
                                </div>
                                <div class="product-action-1">
                                    @auth
                                    <a aria-label="Ajouter aux favoris" class="action-btn" 
                                       href="{{ route('wishlist.toggle') }}" 
                                       onclick="event.preventDefault(); document.getElementById('wishlist-form-{{ $produit->id }}').submit();">
                                        <i class="fi-rs-heart"></i>
                                    </a>
                                    <form id="wishlist-form-{{ $produit->id }}" action="{{ route('wishlist.toggle') }}" method="POST" class="d-none">
                                        @csrf
                                        <input type="hidden" name="produit_id" value="{{ $produit->id }}">
                                    </form>
                                    @else
                                    <a aria-label="Ajouter aux favoris" class="action-btn" href="{{ route('frontend.login') }}">
                                        <i class="fi-rs-heart"></i>
                                    </a>
                                    @endauth
                                    <a aria-label="Vue rapide" class="action-btn" href="{{ route('shop.show', $produit->id) }}"><i class="fi-rs-eye"></i></a>
                                </div>
                                @if($produit->prix_promotionnel)
                                <div class="product-badges product-badges-position product-badges-mrg">
                                    <span class="hot">Promo</span>
                                </div>
                                @elseif($loop->first)
                                <div class="product-badges product-badges-position product-badges-mrg">
                                    <span class="new">Nouveau</span>
                                </div>
                                @endif
                            </div>
                            <div class="product-content-wrap">
                                <div class="product-category">
                                    <a href="{{ route('shop.index', ['categorie' => $produit->sousCategorie->categorie_id ?? '']) }}">
                                        {{ $produit->sousCategorie->category->name ?? 'Catégorie' }}
                                    </a>
                                </div>
                                <h2><a href="{{ route('shop.show', $produit->id) }}">{{ $produit->nom }}</a></h2>
                                <div class="product-rate-cover">
                                    <div class="product-rate d-inline-block">
                                        <div class="product-rating" style="width: {{ rand(70, 100) }}%"></div>
                                    </div>
                                    <span class="font-small ml-5 text-muted"> ({{ number_format(rand(30, 50) / 10, 1) }})</span>
                                </div>
                                <div>
                                    <span class="font-small text-muted">
                                        @if($produit->marque)
                                            marque :<a href="#"> {{ $produit->marque->name }}</a>
                                        @else
                                            marque :<a href="#"> Notre Marque</a>
                                        @endif
                                    </span>
                                </div>
                                <div class="product-card-bottom">
                                    <div class="product-price">
                                        @if($produit->prix_promotionnel)
                                            <span>{{ number_format($produit->prix_promotionnel, 2) }} €</span>
                                            <span class="old-price">{{ number_format($produit->prix_ttc, 2) }} €</span>
                                        @else
                                            <span>{{ number_format($produit->prix_ttc, 2) }} €</span>
                                        @endif
                                    </div>
                                    <!-- Dans product-card -->
                                    <!-- <div class="add-cart">
                                        <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                                            @csrf
                                            <input type="hidden" name="produit_id" value="{{ $produit->id }}">
                                            <input type="hidden" name="qty" value="1">
                                            <button type="submit" class="add" style="background: none; border: none; color: inherit; cursor: pointer;">
                                                <i class="fi-rs-shopping-cart mr-5"></i>Ajouter
                                            </button>
                                        </form>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end product card-->
                    @empty
                    <div class="col-12 text-center py-5">
                        <h4>Aucun produit disponible pour le moment</h4>
                        <p>Revenez bientôt pour découvrir nos nouveautés</p>
                    </div>
                    @endforelse
                </div>
                <!--End product-grid-4-->
            </div>
            <!--En tab one-->

            <!-- Tabs par catégorie -->
            @foreach($categories->take(6) as $category)
            <div class="tab-pane fade" id="tab-{{ $category->id }}" role="tabpanel" aria-labelledby="tab-{{ $category->id }}">
                <div class="row product-grid-4">
                    @php
                        $categoryProducts = $produitsPopulaires->filter(function($produit) use ($category) {
                            return $produit->sousCategorie && $produit->sousCategorie->categorie_id == $category->id;
                        });
                    @endphp
                    
                    @forelse($categoryProducts as $produit)
                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                        <div class="product-cart-wrap mb-30">
                            <div class="product-img-action-wrap">
                                <div class="product-img product-img-zoom">
                                    <a href="{{ route('shop.show', $produit->id) }}">
                                        @if($produit->image)
                                            <img class="default-img" src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}" />
                                        @else
                                            <img class="default-img" src="{{ asset('assets/imgs/shop/product-' . (($loop->index % 10) + 1) . '-1.jpg') }}" alt="{{ $produit->nom }}" />
                                        @endif
                                    </a>
                                </div>
                                <div class="product-action-1">
                                    @auth
                                    <a aria-label="Ajouter aux favoris" class="action-btn" 
                                       href="{{ route('wishlist.toggle') }}" 
                                       onclick="event.preventDefault(); document.getElementById('wishlist-form-cat-{{ $produit->id }}').submit();">
                                        <i class="fi-rs-heart"></i>
                                    </a>
                                    <form id="wishlist-form-cat-{{ $produit->id }}" action="{{ route('wishlist.toggle') }}" method="POST" class="d-none">
                                        @csrf
                                        <input type="hidden" name="produit_id" value="{{ $produit->id }}">
                                    </form>
                                    @else
                                    <a aria-label="Ajouter aux favoris" class="action-btn" href="{{ route('frontend.login') }}">
                                        <i class="fi-rs-heart"></i>
                                    </a>
                                    @endauth
                                    <a aria-label="Comparer" class="action-btn" href="#"><i class="fi-rs-shuffle"></i></a>
                                    <a aria-label="Vue rapide" class="action-btn" href="{{ route('shop.show', $produit->id) }}"><i class="fi-rs-eye"></i></a>
                                </div>
                            </div>
                            <div class="product-content-wrap">
                                <div class="product-category">
                                    <a href="{{ route('shop.index', ['categorie' => $category->id]) }}">{{ $category->name }}</a>
                                </div>
                                <h2><a href="{{ route('shop.show', $produit->id) }}">{{ $produit->nom }}</a></h2>
                                <div class="product-rate-cover">
                                    <div class="product-rate d-inline-block">
                                        <div class="product-rating" style="width: {{ rand(70, 100) }}%"></div>
                                    </div>
                                    <span class="font-small ml-5 text-muted"> ({{ number_format(rand(30, 50) / 10, 1) }})</span>
                                </div>
                                <div class="product-card-bottom">
                                    <div class="product-price">
                                        @if($produit->prix_promotionnel)
                                            <span>{{ number_format($produit->prix_promotionnel, 2) }} €</span>
                                            <span class="old-price">{{ number_format($produit->prix_ttc, 2) }} €</span>
                                        @else
                                            <span>{{ number_format($produit->prix_ttc, 2) }} €</span>
                                        @endif
                                    </div>
                                    <div class="add-cart">
                                        <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                                            @csrf
                                            <input type="hidden" name="produit_id" value="{{ $produit->id }}">
                                            <input type="hidden" name="qty" value="1">
                                            <button type="submit" class="add" style="background: none; border: none; color: inherit; cursor: pointer;">
                                                <i class="fi-rs-shopping-cart mr-5"></i>Ajouter
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end product card-->
                    @empty
                    <div class="col-12 text-center py-5">
                        <h4>Aucun produit dans cette catégorie</h4>
                        <p>Découvrez nos autres catégories</p>
                    </div>
                    @endforelse
                </div>
                <!--End product-grid-4-->
            </div>
            <!--En tab category-->
            @endforeach
        </div>
        <!--End tab-content-->
    </div>
</section>
<!-- End Products Tabs Section -->

    </main>
@endsection
