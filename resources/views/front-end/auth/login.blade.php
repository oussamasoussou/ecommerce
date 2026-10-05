@extends('front-end.layouts.app')

@section('title', 'Connexion - Nest')
@section('hide_header', true)
@section('hide_footer', true)

@section('content')
    @include('front-end.auth._artisan-styles')

    <main class="main pages artisan-login artisan-compact">
                        <div class="artisan-card">

                            {{-- Panneau gauche --}}
                            <aside class="artisan-aside">
                                <div>
                                    <a href="{{ url('/') }}" class="artisan-back">
                                        <i class="fi-rs-arrow-left"></i> Retour à la boutique
                                    </a>
                                    <div class="script">Bienvenue à l'atelier</div>
                                    <h2>Des créations faites main, avec passion.</h2>
                                    <p>
                                        Connectez-vous pour retrouver votre panier, suivre vos commandes
                                        et découvrir nos nouvelles pièces artisanales.
                                    </p>
                                </div>

                                <ul class="artisan-values">
                                    <li><span class="dot"><i class="fi-rs-heart"></i></span> Fabriqué à la main</li>
                                        <li><span class="dot"><i class="fi-rs-diamond"></i></span> Matières naturelles</li>
                                    <li><span class="dot"><i class="fi-rs-box"></i></span> Livraison soignée</li>
                            </ul>

                                <div class="artisan-stamp" aria-hidden="true">
                                    <small>Fait</small>
                                    <strong>main</strong>
                                    <small>avec soin</small>
                                </div>
                            </aside>

                            {{-- Formulaire --}}
                            <div class="artisan-form-wrap">
                              <div class="artisan-form-inner">
                                <div class="script">Ravi de vous revoir</div>
                                <h1>Connexion</h1>
                                <p class="lead-text">
                                    Vous n'avez pas de compte ?
                                    <a href="{{ route('frontend.register') }}">Créez-en un ici</a>
                                </p>

                                @if($errors->any())
                                    <div class="artisan-alert error" role="alert">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if(session('success'))
                                    <div class="artisan-alert success" role="status">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                    <form method="POST" action="{{ route('frontend.login.post') }}">
                                @csrf

                                    <div class="artisan-field">
                                        <label for="login-identifier">Email ou téléphone</label>
                                        <div class="input-wrap">
                                            <i class="fi-rs-user"></i>
                                            <input type="text" id="login-identifier" name="login" required
                                                   autocomplete="username" inputmode="email"
                                                   placeholder="vous@exemple.com ou 20 123 456"
                                                   value="{{ old('login') }}" />
                                        </div>
                                    </div>

                                    <div class="artisan-field">
                                        <label for="login-password">Mot de passe</label>
                                        <div class="input-wrap">
                                            <i class="fi-rs-lock"></i>
                                            <input type="password" id="login-password" name="password" required
                                                   autocomplete="current-password" placeholder="Votre mot de passe" />
                                            <button type="button" class="artisan-toggle-pass" id="toggle-password"
                                                    aria-label="Afficher le mot de passe" aria-pressed="false">
                                                <i class="fi-rs-eye" style="position:static;transform:none;color:inherit;"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="artisan-row">
                                        <label class="artisan-check" for="remember">
                                            <input type="checkbox" name="remember" id="remember" value="1"
                                                   {{ old('remember') ? 'checked' : '' }} />
                                            Se souvenir de moi
                                        </label>
                                        <a class="artisan-forgot" href="#">Mot de passe oublié ?</a>
                                    </div>

                                    <button type="submit" class="artisan-btn" name="login">
                                        Se connecter
                                    </button>

                                    <div class="artisan-divider">merci de votre confiance</div>
                                </form>
                              </div>
                            </div>

                        </div>
    </main>

    <script>
        (function () {
            const btn = document.getElementById('toggle-password');
            const input = document.getElementById('login-password');
            if (!btn || !input) return;

            btn.addEventListener('click', function () {
                const show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                btn.setAttribute('aria-pressed', show ? 'true' : 'false');
                btn.setAttribute('aria-label', show ? 'Masquer le mot de passe' : 'Afficher le mot de passe');
                const icon = btn.querySelector('i');
                if (icon) icon.className = show ? 'fi-rs-eye-crossed' : 'fi-rs-eye';
            });
        })();
    </script>
@endsection