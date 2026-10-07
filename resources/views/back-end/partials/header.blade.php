<header class="main-header navbar">
    {{-- Recherche rapide de commande (n°, nom ou téléphone) --}}
    <div class="col-search">
        <form class="searchform" method="GET" action="{{ route('admin.orders.index') }}">
            <div class="input-group">
                <input type="search" name="q" class="form-control" value="{{ request()->routeIs('admin.orders.*') ? request('q') : '' }}"
                       placeholder="N° de commande, nom ou téléphone" aria-label="Rechercher une commande" />
                <button class="btn btn-light bg" type="submit" aria-label="Rechercher"><i class="material-icons md-search"></i></button>
            </div>
        </form>
    </div>
    <div class="col-nav">
        <button class="btn btn-icon btn-mobile me-auto" data-trigger="#offcanvas_aside" aria-label="Menu"><i
                class="material-icons md-apps"></i></button>
        <ul class="nav">
            {{-- Commandes en attente --}}
            @php($pendingCount = \App\Models\Order::where('status', 'pending')->count())
            <li class="nav-item">
                <a class="nav-link btn-icon" href="{{ route('admin.orders.index', ['status' => 'pending']) }}"
                   title="{{ $pendingCount }} commande(s) en attente">
                    <i class="material-icons md-notifications {{ $pendingCount ? 'animation-shake' : '' }}"></i>
                    @if ($pendingCount)
                        <span class="badge rounded-pill">{{ $pendingCount }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn-icon darkmode" href="#" title="Mode sombre"> <i class="material-icons md-nights_stay"></i> </a>
            </li>
            <li class="nav-item">
                <a href="#" class="requestfullscreen nav-link btn-icon" title="Plein écran"><i class="material-icons md-cast"></i></a>
            </li>
            <li class="dropdown nav-item">
                <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" id="dropdownAccount"
                    aria-expanded="false" title="Mon compte">
                    <img class="img-xs rounded-circle" src="{{ asset('back-end/imgs/people/avatar-2.png') }}" alt="Mon compte" />
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownAccount">
                    @auth
                        <span class="dropdown-item-text small text-muted">
                            {{ trim(auth()->user()->firstname . ' ' . auth()->user()->lastname) ?: auth()->user()->email }}
                        </span>
                        <div class="dropdown-divider"></div>
                    @endauth
                    <a class="dropdown-item" href="{{ url('/') }}" target="_blank" rel="noopener">
                        <i class="material-icons md-storefront"></i>Voir la boutique
                    </a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="material-icons md-exit_to_app"></i>Déconnexion
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</header>
