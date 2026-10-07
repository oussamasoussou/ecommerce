@extends('front-end.pages._layout')

@section('page-content')
    <p class="updated">Les présentes conditions s'appliquent à toute commande passée sur le site {{ config('shop.name') }}.</p>

    <h2>1. Vendeur</h2>
    <p>
        Le site est exploité par <x-shop-info key="legal_name" />,
        immatriculé sous le n° <x-shop-info key="registration" />, matricule fiscal <x-shop-info key="tax_id" />,
        dont le siège est situé : <x-shop-info key="address" />.
    </p>

    <h2>2. Produits</h2>
    <p>
        Les produits proposés sont décrits avec la plus grande exactitude possible. Les photographies sont
        présentées à titre indicatif. Les offres sont valables dans la limite des stocks disponibles.
    </p>

    <h2>3. Prix</h2>
    <p>
        Les prix sont indiqués en dinars tunisiens (DT), toutes taxes comprises. Le prix applicable est celui
        affiché au moment de la validation de la commande. La livraison est actuellement gratuite.
    </p>

    <h2>4. Commande</h2>
    <p>
        La commande peut être passée avec ou sans compte client. Elle est enregistrée après validation du
        formulaire de livraison, puis confirmée par téléphone. Nous nous réservons le droit d'annuler une
        commande en cas d'informations erronées, d'indisponibilité du produit ou de litige antérieur.
    </p>

    <h2>5. Paiement</h2>
    <p>Le paiement s'effectue en espèces à la livraison, auprès du livreur.</p>

    <h2>6. Livraison</h2>
    <p>
        Les conditions de livraison sont détaillées sur la page
        <a href="{{ route('pages.show', 'livraison') }}">Livraison</a>.
    </p>

    <h2>7. Retours et réclamations</h2>
    <p>
        Les conditions de retour sont détaillées sur la page
        <a href="{{ route('pages.show', 'retours') }}">Retours et remboursements</a>.
    </p>

    <h2>8. Données personnelles</h2>
    <p>
        Les données collectées sont traitées conformément à notre
        <a href="{{ route('pages.show', 'confidentialite') }}">politique de confidentialité</a>.
    </p>

    <h2>9. Droit applicable</h2>
    <p>
        Les présentes conditions sont soumises au droit tunisien, notamment à la loi n° 2000-83 relative aux
        échanges et au commerce électroniques. En cas de litige, une solution amiable sera recherchée avant
        toute action devant les tribunaux compétents.
    </p>
@endsection
