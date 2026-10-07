  {{-- Polices du thème artisanal (déjà chargées sur les pages connexion / inscription) --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Lora:wght@400;500;600&family=Caveat:wght@500;700&display=swap" rel="stylesheet">

  <style>
      /* Version claire : fond papier crème, texte brun, accents vert olive */
      .artisan-footer {
          --af-bg: #F7EFE1;
          --af-cream: #3E2C1C;          /* texte fort (titres, liens) */
          --af-sand: #8B6B43;           /* icônes, pointillés, écriture manuscrite */
          --af-muted: #6F5A45;          /* texte courant */
          --af-olive: #5D7052;
          --af-olive-light: #5D7052;    /* survol des liens */
          --af-stitch: rgba(139, 107, 67, .3);

          position: relative;
          margin-top: 60px;
          color: var(--af-muted);
          font-family: 'Lora', Georgia, serif;
          background-color: var(--af-bg);
          background-image:
              radial-gradient(rgba(139, 107, 67, .07) 1px, transparent 1px),
              radial-gradient(rgba(139, 107, 67, .045) 1px, transparent 1px);
          background-size: 22px 22px, 13px 13px;
          background-position: 0 0, 7px 11px;
          border-top: 1px solid rgba(139, 107, 67, .12);
      }

      /* Bord supérieur festonné, façon papier découpé */
      .artisan-footer::before {
          content: "";
          position: absolute;
          left: 0;
          right: 0;
          top: -14px;
          height: 14px;
          background: radial-gradient(circle at 10px 14px, var(--af-bg) 10px, transparent 10.5px) repeat-x;
          background-size: 20px 14px;
      }

      .artisan-footer a {
          color: var(--af-cream);
          transition: color .2s ease;
      }

      .artisan-footer a:hover {
          color: var(--af-olive-light);
      }

      .artisan-footer .af-script {
          font-family: 'Caveat', cursive;
          color: var(--af-sand);
      }

      /* Engagements */
      .af-features {
          padding: 46px 0 34px;
          border-bottom: 2px dashed var(--af-stitch);
      }

      .af-feature {
          display: flex;
          align-items: center;
          gap: 16px;
          padding: 10px 0;
      }

      .af-feature-icon {
          flex: 0 0 58px;
          height: 58px;
          border-radius: 50%;
          border: 1.5px dashed var(--af-sand);
          display: flex;
          align-items: center;
          justify-content: center;
          color: var(--af-sand);
          background: #FFFDF8;
      }

      .af-feature-icon svg {
          width: 26px;
          height: 26px;
      }

      .artisan-footer .af-feature h3 {
          font-family: 'Playfair Display', Georgia, serif;
          font-size: 18px;
          color: var(--af-cream);
          margin: 0 0 2px;
      }

      .af-feature p {
          margin: 0;
          font-size: 14px;
          color: var(--af-muted);
      }

      /* Colonnes */
      .af-main {
          padding: 44px 0 20px;
      }

      .af-about img {
          max-width: 170px;
          background: #FFFDF8;
          border: 1px solid rgba(139, 107, 67, .18);
          border-radius: 12px;
          padding: 8px 12px;
          margin-bottom: 14px;
      }

      .af-about .af-script {
          font-size: 24px;
          line-height: 1.2;
          margin-bottom: 14px;
      }

      .af-contact {
          list-style: none;
          padding: 0;
          margin: 0;
      }

      .af-contact li {
          display: flex;
          gap: 10px;
          align-items: flex-start;
          margin-bottom: 10px;
          font-size: 14px;
      }

      .af-contact svg {
          flex: 0 0 16px;
          width: 16px;
          height: 16px;
          margin-top: 4px;
          color: var(--af-sand);
      }

      .artisan-footer .af-title {
          font-family: 'Playfair Display', Georgia, serif;
          font-size: 19px;
          color: var(--af-cream);
          margin-bottom: 18px;
          padding-bottom: 10px;
          position: relative;
      }

      /* Trait de pinceau sous les titres */
      .artisan-footer .af-title::after {
          content: "";
          position: absolute;
          left: 0;
          bottom: 0;
          width: 54px;
          height: 6px;
          background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 10' preserveAspectRatio='none'%3E%3Cpath d='M2 7 C 40 2, 90 9, 130 4 S 185 6, 198 3' stroke='%235D7052' stroke-width='4' fill='none' stroke-linecap='round'/%3E%3C/svg%3E") no-repeat center / 100% 100%;
      }

      .af-links {
          list-style: none;
          padding: 0;
          margin: 0;
      }

      .af-links li {
          margin-bottom: 9px;
          font-size: 15px;
      }

      .af-links a {
          display: inline-flex;
          align-items: center;
          gap: 8px;
          color: var(--af-muted);
      }

      .af-links a::before {
          content: "";
          width: 6px;
          height: 6px;
          border-radius: 50%;
          border: 1.5px solid var(--af-sand);
          transition: background-color .2s ease;
      }

      .af-links a:hover {
          color: var(--af-cream);
      }

      .af-links a:hover::before {
          background: var(--af-olive-light);
          border-color: var(--af-olive-light);
      }

      /* Bas de page */
      .af-bottom {
          border-top: 2px dashed var(--af-stitch);
          padding: 20px 0 26px;
          font-size: 14px;
      }

      .af-bottom .af-copy strong {
          color: var(--af-cream);
          font-weight: 600;
      }

      .af-bottom .af-script {
          font-size: 20px;
      }

      .af-social {
          display: inline-flex;
          align-items: center;
          gap: 10px;
      }

      .af-social a {
          width: 38px;
          height: 38px;
          border-radius: 50%;
          border: 1.5px dashed var(--af-sand);
          display: inline-flex;
          align-items: center;
          justify-content: center;
          font-size: 12px;
      }

      .af-social a {
          background: var(--af-olive);
          border-color: var(--af-olive);
          border-style: solid;
          color: #fff;
      }

      .af-social a:hover {
          background: #4A5A41;
          border-color: #4A5A41;
          color: #fff;
      }

      .af-social img {
          width: 16px;
          height: 16px;
      }

      @media (max-width: 767.98px) {
          .af-features {
              padding: 34px 0 22px;
          }

          .af-main {
              padding-top: 32px;
          }

          .af-bottom {
              text-align: center;
          }

          .af-bottom .af-social-wrap {
              margin-top: 14px;
          }
      }
  </style>

  <footer class="artisan-footer">

      {{-- Engagements --}}
      <section class="af-features">
          <div class="container">
              <div class="row">
                  <div class="col-lg-3 col-sm-6">
                      <div class="af-feature">
                          <span class="af-feature-icon" aria-hidden="true">
                              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="2.5" y="6" width="19" height="12" rx="2"/><circle cx="12" cy="12" r="2.5"/><path d="M6 9.5v5M18 9.5v5"/></svg>
                          </span>
                          <div>
                              <h3>Paiement à la livraison</h3>
                              <p>En espèces, à la réception</p>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <div class="af-feature">
                          <span class="af-feature-icon" aria-hidden="true">
                              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M2.5 6.5h11v9h-11z"/><path d="M13.5 9.5h4l3 3v3h-7"/><circle cx="6.5" cy="17" r="1.8"/><circle cx="17" cy="17" r="1.8"/></svg>
                          </span>
                          <div>
                              <h3>Livraison gratuite</h3>
                              <p>Partout en Tunisie</p>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <div class="af-feature">
                          <span class="af-feature-icon" aria-hidden="true">
                              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M4 11h16l-1.5 7.5a2 2 0 0 1-2 1.5h-9a2 2 0 0 1-2-1.5z"/><path d="M8 11c0-3 1.8-5 4-5s4 2 4 5"/><path d="M12 6V3.5"/></svg>
                          </span>
                          <div>
                              <h3>Fait maison</h3>
                              <p>Bsissa et saveurs du terroir</p>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <div class="af-feature">
                          <span class="af-feature-icon" aria-hidden="true">
                              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20s-7-4.4-7-10a4 4 0 0 1 7-2.6A4 4 0 0 1 19 10c0 5.6-7 10-7 10z"/></svg>
                          </span>
                          <div>
                              <h3>Commande simple</h3>
                              <p>Avec ou sans compte</p>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </section>

      {{-- Colonnes --}}
      <section class="af-main">
          <div class="container">
              <div class="row">
                  <div class="col-lg-4 col-md-6 mb-4 af-about">
                      <a href="{{ url('/') }}"><img src="{{ asset('front-end/imgs/theme/dar_el_3oula.svg') }}" alt="{{ config('shop.name') }}" /></a>
                      <div class="af-script">{{ config('shop.tagline') }}, préparés avec soin.</div>
                      <ul class="af-contact">
                          @if (config('shop.address'))
                              <li>
                                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M12 21s-6.5-5.6-6.5-11a6.5 6.5 0 0 1 13 0c0 5.4-6.5 11-6.5 11z"/><circle cx="12" cy="10" r="2.3"/></svg>
                                  <span>{{ config('shop.address') }}</span>
                              </li>
                          @endif
                          @if (config('shop.phone'))
                              <li>
                                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2z"/></svg>
                                  <a href="tel:{{ preg_replace('/[^\d+]/', '', config('shop.phone')) }}">{{ config('shop.phone') }}</a>
                              </li>
                          @endif
                          @if (config('shop.email'))
                              <li>
                                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
                                  <a href="mailto:{{ config('shop.email') }}">{{ config('shop.email') }}</a>
                              </li>
                          @endif
                          @if (config('shop.hours'))
                              <li>
                                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                                  <span>{{ config('shop.hours') }}</span>
                              </li>
                          @endif
                      </ul>
                  </div>

                  <div class="col-lg-3 col-md-6 col-6 mb-4">
                      <h4 class="af-title">Informations</h4>
                      <ul class="af-links">
                          <li><a href="{{ route('pages.show', 'contact') }}">Nous contacter</a></li>
                          <li><a href="{{ route('pages.show', 'livraison') }}">Livraison</a></li>
                          <li><a href="{{ route('pages.show', 'retours') }}">Retours</a></li>
                          <li><a href="{{ route('pages.show', 'cgv') }}">CGV</a></li>
                          <li><a href="{{ route('pages.show', 'mentions-legales') }}">Mentions légales</a></li>
                          <li><a href="{{ route('pages.show', 'confidentialite') }}">Confidentialité</a></li>
                      </ul>
                  </div>

                  <div class="col-lg-2 col-md-6 col-6 mb-4">
                      <h4 class="af-title">Mon compte</h4>
                      <ul class="af-links">
                          @auth
                              <li><a href="{{ route('account.profile') }}">Mon profil</a></li>
                              <li><a href="{{ route('account.orders') }}">Mes commandes</a></li>
                              <li><a href="{{ route('wishlist.index') }}">Mes favoris</a></li>
                          @else
                              <li><a href="{{ route('frontend.login') }}">Connexion</a></li>
                              <li><a href="{{ route('frontend.register') }}">Créer un compte</a></li>
                          @endauth
                          <li><a href="{{ route('cart.index') }}">Mon panier</a></li>
                      </ul>
                  </div>

                  <div class="col-lg-3 col-md-6 mb-4">
                      <h4 class="af-title">Boutique</h4>
                      <ul class="af-links">
                          <li><a href="{{ route('shop.index') }}">Tous les produits</a></li>
                          @foreach (($categoriesMenu ?? collect())->take(5) as $cat)
                              @if ($cat->sousCategories->first())
                                  <li><a href="{{ route('shop.index', ['categorie' => $cat->sousCategories->first()->id]) }}">{{ $cat->name }}</a></li>
                              @endif
                          @endforeach
                      </ul>
                  </div>
              </div>
          </div>
      </section>

      {{-- Bas de page --}}
      <div class="af-bottom">
          <div class="container">
              <div class="row align-items-center">
                  <div class="col-md-6 af-copy">
                      &copy; {{ date('Y') }} <strong>{{ config('shop.name') }}</strong> — <span class="af-script">fait avec amour en Tunisie</span>
                  </div>
                  <div class="col-md-6 text-md-end af-social-wrap">
                      @if (count(config('shop.social')))
                          <div class="af-social">
                              @foreach (config('shop.social') as $network => $url)
                                  <a href="{{ $url }}" target="_blank" rel="noopener" aria-label="{{ $network }}">
                                      @if ($network === 'Facebook')
                                          <img src="{{ asset('front-end/imgs/theme/icons/icon-facebook-white.svg') }}" alt="" />
                                      @elseif ($network === 'Instagram')
                                          <img src="{{ asset('front-end/imgs/theme/icons/icon-instagram-white.svg') }}" alt="" />
                                      @else
                                          {{ \Illuminate\Support\Str::limit($network, 2, '') }}
                                      @endif
                                  </a>
                              @endforeach
                          </div>
                      @endif
                  </div>
              </div>
          </div>
      </div>
  </footer>
