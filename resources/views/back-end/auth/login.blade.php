<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <title>Connexion - Tableau de bord</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="robots" content="noindex, nofollow" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('back-end/imgs/theme/favicon.svg') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,500&family=Lora:wght@400;500;600&family=Caveat:wght@500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --kraft: #c8a97e;
            --kraft-dark: #8b6b43;
            --cream: #fbf6ec;
            --paper: #f5ecdc;
            --ink: #3e2c1c;
            --ink-soft: #6f5a45;
            --terracotta: #148b41;
            --terracotta-dark: #4A5A41;
        }

        *, *::before, *::after {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            min-height: 100%;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 16px;
            font-family: 'Lora', Georgia, serif;
            color: var(--ink);
            background-color: var(--paper);
            background-image:
                radial-gradient(rgba(139, 107, 67, .08) 1px, transparent 1px),
                radial-gradient(rgba(139, 107, 67, .05) 1px, transparent 1px);
            background-size: 22px 22px, 13px 13px;
            background-position: 0 0, 7px 11px;
        }

        a {
            text-decoration: none;
        }

        .admin-login {
            width: 100%;
            max-width: 440px;
        }

        /* Carte */
        .admin-card {
            position: relative;
            background: var(--cream);
            border-radius: 18px;
            padding: 48px 40px 40px;
            box-shadow:
                0 1px 0 rgba(255, 255, 255, .6) inset,
                0 18px 40px -18px rgba(62, 44, 28, .35);
        }

        /* Couture pointillée */
        .admin-card::after {
            content: "";
            position: absolute;
            inset: 10px;
            border: 2px dashed rgba(139, 107, 67, .35);
            border-radius: 12px;
            pointer-events: none;
        }

        /* Tampon */
        .admin-stamp {
            position: absolute;
            top: -34px;
            left: 50%;
            width: 76px;
            height: 76px;
            margin-left: -38px;
            border-radius: 50%;
            background: var(--kraft-dark);
            border: 3px solid var(--cream);
            outline: 1.5px dashed rgba(243, 217, 177, .7);
            outline-offset: -9px;
            box-shadow: 0 8px 18px -8px rgba(62, 44, 28, .6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f3d9b1;
            transform: rotate(-8deg);
        }

        .admin-stamp svg {
            width: 30px;
            height: 30px;
        }

        .admin-head {
            text-align: center;
            margin: 10px 0 30px;
        }

        .admin-head .script {
            font-family: 'Caveat', cursive;
            font-size: 22px;
            color: var(--terracotta);
        }

        .admin-head h1 {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 34px;
            margin: 2px 0 0;
            display: inline-block;
            position: relative;
            color: var(--ink);
        }

        /* Trait de pinceau */
        .admin-head h1::after {
            content: "";
            position: absolute;
            left: 8%;
            right: 8%;
            bottom: -6px;
            height: 8px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 10' preserveAspectRatio='none'%3E%3Cpath d='M2 7 C 40 2, 90 9, 130 4 S 185 6, 198 3' stroke='%23148b41' stroke-width='3' fill='none' stroke-linecap='round'/%3E%3C/svg%3E") no-repeat center / 100% 100%;
        }

        .admin-head p {
            margin: 18px 0 0;
            font-size: 14px;
            color: var(--ink-soft);
        }

        /* Champs */
        .field {
            margin-bottom: 20px;
        }

        .field label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .6px;
            text-transform: uppercase;
            color: var(--kraft-dark);
            margin-bottom: 8px;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap > svg {
            position: absolute;
            left: 15px;
            top: 50%;
            width: 18px;
            height: 18px;
            transform: translateY(-50%);
            color: var(--kraft);
            pointer-events: none;
        }

        .input-wrap input {
            width: 100%;
            height: 52px;
            padding: 0 48px 0 44px;
            font-family: 'Lora', Georgia, serif;
            font-size: 15px;
            color: var(--ink);
            background: #fffdf8;
            border: 1.5px solid #e5d6bd;
            border-radius: 10px;
            box-shadow: inset 0 2px 4px rgba(139, 107, 67, .06);
            transition: border-color .2s ease, box-shadow .2s ease, background-color .2s ease;
        }

        .input-wrap input::placeholder {
            color: #b9a68b;
        }

        .input-wrap input:focus {
            outline: none;
            background: #fff;
            border-color: var(--terracotta);
            box-shadow: 0 0 0 4px rgba(93, 112, 82, .12);
        }

        .input-wrap input.is-invalid {
            border-color: rgba(93, 112, 82, .7);
        }

        .toggle-pass {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            width: 36px;
            height: 36px;
            padding: 0;
            border: 0;
            border-radius: 8px;
            background: transparent;
            color: var(--kraft-dark);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .toggle-pass svg {
            width: 18px;
            height: 18px;
        }

        .toggle-pass svg[hidden] {
            display: none;
        }

        .toggle-pass:hover,
        .toggle-pass:focus-visible {
            background: rgba(200, 169, 126, .18);
            outline: none;
        }

        /* Bouton */
        .btn-artisan {
            position: relative;
            display: block;
            width: 100%;
            height: 54px;
            margin-top: 28px;
            padding: 0 20px;
            border: 0;
            border-radius: 10px;
            background-color: var(--terracotta);
            color: var(--cream);
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 18px;
            font-weight: 600;
            letter-spacing: .5px;
            cursor: pointer;
            box-shadow: 0 4px 0 var(--terracotta-dark), 0 10px 20px -8px rgba(74, 90, 65, .6);
            transition: transform .15s ease, box-shadow .15s ease, background-color .2s ease;
        }

        .btn-artisan::before {
            content: "";
            position: absolute;
            inset: 5px;
            border: 1.5px dashed rgba(251, 246, 236, .45);
            border-radius: 7px;
            pointer-events: none;
        }

        .btn-artisan:hover {
            background-color: #6B8060;
            transform: translateY(-2px);
            box-shadow: 0 6px 0 var(--terracotta-dark), 0 14px 24px -8px rgba(74, 90, 65, .6);
        }

        .btn-artisan:active {
            background-color: var(--terracotta-dark);
            transform: translateY(3px);
            box-shadow: 0 1px 0 var(--terracotta-dark), 0 4px 10px -6px rgba(74, 90, 65, .6);
        }

        .btn-artisan:focus-visible {
            outline: 3px solid rgba(93, 112, 82, .35);
            outline-offset: 3px;
        }

        .btn-artisan[disabled] {
            opacity: .75;
            cursor: wait;
        }

        /* Alertes */
        .alert {
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 22px;
            font-size: 14px;
            border: 1.5px dashed;
        }

        .alert ul {
            margin: 0;
            padding-left: 18px;
        }

        .alert-error {
            background: #fbeae4;
            border-color: rgba(166, 58, 43, .5);
            color: #9B3A2B;
        }

        .alert-success {
            background: #eef0e2;
            border-color: rgba(107, 116, 69, .55);
            color: #4e5530;
        }

        /* Pied */
        .admin-foot {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-top: 28px;
            color: var(--kraft);
            font-family: 'Caveat', cursive;
            font-size: 19px;
            white-space: nowrap;
        }

        .admin-foot::before,
        .admin-foot::after {
            content: "";
            flex: 1;
            border-top: 1.5px dashed rgba(139, 107, 67, .35);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 22px;
            font-size: 14px;
            color: var(--kraft-dark);
        }

        .back-link:hover {
            color: var(--terracotta);
        }

        @media (max-width: 480px) {
            .admin-card {
                padding: 46px 22px 30px;
            }

            .admin-head h1 {
                font-size: 30px;
            }
        }
    </style>
</head>

<body>
    <main class="admin-login">
        <div class="admin-card">

            <div class="admin-stamp" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 21h18" />
                    <path d="M5 21V10l7-5 7 5v11" />
                    <path d="M9 21v-6h6v6" />
                </svg>
            </div>

            <div class="admin-head">
                <div class="script">Espace administrateur</div>
                <h1>Connexion</h1>
                <p>Accédez au tableau de bord de l'atelier.</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-error" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success" role="status">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" id="admin-login-form">
                @csrf

                <div class="field">
                    <label for="email">Adresse email</label>
                    <div class="input-wrap">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="3" y="5" width="18" height="14" rx="2" />
                            <path d="m3 7 9 6 9-6" />
                        </svg>
                        <input type="email" id="email" name="email" required autofocus
                               autocomplete="username" placeholder="admin@exemple.com"
                               value="{{ old('email') }}"
                               class="{{ $errors->has('email') ? 'is-invalid' : '' }}" />
                    </div>
                </div>

                <div class="field">
                    <label for="password">Mot de passe</label>
                    <div class="input-wrap">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="4" y="11" width="16" height="10" rx="2" />
                            <path d="M8 11V7a4 4 0 0 1 8 0v4" />
                        </svg>
                        <input type="password" id="password" name="password" required
                               autocomplete="current-password" placeholder="Votre mot de passe" />
                        <button type="button" class="toggle-pass" id="toggle-password"
                                aria-label="Afficher le mot de passe" aria-pressed="false">
                            <svg class="icon-show" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            <svg class="icon-hide" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" hidden>
                                <path d="M3 3l18 18" />
                                <path d="M10.6 5.1A10.6 10.6 0 0 1 12 5c6.5 0 10 7 10 7a17 17 0 0 1-3.2 4.1M6.6 6.6C3.8 8.4 2 12 2 12s3.5 7 10 7a9.7 9.7 0 0 0 5.4-1.6" />
                                <path d="M9.9 9.9a3 3 0 0 0 4.2 4.2" />
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-artisan" id="admin-login-btn">Se connecter</button>
            </form>

            <div class="admin-foot">accès réservé</div>
        </div>

        <a href="{{ url('/') }}" class="back-link">&larr; Retour à la boutique</a>
    </main>

    <script>
        (function () {
            const btn = document.getElementById('toggle-password');
            const input = document.getElementById('password');
            if (btn && input) {
                btn.addEventListener('click', function () {
                    const show = input.type === 'password';
                    input.type = show ? 'text' : 'password';
                    btn.setAttribute('aria-pressed', show ? 'true' : 'false');
                    btn.setAttribute('aria-label', show ? 'Masquer le mot de passe' : 'Afficher le mot de passe');
                    btn.querySelector('.icon-show').hidden = show;
                    btn.querySelector('.icon-hide').hidden = !show;
                });
            }

            // Éviter les doubles soumissions
            const form = document.getElementById('admin-login-form');
            const submit = document.getElementById('admin-login-btn');
            if (form && submit) {
                form.addEventListener('submit', function () {
                    submit.disabled = true;
                    submit.textContent = 'Connexion…';
                });
            }
        })();
    </script>
</body>

</html>
