@extends('front-end.layouts.app')

@section('title', 'Inscription - Nest')
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
                                    <div class="script">Rejoignez l'atelier</div>
                                    <h2>Un compte, et tout le savoir-faire à portée de main.</h2>
                                    <p>
                                        Créez votre compte pour commander plus vite, suivre vos livraisons
                                        et garder vos produits préférés en favoris.
                                    </p>
                                </div>

                                <ul class="artisan-values">
                                    <li><span class="dot"><i class="fi-rs-box"></i></span> Suivi de vos commandes</li>
                                    <li><span class="dot"><i class="fi-rs-heart"></i></span> Liste de favoris</li>
                                    <li><span class="dot"><i class="fi-rs-marker"></i></span> Adresse enregistrée</li>
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
                                <div class="script">Bienvenue parmi nous</div>
                                <h1>Créer un compte</h1>
                                <p class="lead-text">
                                    Vous avez déjà un compte ?
                                    <a href="{{ route('frontend.login') }}">Connectez-vous</a>
                                </p>

                                @if(session('success'))
                                    <div class="artisan-alert success" role="status">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if($errors->any())
                                    <div class="artisan-alert error" role="alert">
                                        Merci de corriger les champs indiqués ci-dessous.
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('frontend.register.post') }}" id="register-form">
                                    @csrf

                                    {{-- Identité --}}
                                    <div class="artisan-fieldset-title">Vos informations</div>

                                    <div class="artisan-grid-2">
                                        <div class="artisan-field">
                                            <label for="firstname">Prénom</label>
                                            <div class="input-wrap">
                                                <i class="fi-rs-user"></i>
                                                <input type="text" id="firstname" name="firstname" required
                                                       autocomplete="given-name" placeholder="Votre prénom"
                                                       value="{{ old('firstname') }}"
                                                       class="@error('firstname') is-invalid @enderror" />
                                            </div>
                                            @error('firstname')
                                                <div class="artisan-field-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="artisan-field">
                                            <label for="lastname">Nom</label>
                                            <div class="input-wrap">
                                                <i class="fi-rs-user"></i>
                                                <input type="text" id="lastname" name="lastname" required
                                                       autocomplete="family-name" placeholder="Votre nom"
                                                       value="{{ old('lastname') }}"
                                                       class="@error('lastname') is-invalid @enderror" />
                                            </div>
                                            @error('lastname')
                                                <div class="artisan-field-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="artisan-grid-2">
                                        <div class="artisan-field">
                                            <label for="email">Adresse email</label>
                                            <div class="input-wrap">
                                                <i class="fi-rs-envelope"></i>
                                                <input type="email" id="email" name="email" required
                                                       autocomplete="email" placeholder="vous@exemple.com"
                                                       value="{{ old('email') }}"
                                                       class="@error('email') is-invalid @enderror" />
                                            </div>
                                            @error('email')
                                                <div class="artisan-field-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="artisan-field">
                                            <label for="phone">Téléphone</label>
                                            <div class="input-wrap">
                                                <i class="fi-rs-smartphone"></i>
                                                <input type="tel" id="phone" name="phone" required
                                                       autocomplete="tel" placeholder="+216 XX XXX XXX"
                                                       value="{{ old('phone') }}"
                                                       class="@error('phone') is-invalid @enderror" />
                                            </div>
                                            @error('phone')
                                                <div class="artisan-field-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Coordonnées --}}
                                    <div class="artisan-fieldset-title">Coordonnées de livraison</div>

                                    <div class="artisan-grid-2">
                                        <div class="artisan-field">
                                            <label for="address">Adresse</label>
                                            <div class="input-wrap">
                                                <i class="fi-rs-marker"></i>
                                                <input type="text" id="address" name="address" required
                                                       autocomplete="street-address" placeholder="Rue, numéro…"
                                                       value="{{ old('address') }}"
                                                       class="@error('address') is-invalid @enderror" />
                                            </div>
                                            @error('address')
                                                <div class="artisan-field-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="artisan-field">
                                            <label for="city">Ville</label>
                                            <div class="input-wrap">
                                                <i class="fi-rs-building"></i>
                                                <input type="text" id="city" name="city" required
                                                       autocomplete="address-level2" placeholder="ex. Tunis"
                                                       value="{{ old('city') }}"
                                                       class="@error('city') is-invalid @enderror" />
                                            </div>
                                            @error('city')
                                                <div class="artisan-field-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Sécurité --}}
                                    <div class="artisan-fieldset-title">Sécurité</div>

                                    <div class="artisan-field">
                                        <label for="password">Mot de passe</label>
                                        <div class="input-wrap">
                                            <i class="fi-rs-lock"></i>
                                            <input type="password" id="password" name="password" required minlength="6"
                                                   autocomplete="new-password" placeholder="6 caractères minimum"
                                                   class="@error('password') is-invalid @enderror" />
                                            <button type="button" class="artisan-toggle-pass" data-toggle-password="password"
                                                    aria-label="Afficher le mot de passe" aria-pressed="false">
                                                <i class="fi-rs-eye" style="position:static;transform:none;color:inherit;"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <div class="artisan-field-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="artisan-field">
                                        <label for="password_confirmation">Confirmer le mot de passe</label>
                                        <div class="input-wrap">
                                            <i class="fi-rs-lock"></i>
                                            <input type="password" id="password_confirmation" name="password_confirmation"
                                                   required minlength="6" autocomplete="new-password"
                                                   placeholder="Retapez le mot de passe" />
                                            <button type="button" class="artisan-toggle-pass" data-toggle-password="password_confirmation"
                                                    aria-label="Afficher le mot de passe" aria-pressed="false">
                                                <i class="fi-rs-eye" style="position:static;transform:none;color:inherit;"></i>
                                            </button>
                                        </div>
                                        <div class="artisan-field-error" id="password-match-error" hidden>
                                            Les mots de passe ne correspondent pas.
                                        </div>
                                    </div>

                                    <div class="artisan-row">
                                        <label class="artisan-check" for="terms">
                                            <input type="checkbox" name="terms" id="terms" value="1" required
                                                   {{ old('terms') ? 'checked' : '' }} />
                                            <span>J'accepte les <a href="#">conditions générales</a></span>
                                        </label>
                                    </div>
                                    @error('terms')
                                        <div class="artisan-field-error" style="margin-top:-18px;margin-bottom:18px;">{{ $message }}</div>
                                    @enderror

                                    <button type="submit" class="artisan-btn" name="register">
                                        Créer mon compte
                                    </button>

                                    <p class="artisan-note">
                                        Vos données personnelles sont utilisées conformément à notre politique de confidentialité.
                                    </p>
                                </form>
                              </div>
                            </div>

                        </div>
    </main>

    <script>
        (function () {
            // Afficher / masquer les mots de passe
            document.querySelectorAll('[data-toggle-password]').forEach(function (btn) {
                const input = document.getElementById(btn.dataset.togglePassword);
                if (!input) return;

                btn.addEventListener('click', function () {
                    const show = input.type === 'password';
                    input.type = show ? 'text' : 'password';
                    btn.setAttribute('aria-pressed', show ? 'true' : 'false');
                    btn.setAttribute('aria-label', show ? 'Masquer le mot de passe' : 'Afficher le mot de passe');
                    const icon = btn.querySelector('i');
                    if (icon) icon.className = show ? 'fi-rs-eye-crossed' : 'fi-rs-eye';
                });
            });

            // Vérifier que les deux mots de passe correspondent
            const form = document.getElementById('register-form');
            const pass = document.getElementById('password');
            const confirm = document.getElementById('password_confirmation');
            const error = document.getElementById('password-match-error');
            if (!form || !pass || !confirm || !error) return;

            function checkMatch() {
                const mismatch = confirm.value !== '' && pass.value !== confirm.value;
                error.hidden = !mismatch;
                confirm.classList.toggle('is-invalid', mismatch);
                return !mismatch;
            }

            confirm.addEventListener('input', checkMatch);
            pass.addEventListener('input', function () {
                if (confirm.value !== '') checkMatch();
            });

            form.addEventListener('submit', function (e) {
                if (!checkMatch()) {
                    e.preventDefault();
                    confirm.focus();
                }
            });
        })();
    </script>
@endsection
