@extends('front-end.layouts.app')

@section('title', 'Inscription - Nest')

@section('content')
<main class="main pages">
    {{-- Fil d'Ariane (inchangé) --}}
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ url('/') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Accueil</a>
                <span></span> Pages <span></span> Mon Compte
            </div>
        </div>
    </div>
    
    <div class="page-content pt-40 pb-150">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-10 col-md-12 m-auto">
                    <div class="row">
                        {{-- Colonne du formulaire (plus large pour les champs) --}}
                        <div class="col-lg-7 col-md-12">
                            <div class="login_wrap widget-taber-content background-white">
                                <div class="padding_eight_all bg-white">
                                    <div class="heading_s1">
                                        <h1 class="mb-5">Créer un compte ✨</h1>
                                        <p class="mb-30">Vous avez déjà un compte ? <a href="{{ route('frontend.login') }}" class="text-brand">Connectez-vous</a></p>
                                    </div>
                                    
                                    {{-- Affichage des messages flash (laissé en haut pour une meilleure visibilité) --}}
                                    @if(session('success'))
                                        <div class="alert alert-success mb-4">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    {{-- Le bloc principal d'erreurs a été supprimé pour afficher les erreurs champ par champ --}}
                                    
                                    <form method="POST" action="{{ route('frontend.register.post') }}">
                                        @csrf
                                        
                                        {{-- Groupe 1 : Prénom et Nom (alignés) --}}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" required name="firstname" placeholder="Prénom *" value="{{ old('firstname') }}" class="@error('firstname') is-invalid @enderror" />
                                                    @error('firstname')
                                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" required name="lastname" placeholder="Nom *" value="{{ old('lastname') }}" class="@error('lastname') is-invalid @enderror" />
                                                    @error('lastname')
                                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Groupe 2 : Nom d'utilisateur et Email --}}
                                        <div class="form-group">
                                            <input type="text" required name="username" placeholder="Nom d'utilisateur *" value="{{ old('username') }}" class="@error('username') is-invalid @enderror" />
                                            @error('username')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="email" required name="email" placeholder="Email *" value="{{ old('email') }}" class="@error('email') is-invalid @enderror" />
                                            @error('email')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Groupe 3 : Téléphone et Adresse (Optionnel, alignés) --}}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="tel" name="phone" placeholder="Téléphone (Optionnel)" value="{{ old('phone') }}" class="@error('phone') is-invalid @enderror" />
                                                    @error('phone')
                                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" name="address" placeholder="Adresse (Optionnel)" value="{{ old('address') }}" class="@error('address') is-invalid @enderror" />
                                                    @error('address')
                                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        
                                        {{-- Groupe 4 : Ville et Pays (Optionnel, alignés) --}}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" name="city" placeholder="Ville (Optionnel)" value="{{ old('city') }}" class="@error('city') is-invalid @enderror" />
                                                    @error('city')
                                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" name="country" placeholder="Pays (Optionnel)" value="{{ old('country') }}" class="@error('country') is-invalid @enderror" />
                                                    @error('country')
                                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Groupe 5 : Mot de passe (avec bouton Afficher/Masquer) --}}
                                        <div class="form-group position-relative">
                                            <input id="password" required type="password" name="password" placeholder="Mot de passe *" class="@error('password') is-invalid @enderror" />
                                            <span class="password-toggle" onclick="togglePasswordVisibility('password')" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                                                <i class="fi-rs-eye" id="togglePasswordIcon"></i>
                                            </span>
                                            @error('password')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group position-relative">
                                            <input id="password_confirmation" required type="password" name="password_confirmation" placeholder="Confirmer le mot de passe *" />
                                            <span class="password-toggle" onclick="togglePasswordVisibility('password_confirmation')" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                                                <i class="fi-rs-eye" id="togglePasswordConfirmIcon"></i>
                                            </span>
                                        </div>
                                        
                                        <div class="login_footer form-group mb-30">
                                            <div class="chek-form">
                                                <div class="custome-checkbox">
                                                    <input class="form-check-input" type="checkbox" name="terms" id="terms" value="1" required />
                                                    <label class="form-check-label" for="terms"><span>J'accepte les **termes & conditions** <a href="#">En savoir plus</a></span></label>
                                                </div>
                                            </div>
                                            @error('terms')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group mb-30">
                                            <button type="submit" class="btn btn-fill-out btn-block hover-up font-weight-bold" name="register">
                                                <i class="fi-rs-user-add mr-5"></i> S'inscrire maintenant
                                            </button>
                                        </div>
                                        <p class="font-xs text-muted">**Note:** Vos données personnelles sont utilisées conformément à notre politique de confidentialité.</p>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                     
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


@endsection