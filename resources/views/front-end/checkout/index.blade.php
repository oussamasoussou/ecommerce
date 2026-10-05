@extends('front-end.layouts.app')

@section('content')
<div class="container py-5">
    <h2>Finaliser la commande</h2>

    <div id="cart-items">
        @foreach ($cart as $key => $item)
            <p>{{ $item['name'] }} x {{ $item['qty'] }} = DT{{ number_format($item['price']*$item['qty'],2) }}</p>
        @endforeach
    </div>

    <form id="checkout-form">
        @csrf
        <input type="text" name="billing[nom]" placeholder="Nom complet" required>
        <input type="text" name="billing[adresse]" placeholder="Adresse" required>
        <input type="text" name="billing[telephone]" placeholder="Téléphone" required>

        <p class="payment-mode-note">Paiement à la livraison (espèces à la réception).</p>

        <button type="submit" id="pay-button">Valider la commande</button>
    </form>

    <div id="payment-message"></div>
</div>
@endsection

@section('scripts')
<script>
    const form = document.getElementById('checkout-form');
    const payButton = document.getElementById('pay-button');
    const messageDiv = document.getElementById('payment-message');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        payButton.disabled = true;

        const billingData = {
            nom: form['billing[nom]'].value,
            adresse: form['billing[adresse]'].value,
            telephone: form['billing[telephone]'].value
        };

        const resp = await fetch("{{ route('checkout.placeOrder') }}", {
            method: 'POST',
            headers: {'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
            body: JSON.stringify({billing: billingData})
        }).then(r => r.json());

        if (resp.error) {
            messageDiv.innerText = resp.error;
            payButton.disabled = false;
            return;
        }

        messageDiv.innerText = "Commande validée ! Commande #" + resp.order_id;
        window.location.href = "/account/orders";
    });
</script>
@endsection
