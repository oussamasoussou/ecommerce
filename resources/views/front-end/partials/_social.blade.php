{{-- Liens vers les réseaux sociaux renseignés dans .env (config/shop.php). Rien n'est affiché si aucun n'est configuré. --}}
@php
    $socialIcons = [
        'Facebook' => 'front-end/imgs/theme/icons/icon-facebook-white.svg',
        'Instagram' => 'front-end/imgs/theme/icons/icon-instagram-white.svg',
    ];
@endphp

@if (count(config('shop.social')))
    <div class="{{ $class ?? 'mobile-social-icon' }}">
        <h6 class="{{ $titleClass ?? '' }}">Suivez-nous</h6>
        @foreach (config('shop.social') as $network => $url)
            <a href="{{ $url }}" target="_blank" rel="noopener" aria-label="{{ $network }}">
                @isset($socialIcons[$network])
                    <img src="{{ asset($socialIcons[$network]) }}" alt="{{ $network }}" />
                @else
                    {{ $network }}
                @endisset
            </a>
        @endforeach
    </div>
@endif
