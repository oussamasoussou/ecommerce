@extends('front-end.layouts.app')

@section('title', 'Finaliser la commande')

@section('content')
    <style>
        .checkout-page {
            --co-primary: #148b41;
            --co-primary-dark: #4A5A41;
            --co-primary-soft: #EEF1E8;
            --co-ink: #253D4E;
            --co-muted: #7E7E7E;
            --co-line: #ECECEC;
            --co-bg: #F7F8F9;
            --co-error: #B23B2E;
            padding: 30px 0 80px;
        }

        /* Étapes */
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
            border: 1.5px solid var(--co-line);
            background: #fff;
        }

        .co-step.done .num {
            background: var(--co-primary-soft);
            border-color: var(--co-primary);
            color: var(--co-primary);
        }

        .co-step.active {
            color: var(--co-ink);
            font-weight: 700;
        }

        .co-step.active .num {
            background: var(--co-primary);
            border-color: var(--co-primary);
            color: #fff;
        }

        .co-step-sep {
            width: 40px;
            border-top: 1.5px dashed var(--co-line);
        }

        .co-title {
            font-size: 32px;
            margin-bottom: 6px;
        }

        .co-subtitle {
            color: var(--co-muted);
            margin-bottom: 30px;
        }

        /* Cartes */
        .co-card {
            background: #fff;
            border: 1px solid var(--co-line);
            border-radius: 16px;
            padding: 28px;
            margin-bottom: 24px;
        }

        .co-card-title {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 20px;
            margin-bottom: 22px;
        }

        .co-card-title .icon {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--co-primary-soft);
            color: var(--co-primary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        /* Champs */
        .co-field {
            margin-bottom: 18px;
        }

        .co-field label {
            display: block;
            font-weight: 600;
            font-size: 14px;
            color: var(--co-ink);
            margin-bottom: 7px;
        }

        .co-field label .req {
            color: var(--co-error);
        }

        .checkout-page .co-field input,
        .checkout-page .co-field textarea {
            width: 100%;
            height: 50px;
            padding: 0 16px;
            font-size: 15px;
            color: var(--co-ink);
            background: #fff;
            border: 1.5px solid var(--co-line);
            border-radius: 10px;
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .checkout-page .co-field textarea {
            height: auto;
            min-height: 90px;
            padding: 12px 16px;
            resize: vertical;
        }

        .checkout-page .co-field input:focus,
        .checkout-page .co-field textarea:focus {
            outline: none;
            border-color: var(--co-primary);
            box-shadow: 0 0 0 4px rgba(93, 112, 82, .12);
        }

        .checkout-page .co-field .is-invalid {
            border-color: var(--co-error);
        }

        .co-field-error {
            margin-top: 6px;
            font-size: 13px;
            color: var(--co-error);
        }

        /* Mode de paiement */
        .co-payment {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 18px;
            border: 1.5px solid var(--co-primary);
            border-radius: 12px;
            background: var(--co-primary-soft);
        }

        .co-payment .radio {
            flex: 0 0 22px;
            height: 22px;
            border-radius: 50%;
            border: 2px solid var(--co-primary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-top: 2px;
        }

        .co-payment .radio::after {
            content: "";
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--co-primary);
        }

        .co-payment strong {
            display: block;
            color: var(--co-ink);
            font-size: 16px;
            margin-bottom: 3px;
        }

        .co-payment span {
            color: var(--co-muted);
            font-size: 14px;
        }

        /* Récapitulatif */
        .co-summary {
            position: sticky;
            top: 110px;
        }

        .co-items {
            list-style: none;
            padding: 0;
            margin: 0 0 18px;
            max-height: 340px;
            overflow-y: auto;
        }

        .co-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 0;
            border-bottom: 1px dashed var(--co-line);
        }

        .co-item:last-child {
            border-bottom: 0;
        }

        .co-item-img {
            position: relative;
            flex: 0 0 64px;
            height: 64px;
            border-radius: 10px;
            background: var(--co-bg);
            border: 1px solid var(--co-line);
        }

        .co-item-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
        }

        .co-item-qty {
            position: absolute;
            top: -8px;
            right: -8px;
            min-width: 22px;
            height: 22px;
            padding: 0 6px;
            border-radius: 11px;
            background: var(--co-primary);
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .co-item-info {
            flex: 1;
            min-width: 0;
        }

        .co-item-name {
            font-weight: 700;
            color: var(--co-ink);
            font-size: 15px;
            line-height: 1.3;
            margin: 0;
        }

        .co-item-meta {
            font-size: 13px;
            color: var(--co-muted);
        }

        .co-item-price {
            font-weight: 700;
            color: var(--co-ink);
            white-space: nowrap;
        }

        .co-line {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            color: var(--co-muted);
        }

        .co-line strong {
            color: var(--co-ink);
        }

        .co-line .free {
            color: var(--co-primary);
            font-weight: 700;
        }

        .co-total {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-top: 10px;
            padding-top: 16px;
            border-top: 1.5px dashed var(--co-line);
        }

        .co-total span {
            font-size: 18px;
            font-weight: 700;
            color: var(--co-ink);
        }

        .co-total strong {
            font-size: 26px;
            color: var(--co-primary);
        }

        .checkout-page .co-submit {
            width: 100%;
            height: 56px;
            margin-top: 22px;
            border: 0;
            border-radius: 12px;
            background-color: var(--co-primary) !important;
            color: #fff;
            font-size: 17px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: background-color .2s ease, transform .15s ease;
        }

        .checkout-page .co-submit:hover {
            background-color: var(--co-primary-dark) !important;
            transform: translateY(-1px);
        }

        .checkout-page .co-submit[disabled] {
            opacity: .7;
            cursor: wait;
            transform: none;
        }

        .co-secure {
            margin-top: 14px;
            text-align: center;
            font-size: 13px;
            color: var(--co-muted);
        }

        .co-alert {
            display: none;
            margin-top: 16px;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 14px;
        }

        .co-alert.show {
            display: block;
        }

        .co-alert.error {
            background: #FBEAE8;
            color: var(--co-error);
            border: 1px solid rgba(178, 59, 46, .3);
        }

        .co-alert.success {
            background: var(--co-primary-soft);
            color: var(--co-primary-dark);
            border: 1px solid rgba(93, 112, 82, .3);
        }

        .co-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--co-muted);
            font-size: 14px;
        }

        .co-back:hover {
            color: var(--co-primary);
        }

        /* Panier vide */
        .co-empty {
            text-align: center;
            padding: 60px 20px;
        }

        .co-empty .icon {
            font-size: 56px;
            color: var(--co-line);
        }

        @media (max-width: 991.98px) {
            .co-summary {
                position: static;
            }
        }

        @media (max-width: 575.98px) {
            .co-card {
                padding: 20px;
            }

            .co-title {
                font-size: 26px;
            }

            .co-step .label {
                display: none;
            }
        }
    </style>

    <div class="checkout-page">
        <div class="container">

            {{-- Étapes --}}
            <div class="co-steps" aria-label="Étapes de la commande">
                <span class="co-step done"><span class="num">✓</span><span class="label">Panier</span></span>
                <span class="co-step-sep"></span>
                <span class="co-step active" aria-current="step"><span class="num">2</span><span class="label">Livraison</span></span>
                <span class="co-step-sep"></span>
                <span class="co-step"><span class="num">3</span><span class="label">Confirmation</span></span>
            </div>

            @if ($cart->isEmpty())
                <div class="co-card co-empty">
                    <div class="icon"><i class="fi-rs-shopping-cart"></i></div>
                    <h3 class="mt-3 mb-2">Votre panier est vide</h3>
                    <p class="text-muted mb-4">Ajoutez des produits à votre panier avant de passer commande.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-primary">Découvrir nos produits</a>
                </div>
            @else
                <h1 class="co-title">Finaliser la commande</h1>
                <p class="co-subtitle">Vérifiez vos informations de livraison, puis validez votre commande.</p>

                <form id="checkout-form" novalidate>
                    @csrf
                    <div class="row">

                        {{-- Colonne gauche : livraison + paiement --}}
                        <div class="col-lg-7">
                            <div class="co-card">
                                <h3 class="co-card-title">
                                    <span class="icon"><i class="fi-rs-marker"></i></span>
                                    Informations de livraison
                                </h3>

                                <div class="co-field">
                                    <label for="billing-nom">Nom complet <span class="req">*</span></label>
                                    <input type="text" id="billing-nom" name="nom" required maxlength="255"
                                           autocomplete="name" placeholder="Prénom et nom"
                                           value="{{ $billing['nom'] }}">
                                    <div class="co-field-error" data-error-for="nom" hidden></div>
                                </div>

                                <div class="co-field">
                                    <label for="billing-telephone">Téléphone <span class="req">*</span></label>
                                    <input type="tel" id="billing-telephone" name="telephone" required maxlength="20"
                                           autocomplete="tel" placeholder="+216 XX XXX XXX"
                                           value="{{ $billing['telephone'] }}">
                                    <div class="co-field-error" data-error-for="telephone" hidden></div>
                                </div>

                                <div class="co-field mb-0">
                                    <label for="billing-adresse">Adresse de livraison <span class="req">*</span></label>
                                    <textarea id="billing-adresse" name="adresse" required
                                              autocomplete="street-address"
                                              placeholder="Rue, numéro, ville…">{{ $billing['adresse'] }}</textarea>
                                    <div class="co-field-error" data-error-for="adresse" hidden></div>
                                </div>
                            </div>

                            <div class="co-card">
                                <h3 class="co-card-title">
                                    <span class="icon"><i class="fi-rs-credit-card"></i></span>
                                    Mode de paiement
                                </h3>

                                <div class="co-payment">
                                    <span class="radio" aria-hidden="true"></span>
                                    <div>
                                        <strong>Paiement à la livraison</strong>
                                        <span>Vous payez en espèces au livreur à la réception de votre commande.</span>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('cart.index') }}" class="co-back">
                                <i class="fi-rs-arrow-left"></i> Retour au panier
                            </a>
                        </div>

                        {{-- Colonne droite : récapitulatif --}}
                        <div class="col-lg-5">
                            <div class="co-card co-summary">
                                <h3 class="co-card-title">
                                    <span class="icon"><i class="fi-rs-shopping-bag"></i></span>
                                    Votre commande
                                </h3>

                                <ul class="co-items">
                                    @foreach ($cart as $item)
                                        <li class="co-item">
                                            <div class="co-item-img">
                                                @if ($item['image'])
                                                    <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}">
                                                @endif
                                                <span class="co-item-qty">{{ $item['qty'] }}</span>
                                            </div>
                                            <div class="co-item-info">
                                                <p class="co-item-name">{{ $item['name'] }}</p>
                                                @if ($item['couleur'] || $item['taille'])
                                                    <div class="co-item-meta">
                                                        {{ collect([$item['couleur'], $item['taille']])->filter()->implode(' · ') }}
                                                    </div>
                                                @endif
                                                <div class="co-item-meta">
                                                    {{ $item['qty'] }} × {{ number_format($item['price'], 2, ',', ' ') }} DT
                                                </div>
                                            </div>
                                            <div class="co-item-price">
                                                {{ number_format($item['price'] * $item['qty'], 2, ',', ' ') }} DT
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="co-line">
                                    <span>Sous-total</span>
                                    <strong>{{ number_format($total, 2, ',', ' ') }} DT</strong>
                                </div>
                                <div class="co-line">
                                    <span>Livraison</span>
                                    <span class="free">Gratuite</span>
                                </div>

                                <div class="co-total">
                                    <span>Total</span>
                                    <strong>{{ number_format($total, 2, ',', ' ') }} DT</strong>
                                </div>

                                <button type="submit" class="co-submit" id="pay-button">
                                    <i class="fi-rs-check"></i> Valider la commande
                                </button>

                                <div class="co-alert" id="payment-message" role="alert"></div>

                                <p class="co-secure">
                                    <i class="fi-rs-lock"></i> Paiement en espèces à la réception
                                </p>
                            </div>
                        </div>

                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
    (function () {
        const form = document.getElementById('checkout-form');
        if (!form) return;

        const payButton = document.getElementById('pay-button');
        const messageDiv = document.getElementById('payment-message');
        const buttonHtml = payButton.innerHTML;

        function showMessage(type, text) {
            messageDiv.className = 'co-alert show ' + type;
            messageDiv.textContent = text;
        }

        function clearErrors() {
            messageDiv.className = 'co-alert';
            form.querySelectorAll('[data-error-for]').forEach(el => { el.hidden = true; el.textContent = ''; });
            form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        }

        function fieldError(name, text) {
            const input = form.elements[name];
            const error = form.querySelector('[data-error-for="' + name + '"]');
            if (input) input.classList.add('is-invalid');
            if (error) { error.textContent = text; error.hidden = false; }
        }

        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            clearErrors();

            // Validation côté navigateur
            const labels = { nom: 'Le nom complet', telephone: 'Le téléphone', adresse: "L'adresse de livraison" };
            let firstInvalid = null;
            Object.keys(labels).forEach(name => {
                if (!form.elements[name].value.trim()) {
                    fieldError(name, labels[name] + ' est obligatoire.');
                    firstInvalid = firstInvalid || form.elements[name];
                }
            });
            if (firstInvalid) { firstInvalid.focus(); return; }

            payButton.disabled = true;
            payButton.innerHTML = 'Validation en cours…';

            try {
                const response = await fetch("{{ route('checkout.placeOrder') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        billing: {
                            nom: form.elements.nom.value.trim(),
                            telephone: form.elements.telephone.value.trim(),
                            adresse: form.elements.adresse.value.trim()
                        }
                    })
                });

                const data = await response.json().catch(() => ({}));

                if (response.status === 422 && data.errors) {
                    Object.entries(data.errors).forEach(([key, messages]) => {
                        fieldError(key.replace('billing.', ''), messages[0]);
                    });
                    throw new Error('Merci de corriger les champs indiqués.');
                }

                if (!response.ok || data.error) {
                    throw new Error(data.error || 'Une erreur est survenue. Veuillez réessayer.');
                }

                showMessage('success', 'Commande #' + data.order_id + ' validée !');
                document.querySelectorAll('.cart-count').forEach(el => el.textContent = 0);
                window.location.href = data.redirect || "{{ route('checkout.confirmation') }}";
            } catch (err) {
                showMessage('error', err.message);
                payButton.disabled = false;
                payButton.innerHTML = buttonHtml;
            }
        });
    })();
</script>
@endpush
