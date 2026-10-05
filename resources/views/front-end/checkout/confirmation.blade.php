@extends('front-end.layouts.app')

@section('title', 'Commande confirmée')

@section('content')
    <style>
        .confirm-page {
            --co-primary: #148b41;
            --co-primary-dark: #4A5A41;
            --co-primary-soft: #EEF1E8;
            --co-ink: #253D4E;
            --co-muted: #7E7E7E;
            --co-line: #ECECEC;
            padding: 30px 0 80px;
        }

        .co-steps {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 36px;
            font-size: 14px;
            color: var(--co-muted);
        }

        .co-step {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .co-step .num {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
            background: var(--co-primary-soft);
            border: 1.5px solid var(--co-primary);
            color: var(--co-primary);
        }

        .co-step.active {
            color: var(--co-ink);
            font-weight: 700;
        }

        .co-step.active .num {
            background: var(--co-primary);
            color: #fff;
        }

        .co-step-sep {
            width: 40px;
            border-top: 1.5px dashed var(--co-line);
        }

        .confirm-card {
            max-width: 720px;
            margin: 0 auto;
            background: #fff;
            border: 1px solid var(--co-line);
            border-radius: 16px;
            padding: 40px;
        }

        .confirm-head {
            text-align: center;
            margin-bottom: 30px;
        }

        .confirm-check {
            width: 76px;
            height: 76px;
            margin: 0 auto 18px;
            border-radius: 50%;
            background: var(--co-primary-soft);
            color: var(--co-primary);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .confirm-check svg {
            width: 38px;
            height: 38px;
        }

        .confirm-head h1 {
            font-size: 30px;
            margin-bottom: 8px;
        }

        .confirm-head p {
            color: var(--co-muted);
            margin: 0;
        }

        .confirm-number {
            display: inline-block;
            margin-top: 14px;
            padding: 6px 16px;
            border-radius: 20px;
            background: var(--co-primary-soft);
            color: var(--co-primary-dark);
            font-weight: 700;
        }

        .confirm-section-title {
            font-size: 17px;
            margin: 26px 0 12px;
        }

        .confirm-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px 24px;
            padding: 18px;
            border-radius: 12px;
            background: #F7F8F9;
        }

        .confirm-info span {
            display: block;
            font-size: 13px;
            color: var(--co-muted);
        }

        .confirm-info strong {
            color: var(--co-ink);
            word-break: break-word;
        }

        .confirm-info .full {
            grid-column: 1 / -1;
        }

        .confirm-items {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .confirm-items li {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            padding: 10px 0;
            border-bottom: 1px dashed var(--co-line);
            color: var(--co-ink);
        }

        .confirm-items li span {
            color: var(--co-muted);
        }

        .confirm-total {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            padding-top: 16px;
        }

        .confirm-total span {
            font-size: 18px;
            font-weight: 700;
            color: var(--co-ink);
        }

        .confirm-total strong {
            font-size: 24px;
            color: var(--co-primary);
        }

        .confirm-note {
            margin-top: 24px;
            padding: 14px 16px;
            border-radius: 12px;
            border: 1.5px solid var(--co-primary);
            background: var(--co-primary-soft);
            color: var(--co-primary-dark);
            font-size: 14px;
        }

        .confirm-actions {
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 28px;
        }

        @media (max-width: 575.98px) {
            .confirm-card {
                padding: 26px 20px;
            }

            .confirm-info {
                grid-template-columns: 1fr;
            }

            .co-step .label {
                display: none;
            }
        }
    </style>

    <div class="confirm-page">
        <div class="container">

            <div class="co-steps" aria-label="Étapes de la commande">
                <span class="co-step"><span class="num">✓</span><span class="label">Panier</span></span>
                <span class="co-step-sep"></span>
                <span class="co-step"><span class="num">✓</span><span class="label">Livraison</span></span>
                <span class="co-step-sep"></span>
                <span class="co-step active" aria-current="step"><span class="num">3</span><span class="label">Confirmation</span></span>
            </div>

            <div class="confirm-card">
                <div class="confirm-head">
                    <div class="confirm-check" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12.5l4.5 4.5L19 7.5" />
                        </svg>
                    </div>
                    <h1>Merci pour votre commande !</h1>
                    <p>Votre commande a bien été enregistrée. Nous vous contacterons pour confirmer la livraison.</p>
                    <span class="confirm-number">Commande n° {{ $order->id }}</span>
                </div>

                <h3 class="confirm-section-title">Livraison</h3>
                <div class="confirm-info">
                    <div>
                        <span>Nom</span>
                        <strong>{{ $order->nom_client }}</strong>
                    </div>
                    <div>
                        <span>Téléphone</span>
                        <strong>{{ $order->telephone }}</strong>
                    </div>
                    <div class="full">
                        <span>Adresse</span>
                        <strong>{{ $order->adresse_livraison }}</strong>
                    </div>
                </div>

                <h3 class="confirm-section-title">Récapitulatif</h3>
                <ul class="confirm-items">
                    @foreach ($order->items as $item)
                        <li>
                            <div>
                                {{ $item->produit->nom ?? 'Produit' }}
                                <span>× {{ $item->quantite }}</span>
                            </div>
                            <strong>{{ number_format($item->total, 2, ',', ' ') }} DT</strong>
                        </li>
                    @endforeach
                </ul>

                <div class="confirm-total">
                    <span>Total à payer à la livraison</span>
                    <strong>{{ number_format($order->total, 2, ',', ' ') }} DT</strong>
                </div>

                <div class="confirm-note">
                    <i class="fi-rs-info mr-5"></i>
                    Paiement en espèces au livreur à la réception de votre commande.
                </div>

                <div class="confirm-actions">
                    <a href="{{ route('shop.index') }}" class="btn btn-primary">Continuer mes achats</a>
                    @auth
                        <a href="{{ route('account.orders') }}" class="btn btn-outline-primary">Voir mes commandes</a>
                    @endauth
                </div>
            </div>

        </div>
    </div>
@endsection
