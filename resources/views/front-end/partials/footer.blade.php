  <footer class="main">
       
        <section class="featured section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 mb-md-4 mb-xl-0">
                        <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                            <div class="banner-icon">
                                <img src="{{ asset('front-end/imgs/theme/icons/icon-1.svg') }}" alt="" />
                            </div>
                            <div class="banner-text">
                                <h3 class="icon-box-title">Meilleurs prix</h3>
                                <p>Commandes dès 50DT</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                        <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                            <div class="banner-icon">
                                <img src="{{ asset('front-end/imgs/theme/icons/icon-2.svg') }}" alt="" />
                            </div>
                            <div class="banner-text">
                                <h3 class="icon-box-title">Livraison gratuite</h3>
                                <p>Services disponibles 24/7</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                        <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                            <div class="banner-icon">
                                <img src="{{ asset('front-end/imgs/theme/icons/icon-3.svg') }}" alt="" />
                            </div>
                            <div class="banner-text">
                                <h3 class="icon-box-title">Bons plans du jour</h3>
                                <p>À l'inscription</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                        <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                            <div class="banner-icon">
                                <img src="{{ asset('front-end/imgs/theme/icons/icon-4.svg') }}" alt="" />
                            </div>
                            <div class="banner-text">
                                <h3 class="icon-box-title">Large choix</h3>
                                <p>Méga réductions</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                        <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                            <div class="banner-icon">
                                <img src="{{ asset('front-end/imgs/theme/icons/icon-5.svg') }}" alt="" />
                            </div>
                            <div class="banner-text">
                                <h3 class="icon-box-title">Retours faciles</h3>
                                <p>Sous 30 jours</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 d-xl-none">
                        <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                            <div class="banner-icon">
                                <img src="{{ asset('front-end/imgs/theme/icons/icon-6.svg') }}" alt="" />
                            </div>
                            <div class="banner-text">
                                <h3 class="icon-box-title">Livraison sécurisée</h3>
                                <p>Sous 30 jours</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-padding footer-mid">
            <div class="container pt-15 pb-20">
                <!-- <div class="row">
                    <div class="col">
                        <div class="widget-about font-md mb-md-3 mb-lg-3 mb-xl-0">
                            <div class="logo mb-30">
                                <a href="{{ url('/') }}" class="mb-15"><img src="{{ asset('front-end/imgs/theme/logo.png') }}" alt="logo" /></a>
                                <p class="font-lg text-heading">Votre boutique en ligne</p>
                            </div>
                            <ul class="contact-infor">
                                <li><img src="{{ asset('front-end/imgs/theme/icons/icon-location.svg') }}" alt="" /><strong>Adresse: </strong> <span>Votre adresse ici</span></li>
                                <li><img src="{{ asset('front-end/imgs/theme/icons/icon-contact.svg') }}" alt="" /><strong>Téléphone:</strong><span>+213 - 000-000-0000</span></li>
                                <li><img src="{{ asset('front-end/imgs/theme/icons/icon-email-2.svg') }}" alt="" /><strong>Email:</strong><span>contact@votre-boutique.com</span></li>
                                <li><img src="{{ asset('front-end/imgs/theme/icons/icon-clock.svg') }}" alt="" /><strong>Horaires:</strong><span>10:00 - 18:00, Lun - Sam</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="footer-link-widget col">
                        <h4 class="widget-title">Entreprise</h4>
                        <ul class="footer-list mb-sm-5 mb-md-0">
                            <li><a href="#">À propos</a></li>
                            <li><a href="#">Informations de livraison</a></li>
                            <li><a href="#">Politique de confidentialité</a></li>
                            <li><a href="#">Conditions générales</a></li>
                            <li><a href="#">Nous contacter</a></li>
                            <li><a href="#">Assistance</a></li>
                            <li><a href="#">Carrières</a></li>
                        </ul>
                    </div>
                    <div class="footer-link-widget col">
                        <h4 class="widget-title">Mon compte</h4>
                        <ul class="footer-list mb-sm-5 mb-md-0">
                            <li><a href="{{ route('frontend.login') }}">Connexion</a></li>
                            <li><a href="{{ route('cart.index') }}">Mon panier</a></li>
                            <li><a href="{{ route('wishlist.index') }}">Ma liste de souhaits</a></li>
                            <li><a href="{{ route('account.orders') }}">Suivre ma commande</a></li>
                            <li><a href="{{ route('account.profile') }}">Mon profil</a></li>
                        </ul>
                    </div>
                    <div class="footer-link-widget col">
                        <h4 class="widget-title">Boutique</h4>
                        <ul class="footer-list mb-sm-5 mb-md-0">
                            <li><a href="{{ route('shop.index') }}">Tous les produits</a></li>
                            <li><a href="#">Nouveautés</a></li>
                            <li><a href="#">Promotions</a></li>
                            <li><a href="#">Meilleures ventes</a></li>
                        </ul>
                    </div>
                    <div class="footer-link-widget col">
                        <h4 class="widget-title">Populaire</h4>
                        <ul class="footer-list mb-sm-5 mb-md-0">
                            @foreach (\App\Models\Category::take(6)->get() as $cat)
                            <li><a href="{{ route('shop.index', ['categorie' => $cat->id]) }}">{{ $cat->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                   
                </div> -->
            </div>
        </section>
        <div class="container pb-30">
            <div class="row align-items-center">
                <div class="col-12 mb-30">
                    <div class="footer-bottom"></div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <p class="font-sm mb-0">&copy; {{ date('Y') }}, <strong class="text-brand">Ma Boutique</strong> <br />Tous droits réservés</p>
                </div>
                <div class="col-xl-4 col-lg-6 text-center d-none d-xl-block">
                    <div class="hotline d-lg-inline-flex mr-30">
                        <img src="{{ asset('front-end/imgs/theme/icons/phone-call.svg') }}" alt="hotline" />
                        <p>+213 000-000-000<span>Lun-Sam 08:00-22:00</span></p>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 text-end d-none d-md-block">
                    <div class="mobile-social-icon">
                        <h6>Suivez-nous</h6>
                        <a href="#"><img src="{{ asset('front-end/imgs/theme/icons/icon-facebook-white.svg') }}" alt="" /></a>
                        <a href="#"><img src="{{ asset('front-end/imgs/theme/icons/icon-twitter-white.svg') }}" alt="" /></a>
                        <a href="#"><img src="{{ asset('front-end/imgs/theme/icons/icon-instagram-white.svg') }}" alt="" /></a>
                        <a href="#"><img src="{{ asset('front-end/imgs/theme/icons/icon-pinterest-white.svg') }}" alt="" /></a>
                        <a href="#"><img src="{{ asset('front-end/imgs/theme/icons/icon-youtube-white.svg') }}" alt="" /></a>
                    </div>
                    <p class="font-sm">Jusqu'à 15% de réduction à l'inscription</p>
                </div>
            </div>
        </div>
    </footer>