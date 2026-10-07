@extends('front-end.pages._layout')

@section('page-content')
    <p class="updated">Conditions de retour et de remboursement.</p>

    <h2>Produits alimentaires</h2>
    <p>
        Pour des raisons d'hygiène et de sécurité alimentaire, les produits alimentaires (bsissa, épices,
        produits du terroir…) <strong>ne sont ni repris ni échangés une fois le colis ouvert</strong>,
        sauf produit non conforme ou défectueux.
    </p>

    <h2>Produit non conforme ou endommagé</h2>
    <p>
        Si un produit est abîmé, périmé ou ne correspond pas à votre commande, contactez-nous dans un délai de
        <span class="todo">[à compléter : ex. 48 heures]</span> après réception, avec votre numéro de commande et
        si possible une photo. Nous vous proposerons un échange ou un remboursement.
    </p>

    <h2>Autres produits (non alimentaires)</h2>
    <p>
        Les articles non alimentaires peuvent être retournés dans un délai de
        <span class="todo">[à compléter : ex. 7 jours]</span> après réception, dans leur emballage d'origine et en parfait état.
        Les frais de retour sont <span class="todo">[à compléter : à la charge du client / de la boutique]</span>.
    </p>

    <h2>Remboursement</h2>
    <p>
        Après réception et vérification du produit retourné, le remboursement est effectué sous
        <span class="todo">[à compléter : délai et mode de remboursement]</span>.
    </p>

    <p>Pour toute demande : <a href="{{ route('pages.show', 'contact') }}">contactez-nous</a>.</p>
@endsection
