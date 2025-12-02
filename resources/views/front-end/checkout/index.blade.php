@extends('front-end.layouts.app')

@section('content')
<div class="container py-5">
    <h2>Checkout</h2>

    <div id="cart-items">
        @foreach($cart as $key => $item)
            <p>{{ $item['name'] }} x {{ $item['qty'] }} = €{{ number_format($item['price']*$item['qty'],2) }}</p>
        @endforeach
    </div>

    <form id="checkout-form">
        @csrf
        <input type="text" name="billing[nom]" placeholder="Nom complet" required>
        <input type="text" name="billing[adresse]" placeholder="Adresse" required>
        <input type="text" name="billing[telephone]" placeholder="Téléphone" required>

        <div id="card-element" class="my-3"></div>
        <button type="submit" id="pay-button">Payer</button>
    </form>

    <div id="payment-message"></div>
</div>
@endsection

@section('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe("{{ config('services.stripe.key') ?? env('STRIPE_KEY') }}");

    const form = document.getElementById('checkout-form');
    const payButton = document.getElementById('pay-button');
    const messageDiv = document.getElementById('payment-message');

    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        payButton.disabled = true;

        const billingData = {
            nom: form['billing[nom]'].value,
            adresse: form['billing[adresse]'].value,
            telephone: form['billing[telephone]'].value
        };

        // Créer PaymentIntent
        const intentResp = await fetch("{{ route('checkout.createPaymentIntent') }}", {
            method: 'POST',
            headers: {'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
            body: JSON.stringify({billing: billingData})
        }).then(r=>r.json());

        if(intentResp.error){
            messageDiv.innerText = intentResp.error;
            payButton.disabled = false;
            return;
        }

        // Confirmer paiement
        const {error, paymentIntent} = await stripe.confirmCardPayment(
            intentResp.clientSecret, {
                payment_method: {
                    card: card,
                    billing_details: {
                        name: billingData.nom,
                        email: "{{ auth()->user()->email ?? '' }}"
                    }
                }
            }
        );

        if(error){
            messageDiv.innerText = error.message;
            payButton.disabled = false;
        } else if(paymentIntent.status === 'succeeded'){
            // Appel backend confirm
            const confResp = await fetch("{{ route('checkout.confirm') }}", {
                method:'POST',
                headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
                body: JSON.stringify({payment_intent_id: paymentIntent.id})
            }).then(r=>r.json());

            if(confResp.success){
                messageDiv.innerText = "Paiement réussi ! Commande #" + confResp.order_id;
                window.location.href = "/account/orders";
            } else {
                messageDiv.innerText = confResp.error || "Erreur confirmation commande";
            }
        }
    });
</script>
@endsection
