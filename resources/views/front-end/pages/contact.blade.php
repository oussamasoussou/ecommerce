@extends('front-end.pages._layout')

@section('page-content')
    <p class="updated">Une question sur un produit ou une commande ? Nous vous répondons avec plaisir.</p>

    <h2>Nous joindre</h2>
    <ul>
        <li><strong>Téléphone :</strong>
            @if (config('shop.phone'))
                <a href="tel:{{ preg_replace('/[^\d+]/', '', config('shop.phone')) }}">{{ config('shop.phone') }}</a>
            @else
                <x-shop-info key="phone" />
            @endif
        </li>
        <li><strong>Email :</strong>
            @if (config('shop.email'))
                <a href="mailto:{{ config('shop.email') }}">{{ config('shop.email') }}</a>
            @else
                <x-shop-info key="email" />
            @endif
        </li>
        <li><strong>Adresse :</strong> <x-shop-info key="address" /></li>
        <li><strong>Horaires :</strong> <x-shop-info key="hours" /></li>
    </ul>

    @if (count(config('shop.social')))
        <h2>Suivez-nous</h2>
        <ul>
            @foreach (config('shop.social') as $network => $url)
                <li><a href="{{ $url }}" target="_blank" rel="noopener">{{ $network }}</a></li>
            @endforeach
        </ul>
    @endif

    <h2>Une question sur votre commande ?</h2>
    <p>
        Munissez-vous de votre <strong>numéro de commande</strong> (indiqué sur la page de confirmation
        et dans votre espace client) : nous pourrons vous répondre plus rapidement.
    </p>
@endsection
