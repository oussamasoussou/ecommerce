@extends('front-end.layouts.app')

@section('title', 'Connexion - Nest')

@section('content')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,500&family=Lora:wght@400;500;600&family=Caveat:wght@500;700&display=swap" rel="stylesheet">

    <style>
        .artisan-login {
            --kraft: #c8a97e;
            --kraft-dark: #8b6b43;
            --cream: #fbf6ec;
            --paper: #f5ecdc;
            --ink: #3e2c1c;
            --ink-soft: #6f5a45;
            --terracotta: #b5563a;
            --terracotta-dark: #96432b;
            --olive: #6b7445;

            font-family: 'Lora', Georgia, serif;
            color: var(--ink);
            background-color: var(--paper);
            background-image:
                radial-gradient(rgba(139, 107, 67, .08) 1px, transparent 1px),
                radial-gradient(rgba(139, 107, 67, .05) 1px, transparent 1px);
            background-size: 22px 22px, 13px 13px;
            background-position: 0 0, 7px 11px;
        }

        /* Fil d'Ariane */
        .artisan-login .artisan-breadcrumb {
            padding: 18px 0;
            border-bottom: 1px dashed rgba(139, 107, 67, .35);
            font-size: 14px;
            color: var(--ink-soft);
        }

        .artisan-login .artisan-breadcrumb a {
            color: var(--kraft-dark);
        }

        .artisan-login .artisan-breadcrumb a:hover {
            color: var(--terracotta);
        }

        .artisan-login .artisan-breadcrumb .sep {
            margin: 0 8px;
            color: var(--kraft);
        }

        .artisan-login .artisan-section {
            padding: 80px 0 100px;
        }

        /* Carte principale */
        .artisan-card {
            position: relative;
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: var(--cream);
            border-radius: 18px;
            box-shadow:
                0 1px 0 rgba(255, 255, 255, .6) inset,
                0 18px 40px -18px rgba(62, 44, 28, .35);
            overflow: hidden;
        }

        /* Couture pointillée */
        .artisan-card::after {
            content: "";
            position: absolute;
            inset: 10px;
            border: 2px dashed rgba(139, 107, 67, .35);
            border-radius: 12px;
            pointer-events: none;
        }

        /* Panneau gauche */
        .artisan-aside {
            position: relative;
            padding: 56px 44px;
            color: var(--cream);
            background-color: var(--kraft-dark);
            background-image:
                linear-gradient(160deg, rgba(62, 44, 28, .15), rgba(62, 44, 28, .55)),
                repeating-linear-gradient(45deg, rgba(255, 255, 255, .03) 0 2px, transparent 2px 6px);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 32px;
        }

        .artisan-aside .script {
            font-family: 'Caveat', cursive;
            font-size: 26px;
            color: #f3d9b1;
            margin-bottom: 6px;
        }

        .artisan-aside h2 {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 34px;
            line-height: 1.2;
            color: var(--cream);
            margin-bottom: 16px;
        }

        .artisan-aside p {
            color: rgba(251, 246, 236, .85);
            font-size: 15px;
            line-height: 1.7;
            margin: 0;
        }

        .artisan-values {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            gap: 14px;
        }

        .artisan-values li {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 15px;
            color: var(--cream);
        }

        .artisan-values .dot {
            flex: 0 0 34px;
            height: 34px;
            border-radius: 50%;
            border: 1.5px dashed rgba(243, 217, 177, .7);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #f3d9b1;
            font-size: 15px;
        }

        /* Tampon */
        .artisan-stamp {
            position: absolute;
            right: 28px;
            bottom: 28px;
            width: 96px;
            height: 96px;
            border-radius: 50%;
            border: 2px solid rgba(243, 217, 177, .75);
            outline: 1.5px dashed rgba(243, 217, 177, .5);
            outline-offset: -9px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            transform: rotate(-12deg);
            color: #f3d9b1;
            font-family: 'Playfair Display', Georgia, serif;
            line-height: 1.1;
        }

        .artisan-stamp small {
            font-size: 9px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .artisan-stamp strong {
            font-size: 18px;
            font-style: italic;
            font-weight: 500;
        }

        /* Formulaire */
        .artisan-form-wrap {
            position: relative;
            padding: 56px 48px;
        }

        .artisan-form-wrap .script {
            font-family: 'Caveat', cursive;
            font-size: 24px;
            color: var(--terracotta);
        }

        .artisan-form-wrap h1 {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 38px;
            color: var(--ink);
            margin: 0 0 6px;
            display: inline-block;
            position: relative;
        }

        /* Soulignement façon trait de pinceau */
        .artisan-form-wrap h1::after {
            content: "";
            position: absolute;
            left: 0;
            right: 10%;
            bottom: -4px;
            height: 8px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 10' preserveAspectRatio='none'%3E%3Cpath d='M2 7 C 40 2, 90 9, 130 4 S 185 6, 198 3' stroke='%23b5563a' stroke-width='3' fill='none' stroke-linecap='round'/%3E%3C/svg%3E") no-repeat center / 100% 100%;
        }

        .artisan-form-wrap .lead-text {
            color: var(--ink-soft);
            font-size: 15px;
            margin: 18px 0 30px;
        }

        .artisan-form-wrap .lead-text a {
            color: var(--terracotta);
            font-weight: 600;
            border-bottom: 1px dashed currentColor;
        }

        .artisan-form-wrap .lead-text a:hover {
            color: var(--terracotta-dark);
        }

        .artisan-field {
            margin-bottom: 20px;
        }

        .artisan-field label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .5px;
            text-transform: uppercase;
            color: var(--kraft-dark);
            margin-bottom: 8px;
        }

        .artisan-field .input-wrap {
            position: relative;
        }

        .artisan-field .input-wrap i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--kraft);
            font-size: 16px;
            line-height: 1;
            pointer-events: none;
        }

        .artisan-login .artisan-field input[type="email"],
        .artisan-login .artisan-field input[type="password"],
        .artisan-login .artisan-field input[type="text"] {
            width: 100%;
            height: 52px;
            padding: 0 48px 0 46px;
            font-family: 'Lora', Georgia, serif;
            font-size: 15px;
            color: var(--ink);
            background: #fffdf8;
            border: 1.5px solid #e5d6bd;
            border-radius: 10px;
            box-shadow: inset 0 2px 4px rgba(139, 107, 67, .06);
            transition: border-color .2s ease, box-shadow .2s ease, background-color .2s ease;
        }

        .artisan-login .artisan-field input::placeholder {
            color: #b9a68b;
        }

        .artisan-login .artisan-field input:focus {
            outline: none;
            background: #fff;
            border-color: var(--terracotta);
            box-shadow: 0 0 0 4px rgba(181, 86, 58, .12);
        }

        .artisan-toggle-pass {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            width: 36px;
            height: 36px;
            border: 0;
            border-radius: 8px;
            background: transparent;
            color: var(--kraft-dark);
            font-family: 'Lora', Georgia, serif;
            font-size: 12px;
            cursor: pointer;
        }

        .artisan-toggle-pass:hover,
        .artisan-toggle-pass:focus-visible {
            background: rgba(200, 169, 126, .18);
            outline: none;
        }

        .artisan-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            margin: 6px 0 28px;
            font-size: 14px;
        }

        .artisan-check {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            color: var(--ink-soft);
            margin: 0;
        }

        .artisan-login .artisan-check input {
            appearance: none;
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            margin: 0;
            border: 1.5px solid var(--kraft);
            border-radius: 5px;
            background: #fffdf8;
            display: inline-grid;
            place-content: center;
            cursor: pointer;
            transition: background-color .15s ease, border-color .15s ease;
        }

        .artisan-login .artisan-check input::before {
            content: "";
            width: 10px;
            height: 10px;
            transform: scale(0);
            transition: transform .15s ease;
            background: var(--cream);
            clip-path: polygon(14% 44%, 0 65%, 50% 100%, 100% 16%, 80% 0%, 43% 62%);
        }

        .artisan-login .artisan-check input:checked {
            background: var(--terracotta);
            border-color: var(--terracotta);
        }

        .artisan-login .artisan-check input:checked::before {
            transform: scale(1);
        }

        .artisan-login .artisan-check input:focus-visible {
            outline: 3px solid rgba(181, 86, 58, .3);
            outline-offset: 2px;
        }

        .artisan-forgot {
            color: var(--kraft-dark);
            border-bottom: 1px dashed transparent;
        }

        .artisan-forgot:hover {
            color: var(--terracotta);
            border-bottom-color: currentColor;
        }

        /* Sélecteurs renforcés : main.css force button[type=submit] en vert (#3BB77E) */
        .artisan-login button.artisan-btn,
        .artisan-login button.artisan-btn[type=submit] {
            display: block;
            width: 100%;
            height: 54px;
            padding: 0 20px;
            border: 0;
            border-radius: 10px;
            background: var(--terracotta);
            background-color: var(--terracotta);
            color: var(--cream);
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 18px;
            font-weight: 600;
            letter-spacing: .5px;
            cursor: pointer;
            position: relative;
            box-shadow: 0 4px 0 var(--terracotta-dark), 0 10px 20px -8px rgba(150, 67, 43, .6);
            transition: transform .15s ease, box-shadow .15s ease, background-color .2s ease;
        }

        /* Couture intérieure du bouton */
        .artisan-btn::before {
            content: "";
            position: absolute;
            inset: 5px;
            border: 1.5px dashed rgba(251, 246, 236, .45);
            border-radius: 7px;
            pointer-events: none;
        }

        .artisan-login button.artisan-btn:hover,
        .artisan-login button.artisan-btn[type=submit]:hover {
            background-color: #c0613f !important;
            color: var(--cream);
            transform: translateY(-2px);
            box-shadow: 0 6px 0 var(--terracotta-dark), 0 14px 24px -8px rgba(150, 67, 43, .6);
        }

        .artisan-login button.artisan-btn:active {
            background-color: var(--terracotta-dark) !important;
            transform: translateY(3px);
            box-shadow: 0 1px 0 var(--terracotta-dark), 0 4px 10px -6px rgba(150, 67, 43, .6);
        }

        .artisan-btn:focus-visible {
            outline: 3px solid rgba(181, 86, 58, .35);
            outline-offset: 3px;
        }

        .artisan-divider {
            display: flex;
            align-items: center;
            gap: 14px;
            margin: 28px 0 0;
            color: var(--kraft);
            font-family: 'Caveat', cursive;
            font-size: 20px;
        }

        .artisan-divider::before,
        .artisan-divider::after {
            content: "";
            flex: 1;
            border-top: 1.5px dashed rgba(139, 107, 67, .35);
        }

        /* Alertes */
        .artisan-alert {
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 22px;
            font-size: 14px;
            border: 1.5px dashed;
        }

        .artisan-alert ul {
            margin: 0;
            padding-left: 18px;
        }

        .artisan-alert.error {
            background: #fbeae4;
            border-color: rgba(181, 86, 58, .55);
            color: var(--terracotta-dark);
        }

        .artisan-alert.success {
            background: #eef0e2;
            border-color: rgba(107, 116, 69, .55);
            color: #4e5530;
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .artisan-card {
                grid-template-columns: 1fr;
            }

            .artisan-aside {
                padding: 40px 32px 120px;
            }

            .artisan-aside h2 {
                font-size: 28px;
            }
        }

        @media (max-width: 575.98px) {
            .artisan-login .artisan-section {
                padding: 40px 0 60px;
            }

            .artisan-form-wrap {
                padding: 40px 24px;
            }

            .artisan-aside {
                padding: 36px 24px 116px;
            }

            .artisan-form-wrap h1 {
                font-size: 32px;
            }
        }
    </style>

    <main class="main pages artisan-login">
        <div class="artisan-breadcrumb">
            <div class="container">
                <a href="{{ url('/') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Accueil</a>
                <span class="sep">~</span> Mon Compte
            </div>
        </div>

        <div class="artisan-section">
            <div class="container">
                <div class="row">
                    <div class="col-xl-10 col-lg-11 m-auto">
                        <div class="artisan-card">

                            {{-- Panneau gauche --}}
                            <aside class="artisan-aside">
                                <div>
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
                                        <label for="login-email">Adresse email</label>
                                        <div class="input-wrap">
                                            <i class="fi-rs-envelope"></i>
                                            <input type="email" id="login-email" name="email" required
                                                   autocomplete="email" placeholder="vous@exemple.com"
                                                   value="{{ old('email') }}" />
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