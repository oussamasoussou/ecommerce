@extends('front-end.pages._layout')

@section('page-content')
    <p class="updated">Informations sur l'expédition et la réception de vos commandes.</p>

    <h2>Zones de livraison</h2>
    <p>Nous livrons dans toute la Tunisie <span class="todo">[à confirmer : liste des gouvernorats desservis]</span>.</p>

    <h2>Délais</h2>
    <p>
        Après validation, nous vous contactons par téléphone pour confirmer votre commande.
        La livraison intervient ensuite sous <span class="todo">[à compléter : ex. 2 à 5 jours ouvrables]</span>.
    </p>

    <h2>Frais de livraison</h2>
    <p>
        La livraison est actuellement <strong>gratuite</strong>. Le montant total affiché lors de la commande
        est le montant à payer, sans frais supplémentaires.
    </p>

    <h2>Paiement à la livraison</h2>
    <p>
        Vous réglez votre commande <strong>en espèces au livreur</strong>, à la réception du colis.
        Merci de prévoir le montant exact si possible.
    </p>

    <h2>Réception du colis</h2>
    <p>
        Vérifiez l'état du colis en présence du livreur. En cas de colis abîmé ou de produit manquant,
        signalez-le immédiatement au livreur et contactez-nous
        (<a href="{{ route('pages.show', 'contact') }}">page Contact</a>).
    </p>
@endsection
