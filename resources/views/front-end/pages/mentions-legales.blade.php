@extends('front-end.pages._layout')

@section('page-content')
    <p class="updated">Informations légales relatives au site {{ config('shop.name') }}.</p>

    <h2>Éditeur du site</h2>
    <ul>
        <li><strong>Nom / raison sociale :</strong> <x-shop-info key="legal_name" /></li>
        <li><strong>Adresse :</strong> <x-shop-info key="address" /></li>
        <li><strong>Registre (RNE) :</strong> <x-shop-info key="registration" /></li>
        <li><strong>Matricule fiscal :</strong> <x-shop-info key="tax_id" /></li>
        <li><strong>Téléphone :</strong> <x-shop-info key="phone" /></li>
        <li><strong>Email :</strong> <x-shop-info key="email" /></li>
    </ul>

    <h2>Hébergement</h2>
    <p><x-shop-info key="host" /></p>

    <h2>Propriété intellectuelle</h2>
    <p>
        Les textes, photographies, logos et éléments graphiques du site sont la propriété de
        {{ config('shop.name') }} ou de leurs auteurs respectifs. Toute reproduction sans autorisation est interdite.
    </p>

    <h2>Données personnelles</h2>
    <p>
        Voir notre <a href="{{ route('pages.show', 'confidentialite') }}">politique de confidentialité</a>.
    </p>
@endsection
