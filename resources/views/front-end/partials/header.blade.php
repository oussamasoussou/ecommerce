<header class="header-area header-style-1 header-style-5 header-height-2">
    <div class="mobile-promotion">
        <span>{{ config('shop.tagline') }} — <strong>paiement à la livraison</strong></span>
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
                                <li>Paiement à la livraison partout en Tunisie</li>
                                <li>Livraison gratuite sur toutes les commandes</li>
                                <li>Bsissa et produits traditionnels tunisiens</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4">
                    <div class="header-info header-info-right">
                        <ul>
                            @if (config('shop.phone'))
                                <li>Besoin d'aide ? Appelez-nous :
                                    <a href="tel:{{ preg_replace('/[^\d+]/', '', config('shop.phone')) }}"><strong class="text-brand">{{ config('shop.phone') }}</strong></a>
                                </li>
                            @else
                                <li><a href="{{ route('pages.show', 'contact') }}">Besoin d'aide ? Contactez-nous</a></li>
                            @endif
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
                    <a href="{{ url('/') }}"><img src="{{ asset('front-end/imgs/theme/dar_el_3oula.svg') }}" alt="{{ config('shop.name') }}" /></a>
                </div>
                <div class="header-right">
                    <div class="search-style-2">
                        <form action="{{ route('frontend.search') }}" method="GET">
                            <select class="select-active" name="category">
                                <option value="">Toutes catégories</option>
                                @foreach ($categoriesMenu as $category)
                                    <optgroup label="{{ $category->name }}">
                                        @foreach ($category->sousCategories as $sousCategorie)
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
                                    <img class="svgInject" alt="Mes favoris"
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
                                    <img alt="Mon panier" src="{{ asset('front-end/imgs/theme/icons/icon-cart.svg') }}" />
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
                                                @foreach ($cartItems as $item)
                                                    <li>
                                                        <div class="shopping-cart-img">
                                                            <a href="{{ route('shop.show', $item->produit_id) }}">
                                                                <img src="{{ $item->produit->image_url }}"
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
                                                                </span>{{ number_format($item->prix_unitaire, 2, ',', ' ') }} DT
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
                                                                    DT</span></h4>
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
                                        <a href="{{ route('account.profile') }}">
                                            <img class="svgInject" alt="Mon compte"
                                                src="{{ asset('front-end/imgs/theme/icons/icon-user.svg') }}" />
                                        </a>
                                        <a href="{{ route('account.profile') }}"><span class="lable ml-0">Mon Compte</span></a>
                                        <div class="cart-dropdown-wrap cart-dropdown-hm2 account-dropdown">
                                            <ul>
                                                <li><a href="{{ route('account.profile') }}"><i class="fi fi-rs-user mr-10"></i>Mon profil</a></li>
                                                <li><a href="{{ route('account.orders') }}"><i class="fi fi-rs-location-alt mr-10"></i>Mes commandes</a></li>
                                                <li><a href="{{ route('wishlist.index') }}"><i class="fi fi-rs-heart mr-10"></i>Mes favoris</a></li>
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
                                            <img class="svgInject" alt="Mon compte"
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
                    <a href="{{ url('/') }}"><img src="{{ asset('front-end/imgs/theme/dar_el_3oula.svg') }}" alt="{{ config('shop.name') }}" /></a>
                </div>
                <div class="header-nav d-none d-lg-flex">
                    <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block font-heading">
                        <nav>
                            <ul>
                                <!-- Catégories dynamiques pour le menu desktop -->
                                @foreach ($categoriesMenu as $category)
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
                                                        @foreach ($category->sousCategories as $sousCategorie)
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
                                                            <img src="{{ $category->image ? asset('storage/' . $category->image) : asset('front-end/imgs/theme/no-image.svg') }}"
                                                                alt="{{ $category->name }}" loading="lazy"
                                                                style="height: 322px; width: 508px; object-fit: cover;">
                                                        </a>
                                                        <div class="menu-banner-content">
                                                            <h4>{{ config('shop.name') }}</h4>
                                                            <h3>Découvrez {{ $category->name }}</h3>
                                                            <div class="menu-banner-btn">
                                                                <a
                                                                    href="{{ route('shop.index', ['categorie' => $category->sousCategories->first()->id ?? '']) }}">Acheter
                                                                    maintenant</a>
                                                            </div>
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
                <a href="{{ url('/') }}"><img src="{{ asset('front-end/imgs/theme/dar_el_3oula.svg') }}" alt="{{ config('shop.name') }}" /></a>
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
                <form action="{{ route('frontend.search') }}" method="GET">
                    <input type="text" name="q" placeholder="Rechercher des articles…" value="{{ request('q') }}" />
                    <button type="submit" aria-label="Rechercher"><i class="fi-rs-search"></i></button>
                </form>
            </div>
            <div class="mobile-menu-wrap mobile-header-border">
                <nav>
                    <ul class="mobile-menu font-heading">
                        <!-- Catégories dynamiques pour le menu mobile -->
                        @foreach ($categoriesMenu as $category)
                            <li class="menu-item-has-children">
                                <a
                                    href="{{ route('shop.index', ['categorie' => $category->sousCategories->first()->id ?? '']) }}">
                                    {{ $category->name }}
                                </a>
                                @if($category->sousCategories->count() > 0)
                                    <ul class="dropdown">
                                        @foreach ($category->sousCategories as $sousCategorie)
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
                    <a href="{{ route('pages.show', 'contact') }}"><i class="fi-rs-marker"></i> Nous contacter</a>
                </div>
                <div class="single-mobile-header-info">
                    @auth
                        <a href="{{ route('account.profile') }}"><i class="fi-rs-user"></i>Mon compte</a>
                    @else
                        <a href="{{ route('frontend.login') }}"><i class="fi-rs-user"></i>Connexion / Inscription</a>
                    @endauth
                </div>
                @if (config('shop.phone'))
                    <div class="single-mobile-header-info">
                        <a href="tel:{{ preg_replace('/[^\d+]/', '', config('shop.phone')) }}"><i class="fi-rs-headphones"></i>{{ config('shop.phone') }}</a>
                    </div>
                @endif
            </div>
            @include('front-end.partials._social', ['class' => 'mobile-social-icon mb-50', 'titleClass' => 'mb-15'])
            <div class="site-copyright">&copy; {{ date('Y') }} {{ config('shop.name') }}. Tous droits réservés.</div>
        </div>
    </div>
</div>