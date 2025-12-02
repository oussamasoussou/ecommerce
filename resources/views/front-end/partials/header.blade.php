<header class="header-area header-style-1 header-style-5 header-height-2">
    <div class="mobile-promotion">
        <span>Ouverture exceptionnelle, <strong>jusqu'à 15%</strong> de réduction sur tous les articles. Plus que
            <strong>3 jours</strong> restants</span>
    </div>
    <div class="header-top header-top-ptb-1 d-none d-lg-block">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-3 col-lg-4">
                    <!-- Espace libre -->
                </div>
                <div class="col-xl-6 col-lg-4">
                    <div class="text-center">
                        <div id="news-flash" class="d-inline-block">
                            <ul>
                                <li>Livraison 100% sécurisée sans contact avec le livreur</li>
                                <li>Super offres - Économisez plus avec des coupons</li>
                                <li>Bijoux argent tendance, économisez jusqu'à 35% aujourd'hui</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4">
                    <div class="header-info header-info-right">
                        <ul>
                            <li>Besoin d'aide ? Appelez-nous : <strong class="text-brand"> + 1800 900</strong></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
        <div class="container">
            <div class="header-wrap">
                <div class="logo logo-width-1">
                    <a href="index.html"><img src="{{ asset('front-end/imgs/theme/logo.svg') }}" alt="logo" /></a>
                </div>
                <div class="header-right">
                    <div class="search-style-2">
                        <form action="{{ route('frontend.search') }}" method="GET">
                            <select class="select-active" name="category">
                                <option value="">Toutes catégories</option>
                                @foreach($categoriesMenu as $category)
                                    <optgroup label="{{ $category->name }}">
                                        @foreach($category->sousCategories as $sousCategorie)
                                            <option value="{{ $sousCategorie->id }}" {{ request('category') == $sousCategorie->id ? 'selected' : '' }}>
                                                {{ $sousCategorie->name }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            <input type="text" name="q" placeholder="Rechercher des articles..."
                                value="{{ request('q') }}" />
                            <button style="border: none; background: none; cursor: pointer;">
                            </button>
                        </form>
                    </div>
                    <div class="header-action-right">
                        <div class="header-action-2">
                            <div class="header-action-icon-2">
                                <a href="{{ route('wishlist.index') }}">
                                    <img class="svgInject" alt="Nest"
                                        src="{{ asset('front-end/imgs/theme/icons/icon-heart.svg') }}" />
                                    <span class="pro-count blue">
                                        @auth
                                            {{ auth()->user()->wishlists()->count() }}
                                        @else
                                            0
                                        @endauth
                                    </span>
                                </a>
                            </div>
                            <div class="header-action-icon-2">
                                <a class="mini-cart-icon" href="{{ route('cart.index') }}">
                                    <img alt="Nest" src="{{ asset('front-end/imgs/theme/icons/icon-cart.svg') }}" />
                                    <span class="pro-count blue cart-count">
                                        {{ App\Models\Cart::getCartCount() }}
                                    </span>
                                </a>
                                <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                    <div class="cart-dropdown-content">
                                        <ul id="mini-cart-items">
                                            @php
                                                $cartItems = App\Models\Cart::getCart()->take(3);
                                                $miniCartTotal = App\Models\Cart::getCartTotal();
                                            @endphp

                                            @if($cartItems->count() > 0)
                                                @foreach($cartItems as $item)
                                                    <li>
                                                        <div class="shopping-cart-img">
                                                            <a href="{{ route('shop.show', $item->produit_id) }}">
                                                                <img src="{{ asset('storage/' . $item->produit->image) }}"
                                                                    alt="{{ $item->produit->nom }}"
                                                                    style="width: 60px; height: 60px; object-fit: cover;">
                                                            </a>
                                                        </div>
                                                        <div class="shopping-cart-title">
                                                            <h4>
                                                                <a href="{{ route('shop.show', $item->produit_id) }}">
                                                                    {{ Str::limit($item->produit->nom, 20) }}
                                                                </a>
                                                            </h4>
                                                            <h4><span>{{ $item->quantite }} ×
                                                                </span>{{ number_format($item->prix_unitaire, 2, ',', ' ') }} €
                                                            </h4>
                                                        </div>
                                                        <div class="shopping-cart-delete">
                                                            <a href="#" class="remove-mini-cart" data-cart-id="{{ $item->id }}">
                                                                <i class="fi-rs-cross-small"></i>
                                                            </a>
                                                        </div>
                                                    </li>
                                                @endforeach

                                                <li>
                                                    <div class="shopping-cart-footer">
                                                        <div class="shopping-cart-total">
                                                            <h4>Total <span>{{ number_format($miniCartTotal, 2, ',', ' ') }}
                                                                    €</span></h4>
                                                        </div>
                                                        <div class="shopping-cart-button">
                                                            <a href="{{ route('cart.index') }}" class="outline">Voir le
                                                                panier</a>
                                                            <a href="{{ route('checkout.index') }}">Commander</a>
                                                        </div>
                                                    </div>
                                                </li>
                                            @else
                                                <li class="text-center py-3">
                                                    <p class="text-muted">Votre panier est vide</p>
                                                    <a href="{{ route('shop.index') }}"
                                                        class="btn btn-sm btn-fill-out">Commencer les achats</a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="header-action-icon-2">
                                @auth
                                    <!-- Menu utilisateur connecté -->
                                    <div class="header-action-icon-2">
                                        <a href="#">
                                            <img class="svgInject" alt="Nest"
                                                src="{{ asset('front-end/imgs/theme/icons/icon-user.svg') }}" />
                                        </a>
                                        <a href="#"><span class="lable ml-0">Mon Compte</span></a>
                                        <div class="cart-dropdown-wrap cart-dropdown-hm2 account-dropdown">
                                            <ul>
                                                <li><a href="#"><i class="fi fi-rs-user mr-10"></i>Mon Compte</a></li>
                                                <li><a href="#"><i class="fi fi-rs-location-alt mr-10"></i>Suivi de
                                                        commande</a></li>
                                                <li><a href="#"><i class="fi fi-rs-label mr-10"></i>Mes Bons de
                                                        réduction</a></li>
                                                <li><a href="shop-wishlist.html"><i class="fi fi-rs-heart mr-10"></i>Ma
                                                        Liste de souhaits</a></li>
                                                <li><a href="#"><i
                                                            class="fi fi-rs-settings-sliders mr-10"></i>Paramètres</a></li>
                                                <li>
                                                    <form method="POST" action="{{ route('frontend.logout') }}"
                                                        id="logout-form">
                                                        @csrf
                                                        <a href="#"
                                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                            <i class="fi fi-rs-sign-out mr-10"></i>Déconnexion
                                                        </a>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                @else
                                    <!-- Lien de connexion -->
                                    <div class="header-action-icon-2">
                                        <a href="{{ route('frontend.login') }}">
                                            <img class="svgInject" alt="Nest"
                                                src="{{ asset('front-end/imgs/theme/icons/icon-user.svg') }}" />
                                        </a>
                                        <a href="{{ route('frontend.login') }}"><span
                                                class="lable ml-0">Connexion</span></a>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom header-bottom-bg-color sticky-bar">
        <div class="container">
            <div class="header-wrap header-space-between position-relative">
                <div class="logo logo-width-1 d-block d-lg-none">
                    <a href="index.html"><img src="{{ asset('front-end/imgs/theme/logo.svg') }}" alt="logo" /></a>
                </div>
                <div class="header-nav d-none d-lg-flex">
                    <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block font-heading">
                        <nav>
                            <ul>
                                <!-- Catégories dynamiques pour le menu desktop -->
                                @foreach($categoriesMenu as $category)
                                    <li class="@if($category->sousCategories->count() > 0) position-static @endif">
                                        <img src="{{ asset('storage/' . $category->logo) }}" alt="{{ $category->name }}"
                                            style="height: 22px; width: 22px; object-fit: contain; margin-right: 4px; 
                                                    filter: brightness(0) invert(1) sepia(1) saturate(0%) hue-rotate(0deg);">
                                        <a
                                            href="{{ route('shop.index', ['categorie' => $category->sousCategories->first()->id ?? '']) }}">
                                            {{ $category->name }}
                                            @if($category->sousCategories->count() > 0)
                                                <i class="fi-rs-angle-down"></i>
                                            @endif
                                        </a>

                                        @if($category->sousCategories->count() > 0)
                                            <ul class="mega-menu">
                                                <li class="sub-mega-menu sub-mega-menu-width-22">
                                                    <a class="menu-title"
                                                        href="{{ route('shop.index', ['categorie' => $category->sousCategories->first()->id ?? '']) }}">{{ $category->name }}</a>
                                                    <ul>
                                                        @foreach($category->sousCategories as $sousCategorie)
                                                            <li><a
                                                                    href="{{ route('shop.index', ['categorie' => $sousCategorie->id]) }}">{{ $sousCategorie->name }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                                <li class="sub-mega-menu sub-mega-menu-width-34">
                                                    <div class="menu-banner-wrap">
                                                        <a
                                                            href="{{ route('shop.index', ['categorie' => $category->sousCategories->first()->id ?? '']) }}">
                                                            <img src="{{ asset('storage/' . $category->image) }}"
                                                                style="height: 322px; width: 508px;">
                                                            <a alt="{{ $category->name }}" />
                                                        </a>
                                                        <div class="menu-banner-content">
                                                            <h4>Offres spéciales</h4>
                                                            <h3>Découvrez {{ $category->name }}</h3>
                                                            <div class="menu-banner-price">
                                                                <span class="new-price text-success">Économisez jusqu'à
                                                                    50%</span>
                                                            </div>
                                                            <div class="menu-banner-btn">
                                                                <a
                                                                    href="{{ route('shop.index', ['categorie' => $category->sousCategories->first()->id ?? '']) }}">Acheter
                                                                    maintenant</a>
                                                            </div>
                                                        </div>
                                                        <div class="menu-banner-discount">
                                                            <h3>
                                                                <span>25%</span>
                                                                de réduction
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </nav>
                    </div>
                </div>

                <div class="header-action-icon-2 d-block d-lg-none">
                    <div class="burger-icon burger-icon-white">
                        <span class="burger-icon-top"></span>
                        <span class="burger-icon-mid"></span>
                        <span class="burger-icon-bottom"></span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</header>

<!-- Mobile Header -->
<div class="mobile-header-active mobile-header-wrapper-style">
    <div class="mobile-header-wrapper-inner">
        <div class="mobile-header-top">
            <div class="mobile-header-logo">
                <a href="index.html"><img src="{{ asset('front-end/imgs/theme/logo.svg') }}" alt="logo" /></a>
            </div>
            <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                <button class="close-style search-close">
                    <i class="icon-top"></i>
                    <i class="icon-bottom"></i>
                </button>
            </div>
        </div>
        <div class="mobile-header-content-area">
            <div class="mobile-search search-style-3 mobile-header-border">
                <form action="#">
                    <input type="text" placeholder="Rechercher des articles…" />
                    <button type="submit"><i class="fi-rs-search"></i></button>
                </form>
            </div>
            <div class="mobile-menu-wrap mobile-header-border">
                <nav>
                    <ul class="mobile-menu font-heading">
                        <!-- Catégories dynamiques pour le menu mobile -->
                        @foreach($categoriesMenu as $category)
                            <li class="menu-item-has-children">
                                <a
                                    href="{{ route('shop.index', ['categorie' => $category->sousCategories->first()->id ?? '']) }}">
                                    {{ $category->name }}
                                </a>
                                @if($category->sousCategories->count() > 0)
                                    <ul class="dropdown">
                                        @foreach($category->sousCategories as $sousCategorie)
                                            <li>
                                                <a href="{{ route('shop.index', ['categorie' => $sousCategorie->id]) }}">
                                                    {{ $sousCategorie->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </nav>
            </div>
            <div class="mobile-header-info-wrap">
                <div class="single-mobile-header-info">
                    <a href="page-contact.html"><i class="fi-rs-marker"></i> Notre localisation</a>
                </div>
                <div class="single-mobile-header-info">
                    <a href="page-login.html"><i class="fi-rs-user"></i>Connexion / Inscription</a>
                </div>
                <div class="single-mobile-header-info">
                    <a href="#"><i class="fi-rs-headphones"></i>(+01) - 2345 - 6789</a>
                </div>
            </div>
            <div class="mobile-social-icon mb-50">
                <h6 class="mb-15">Suivez-nous</h6>
                <a href="#"><img src="{{ asset('front-end/imgs/theme/icons/icon-facebook-white.svg') }}"
                        alt="Facebook" /></a>
                <a href="#"><img src="{{ asset('front-end/imgs/theme/icons/icon-twitter-white.svg') }}"
                        alt="Twitter" /></a>
                <a href="#"><img src="{{ asset('front-end/imgs/theme/icons/icon-instagram-white.svg') }}"
                        alt="Instagram" /></a>
                <a href="#"><img src="{{ asset('front-end/imgs/theme/icons/icon-pinterest-white.svg') }}"
                        alt="Pinterest" /></a>
                <a href="#"><img src="{{ asset('front-end/imgs/theme/icons/icon-youtube-white.svg') }}"
                        alt="YouTube" /></a>
            </div>
            <div class="site-copyright">Copyright 2025 © Nest. Tous droits réservés. Propulsé par AliThemes.</div>
        </div>
    </div>
</div>