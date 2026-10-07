@extends('front-end.pages._layout')

@section('page-content')
    <p class="updated">Comment nous collectons et protégeons vos données personnelles.</p>

    <h2>Données collectées</h2>
    <ul>
        <li><strong>Lors d'une commande :</strong> nom, téléphone et adresse de livraison.</li>
        <li><strong>Lors de la création d'un compte :</strong> prénom, nom, email, téléphone, adresse et ville.</li>
        <li><strong>Pendant la navigation :</strong> un cookie de session, nécessaire au fonctionnement du panier.</li>
    </ul>

    <h2>Utilisation</h2>
    <p>
        Vos données servent uniquement à traiter et livrer vos commandes, à vous contacter au sujet de celles-ci
        et à gérer votre compte. Elles ne sont ni vendues ni cédées à des tiers, à l'exception du transporteur
        pour la livraison.
    </p>

    <h2>Conservation et sécurité</h2>
    <p>
        Les mots de passe sont chiffrés et ne sont jamais lisibles, y compris par nous. Les données sont conservées
        pendant la durée nécessaire à la gestion des commandes et aux obligations légales.
    </p>

    <h2>Vos droits</h2>
    <p>
        Conformément à la loi organique n° 2004-63 sur la protection des données à caractère personnel, vous pouvez
        demander l'accès, la rectification ou la suppression de vos données en nous contactant
        (<a href="{{ route('pages.show', 'contact') }}">page Contact</a>). Vous pouvez aussi modifier vos informations
        depuis votre espace client.
    </p>
@endsection
