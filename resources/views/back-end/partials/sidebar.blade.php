<aside class="navbar-aside" id="offcanvas_aside">
    <div class="aside-top"> 
        <a href="#" class="brand-wrap"> 
            <img src="{{ asset('assets/imgs/theme/logo.svg') }}" class="logo" alt="Dashboard" /> 
        </a>
        <div> 
            <button class="btn btn-icon btn-aside-minimize"> 
                <i class="text-muted material-icons md-menu_open"></i>
            </button> 
        </div>
    </div>
    <nav>
        <ul class="menu-aside"> 
            <!-- Bannières -->
            <li class="menu-item has-submenu {{ request()->routeIs('marques.*') ? 'active' : '' }}">
                <a class="menu-link" href="#">
                    <i class="icon material-icons md-home"></i>
                    <span class="text">Affichage Accueil Client</span>
                </a>
                <div class="submenu">
                    <a href="{{ route('bannieres.index') }}">Bannières</a> 
                     <a href="{{ route('sliders.index') }}">Sliders</a> 
                </div>
            </li>

            <!-- Marques -->
            <li class="menu-item has-submenu {{ request()->routeIs('marques.*') ? 'active' : '' }}">
                <a class="menu-link" href="#">
                    <i class="icon material-icons md-branding_watermark"></i>
                    <span class="text">Marques</span>
                </a>
                <div class="submenu">
                    <a href="{{ route('marques.index') }}">Liste des marques</a>
                    <a href="{{ route('marques.create') }}">Ajouter marque</a>
                </div>
            </li>

            <!-- Catégories -->
            <li class="menu-item has-submenu {{ request()->routeIs('categories.*') ? 'active' : '' }}"> 
                <a class="menu-link" href="#"> 
                    <i class="icon material-icons md-shopping_cart"></i> 
                    <span class="text">Catégories</span> 
                </a>
                <div class="submenu"> 
                    <a href="{{ route('categories.index') }}">Liste des catégories</a> 
                    <a href="{{ route('categories.create') }}">Ajouter catégorie</a> 
                </div>
            </li> 

            <!-- Sous-catégories -->
            <li class="menu-item has-submenu {{ request()->routeIs('souscategories.*') ? 'active' : '' }}"> 
                <a class="menu-link" href="#"> 
                    <i class="icon material-icons md-subdirectory_arrow_right"></i> 
                    <span class="text">Sous-catégories</span> 
                </a>
                <div class="submenu"> 
                    <a href="{{ route('souscategories.index') }}">Liste des sous-catégories</a> 
                    <a href="{{ route('souscategories.create') }}">Ajouter sous-catégorie</a> 
                </div>
            </li> 

            <!-- Couleurs -->
            <li class="menu-item has-submenu {{ request()->routeIs('couleurs.*') ? 'active' : '' }}"> 
                <a class="menu-link" href="#"> 
                    <i class="icon material-icons md-color_lens"></i> 
                    <span class="text">Couleurs</span> 
                </a>
                <div class="submenu"> 
                    <a href="{{ route('couleurs.index') }}">Liste des couleurs</a> 
                    <a href="{{ route('couleurs.create') }}">Ajouter couleur</a> 
                </div>
            </li> 

            <!-- Tailles -->
            <li class="menu-item has-submenu {{ request()->routeIs('tailles.*') ? 'active' : '' }}"> 
                <a class="menu-link" href="#"> 
                    <i class="icon material-icons md-line_weight"></i> 
                    <span class="text">Tailles</span> 
                </a>
                <div class="submenu"> 
                    <a href="{{ route('tailles.index') }}">Liste des tailles</a> 
                    <a href="{{ route('tailles.create') }}">Ajouter taille</a> 
                </div>
            </li>

            <!-- Produits -->
            <li class="menu-item has-submenu {{ request()->routeIs('produits.*') ? 'active' : '' }}"> 
                <a class="menu-link" href="#"> 
                    <i class="icon material-icons md-shopping_bag"></i> 
                    <span class="text">Produits</span> 
                </a>
                <div class="submenu">
                    <a href="{{ route('produits.index') }}">Liste des produits</a>
                    <a href="{{ route('produits.create') }}">Ajouter un produit</a>
                </div>
            </li>
            <!-- Livraisons -->
            <li class="menu-item has-submenu {{ request()->routeIs('produits.*') ? 'active' : '' }}"> 
                <a class="menu-link" href="#"> 
                    <i class="icon material-icons md-shopping_bag"></i> 
                    <span class="text">Livraison</span> 
                </a>
                <div class="submenu">
                    <a href="{{ route('deliveries.index') }}">prix des Livraison</a>
                </div>
            </li>
        </ul>
    </nav>
</aside>