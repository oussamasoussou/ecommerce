@extends('front-end.layouts.app')

@section('title', 'Connexion - Nest')

@section('content')
    <main class="main pages">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ url('/') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Accueil</a>
                    <span></span> Pages <span></span> Mon Compte
                </div>
            </div>
        </div>
        <div class="page-content pt-150 pb-150">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-10 col-md-12 m-auto">
                        <div class="row">
                            <div class="col-lg-6 pr-30 d-none d-lg-block">
                                <img class="border-radius-15" src="{{ asset('front-end/imgs/page/login-1.png') }}"
                                    alt="Connexion" />
                            </div>
                            <div class="col-lg-6 col-md-8">
                                <div class="login_wrap widget-taber-content background-white">
                                    <div class="padding_eight_all bg-white">
                                        <div class="heading_s1">
                                            <h1 class="mb-5">Connexion</h1>
                                            <p class="mb-30">Vous n'avez pas de compte ? <a
                                                    href="{{ route('frontend.register') }}">Créez-en un ici</a></p>
                                        </div>

                                        @if($errors->any())
                                            <div class="alert alert-danger mb-4">
                                                <ul class="mb-0">
                                                    @foreach($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        @if(session('success'))
                                            <div class="alert alert-success mb-4">
                                                {{ session('success') }}
                                            </div>
                                        @endif

                                        <form method="POST" action="{{ route('frontend.login.post') }}">
                                            @csrf
                                            <div class="form-group">
                                                <input type="email" required name="email" placeholder="Email *"
                                                    value="{{ old('email') }}" />
                                            </div>
                                            <div class="form-group">
                                                <input required type="password" name="password"
                                                    placeholder="Votre mot de passe *" />
                                            </div>
                                            <div class="login_footer form-group mb-50">
                                                <div class="chek-form">
                                                    <div class="custome-checkbox">
                                                        <input class="form-check-input" type="checkbox" name="remember"
                                                            id="exampleCheckbox1" value="1" />
                                                        <label class="form-check-label" for="exampleCheckbox1"><span>Se
                                                                souvenir de moi</span></label>
                                                    </div>
                                                </div>
                                                <a class="text-muted" href="#">Mot de passe oublié ?</a>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-heading btn-block hover-up"
                                                    name="login">Se connecter</button>
                                            </div>
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